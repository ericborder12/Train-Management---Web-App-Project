<?php
session_start();
require "db.php";

$success = false;
$error = "";

if(isset($_SESSION["trainno"]) && isset($_SESSION["doj"])) {
  $trainno = $_SESSION["trainno"];
  $doj = $_SESSION["doj"];
  $ns = $_SESSION["ns"];
  
  $temp = 0;
  $insertedCount = 0;
  $errorOccurred = false;

  while($temp < $ns) {
    $station_from = $_SESSION["st".$temp];
    $station_to = $_SESSION["st".($temp+1)];
    
    for($class = 1; $class <= 6; $class++) {
      $seats_var = "s".$class.$temp;
      $fare_var = "f".$class.$temp;
      
      $seats = isset($_POST[$seats_var]) ? (int)$_POST[$seats_var] : 0;
      $fare = isset($_POST[$fare_var]) ? (float)$_POST[$fare_var] : 0;
      
      if($seats > 0 || $fare > 0) {
        $class_names = array(1 => "AC1", 2 => "AC2", 3 => "AC3", 4 => "CC", 5 => "EC", 6 => "SL");
        $cname = $class_names[$class];
        
        $query = "INSERT INTO classseats (trainno, sname, dname, cname, seats, rupees) 
                  VALUES ('" . $trainno . "', '" . mysqli_real_escape_string($conn, $station_from) . "', 
                          '" . mysqli_real_escape_string($conn, $station_to) . "', '" . $cname . "', 
                          " . $seats . ", " . $fare . ")";
        
        if(mysqli_query($conn, $query)) {
          $insertedCount++;
        } else {
          $error = "Database error: " . mysqli_error($conn);
          $errorOccurred = true;
          break;
        }
      }
    }
    
    if($errorOccurred) break;
    $temp++;
  }

  if(!$errorOccurred && $insertedCount > 0) {
    $success = true;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Class Seats Added - Railway Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .result-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.3);
      padding: 40px;
      text-align: center;
      max-width: 500px;
      width: 100%;
    }
    .success-icon {
      font-size: 80px;
      color: #43e97b;
      margin-bottom: 20px;
      animation: bounce 0.6s ease-in-out;
    }
    .error-icon {
      font-size: 80px;
      color: #ff6b6b;
      margin-bottom: 20px;
    }
    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    h2 {
      color: #333;
      font-weight: 700;
      margin-bottom: 15px;
    }
    .message-text {
      font-size: 16px;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    .success-message {
      color: #43e97b;
      font-weight: 600;
    }
    .error-message {
      color: #ff6b6b;
      font-weight: 600;
    }
    .details-box {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 5px solid #667eea;
      text-align: left;
    }
    .detail-item {
      margin: 8px 0;
      font-size: 14px;
    }
    .detail-label {
      font-weight: 600;
      color: #667eea;
      display: inline-block;
      width: 120px;
    }
    .action-buttons {
      display: flex;
      gap: 10px;
      margin-top: 30px;
      flex-wrap: wrap;
    }
    .btn-action {
      flex: 1;
      min-width: 150px;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      color: white;
    }
    .btn-primary-action {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .btn-primary-action:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      color: white;
    }
    .btn-secondary-action {
      background: #6c757d;
    }
    .btn-secondary-action:hover {
      background: #5a6268;
      transform: translateY(-3px);
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
      <h2>Class Seats Added Successfully!</h2>
      <p class="message-text success-message">
        ✓ All class seat configurations have been saved to the system.
      </p>

      <div class="details-box">
        <div class="detail-item">
          <span class="detail-label"><i class="fas fa-hashtag"></i> Train No:</span>
          <strong><?php echo htmlspecialchars($_SESSION["trainno"]); ?></strong>
        </div>
        <div class="detail-item">
          <span class="detail-label"><i class="fas fa-calendar"></i> Journey Date:</span>
          <strong><?php echo date('d/m/Y', strtotime($_SESSION["doj"])); ?></strong>
        </div>
        <div class="detail-item">
          <span class="detail-label"><i class="fas fa-route"></i> Route Segments:</span>
          <strong><?php echo $_SESSION["ns"]; ?></strong>
        </div>
        <div class="detail-item">
          <span class="detail-label"><i class="fas fa-layer-group"></i> Entries Saved:</span>
          <strong><?php echo $insertedCount; ?></strong>
        </div>
      </div>

    <?php } else { ?>
      <div class="error-icon">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <h2>Error Adding Class Seats</h2>
      <p class="message-text error-message">
        ✗ Unable to save class seat configurations.
      </p>

      <div class="details-box" style="border-left-color: #ff6b6b; background: #fff5f5;">
        <div class="detail-item" style="color: #ff6b6b;">
          <strong>Error Details:</strong>
        </div>
        <div class="detail-item" style="color: #c92a2a; margin-top: 10px;">
          <?php echo !empty($error) ? htmlspecialchars($error) : "No class seats were added. Please try again."; ?>
        </div>
      </div>
    <?php } ?>

    <div class="action-buttons">
      <a href="http://localhost/railway/insert_into_classseats_3.php" class="btn-action btn-primary-action">
        <i class="fas fa-arrow-left"></i> Go Back
      </a>
      <a href="http://localhost/railway/admin_login.php" class="btn-action btn-secondary-action">
        <i class="fas fa-tachometer-alt"></i> Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
