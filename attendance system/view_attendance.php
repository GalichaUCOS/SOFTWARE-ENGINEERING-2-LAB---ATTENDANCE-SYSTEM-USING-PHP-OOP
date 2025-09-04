<?php
require_once __DIR__ . "/classes/Admin.php";
Admin::requireRole('admin');
$admin = new Admin();

$courses = $admin->getAllCourses();

$course_id = (int)($_POST['course_id'] ?? 0);
$year_level = (int)($_POST['year_level'] ?? 0);
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $course_id && $year_level) {
    $result = $admin->viewAttendanceByCourseYear($course_id, $year_level);
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Check Attendance by Program & Year</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Attendance by Program & Year</h3>
    <a href="dashboard.php" class="btn btn-link">Dashboard</a>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <form method="POST" class="row g-3">
        <div class="col-md-5">
          <label class="form-label">Course / Program</label>
          <select name="course_id" class="form-select" required>
            <option value="">-- Select --</option>
            <?php foreach ($courses as $c): ?>
              <option value="<?= (int)$c['id'] ?>" <?= ($course_id===$c['id'])?'selected':'' ?>>
                <?= htmlspecialchars($c['course_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Year Level</label>
          <select name="year_level" class="form-select" required>
            <option value="">-- Select --</option>
            <?php for ($y=1;$y<=4;$y++): ?>
              <option value="<?= $y ?>" <?= ($year_level===$y)?'selected':'' ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="col-md-4 d-grid align-items-end">
          <button class="btn btn-primary mt-auto">View Attendance</button>
        </div>
      </form>
    </div>
  </div>

  <?php if ($result !== null): ?>
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Student</th>
            <th>Course</th>
            <th>Year</th>
            <th>Date & Time</th>
            <th>Status</th>
            <th>Late?</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['course_name']) ?></td>
              <td><?= (int)$row['year_level'] ?></td>
              <td><?= htmlspecialchars($row['attended_at']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
              <td><?= $row['is_late'] ? "Yes" : "No" ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center text-muted">No results.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
</div>
</body>
</html>
