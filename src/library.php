<?php
declare(strict_types=1);
namespace Pas2\PaginationWindow;

function pageWindow(
    int $totalItems,
    int $pageSize,
    int $current,
    int $radius = 2,
): array {
    if ($totalItems < 0 || $pageSize < 1 || $radius < 0 || $radius > 1000) {
        throw new \InvalidArgumentException("Invalid pagination inputs");
    }
    $pages =
        intdiv($totalItems, $pageSize) + ($totalItems % $pageSize > 0 ? 1 : 0);
    if ($pages === 0) {
        return [
            "current" => 0,
            "totalPages" => 0,
            "pages" => [],
            "hasPrevious" => false,
            "hasNext" => false,
        ];
    }
    $current = max(1, min($current, $pages));
    $start = max(1, $current - $radius);
    $end =
        $current > PHP_INT_MAX - $radius
            ? $pages
            : min($pages, $current + $radius);
    return [
        "current" => $current,
        "totalPages" => $pages,
        "pages" => range($start, $end),
        "hasPrevious" => $current > 1,
        "hasNext" => $current < $pages,
    ];
}
