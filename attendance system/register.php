<?php
require_once __DIR__ . "/classes/User.php";
$user = new User();

$courses = $user->getAllCourses();

$errors = [];
$ok = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $password = $_POST['password'] ?? "";
    $role = $_POST['role'] ?? "student";
    $course_id = !empty($_POST['course_id']) ? (int)$_POST['course_id'] : null;
    $year_level = !empty($_POST['year_level']) ? (int)$_POST['year_level'] : null;

    if ($role === "student" && (empty($course_id) || empty($year_level))) {
        $errors[] = "Course and Year Level are required for students.";
    }

    if (!$errors) {
        if ($user->register($name, $email, $password, $role, $course_id, $year_level)) {
            $ok = "Registered successfully! You can now login.";
        } else {
            $errors[] = "Registration failed. Email may already be taken.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h3 class="mb-3 text-center">Register</h3>

          <?php if ($ok): ?>
            <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
          <?php endif; ?>
          <?php if ($errors): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                  <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="POST" class="vstack gap-3">
            <input class="form-control" name="name" placeholder="Full Name" required>
            <input class="form-control" name="email" type="email" placeholder="Email" required>
            <input class="form-control" name="password" type="password" placeholder="Password" required>

            <select name="role" id="role" class="form-select" required onchange="toggleStudentFields(this.value)">
              <option value="student">Student</option>
              <option value="admin">Admin</option>
            </select>

            <div id="student_fields">
              <label class="form-label mt-2">Course / Program</label>
              <select name="course_id" class="form-select">
                <option value="">-- Select Course --</option>
                <?php foreach ($courses as $c): ?>
                  <option value="<?= (int)$c['id'] ?>">
                    <?= htmlspecialchars($c['course_name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>

              <label class="form-label mt-2">Year Level</label>
              <select name="year_level" class="form-select">
                <option value="">-- Select Year --</option>
                <option value="1">1</option><option value="2">2</option>
                <option value="3">3</option><option value="4">4</option>
              </select>
            </div>

            <button class="btn btn-primary mt-2">Register</button>
            <a href="login.php" class="btn btn-link">Already registered? Login</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function toggleStudentFields(role){
  document.getElementById("student_fields").style.display = (role === "student") ? "block" : "none";
}
toggleStudentFields(document.getElementById('role').value);
</script>
</body>
</html>
