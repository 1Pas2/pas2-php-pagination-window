<?php
declare(strict_types=1);
namespace Pas2\PaginationWindow;

require __DIR__ . "/../src/library.php";
function check(bool $condition, string $message): void
{
    if (!$condition) {
        throw new \RuntimeException($message);
    }
}
function fails(callable $fn): void
{
    try {
        $fn();
    } catch (\Throwable) {
        return;
    }
    throw new \RuntimeException("Expected failure");
}
$p = pageWindow(101, 10, 5, 1);
check($p["pages"] === [4, 5, 6], "window");
check($p["totalPages"] === 11, "ceil");
check(pageWindow(0, 10, 1)["current"] === 0, "empty");
check(pageWindow(12, 10, 99)["current"] === 2, "clamp");
check(
    pageWindow(PHP_INT_MAX, PHP_INT_MAX, 1)["totalPages"] === 1,
    "overflow safe",
);
fails(fn() => pageWindow(1, 0, 1));
echo "All checks passed\n";
