<?php

declare(strict_types=1);

use Diepxuan\Catalog\Services\SimbaMenuRouteMetadata;
use Diepxuan\Catalog\Services\SimbaMenuTargetResolver;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$routes = app(SimbaMenuRouteMetadata::class)->routes();
$errors = [];
$menuIds = [];
$resolver = app(SimbaMenuTargetResolver::class);

foreach ($routes as $routeName => $metadata) {
    $menuid = trim((string) ($metadata['menuid'] ?? ''));
    if ('' === $menuid) {
        $errors[] = "{$routeName}: missing menuid";
        continue;
    }

    if (isset($menuIds[$menuid])) {
        $errors[] = "{$routeName}: duplicate menuid {$menuid} with {$menuIds[$menuid]}";
    }
    $menuIds[$menuid] = $routeName;

    if (!isset($metadata['module'], $metadata['source_type'])) {
        $errors[] = "{$routeName}: missing module/source_type";
    }

    try {
        $resolver->urlForRouteName($routeName, $metadata);
    } catch (Throwable $exception) {
        $errors[] = "{$routeName}: cannot build URL - {$exception->getMessage()}";
    }
}

if ([] !== $errors) {
    fwrite(STDERR, implode(PHP_EOL, $errors) . PHP_EOL);
    exit(1);
}

echo 'Simba menu-backed registries OK: ' . count($routes) . ' routes' . PHP_EOL;
