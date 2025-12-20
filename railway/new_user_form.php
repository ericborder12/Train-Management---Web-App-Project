<?php 
require "db.php";

$pwd = $_POST["password"];
$eid = $_POST["emailid"];
$mno = $_POST["mobileno"];
$dob = $_POST["dob"];

$sql = "INSERT INTO user (password, emailid, mobileno, dob) VALUES ('" . $conn->real_escape_string($pwd) . "', '" . $conn->real_escape_string($eid) . "', '" . $conn->real_escape_string($mno) . "', '" . $conn->real_escape_string($dob) . "')";

$success = false;
$error = "";

if ($conn->query($sql) === TRUE) {
  $success = true;
} else {
  $error = $conn->error;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Result - Railway Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .result-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 40px 30px;
      max-width: 600px;
      width: 100%;
      text-align: center;
    }
    .success-icon {
      color: #43e97b;
      font-size: 80px;
      margin-bottom: 20px;
    }
    .error-icon {
      color: #ff6b6b;
      font-size: 80px;
      margin-bottom: 20px;
    }
    h2 {
      color: #333;
      font-weight: 700;
      margin: 20px 0;
    }
    .result-message {
      font-size: 16px;
      color: #666;
      margin: 20px 0;
      line-height: 1.6;
    }
    .account-details {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 4px solid #667eea;
      text-align: left;
    }
    .account-details p {
      margin: 8px 0;
      color: #333;
    }
    .account-details strong {
      color: #667eea;
      font-weight: 700;
    }
    .error-details {
      background: #f8d7da;
      border: 2px solid #f5c6cb;
      color: #721c24;
      padding: 15px;
      border-radius: 10px;
      margin: 20px 0;
    }
    .action-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-top: 30px;
      flex-wrap: wrap;
    }
    .btn-action {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: inline-block;
      border: none;
      cursor: pointer;
    }
    .btn-action:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      color: white;
    }
    .btn-secondary {
      background: #6c757d;
    }
    .btn-secondary:hover {
      background: #5a6268;
    }
  </style>
</head>
<body>
  <div class="result-card">
    <?php if($success) { ?>
      <div class="success-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <h2>Registration Successful!</h2>
      <p class="result-message">
        Welcome to our railway reservation system! Your account has been created successfully.
      </p>
      <div class="account-details">
        <p><strong><i class="fas fa-envelope"></i> Email:</strong> <?php echo htmlspecialchars($eid); ?></p>
        <p><strong><i class="fas fa-phone"></i> Mobile:</strong> <?php echo htmlspecialchars($mno); ?></p>
        <p><strong><i class="fas fa-birthday-cake"></i> Date of Birth:</strong> <?php echo date('d/m/Y', strtotime($dob)); ?></p>
        <p style="margin-top: 15px; color: #667eea;"><i class="fas fa-lock"></i> Your password has been securely saved.</p>
      </div>
      <p class="result-message" style="font-size: 14px; color: #999;">
        You can now log in using your email and password to book tickets.
      </p>
    <?php } else { ?>
      <div class="error-icon">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <h2>Registration Failed</h2>
      <p class="result-message">
        There was an error while creating your account.
      </p>
      <div class="error-details">
        <strong>Error Details:</strong><br>
        <?php echo htmlspecialchars($error); ?>
      </div>
      <p class="result-message" style="font-size: 14px;">
        Please check your details and try again, or contact customer support.
      </p>
    <?php } ?>

    <div class="action-buttons">
      <a href="http://localhost/railway/index.htm" class="btn-action">
        <i class="fas fa-home"></i> Go to Home
      </a>
      <?php if($success) { ?>
      <a href="http://localhost/railway/user_login.htm" class="btn-action btn-secondary">
        <i class="fas fa-sign-in-alt"></i> Login
      </a>
      <?php } else { ?>
      <a href="http://localhost/railway/new_user_form.html" class="btn-action btn-secondary">
        <i class="fas fa-redo"></i> Try Again
      </a>
      <?php } ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
