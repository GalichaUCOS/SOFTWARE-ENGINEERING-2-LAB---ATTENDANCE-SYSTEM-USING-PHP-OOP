<?php
require_once __DIR__ . "/classes/Student.php";
Student::requireRole('student');
$student = new Student();
$rows = $student->viewHistory($_SESSION['user']['id']);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Attendance History</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Your Attendance History</h3>
    <a href="dashboard.php" class="btn btn-link">Dashboard</a>
  </div>
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Date & Time</th>
            <th>Status</th>
            <th>Late?</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($rows && $rows->num_rows): ?>
            <?php while ($r = $rows->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($r['attended_at']) ?></td>
                <td><?= htmlspecialchars($r['status']) ?></td>
                <td><?= $r['is_late'] ? "Yes" : "No" ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="3" class="text-center text-muted">No attendance yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
