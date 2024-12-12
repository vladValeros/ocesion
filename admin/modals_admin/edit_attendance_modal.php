
<div class="modal fade" id="editAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="editAttendanceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAttendanceModalLabel">Edit Attendance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="attendance.php">
        <div class="modal-body">
          <input type="hidden" id="edit_update_id" name="update_id">
          <input type="hidden" id="edit_event_id" name="event_id" value="<?= $event_id ?>">

          <div class="form-group">
            <label for="edit_student_number">Student Number</label>
            <input type="text" class="form-control" id="edit_student_number" name="student_number" readonly>
          </div>

          <div class="form-group">
            <label for="edit_student_name">Student Name</label>
            <input type="text" class="form-control" id="edit_student_name" name="student_name" readonly>
          </div>

          <div class="form-group">
            <label for="edit_student_course">Course</label>
            <input type="text" class="form-control" id="edit_student_course" name="student_course" readonly>
          </div>

          <div class="form-group">
            <label for="edit_time_in">Time In</label>
            <input type="time" class="form-control" id="edit_time_in" name="time_in">
          </div>

          <div class="form-group">
            <label for="edit_time_out">Time Out</label>
            <input type="time" class="form-control" id="edit_time_out" name="time_out">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
