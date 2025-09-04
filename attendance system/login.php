<?php
require_once __DIR__ . "/classes/User.php";
$user = new User();

$error = null;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if ($user->login($_POST['email'] ?? "", $_POST['password'] ?? "")) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h3 class="mb-3 text-center">Login</h3>
          <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          <form method="POST" class="vstack gap-3">
            <input class="form-control" name="email" type="email" placeholder="Email" required>
            <input class="form-control" name="password" type="password" placeholder="Password" required>
            <button class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-link">Create account</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
