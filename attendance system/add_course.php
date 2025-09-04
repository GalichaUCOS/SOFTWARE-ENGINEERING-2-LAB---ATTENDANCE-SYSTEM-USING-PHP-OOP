<?php
require_once __DIR__ . "/classes/Admin.php";
Admin::requireRole('admin');
$admin = new Admin();

$ok = null; $error = null;

// Handle add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']==='add') {
    $name = trim($_POST['course_name'] ?? "");
    if ($name) {
        if ($admin->addCourse($name)) $ok = "Course added!";
        else $error = "Failed to add course (may already exist).";
    } else $error = "Course name is required.";
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']==='update') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['course_name'] ?? "");
    if ($id && $name) {
        if ($admin->updateCourse($id, $name)) $ok = "Course updated!";
        else $error = "Failed to update course.";
    } else $error = "Course ID and name are required.";
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']==='delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id) {
        if ($admin->deleteCourse($id)) $ok = "Course deleted!";
        else $error = "Failed to delete course (if used by users, ensure FK is ON DELETE SET NULL).";
    } else $error = "Course ID is required.";
}

$courses = $admin->getAllCourses();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Courses</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Courses</h3>
    <a href="dashboard.php" class="btn btn-link">Back to Dashboard</a>
  </div>

  <?php if ($ok): ?><div class="alert alert-success"><?= htmlspecialchars($ok) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>

  <div class="card mb-4">
    <div class="card-body">
      <form method="POST" class="row g-2">
        <input type="hidden" name="action" value="add">
        <div class="col-md-8">
          <input class="form-control" name="course_name" placeholder="New Course / Program" required>
        </div>
        <div class="col-md-4 d-grid">
          <button class="btn btn-primary">Add Course</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table align-middle">
        <thead>
          <tr><th>ID</th><th>Course Name</th><th class="text-end">Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($courses as $c): ?>
          <tr>
            <td><?= (int)$c['id'] ?></td>
            <td>
              <form method="POST" class="d-flex gap-2">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                <input class="form-control" name="course_name" value="<?= htmlspecialchars($c['course_name']) ?>" required>
                <button class="btn btn-secondary btn-sm">Save</button>
              </form>
            </td>
            <td class="text-end">
              <form method="POST" onsubmit="return confirm('Delete this course?')" class="d-inline">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                <button class="btn btn-outline-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; if (!$courses): ?>
          <tr><td colspan="3" class="text-center text-muted">No courses yet.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
