<?php
session_start();
require_once 'database.class.php'; // Include the Database class

// Initialize Database instance and get PDO connection
$database = new Database();
$pdo = $database->getConnection();

// Initialize variables
$username = $password = $role = "";
$username_err = $password_err = $role_err = "";

// Fetch user details by student number and insert them into the users table
function addUserByStudentNumber($student_number, $role, $password) {
    global $pdo;

    // Fetch student details
    $sql_fetch = "SELECT last_name, first_name, middle_name FROM students WHERE student_number = :student_number";
    $stmt_fetch = $pdo->prepare($sql_fetch);
    $stmt_fetch->bindParam(":student_number", $student_number, PDO::PARAM_STR);
    $stmt_fetch->execute();
    $student = $stmt_fetch->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        return "Invalid student number.";
    }

    // Combine full name
    $full_name = $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name'];

    // Check for duplicate username
    $sql_check = "SELECT id FROM users WHERE username = :username";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(":username", $student_number, PDO::PARAM_STR);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        return "Username already exists.";
    }

    // Hash the password before inserting
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $sql_insert = "INSERT INTO users (username, role, full_name, password) VALUES (:username, :role, :full_name, :password)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindParam(":username", $student_number, PDO::PARAM_STR);
    $stmt_insert->bindParam(":role", $role, PDO::PARAM_STR);
    $stmt_insert->bindParam(":full_name", $full_name, PDO::PARAM_STR);
    $stmt_insert->bindParam(":password", $hashed_password, PDO::PARAM_STR);  // Bind hashed password

    if ($stmt_insert->execute()) {
        return true; // Success
    }

    return "Failed to add user.";
}

// Handle Create and Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate student number
    $student_number = trim($_POST['student_number']);
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';  // Check if 'role' exists in POST data
    $password = trim($_POST['password']);  // Get password from POST

    // Validate student number
    if (empty($student_number)) {
        $username_err = "Student number is required.";
    }
    if (empty($role)) {
        $role_err = "Role is required.";  // Provide error message if role is empty
    }
    if (empty($password)) {
        $password_err = "Password is required.";  // Validate password
    }

    // If updating
    if (empty($username_err) && empty($role_err) && isset($_POST['update_id']) && !empty($_POST['update_id'])) {
        $update_id = $_POST['update_id'];
        $sql_update = "UPDATE users SET username = :username, role = :role WHERE id = :id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(":username", $student_number, PDO::PARAM_STR);
        $stmt_update->bindParam(":role", $role, PDO::PARAM_STR);
        $stmt_update->bindParam(":id", $update_id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            header("Location: users.php");
            exit();
        } else {
            echo "Failed to update user.";
        }
    }

    // If adding
    if (empty($username_err) && empty($role_err) && empty($password_err)) {
        $result = addUserByStudentNumber($student_number, $role, $password);  // Pass password to function
        if ($result === true) {
            header("Location: users.php");
            exit();
        } else {
            echo "<script>alert('Error: $result'); window.history.back();</script>";
        }
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM users WHERE id = :id";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->bindParam(":id", $delete_id, PDO::PARAM_INT);

    if ($stmt_delete->execute()) {
        header("Location: users.php");
        exit();
    } else {
        echo "Failed to delete user.";
    }
}

// Fetch all users
$sql_fetch_all = "SELECT id, username, role, full_name FROM users ORDER BY username ASC";
$users = $pdo->query($sql_fetch_all)->fetchAll(PDO::FETCH_ASSOC);
?>
