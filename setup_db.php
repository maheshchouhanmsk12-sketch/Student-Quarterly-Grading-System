<?php
require_once('DBConnection.php');

$key = isset($_GET['key']) ? $_GET['key'] : '';
if ($key !== 'install_sqgs_2026') {
    die("Access denied. Invalid or missing key.");
}

$sql_file = __DIR__ . '/database/sqgs_db.sql';
if (!file_exists($sql_file)) {
    die("Error: sqgs_db.sql not found at " . $sql_file);
}

$sql_content = file_get_contents($sql_file);

// Clean up comments
$lines = explode("\n", $sql_content);
$clean_sql = "";
$in_comment = false;

foreach ($lines as $line) {
    $trimmed = trim($line);
    if (empty($trimmed)) continue;
    if (strpos($trimmed, '/*') === 0 && strpos($trimmed, '*/') === false) {
        $in_comment = true;
        continue;
    }
    if ($in_comment) {
        if (strpos($trimmed, '*/') !== false) {
            $in_comment = false;
        }
        continue;
    }
    if (strpos($trimmed, '--') === 0 || strpos($trimmed, '#') === 0) {
        continue;
    }
    $clean_sql .= $line . "\n";
}

// Split by semicolon
$queries = explode(";\n", $clean_sql);
$success_count = 0;
$errors = [];

foreach ($queries as $query) {
    $q = trim($query);
    if (!empty($q)) {
        if ($conn->query($q)) {
            $success_count++;
        } else {
            // Ignore minor duplicate errors if tables already exist
            if ($conn->errno != 1050) {
                $errors[] = "Error (" . $conn->errno . "): " . $conn->error . " in query: " . substr($q, 0, 50);
            }
        }
    }
}

echo "<h3>SQGS Database Setup Status</h3>";
echo "<p><strong>Database Name:</strong> " . (getenv('DB_NAME') ?: (getenv('MYSQL_DATABASE') ?: 'defaultdb')) . "</p>";
echo "<p><strong>Queries Executed Successfully:</strong> " . $success_count . "</p>";

if (!empty($errors)) {
    echo "<h4>Warnings / Errors:</h4><ul>";
    foreach ($errors as $err) {
        echo "<li>" . htmlspecialchars($err) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: green; font-weight: bold;'>All tables and default data imported successfully!</p>";
}
echo "<p><a href='./login.php'>Go to Login Page</a></p>";
