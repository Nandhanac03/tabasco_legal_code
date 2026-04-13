<?php
session_start();
$_SESSION['user_id'] = 34; // Admin user

require_once __DIR__ . '/Area.php';

$area = new Area();

// Add new area
$area->Save_Area([
    'title' => 'New Area',
    'description' => 'Testing',
    'status' => 1,
    'created_by' => $_SESSION['user_id'],
    'updated_by' => $_SESSION['user_id']
]);

// Update area ID=1
$area->Save_Area([
    'title' => 'Updated Area',
    'description' => 'Updated desc',
    'status' => 1,
    'updated_by' => $_SESSION['user_id']
], 1);

echo "Check legal_activity_log table for entries!";
