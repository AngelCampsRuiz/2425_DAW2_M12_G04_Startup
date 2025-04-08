<?php

// This script will check the roles table structure in detail
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check if roles table exists
$rolesTableExists = DB::select("SHOW TABLES LIKE 'roles'");

if (count($rolesTableExists) > 0) {
    $columns = DB::select("SHOW COLUMNS FROM roles");
    echo "Roles table structure:\n";
    foreach ($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }
    
    // Check if there's any data in the roles table
    $rolesCount = DB::table('roles')->count();
    echo "\nNumber of rows in roles table: " . $rolesCount . "\n";
    
    if ($rolesCount > 0) {
        $roles = DB::table('roles')->get();
        echo "\nRoles data:\n";
        foreach ($roles as $role) {
            echo "ID: " . $role->id . " - ";
            foreach ((array)$role as $key => $value) {
                if ($key !== 'id') {
                    echo $key . ": " . $value . ", ";
                }
            }
            echo "\n";
        }
    }
} else {
    echo "Roles table does not exist\n";
}

echo "\nCheck complete!\n";
