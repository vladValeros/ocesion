<?php
require_once 'database.class.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables
$event_id = $student_number = $student_name = $time_in = $time_out = $course = "";
$event_id_err = $student_number_err = $time_in_err = $time_out_err = "";

// Initialize database connection
$database = new Database();
$pdo = $database->getConnection();

// Fetch all events for the dropdown
$events = $pdo->query("SELECT * FROM events ORDER BY event_date ASC")->fetchAll(PDO::FETCH_ASSOC);

// Function to log attendance actions
function logAttendanceAction($pdo, $userId, $action, $attendanceId, $description) {
    try {
        $sql = "INSERT INTO attendance_logs (user_id, action, attendance_id, description) 
                VALUES (:user_id, :action, :attendance_id, :description)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':action', $action, PDO::PARAM_STR);
        $stmt->bindParam(':attendance_id', $attendanceId, PDO::PARAM_INT);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Error logging action: " . $e->getMessage());
    }
}

// Determine redirection path based on user role
function getRedirectPath() {
    if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
        return 'attendance.php';
    } else {
        return 'attendance_officer.php';
    }
}

// Handle Create and Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    if (empty(trim($_POST['event_id']))) {
        $event_id_err = "Please select an event.";
    } else {
        $event_id = trim($_POST['event_id']);
    }

    if (empty(trim($_POST['student_number']))) {
        $student_number_err = "Please enter the student number.";
    } else {
        $student_number = trim($_POST['student_number']);
        // Fetch student name and course
        $stmt = $pdo->prepare("
            SELECT 
                CONCAT(last_name, ', ', first_name, ' ', middle_name) AS name, 
                course 
            FROM students 
            WHERE student_number = :student_number
        ");
        $stmt->bindParam(':student_number', $student_number);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            $student_name = $student['name'];
            $course = $student['course'];
        } else {
            $student_number_err = "Student not found.";
        }
    }

    if (empty(trim($_POST['time_in']))) {
        $time_in_err = "Please enter the time in.";
    } else {
        $time_in = trim($_POST['time_in']);
    }

    if (empty(trim($_POST['time_out']))) {
        $time_out_err = "Please enter the time out.";
    } elseif ($time_in >= trim($_POST['time_out'])) {
        $time_out_err = "Time out cannot be earlier than or equal to the time in.";
    } else {
        $time_out = trim($_POST['time_out']);
    }

    // Check input errors before inserting or updating in the database
    if (empty($event_id_err) && empty($student_number_err) && empty($time_in_err) && empty($time_out_err)) {
        if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
            // Update attendance
            $sql = "UPDATE attendance 
                    SET event_id = :event_id, student_number = :student_number, student_name = :student_name, 
                        time_in = :time_in, time_out = :time_out 
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":event_id", $event_id);
            $stmt->bindParam(":student_number", $student_number);
            $stmt->bindParam(":student_name", $student_name);
            $stmt->bindParam(":time_in", $time_in);
            $stmt->bindParam(":time_out", $time_out);
            $stmt->bindParam(":id", $_POST['update_id']);
            $stmt->execute();

            // Log the update action
            logAttendanceAction($pdo, $_SESSION['user']['id'], 'update', $_POST['update_id'], "Updated attendance for student: $student_name");
        } else {
            // Insert new attendance
            $sql = "INSERT INTO attendance (event_id, student_number, student_name, time_in, time_out) 
                    VALUES (:event_id, :student_number, :student_name, :time_in, :time_out)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":event_id", $event_id);
            $stmt->bindParam(":student_number", $student_number);
            $stmt->bindParam(":student_name", $student_name);
            $stmt->bindParam(":time_in", $time_in);
            $stmt->bindParam(":time_out", $time_out);
            $stmt->execute();

            // Log the add action
            $attendanceId = $pdo->lastInsertId();
            logAttendanceAction($pdo, $_SESSION['user']['id'], 'add', $attendanceId, "Added attendance for student: $student_name");
        }

        // Redirect based on user role
        header("Location: " . getRedirectPath() . "?event_id=$event_id");
        exit();
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    // Fetch attendance details for logging
    $stmt = $pdo->prepare("SELECT * FROM attendance WHERE id = :id");
    $stmt->bindParam(":id", $_GET['delete_id']);
    $stmt->execute();
    $attendance = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($attendance) {
        // Log the delete action
        logAttendanceAction($pdo, $_SESSION['user']['id'], 'delete', $_GET['delete_id'], "Deleted attendance for student: " . $attendance['student_name']);

        // Delete the attendance
        $sql = "DELETE FROM attendance WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $_GET['delete_id']);
        $stmt->execute();
    }

    // Redirect based on user role
    header("Location: " . getRedirectPath() . "?event_id=" . htmlspecialchars($_GET['event_id']));
    exit();
}
?>
