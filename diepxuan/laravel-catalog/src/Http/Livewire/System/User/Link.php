<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-07-23 18:30:00
 */

namespace Diepxuan\Catalog\Http\Livewire\System\User;

use Diepxuan\Catalog\Models\System;
use Illuminate\View\View;
use Livewire\Component;

class Link extends Component
{
    public $sysUser;
    public $users;
    public $options;
    public $userId;

    public function loadData(): void {}

    /**
     * Initialize dropdown options + current linked user.
     *
     * Silent fail-safe khi:
     * - $sysUser null (chua co Simba user dang xu ly).
     * - $users null hoac empty (chua load user list).
     * Trong ca 2 truong hop, cac property mac dinh (options=[],
     * userId=null), component se render dropdown rong.
     */
    public function mount(): void
    {
        // Guard $users null/empty de khong crash mapWithKeys
        if (! $this->users || $this->users->isEmpty()) {
            $this->options = [];
            $this->userId  = null;

            return;
        }

        $this->options ??= $this->users
            ->mapWithKeys(static fn ($user) => [
                $user->id => "{$user->name} ({$user->email})",
            ])
            ->toArray();

        // Guard $sysUser null de khong crash username access
        if (! $this->sysUser) {
            $this->userId = null;

            return;
        }

        $username = $this->sysUser->username;

        $this->userId = $this->users
            ->firstWhere(fn ($user) => $username === optional($user->simbaLink)->simba_user_id)
            ?->id;
    }

    /**
     * Cap nhat UserLink row cho user duoc chon trong dropdown.
     *
     * Fail-safe:
     * - User khong ton tai (dropdown stale, bi xoa giua luc) -> skip silent.
     * - $sysUser null (chua co Simba user dang xu ly) -> skip silent.
     * - DB loi (unique constraint, FK, ...) -> flash error, khong crash UI.
     */
    public function updateUserLink(): void
    {
        if (! $this->users || ! $this->sysUser) {
            session()->flash('error', 'Thieu du lieu (users hoac sysUser chua load).');

            return;
        }

        $user = $this->users->where('id', $this->userId)->first();
        if (! $user) {
            session()->flash('error', "User ID {$this->userId} khong ton tai.");

            return;
        }

        try {
            $user->simbaLink()->updateOrCreate(
                ['laravel_user_id' => $user->id],
                ['simba_user_id'   => $this->sysUser->username]
            );

            session()->flash('success', 'Da cap nhat UserLink.');
        } catch (\Throwable $e) {
            \Log::error('UserLink::updateUserLink failed', [
                'user_id' => $user->id,
                'sys_user' => $this->sysUser->username,
                'error'   => $e->getMessage(),
            ]);

            session()->flash('error', 'Khong the cap nhat UserLink: ' . $e->getMessage());
        }
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render()
    {
        // diepxuan/laravel-catalog/resources/views/system/user/link.blade.php
        return view('catalog::system.user.link');
    }
}
