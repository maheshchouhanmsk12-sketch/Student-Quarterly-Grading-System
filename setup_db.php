<?php
require_once('DBConnection.php');

$key = isset($_GET['key']) ? $_GET['key'] : '';
if ($key !== 'install_sqgs_2026') {
    die("Access denied. Invalid or missing key.");
}

// Try disabling primary key requirement in session if allowed
@$conn->query("SET SESSION sql_require_primary_key = 0");

$tables = [
    "CREATE TABLE IF NOT EXISTS `admin_list` (
        `admin_id` int(30) NOT NULL AUTO_INCREMENT,
        `fullname` text NOT NULL,
        `username` text NOT NULL,
        `password` text NOT NULL,
        `status` tinyint(1) NOT NULL DEFAULT 1,
        `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`admin_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `subjects` (
        `subject_id` int(30) NOT NULL AUTO_INCREMENT,
        `name` text NOT NULL,
        `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (`subject_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `grading_components` (
        `component_id` int(30) NOT NULL AUTO_INCREMENT,
        `name` text NOT NULL,
        `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (`component_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `class_list` (
        `class_id` int(30) NOT NULL AUTO_INCREMENT,
        `subject_id` int(30) NOT NULL,
        `grade` text NOT NULL,
        `section` text NOT NULL,
        `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (`class_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `component_subject_percentage` (
        `csp_id` int(30) NOT NULL AUTO_INCREMENT,
        `subject_id` int(30) NOT NULL,
        `component_id` int(30) NOT NULL,
        `percentage` text NOT NULL,
        PRIMARY KEY (`csp_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `student_list` (
        `student_id` int(30) NOT NULL AUTO_INCREMENT,
        `class_id` int(30) NOT NULL,
        `name` text NOT NULL,
        PRIMARY KEY (`student_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `assessment_list` (
        `assessment_id` int(30) NOT NULL AUTO_INCREMENT,
        `class_id` int(30) NOT NULL,
        `component_id` int(30) NOT NULL,
        `quarter` int(30) NOT NULL,
        `name` text NOT NULL,
        `hps` double NOT NULL DEFAULT 0,
        PRIMARY KEY (`assessment_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `transmutation_table` (
        `trans_id` int(30) NOT NULL AUTO_INCREMENT,
        `from` double NOT NULL DEFAULT 0,
        `to` double NOT NULL DEFAULT 0,
        `grade` double NOT NULL DEFAULT 0,
        PRIMARY KEY (`trans_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `mark_list` (
        `id` int NOT NULL AUTO_INCREMENT,
        `assessment_id` int(30) NOT NULL,
        `student_id` int(30) NOT NULL,
        `mark` double NOT NULL DEFAULT 0,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
];

echo "<h3>Initializing SQGS Tables on Aiven...</h3>";

foreach ($tables as $sql) {
    if (!$conn->query($sql)) {
        echo "<p style='color:red;'>Table Creation Error: " . $conn->error . "</p>";
    }
}

// Check if admin user already exists, if not, insert dummy data
$check_admin = $conn->query("SELECT count(*) as cnt FROM admin_list")->fetch_assoc()['cnt'];
if ($check_admin == 0) {
    $conn->query("INSERT INTO `admin_list` (`admin_id`, `fullname`, `username`, `password`, `status`, `date_created`) VALUES
        (1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1, CURRENT_TIMESTAMP),
        (2, 'User 1', 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 1, CURRENT_TIMESTAMP)");

    $conn->query("INSERT INTO `grading_components` (`component_id`, `name`, `delete_flag`) VALUES
        (1, 'Written Works', 0),
        (2, 'Performance Tasks', 0),
        (3, 'Quarterly Assessment', 0)");

    $conn->query("INSERT INTO `subjects` (`subject_id`, `name`, `delete_flag`) VALUES
        (1, 'English', 0),
        (2, 'Math', 0),
        (3, 'Science', 0),
        (4, 'Filipino', 0),
        (5, 'AP', 0),
        (6, 'ESP', 0)");

    $conn->query("INSERT INTO `class_list` (`class_id`, `subject_id`, `grade`, `section`, `delete_flag`) VALUES
        (1, 1, '7', 'A', 0),
        (2, 1, '8', 'A', 0),
        (5, 1, '7', 'B', 0),
        (6, 2, '7', 'A', 0),
        (7, 2, '7', 'B', 0),
        (8, 6, '7', 'C', 0),
        (9, 6, '7', 'A', 0)");

    $conn->query("INSERT INTO `student_list` (`student_id`, `class_id`, `name`) VALUES
        (1, 6, 'Blake, Samantha'),
        (2, 6, 'Cooper, Claire'),
        (3, 6, 'Davis, John'),
        (4, 6, 'Miller, Mark'),
        (5, 6, 'Smith, George'),
        (6, 6, 'Smith, Samantha'),
        (7, 6, 'Williams, Mike')");

    $conn->query("INSERT INTO `transmutation_table` (`trans_id`, `from`, `to`, `grade`) VALUES
        (1, 100, 100, 100), (2, 98.4, 99.99, 99), (3, 96.8, 98.39, 98), (4, 95.2, 96.79, 97),
        (5, 93.6, 95.19, 96), (6, 92, 93.59, 95), (7, 90.4, 91.99, 94), (8, 88.8, 90.39, 93),
        (9, 87.2, 88.79, 92), (10, 85.6, 87.19, 91), (11, 84, 85.59, 90), (12, 82.4, 83.99, 89),
        (13, 80.8, 82.39, 88), (14, 79.2, 80.79, 87), (15, 77.6, 79.19, 86), (16, 76, 77.59, 85),
        (17, 74.4, 75.99, 84), (18, 72.8, 74.39, 83), (19, 71.2, 72.79, 82), (20, 69.6, 71.19, 81),
        (21, 68, 69.59, 80), (22, 66.4, 67.99, 79), (23, 64.8, 66.39, 78), (24, 63.2, 64.79, 77),
        (25, 61.6, 63.19, 76), (26, 60, 61.59, 75), (27, 56, 59.99, 74), (28, 52, 55.99, 73),
        (29, 48, 51.99, 72), (30, 44, 47.99, 71), (31, 40, 43.99, 70), (32, 36, 39.99, 69),
        (33, 32, 35.99, 68), (34, 28, 31.99, 67), (35, 24, 27.99, 66), (36, 20, 23.99, 65),
        (37, 16, 19.99, 64), (38, 12, 15.99, 63), (39, 8, 11.99, 62), (40, 4, 7.99, 61),
        (41, 0, 3.99, 60)");

    echo "<p style='color:green; font-weight:bold;'>All tables and sample data imported successfully!</p>";
} else {
    echo "<p style='color:blue;'>Tables already exist with data.</p>";
}

echo "<p><a href='./login.php'>Go to Login Page</a></p>";
