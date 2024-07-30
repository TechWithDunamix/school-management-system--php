<?php
require_once 'db.php';
require_once 'DatabaseHelper.php';

$db = new Database();
$dbHelper = new DatabaseHelper($db);

// Select all records from a table
$allUsers = $dbHelper->selectAll('Users');
print_r($allUsers);

// Select records with a WHERE clause
$usersWithEmail = $dbHelper->selectWhere('Users', 'Email = ?', ['example@example.com']);
print_r($usersWithEmail);

// Select specific columns from a table
$usernames = $dbHelper->selectColumns('Users', ['Username', 'Email']);
print_r($usernames);

// Select specific columns with a WHERE clause
$usernamesWithEmail = $dbHelper->selectColumnsWhere('Users', ['Username', 'Email'], 'Email = ?', ['example@example.com']);
print_r($usernamesWithEmail);

// Insert a new record into a table
$newUser = [
    'Username' => 'johndoe',
    'PasswordHash' => password_hash('password123', PASSWORD_BCRYPT),
    'Email' => 'johndoe@example.com',
    'FullName' => 'John Doe',
    'PhoneNumber' => '1234567890'
];
$dbHelper->insert('Users', $newUser);

// Update records in a table
$updateData = [
    'FullName' => 'Johnathan Doe'
];
$dbHelper->update('Users', $updateData, 'Username = ?', ['johndoe']);

// Delete records from a table
$dbHelper->delete('Users', 'Username = ?', ['johndoe']);

