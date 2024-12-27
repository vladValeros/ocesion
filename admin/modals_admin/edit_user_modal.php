<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="users.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="mb-3">
                        <label for="modal-student_number" class="form-label">Student Number</label>
                        <input type="text" id="modal-student_number" name="student_number" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                      <label for="modal-password">Password</label>
                      <input type="password" class="form-control" id="modal-password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="modal-role" class="form-label">Role</label>
                        <select name="role" id="modal-role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="club_adviser">Club Adviser</option>
                            <option value="officer">Officer</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
