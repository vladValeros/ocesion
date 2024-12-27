<div class="fade modal" aria-hidden="true" aria-labelledby="addStudentModalLabel" id="addStudentModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="studentForm" action="students.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Group student number, names in one row -->
          <div class="row">
            <div class="col-md-6">
              <!-- Student Number -->
              <div class="mb-3">
                <label class="form-label" for="student_number">Student Number</label>
                <input type="text" name="student_number" class="form-control" value="<?= htmlspecialchars($student_number ?? '') ?>">
                <span class="error-message text-danger"><?php echo $student_number_err ?? ''; ?></span>
              </div>
            </div>
            <div class="col-md-6">
              <!-- Last Name -->
              <div class="mb-3">
                <label class="form-label" for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($last_name ?? '') ?>">
                <span class="error-message text-danger"><?php echo $last_name_err ?? ''; ?></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <!-- First Name -->
              <div class="mb-3">
                <label class="form-label" for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($first_name ?? '') ?>">
                <span class="error-message text-danger"><?php echo $first_name_err ?? ''; ?></span>
              </div>
            </div>
            <div class="col-md-6">
              <!-- Middle Name -->
              <div class="mb-3">
                <label class="form-label" for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" value="<?= htmlspecialchars($middle_name ?? '') ?>">
                <span class="error-message text-danger"><?php echo $middle_name_err ?? ''; ?></span>
              </div>
            </div>
          </div>

          <!-- Group Course, Year Level, and Section in one row -->
          <div class="row">
            <div class="col-md-4">
              <!-- Course -->
              <div class="mb-3">
              <label class="form-label" for="course">Course</label>
              <select class="form-select" id="course" name="course">
                <option value="" disabled <?= empty($course) ? 'selected' : ''; ?>>Select Course</option>
                <option value="BSCS" <?= (isset($course) && $course === 'BSCS') ? 'selected' : ''; ?>>BSCS</option>
                <option value="BSIT" <?= (isset($course) && $course === 'BSIT') ? 'selected' : ''; ?>>BSIT</option>
                <option value="ACT-NW" <?= (isset($course) && $course === 'ACT-NW') ? 'selected' : ''; ?>>ACT-NW</option>
                <option value="ACT-AD" <?= (isset($course) && $course === 'ACT-AD') ? 'selected' : ''; ?>>ACT-AD</option>
                <option value="MIT" <?= (isset($course) && $course === 'MIT') ? 'selected' : ''; ?>>MIT</option>
              </select>
              <span class="error-message text-danger"><?php echo $course_err ?? ''; ?></span>
            </div>
            </div>
            <div class="col-md-4">
              <!-- Year Level -->
              <div class="mb-3">
              <label class="form-label" for="year_level">Year Level</label>
              <select class="form-select" id="year_level" name="year_level">
                <option value="" disabled <?= empty($year_level) ? 'selected' : ''; ?>>Select Year Level</option>
                <option value="1" <?= (isset($year_level) && $year_level === '1') ? 'selected' : ''; ?>>1</option>
                <option value="2" <?= (isset($year_level) && $year_level === '2') ? 'selected' : ''; ?>>2</option>
                <option value="3" <?= (isset($year_level) && $year_level === '3') ? 'selected' : ''; ?>>3</option>
                <option value="4" <?= (isset($year_level) && $year_level === '4') ? 'selected' : ''; ?>>4</option>
                <option value="5" <?= (isset($year_level) && $year_level === '5') ? 'selected' : ''; ?>>5</option>
              </select>
              <span class="error-message text-danger"><?php echo $year_level_err ?? ''; ?></span>
            </div>
            </div>
            <div class="col-md-4">
              <!-- Section -->
              <div class="mb-3">
                <label class="form-label" for="section">Section</label>
                <select class="form-select" id="section" name="section">
                  <option value="" disabled <?= empty($section) ? 'selected' : ''; ?>>Select Section</option>
                  <option value="A" <?= (isset($section) && $section === 'A') ? 'selected' : ''; ?>>A</option>
                  <option value="B" <?= (isset($section) && $section === 'B') ? 'selected' : ''; ?>>B</option>
                  <option value="C" <?= (isset($section) && $section === 'C') ? 'selected' : ''; ?>>C</option>
                </select>
                <span class="error-message text-danger"><?php echo $section_err ?? ''; ?></span>
              </div>
            </div>
          </div>

          <!-- Group Birthdate, Sex, and Status in one row -->
          <div class="row">
            <div class="col-md-4">
              <!-- Birthdate -->
              <div class="mb-3">
                <label class="form-label" for="birthdate">Birthdate</label>
                <input class="form-control" id="birthdate" name="birthdate" type="date" value="<?= htmlspecialchars($birthdate ?? '') ?>">
                <span class="error-message text-danger"><?php echo $birthdate_err ?? ''; ?></span>
              </div>
            </div>
            <div class="col-md-4">
              <!-- Sex -->
              <div class="mb-3">
                <label class="form-label" for="sex">Sex</label>
                <select class="form-select" id="sex" name="sex">
                  <option value="" disabled <?= empty($sex) ? 'selected' : ''; ?>>Select Sex</option>
                  <option value="Male" <?= (isset($sex) && $sex === 'Male') ? 'selected' : ''; ?>>Male</option>
                  <option value="Female" <?= (isset($sex) && $sex === 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
                <span class="error-message text-danger"><?php echo $sex_err ?? ''; ?></span>
              </div>
            </div>
            <div class="col-md-4">
              <!-- Status -->
              <div class="mb-3">
                <label class="form-label" for="status">Status</label>
                <select class="form-select" id="status" name="status">
                  <option value="" disabled <?= empty($status) ? 'selected' : ''; ?>>Select Status</option>
                  <option value="Regular" <?= (isset($status) && $status === 'Regular') ? 'selected' : ''; ?>>Regular</option>
                  <option value="Irregular" <?= (isset($status) && $status === 'Irregular') ? 'selected' : ''; ?>>Irregular</option>
                </select>
                <span class="error-message text-danger"><?php echo $status_err ?? ''; ?></span>
              </div>
            </div>
          </div>


          <!-- Address -->
          <div class="mb-3">
                <label class="form-label" for="address">Address</label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address ?? '') ?>">
                <span class="error-message text-danger"><?php echo $address_err ?? ''; ?></span>
          </div> 


          <div class="row">
            <div class="col-md-6">
               <!-- WMSU Email -->
               <div class="mb-3">
                <label class="form-label" for="wmsu_email">WMSU Email</label>
                <input type="text" name="wmsu_email" class="form-control" value="<?= htmlspecialchars($wmsu_email ?? '') ?>">
                <span class="error-message text-danger"><?php echo $wmsu_email_err ?? ''; ?></span>
              </div>
              <!-- Personal Email -->
              <div class="mb-3">
                <label class="form-label" for="personal_email">Personal Email</label>
                <input type="text" name="personal_email" class="form-control" value="<?= htmlspecialchars($personal_email ?? '') ?>">
                <span class="error-message text-danger"><?php echo $personal_email_err ?? ''; ?></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModalBtn">Close</button>
          <button class="btn btn-primary" type="submit">Add Student</button>
        </div>
      </form>
    </div>
  </div>
</div>
