<?php

// This script will help diagnose and fix database issues
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check database connection
try {
    $connection = DB::connection();
    echo "Database connection successful!\n";
} catch (\Exception $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Check if user table exists
$userTableExists = DB::select("SHOW TABLES LIKE 'user'");
$usersTableExists = DB::select("SHOW TABLES LIKE 'users'");

echo "User table exists: " . (count($userTableExists) > 0 ? "Yes" : "No") . "\n";
echo "Users table exists: " . (count($usersTableExists) > 0 ? "Yes" : "No") . "\n";

// Show user table structure if it exists
if (count($userTableExists) > 0) {
    $columns = DB::select("SHOW COLUMNS FROM user");
    echo "\nUser table structure:\n";
    foreach ($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }
}

// Show users table structure if it exists
if (count($usersTableExists) > 0) {
    $columns = DB::select("SHOW COLUMNS FROM users");
    echo "\nUsers table structure:\n";
    foreach ($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }
}

// Check foreign key references
$tables = ['empresas', 'estudiantes', 'tutores'];
foreach ($tables as $table) {
    $tableExists = DB::select("SHOW TABLES LIKE '$table'");
    if (count($tableExists) > 0) {
        $foreignKeys = DB::select("
            SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = '$table'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        echo "\nForeign keys for $table:\n";
        foreach ($foreignKeys as $fk) {
            echo "- " . $fk->COLUMN_NAME . " references " . $fk->REFERENCED_TABLE_NAME . "." . $fk->REFERENCED_COLUMN_NAME . "\n";
        }
    } else {
        echo "\nTable $table does not exist\n";
    }
}

echo "\nDiagnosis complete!\n";
