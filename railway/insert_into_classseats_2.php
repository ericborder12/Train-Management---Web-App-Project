<?php
require "db.php";

$sql = "INSERT INTO classseats (trainno, doj, class, seatsleft, fare) VALUES ('" . $conn->real_escape_string($_POST["tno"]) . "', '" . $conn->real_escape_string($_POST["doj"]) . "', '" . $conn->real_escape_string($_POST["class"]) . "', '" . $conn->real_escape_string($_POST["seatsleft"]) . "', '" . $conn->real_escape_string($_POST["fps"]) . "')";

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
  <title>Class Added - Railway Admin</title>
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
    .class-details {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 4px solid #667eea;
      text-align: left;
    }
    .class-details p {
      margin: 8px 0;
      color: #333;
    }
    .class-details strong {
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
  </style>
</head>
<body>
  <div class="result-card">
    <?php if($success) { ?>
      <div class="success-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <h2>Class Added Successfully!</h2>
      <p class="result-message">
        The train class and seat information has been added.
      </p>
      <div class="class-details">
        <p><strong><i class="fas fa-train"></i> Train No:</strong> <?php echo htmlspecialchars($_POST["tno"]); ?></p>
        <p><strong><i class="fas fa-layer-group"></i> Class:</strong> <?php echo htmlspecialchars($_POST["class"]); ?></p>
        <p><strong><i class="fas fa-calendar"></i> Date of Journey:</strong> <?php echo date('d/m/Y', strtotime($_POST["doj"])); ?></p>
        <p><strong><i class="fas fa-chair"></i> Total Seats:</strong> <?php echo htmlspecialchars($_POST["seatsleft"]); ?></p>
        <p><strong><i class="fas fa-money-bill-wave"></i> Fare per Seat (VND):</strong> <?php echo number_format($_POST["fps"], 0, '.', ','); ?> VND</p>
      </div>
    <?php } else { ?>
      <div class="error-icon">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <h2>Error Adding Class</h2>
      <p class="result-message">
        There was an error while adding the class information.
      </p>
      <div class="error-details">
        <strong>Error Details:</strong><br>
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php } ?>

    <div class="action-buttons">
      <a href="http://localhost/railway/admin_login.php" class="btn-action">
        <i class="fas fa-tachometer-alt"></i> Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
