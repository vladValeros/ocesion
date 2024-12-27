<?php
require_once '../classes/database.class.php';

// Initialize the Database connection
$database = new Database();
$pdo = $database->getConnection();

// Check if student_number is provided
if (isset($_GET['student_number'])) {
    $student_number = trim($_GET['student_number']);
    
    // Prepare and execute the query
    $stmt = $pdo->prepare("
        SELECT 
            CONCAT(last_name, ', ', first_name, ' ', middle_name) AS name, 
            course 
        FROM students 
        WHERE student_number = :student_number
    ");
    $stmt->bindParam(':student_number', $student_number);
    $stmt->execute();
    
    // Fetch the student data
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return response as JSON
    if ($student) {
        echo json_encode(['success' => true, 'name' => $student['name'], 'course' => $student['course']]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
