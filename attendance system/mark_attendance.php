<?php
require_once __DIR__ . "/classes/Student.php";
Student::requireRole('student');
$student = new Student();

$ok = null; $error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($student->markAttendance($_SESSION['user']['id'])) {
        $ok = "Attendance filed successfully.";
    } else {
        $error = "Could not file attendance.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Mark Attendance</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Mark Attendance</h3>
    <div>
      <a href="history.php" class="btn btn-outline-secondary btn-sm">View History</a>
      <a href="dashboard.php" class="btn btn-link btn-sm">Dashboard</a>
    </div>
  </div>

  <?php if ($ok): ?><div class="alert alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <div class="card">
    <div class="card-body">
      <form method="POST" class="vstack gap-2">
        <p class="text-muted mb-2">Click the button to file your attendance now. You’ll be marked <strong>Late</strong> if it’s past the cutoff time.</p>
        <button class="btn btn-primary">File Attendance</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
