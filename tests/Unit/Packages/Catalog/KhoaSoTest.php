<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Catalog;

use Diepxuan\Catalog\Services\KhoaSo;
use Diepxuan\Catalog\Services\KhoaSoException;
use PHPUnit\Framework\TestCase;

/**
 * Unit test cho helper khóa sổ (task 360).
 *
 * Test thuần logic so sánh ngày — không chạm DB: subclass override lockDate()
 * để cố định ngày khóa sổ của từng công ty.
 */
final class KhoaSoTest extends TestCase
{
    private function service(string $ngayKs, array $extra = []): KhoaSo
    {
        $map = ['001' => $ngayKs] + $extra;

        return new class($map) extends KhoaSo {
            public function __construct(private array $map) {}

            public function lockDate(?string $maCty = null): ?string
            {
                $maCty = $maCty ?: '001';

                return $this->map[$maCty] ?? null;
            }
        };
    }

    public function testDocumentDateBeforeLockDateIsLocked(): void
    {
        $khoaSo = $this->service('2026-06-30');

        self::assertTrue($khoaSo->isDocumentDateLocked('2026-06-15'));
    }

    public function testDocumentDateEqualToLockDateIsLocked(): void
    {
        $khoaSo = $this->service('2026-06-30');

        // Simba quy dinh hop le khi ngay_ct > ngay_ks, nen bang nhau van bi chan.
        self::assertTrue($khoaSo->isDocumentDateLocked('2026-06-30'));
    }

    public function testDocumentDateAfterLockDateIsAllowed(): void
    {
        $khoaSo = $this->service('2026-06-30');

        self::assertFalse($khoaSo->isDocumentDateLocked('2026-07-01'));
    }

    public function testDocumentDateLockedReturnsFalseWithoutConfig(): void
    {
        $khoaSo = $this->service('', ['001' => null]);

        // Khong co cau hinh ngay khoa so -> khong chan nham.
        self::assertFalse($khoaSo->isDocumentDateLocked('2020-01-01', '001'));
    }

    public function testDocumentDateLockedReturnsFalseForEmptyDate(): void
    {
        $khoaSo = $this->service('2026-06-30');

        self::assertFalse($khoaSo->isDocumentDateLocked(null));
        self::assertFalse($khoaSo->isDocumentDateLocked(''));
    }

    public function testPeriodIsLockedWhenEndDateNotAfterLockDate(): void
    {
        $khoaSo = $this->service('2026-06-30');

        self::assertTrue($khoaSo->isPeriodLocked('2026-06-01', '2026-06-30'));
        self::assertFalse($khoaSo->isPeriodLocked('2026-07-01', '2026-07-31'));
    }

    public function testPeriodLockedFallsBackToStartDateWhenEndDateMissing(): void
    {
        $khoaSo = $this->service('2026-06-30');

        self::assertTrue($khoaSo->isPeriodLocked('2026-06-01', null));
        self::assertFalse($khoaSo->isPeriodLocked('2026-08-01', null));
    }

    public function testAssertDocumentDateThrowsVietnameseMessage(): void
    {
        $khoaSo = $this->service('2026-06-30');

        $this->expectException(KhoaSoException::class);
        $this->expectExceptionMessage(KhoaSo::MESSAGE_DOCUMENT_LOCKED);

        $khoaSo->assertDocumentDateNotLocked('2026-06-01');
    }

    public function testAssertDocumentDatePassesForOpenPeriod(): void
    {
        $khoaSo = $this->service('2026-06-30');

        $khoaSo->assertDocumentDateNotLocked('2026-09-15');

        self::assertTrue(true, 'Khong nem exception voi chung tu ngoai ky khoa so.');
    }

    public function testAssertPeriodThrowsVietnameseMessage(): void
    {
        $khoaSo = $this->service('2026-06-30');

        $this->expectException(KhoaSoException::class);
        $this->expectExceptionMessage(KhoaSo::MESSAGE_PERIOD_LOCKED);

        $khoaSo->assertPeriodNotLocked('2026-05-01', '2026-05-31');
    }

    public function testDifferentCompanyUsesItsOwnLockDate(): void
    {
        // 001 khoa den 2026-06-30 (chua qua), 002 da khoa den 2025-12-31.
        $khoaSo = $this->service('2026-06-30', ['002' => '2025-12-31']);

        // 2026-03-01 nam trong ky da khoa cua 001 -> bi chan.
        self::assertTrue($khoaSo->isDocumentDateLocked('2026-03-01', '001'));
        // Nhung sau ky khoa cua 002 -> duoc phep.
        self::assertFalse($khoaSo->isDocumentDateLocked('2026-03-01', '002'));
        // Va 2026-09-15 ngoai ky khoa cua 001 -> duoc phep.
        self::assertFalse($khoaSo->isDocumentDateLocked('2026-09-15', '001'));
    }

    public function testMessageConstantsAreVietnameseAndMentionKhoaSo(): void
    {
        self::assertStringContainsString('khóa sổ', KhoaSo::MESSAGE_DOCUMENT_LOCKED);
        self::assertStringContainsString('khóa sổ', KhoaSo::MESSAGE_PERIOD_LOCKED);
    }
}
