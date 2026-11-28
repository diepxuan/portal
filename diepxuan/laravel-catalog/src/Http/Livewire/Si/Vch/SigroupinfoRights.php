<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 */

namespace Diepxuan\Catalog\Http\Livewire\Si\Vch;

use Diepxuan\Simba\StoredProcedures\AsDelGroupRight;
use Diepxuan\Simba\StoredProcedures\AsGetGroupInfo;
use Diepxuan\Simba\StoredProcedures\AsGetMenuBar;
use Diepxuan\Simba\StoredProcedures\AsGetMenuDetail;
use Diepxuan\Simba\StoredProcedures\AsInsGroupRight;
use Diepxuan\Simba\StoredProcedures\AsSiGetAllGroupRights;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Phân quyền chức năng cho nhóm người sử dụng — frmSiSetRights (SIGroupInfo.dll).
 *
 * NGUON SU THAT:
 *   simba-docs/decompiled/asia/SIGroupInfo.dll/AsiaErp.UserInterface/frmSiSetRights.cs
 *   simba-docs/decompiled/asia/SIGroupInfo.dll/AsiaErp.DataAccess/MsSqlSiGroupInfoDao.cs
 *
 * SP (da doi chieu INFORMATION_SCHEMA.PARAMETERS):
 *   asGetMenuBar('vi-VN')        (1) -> 13 dong: Phan he
 *   asGetMenuDetail('vi-VN')     (1) -> 42 dong: So lieu
 *   asSiGetAllGroupRights(group) (1) -> 571 dong: chuc nang + 4 quyen
 *   asInsGroupRight   (7) pGroupName, pMenuID, pViewRight, pInsertRight,
 *                          pUpdateRight, pDeleteRight, pRet
 *   asDelGroupRight   (3) pGroupName, pMenuID, pRet
 *
 * LOGIC LOC (tu frmSiSetRights.cs):
 *   cboMainMenu_SelectedValueChanged:
 *     f_oTblSubMenu.RowFilter = "Link = '<Link cua Phan he>'"
 *   cboSubMenu_SelectedIndexChanged:
 *     f_oTblGroupRight.RowFilter = "SUBSTRING(MenuID,1,5) = '<5 ky tu dau MenuID>'"
 *
 * LOGIC LUU (tu cmdSave_Click):
 *   - Delete-then-Insert (khong co SP update)
 *   - ViewRight LUON = true khi insert neu co bat ky quyen nao
 *   - Bo tick het 4 quyen -> chi Delete, khong Insert
 */
class SigroupinfoRights extends Component
{
    /**
     * Nhom dang phan quyen — CHON BANG DROPDOWN trong form.
     *
     * Route KHONG co tham so (Sep yeu cau), nen component tu nap danh sach
     * nhom va cho nguoi dung chon.
     */
    public string $groupName = '';

    /** Danh sach nhom: [['groupname'=>..,'fullname'=>..], ...] */
    public array $groups = [];

    public ?string $mainMenuId = null;

    public ?string $subMenuId = null;

    public ?string $errorMessage = null;

    public ?string $successMessage = null;

    /** 13 dong tu asGetMenuBar: [['MenuID'=>..,'bar'=>..,'Link'=>..], ...] */
    public array $mainMenus = [];

    /** 42 dong tu asGetMenuDetail */
    public array $subMenus = [];

    /**
     * 571 dong tu asSiGetAllGroupRights.
     *
     * Moi phan tu: ['MenuID','Bar','LinkDetail','Link','ViewRight','InsertRight','UpdateRight','DeleteRight']
     */
    public array $rights = [];

    /**
     * Ban sao quyen BAN DAU de biet dong nao thay doi khi luu.
     *
     * @var array<string, array<string, bool>>
     */
    public array $originalRights = [];

    public function mount(?string $group = null): void
    {
        $this->loadGroups();
        $this->loadMenus();

        // Neu co ?group= tren URL thi dung, khong thi chon nhom dau tien.
        $preferred = trim((string) $group);

        if ('' !== $preferred && $this->hasGroup($preferred)) {
            $this->groupName = $preferred;
        } elseif ($this->groups !== []) {
            $this->groupName = (string) $this->groups[0]['groupname'];
        }

        $this->loadRights();
        $this->selectFirstMenu();
    }

    /**
     * Doi nhom -> nap lai quyen cua nhom moi.
     */
    public function updatedGroupName(): void
    {
        $this->errorMessage = null;
        $this->successMessage = null;
        $this->loadRights();
    }

    /**
     * Nap danh sach nhom tu asGetGroupInfo (dung cho dropdown).
     */
    protected function loadGroups(): void
    {
        try {
            $rows = AsGetGroupInfo::call(['pGroupName' => ''])->all();
        } catch (\Throwable $exception) {
            report($exception);
            $this->errorMessage = 'Không tải được danh sách nhóm.';

            return;
        }

        $this->groups = [];

        foreach ($rows as $row) {
            $data = \is_array($row) ? $row : (array) $row;

            $name = (string) ($data['groupname'] ?? '');

            if ('' === trim($name)) {
                continue;
            }

            $this->groups[] = [
                'groupname' => $name,
                'fullname'  => (string) ($data['fullname'] ?? ''),
            ];
        }
    }

