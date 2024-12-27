<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="userForm" method="POST" action="users.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="student_number" class="form-label">Student Number</label>
                        <input type="text" id="student_number" name="student_number" class="form-control">
                        <span class="error-message text-danger"><?php echo $username_err ?? ''; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="student_name" class="form-label">Full Name</label>
                        <input type="text" id="student_name" class="form-control" readonly>
                    </div>
                    <!-- Password -->
                    <div class="mb-3">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" name="password" class="form-control" value="<?= htmlspecialchars($password ?? '') ?>">
                      <span class="error-message text-danger"><?php echo $password_err ?? ''; ?></span>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="role">Role</label>
                      <select class="form-select" id="role" name="role">
                        <option value="" disabled <?= empty($role) ? 'selected' : ''; ?>>Select Role</option>
                        <option value="officer" <?= (isset($role) && $role === 'officer') ? 'selected' : ''; ?>>Officer</option>
                        <option value="club_adviser" <?= (isset($role) && $role === 'club_adviser') ? 'selected' : ''; ?>>Adviser</option>
                        <option value="admin" <?= (isset($role) && $role === 'admin') ? 'selected' : ''; ?>>Admin</option>
                      </select>
                      <span class="error-message text-danger"><?php echo $role_err ?? ''; ?></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModalBtn">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('student_number').addEventListener('input', function () {
        const studentNumber = this.value;
        if (studentNumber.length > 0) {
            fetch(`get_name.php?student_number=${studentNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('student_name').value = data.name;
                    } else {
                        document.getElementById('student_name').value = '';
                    }
                });
        } else {
            document.getElementById('student_name').value = '';
        }
    });
</script>
