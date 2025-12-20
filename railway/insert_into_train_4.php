<?php
session_start();
require "db.php";

$success = true;
$error = "";

// Insert train
$sql = "INSERT INTO train (tname, sp, st, dp, dt, dd, distance) VALUES ('" . $conn->real_escape_string($_SESSION["tname"]) . "', '" . $conn->real_escape_string($_SESSION["sp"]) . "', '" . $conn->real_escape_string($_SESSION["st"]) . "', '" . $conn->real_escape_string($_SESSION["dp"]) . "', '" . $conn->real_escape_string($_SESSION["dt"]) . "', '" . $conn->real_escape_string($_SESSION["dd"]) . "', '" . $conn->real_escape_string($_SESSION["ds"]) . "')";

if ($conn->query($sql) !== TRUE) {
  $success = false;
  $error = $conn->error;
}

if($success) {
  // Get the train number
  $cdquery = "SELECT trainno FROM train where tname='" . $conn->real_escape_string($_SESSION["tname"]) . "' AND sp='" . $conn->real_escape_string($_SESSION["sp"]) . "' AND dp='" . $conn->real_escape_string($_SESSION["dp"]) . "'";
  $cdresult = mysqli_query($conn, $cdquery);
  $cdrow = mysqli_fetch_array($cdresult);
  $trainno = $cdrow['trainno'];

  // Insert starting point in schedule
  $sql = "INSERT INTO schedule (trainno, sname, arrival_time, departure_time, distance) VALUES ('" . $trainno . "', '" . $conn->real_escape_string($_SESSION["sp"]) . "', '" . $conn->real_escape_string($_SESSION["st"]) . "', '" . $conn->real_escape_string($_SESSION["st"]) . "', '0')";
  if ($conn->query($sql) !== TRUE) {
    $success = false;
    $error = $conn->error;
  }

  // Insert intermediate stations
  if($success && isset($_SESSION["ns"])) {
    for($temp = 1; $temp <= $_SESSION["ns"]; $temp++) {
      if(isset($_POST["stn".$temp])) {
        $sql = "INSERT INTO schedule (trainno, sname, arrival_time, departure_time, distance) VALUES ('" . $trainno . "', '" . $conn->real_escape_string($_POST["stn".$temp]) . "', '" . $conn->real_escape_string($_POST["st".$temp]) . "', '" . $conn->real_escape_string($_POST["dt".$temp]) . "', '" . $conn->real_escape_string($_POST["ds".$temp]) . "')";
        if ($conn->query($sql) !== TRUE) {
          $success = false;
          $error = $conn->error;
          break;
        }
      }
    }
  }

  // Insert destination point in schedule
  if($success) {
    $sql = "INSERT INTO schedule (trainno, sname, arrival_time, departure_time, distance) VALUES ('" . $trainno . "', '" . $conn->real_escape_string($_SESSION["dp"]) . "', '" . $conn->real_escape_string($_SESSION["dt"]) . "', '" . $conn->real_escape_string($_SESSION["dt"]) . "', '" . $conn->real_escape_string($_SESSION["ds"]) . "')";
    if ($conn->query($sql) !== TRUE) {
      $success = false;
      $error = $conn->error;
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Train Created - Railway Admin</title>
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
    .train-summary {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 4px solid #667eea;
      text-align: left;
    }
    .train-summary p {
      margin: 8px 0;
      color: #333;
    }
    .train-summary strong {
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
      <h2>Train Created Successfully!</h2>
      <p class="result-message">
        Your train and schedule have been created and added to the system.
      </p>
      <div class="train-summary">
        <p><strong><i class="fas fa-heading"></i> Train Name:</strong> <?php echo htmlspecialchars($_SESSION["tname"]); ?></p>
        <p><strong><i class="fas fa-route"></i> Route:</strong> <?php echo htmlspecialchars($_SESSION["sp"]); ?> → <?php echo htmlspecialchars($_SESSION["dp"]); ?></p>
        <p><strong><i class="fas fa-clock"></i> Journey Time:</strong> <?php echo htmlspecialchars($_SESSION["st"]); ?> to <?php echo htmlspecialchars($_SESSION["dt"]); ?></p>
        <p><strong><i class="fas fa-ruler"></i> Distance:</strong> <?php echo htmlspecialchars($_SESSION["ds"]); ?> km</p>
        <p><strong><i class="fas fa-calendar"></i> Arrival Day:</strong> <?php echo htmlspecialchars($_SESSION["dd"]); ?></p>
        <p><strong><i class="fas fa-station"></i> Intermediate Stations:</strong> <?php echo htmlspecialchars($_SESSION["ns"]); ?></p>
      </div>
    <?php } else { ?>
      <div class="error-icon">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <h2>Error Creating Train</h2>
      <p class="result-message">
        There was an error while creating the train and schedule.
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