    protected function hasGroup(string $name): bool
    {
        foreach ($this->groups as $g) {
            if (trim((string) $g['groupname']) === trim($name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Doi "Phân hệ" -> reset "Số liệu" theo Link (dung form goc).
     */
    public function updatedMainMenuId(): void
    {
        $this->subMenuId = null;
        $this->selectFirstSubMenu();
    }

    /**
     * Danh sach "Số liệu" thuoc Phan he dang chon.
     *
     * Tuong ung f_oTblSubMenu.DefaultView.RowFilter = "Link = '<Link>'".
     *
     * @return array<int, array<string, string>>
     */
    public function subMenuOptions(): array
    {
        $link = $this->currentMainLink();

        if (null === $link) {
            return [];
        }

        return array_values(array_filter(
            $this->subMenus,
            static fn (array $row): bool => (string) ($row['Link'] ?? '') === $link
        ));
    }

    /**
     * Danh sach chuc nang da loc theo "So lieu" dang chon.
     *
     * Tuong ung f_oTblGroupRight.DefaultView.RowFilter =
     *   "SUBSTRING(MenuID,1,5) = '<5 ky tu dau MenuID>'".
     *
     * @return array<int, array<string, mixed>>
     */
    public function filteredRights(): array
    {
        if (null === $this->subMenuId || '' === $this->subMenuId) {
            return [];
        }

        $prefix = mb_substr($this->subMenuId, 0, 5);

        return array_values(array_filter(
            $this->rights,
            static fn (array $row): bool => mb_substr((string) ($row['MenuID'] ?? ''), 0, 5) === $prefix
        ));
    }

    /**
     * Bat/tat 1 quyen cua 1 chuc nang.
     */
    public function toggleRight(string $menuId, string $column): void
    {
        if (!\in_array($column, ['ViewRight', 'InsertRight', 'UpdateRight', 'DeleteRight'], true)) {
            return;
        }

        foreach ($this->rights as $index => $row) {
            if ((string) ($row['MenuID'] ?? '') !== $menuId) {
                continue;
            }

            $this->rights[$index][$column] = !(bool) ($row[$column] ?? false);

            return;
        }
    }

    /**
     * Luu — theo cmdSave_Click cua form goc.
     *
     * Voi moi dong THAY DOI:
     *   1. asDelGroupRight(group, menuId)
     *   2. Neu con bat ky quyen nao -> asInsGroupRight(viewRight: true, ...)
     *      (viewright LUON = true, giong form goc)
     */
    public function save(): void
    {
        $this->errorMessage = null;
        $this->successMessage = null;

        if ('' === $this->groupName) {
            $this->errorMessage = 'Chưa chọn nhóm để phân quyền.';

            return;
        }

        $changed = $this->changedRows();

        if ([] === $changed) {
            $this->successMessage = 'Không có thay đổi nào cần lưu.';

            return;
        }

        $saved = 0;

        try {
            foreach ($changed as $row) {
                $menuId = (string) ($row['MenuID'] ?? '');

                if ('' === $menuId) {
                    continue;
                }

                AsDelGroupRight::call([
                    'pGroupName' => $this->groupName,
                    'pMenuID'    => $menuId,
                    'pRet'       => 0,
                ]);

                $insert = (bool) ($row['InsertRight'] ?? false);
                $update = (bool) ($row['UpdateRight'] ?? false);
                $delete = (bool) ($row['DeleteRight'] ?? false);
                $view = (bool) ($row['ViewRight'] ?? false);

                // Form goc: chi insert khi co IT NHAT 1 quyen.
                if ($view || $insert || $update || $delete) {
                    AsInsGroupRight::call([
                        'pGroupName'   => $this->groupName,
                        'pMenuID'      => $menuId,
                        // viewright LUON = true (giong cmdSave_Click)
                        'pViewRight'   => 1,
                        'pInsertRight' => $insert ? 1 : 0,
                        'pUpdateRight' => $update ? 1 : 0,
                        'pDeleteRight' => $delete ? 1 : 0,
                        'pRet'         => 0,
                    ]);
                }

                ++$saved;
            }
        } catch (\Throwable $exception) {
            report($exception);
            $this->errorMessage = 'Không lưu được phân quyền. Vui lòng kiểm tra lại.';

            return;
        }

        $this->loadRights();
        $this->successMessage = 'Đã lưu phân quyền cho nhóm ' . $this->groupName . '.';
    }

    public function render(): View
    {
        return view('catalog::si.vch.sigroupinfo-rights', [
            'subMenuOptions' => $this->subMenuOptions(),
            'filteredRights' => $this->filteredRights(),
        ])->layout('catalog::layouts.app');
    }

    /**
     * Link cua "Phan he" dang chon.
     */
    protected function currentMainLink(): ?string
    {
        if (null === $this->mainMenuId || '' === $this->mainMenuId) {
            return null;
        }

        foreach ($this->mainMenus as $row) {
            if ((string) ($row['MenuID'] ?? '') === $this->mainMenuId) {
                return (string) ($row['Link'] ?? '');
            }
        }

        return null;
    }

    /**
     * Chon "So lieu" dau tien cua Phan he (giong form goc: SelectedValue = row 0).
     */
    protected function selectFirstSubMenu(): void
    {
        $options = $this->subMenuOptions();

        if ([] !== $options) {
            $this->subMenuId = (string) ($options[0]['MenuID'] ?? '');
        }
    }

    protected function selectFirstMenu(): void
    {
        if ([] !== $this->mainMenus) {
            $this->mainMenuId = (string) ($this->mainMenus[0]['MenuID'] ?? '');
            $this->selectFirstSubMenu();
        }
    }

    protected function loadMenus(): void
    {
        try {
            $this->mainMenus = $this->normalizeMenus(AsGetMenuBar::call(['pLanguage' => 'vi-VN'])->all());
            $this->subMenus = $this->normalizeSubMenus(AsGetMenuDetail::call(['pLanguage' => 'vi-VN'])->all());
        } catch (\Throwable $exception) {
            report($exception);
            $this->errorMessage = 'Không tải được danh sách phân hệ.';
        }
    }

    protected function loadRights(): void
    {
        try {
            $rows = AsSiGetAllGroupRights::call(['pGroupName' => $this->groupName])->all();
        } catch (\Throwable $exception) {
            report($exception);
            $this->errorMessage = 'Không tải được phân quyền của nhóm.';

            return;
        }

        $normalized = [];

        foreach ($rows as $row) {
            $data = \is_array($row) ? $row : (array) $row;

            $normalized[] = [
                'MenuID'      => (string) ($data['MenuID'] ?? ''),
                'Bar'         => (string) ($data['Bar'] ?? ''),
                'LinkDetail'  => (string) ($data['LinkDetail'] ?? ''),
                'Link'        => (string) ($data['Link'] ?? ''),
                'ViewRight'   => (bool) ($data['ViewRight'] ?? false),
                'InsertRight' => (bool) ($data['InsertRight'] ?? false),
                'UpdateRight' => (bool) ($data['UpdateRight'] ?? false),
                'DeleteRight' => (bool) ($data['DeleteRight'] ?? false),
            ];
        }

        $this->rights = $normalized;

        // Ban sao ban dau de tinh thay doi
        $this->originalRights = [];

        foreach ($normalized as $row) {
            $this->originalRights[(string) $row['MenuID']] = [
                'ViewRight'   => (bool) $row['ViewRight'],
                'InsertRight' => (bool) $row['InsertRight'],
                'UpdateRight' => (bool) $row['UpdateRight'],
                'DeleteRight' => (bool) $row['DeleteRight'],
            ];
        }
    }

    /**
     * Cac dong co it nhat 1 quyen thay doi so voi ban dau.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function changedRows(): array
    {
        $changed = [];

        foreach ($this->rights as $row) {
            $menuId = (string) ($row['MenuID'] ?? '');
            $before = $this->originalRights[$menuId] ?? [
                'ViewRight'   => false,
                'InsertRight' => false,
                'UpdateRight' => false,
                'DeleteRight' => false,
            ];

            foreach (['ViewRight', 'InsertRight', 'UpdateRight', 'DeleteRight'] as $column) {
                if ((bool) ($row[$column] ?? false) !== (bool) $before[$column]) {
                    $changed[] = $row;

                    continue 2;
                }
            }
        }

        return $changed;
    }

    /**
     * @param array<int, mixed> $rows
     *
     * @return array<int, array<string, string>>
     */
    protected function normalizeMenus(array $rows): array
    {
        $out = [];

        foreach ($rows as $row) {
            $data = \is_array($row) ? $row : (array) $row;

            $out[] = [
                'MenuID' => (string) ($data['MenuID'] ?? ''),
                'bar'    => (string) ($data['bar'] ?? ''),
                'Link'   => (string) ($data['Link'] ?? ''),
            ];
        }

        return $out;
    }

    /**
     * @param array<int, mixed> $rows
     *
     * @return array<int, array<string, string>>
     */
    protected function normalizeSubMenus(array $rows): array
    {
        $out = [];

        foreach ($rows as $row) {
            $data = \is_array($row) ? $row : (array) $row;

            $out[] = [
                'MenuID'     => (string) ($data['MenuID'] ?? ''),
                'bar'        => (string) ($data['bar'] ?? ''),
                'LinkDetail' => (string) ($data['LinkDetail'] ?? ''),
                'Link'       => (string) ($data['Link'] ?? ''),
            ];
        }

        return $out;
    }
}
