<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Catalog;

use Diepxuan\Catalog\Http\Livewire\Ca\Dict\Ardmkh as CaArdmkh;
use Diepxuan\Catalog\Http\Livewire\Po\Dict\Ardmkh as PoArdmkh;
use Diepxuan\Catalog\Http\Livewire\So\Dict\Ardmkh as SoArdmkh;
use Tests\TestCase;

/**
 * Pin hành vi Alpine-search của 3 danh sách ARDMKH: load toàn bộ rows một lần,
 * tìm kiếm chạy phía client (Alpine); page không dùng pagination.
 */
final class ArdmkhListTest extends TestCase
{
    public function testBaseArdmkhDeclaresProtectedHooksForSubclasses(): void
    {
        foreach (['spModuleId', 'listView', 'moduleLabel'] as $hook) {
            $method = new \ReflectionMethod(PoArdmkh::class, $hook);
            self::assertTrue($method->isProtected(), "Po\\Dict\\Ardmkh::{$hook} phai la protected.");
            self::assertTrue(PoArdmkh::class === $method->getDeclaringClass()->getName(), "Po\\Dict\\Ardmkh::{$hook} phai khai bao o base.");
        }
    }

    public function testSubclassesExposeDistinctSpModuleId(): void
    {
        $cases = [
            PoArdmkh::class => 'AP',
            SoArdmkh::class => 'AR',
            CaArdmkh::class => 'CA',
        ];

        foreach ($cases as $class => $expected) {
            $method = new \ReflectionMethod($class, 'spModuleId');
            $method->setAccessible(true);
            self::assertSame($expected, $method->invoke(new $class()), "{$class} phai tra spModuleId = {$expected}.");
        }
    }

    public function testSubclassesExposeDistinctListViews(): void
    {
        $cases = [
            PoArdmkh::class => 'catalog::po.dict.ardmkh',
            SoArdmkh::class => 'catalog::so.dict.ardmkh',
            CaArdmkh::class => 'catalog::ca.dict.ardmkh',
        ];

        foreach ($cases as $class => $expected) {
            $method = new \ReflectionMethod($class, 'listView');
            $method->setAccessible(true);
            self::assertSame($expected, $method->invoke(new $class()));
        }
    }

    public function testSubclassesExposeDistinctModuleLabels(): void
    {
        $cases = [
            PoArdmkh::class => 'PO',
            SoArdmkh::class => 'SO',
            CaArdmkh::class => 'CA',
        ];

        foreach ($cases as $class => $expected) {
            $method = new \ReflectionMethod($class, 'moduleLabel');
            $method->setAccessible(true);
            self::assertSame($expected, $method->invoke(new $class()));
        }
    }

    public function testDeleteMessagesDifferPerModule(): void
    {
        $cases = [
            PoArdmkh::class => 'nhà cung cấp',
            SoArdmkh::class => 'khách hàng',
            CaArdmkh::class => 'nhân viên',
        ];

        foreach ($cases as $class => $expectedLabel) {
            $component = new $class();

            $notFound = new \ReflectionMethod($class, 'notFoundMessage');
            $notFound->setAccessible(true);
            self::assertStringContainsString($expectedLabel, $notFound->invoke($component));

            $hasTx = new \ReflectionMethod($class, 'hasTransactionsMessage');
            $hasTx->setAccessible(true);
            self::assertStringContainsString($expectedLabel, $hasTx->invoke($component));
        }
    }
}
