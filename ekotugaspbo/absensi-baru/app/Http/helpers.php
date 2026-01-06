<?php

use App\Models\Permission;

if (!function_exists('canAccess')) {
    function canAccess(string $menu): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return Permission::where('role', auth()->user()->role)
            ->where('menu_name', $menu)
            ->where('is_accessible', 1)
            ->exists();
    }
}
