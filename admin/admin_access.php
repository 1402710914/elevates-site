<?php
// Shared access helpers for admin panel pages.
// Team members should be able to manage blogs only.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_admin_login(): void
{
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: admin_login.php');
        exit;
    }
}

function is_super_admin(): bool
{
    // Backward compatible default: existing admins behave as super admin.
    return (bool)($_SESSION['admin_is_super_admin'] ?? true);
}

function require_super_admin(): void
{
    if (!is_super_admin()) {
        header('Location: admin_dashboard.php?noaccess=1');
        exit;
    }
}

function can_manage_blogs(): bool
{
    // Backward compatible default: if permission is missing, allow (existing admins).
    return (bool)($_SESSION['can_manage_blogs'] ?? true);
}

function require_can_manage_blogs(): void
{
    if (!can_manage_blogs()) {
        header('Location: admin_dashboard.php?noaccess=1');
        exit;
    }
}

function can_access_permission(string $permissionKey): bool
{
    if (is_super_admin()) {
        return true;
    }

    $raw = $_SESSION[$permissionKey] ?? 0;
    return ((int)$raw === 1) || ($raw === true);
}

function require_permission(string $permissionKey): void
{
    if (!can_access_permission($permissionKey)) {
        header('Location: admin_dashboard.php?noaccess=1');
        exit;
    }
}

