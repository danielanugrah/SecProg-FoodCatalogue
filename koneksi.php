<?php

// Load database credentials from environment variables
$server = getenv('DB_SERVER') ?: 'localhost';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME') ?: 'db_restaurant';

// Establish connection to the database
$konek = mysqli_connect($server, $username, $password, $database);

// Check if the connection was successful
if (!$konek) {
    error_log(mysqli_connect_error(), 0); // Log the error
    die("Database connection failed."); // Show a generic error to the user
}

?>
