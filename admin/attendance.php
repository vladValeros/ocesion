<?php
require_once '../classes/account.class.php';
require_once '../classes/database.class.php';
require_once '../classes/attendance.class.php';
require_once '../tools/functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if the user is not an admin
Account::redirect_if_not_logged_in('admin');

// Initialize Database instance and get PDO connection
$database = new Database();
$pdo = $database->getConnection();

// Fetch attendance data for the selected event
$attendance_data = [];
if (isset($_GET['event_id'])) {
    $event_id = clean_input($_GET['event_id']);

    // Using the PDO object from Database class to prepare and execute the query
    $stmt = $pdo->prepare("
        SELECT 
            a.id, a.student_number, a.time_in, a.time_out, 
            CONCAT(s.last_name, ', ', s.first_name, ' ', s.middle_name) AS student_name, 
            s.course 
        FROM attendance a 
        INNER JOIN students s ON a.student_number = s.student_number 
        WHERE a.event_id = :event_id 
        ORDER BY a.time_in ASC
    ");
    $stmt->bindParam(':event_id', $event_id);
    $stmt->execute();

    // Fetch the attendance data
    $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include '../includes/_head.php'; ?>
<link href="../css/dashboard.css" rel="stylesheet">
<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<body>
<?php include '../includes/_topnav.php'; ?>
<?php include 'modals_admin/edit_attendance_modal.php'; ?>

<div class="container mt-4">
    <h1>Manage Attendance</h1>

    <!-- Event Selection -->
    <form method="GET" class="mb-4">
        <div class="form-group">
            <label for="event_id">Select Event</label>
            <select class="form-control" id="event_id" name="event_id" onchange="this.form.submit()">
                <option value="">Select...</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['id'] ?>" <?= $event_id == $event['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($event['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if (!empty($event_id)): ?>
        <!-- Form for Create and Update -->
        <form method="POST" class="mb-4">
            <input type="hidden" id="update_id" name="update_id">
            <input type="hidden" name="event_id" value="<?= $event_id ?>">

            <!-- Student Number, Student Name, and Course in One Row -->
            <div class="row mb-3">
                <div class="col-md-4">
                <div class="form-group">
                    <label for="student_number">Student Number</label>
                    <input type="text" class="form-control <?= !empty($student_number_err) ? 'is-invalid' : '' ?>" id="student_number" name="student_number" value="<?= htmlspecialchars($student_number) ?>">
                    <span class="invalid-feedback"><?= $student_number_err ?></span>
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label for="student_name">Student Name</label>
                    <input type="text" class="form-control" id="student_name" name="student_name" readonly>
                </div>
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label for="student_course">Course</label>
                    <input type="text" class="form-control" id="student_course" name="student_course" readonly>
                </div>
                </div>
            </div>

            <!-- Time In and Time Out in One Row -->
            <div class="row mb-3">
                <div class="col-md-6">
                <div class="form-group">
                    <label for="time_in">Time In</label>
                    <input type="time" class="form-control <?= !empty($time_in_err) ? 'is-invalid' : '' ?>" id="time_in" name="time_in" value="<?= htmlspecialchars($time_in) ?>">
                    <span class="invalid-feedback"><?= $time_in_err ?></span>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="time_out">Time Out</label>
                    <input type="time" class="form-control <?= !empty($time_out_err) ? 'is-invalid' : '' ?>" id="time_out" name="time_out" value="<?= htmlspecialchars($time_out) ?>">
                    <span class="invalid-feedback"><?= $time_out_err ?></span>
                </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="form-submit-btn">Add Attendance</button>
        </form>


        <!-- Attendance List -->
        <h2>Attendance List</h2>
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance_data as $entry): ?>
                    <tr>
                        <td><?= htmlspecialchars($entry['student_number']) ?></td>
                        <td><?= htmlspecialchars($entry['student_name']) ?></td>
                        <td><?= htmlspecialchars($entry['course']) ?></td>
                        <td><?= htmlspecialchars($entry['time_in']) ?></td>
                        <td><?= htmlspecialchars($entry['time_out']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="<?= $entry['id'] ?>" data-student_number="<?= $entry['student_number'] ?>" data-time_in="<?= $entry['time_in'] ?>" data-time_out="<?= $entry['time_out'] ?>">
                                Edit
                            </button>
                            <a href="attendance.php?delete_id=<?= $entry['id'] ?>&event_id=<?= $event_id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<footer class="text-center py-3 mt-5">
    <p class="mb-0">&copy; 2024 Event Management System. All Rights Reserved.</p>
</footer>
<script src="../vendor/jquery/jquery.min.js"></script>

<script>
    document.getElementById('student_number').addEventListener('input', function () {
        const studentNumber = this.value;
        if (studentNumber.length > 0) {
            fetch(`get_student_name.php?student_number=${studentNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('student_name').value = data.name;
                        document.getElementById('student_course').value = data.course;
                    } else {
                        document.getElementById('student_name').value = '';
                        document.getElementById('student_course').value = '';
                    }
                });
        } else {
            document.getElementById('student_name').value = '';
            document.getElementById('student_course').value = '';
        }
    });
</script>
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
	
<script>
$(document).ready(function() {
	$('#dataTable').DataTable();  // Ensure this ID matches your table ID
});
</script>

<script>
$(document).ready(function() {
    // Handle Edit Button Click
    $('.edit-btn').on('click', function() {
        // Get data attributes from the clicked button
        const id = $(this).data('id');
        const studentNumber = $(this).data('student_number');
        const timeIn = $(this).data('time_in');
        const timeOut = $(this).data('time_out');

        // Populate the modal fields with the existing data
        $('#edit_update_id').val(id);
        $('#edit_student_number').val(studentNumber);
        $('#edit_time_in').val(timeIn);
        $('#edit_time_out').val(timeOut);

        // Fetch the student name and course dynamically
        fetch(`get_student_name.php?student_number=${studentNumber}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#edit_student_name').val(data.name);
                    $('#edit_student_course').val(data.course);
                } else {
                    $('#edit_student_name').val('');
                    $('#edit_student_course').val('');
                }
            });

        // Show the modal
        $('#editAttendanceModal').modal('show');
    });
});
</script>


</body>
</html>
