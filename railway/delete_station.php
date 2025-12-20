<?php
require "db.php";

$stationId = isset($_GET["id"]) ? $_GET["id"] : null;
$success = false;
$error = "";
$stationInfo = null;

if($stationId) {
  // First get station info before deletion
  $selectQuery = "SELECT * FROM station WHERE id='" . $stationId . "'";
  $selectResult = mysqli_query($conn, $selectQuery);
  $stationInfo = mysqli_fetch_array($selectResult);

  // Delete the station
  $sql = "DELETE FROM station WHERE id='" . $stationId . "'";
  
  if ($conn->query($sql) === TRUE) {
    $success = true;
  } else {
    $error = $conn->error;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Delete Station - Railway Admin</title>
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
    .station-details {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 4px solid #ff6b6b;
      text-align: left;
    }
    .station-details p {
      margin: 8px 0;
      color: #333;
    }
    .station-details strong {
      color: #dc3545;
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
      <h2>Station Deleted Successfully!</h2>
      <p class="result-message">
        The station has been permanently removed from the system.
      </p>
      <?php if($stationInfo) { ?>
      <div class="station-details">
        <p><strong><i class="fas fa-map-marker-alt"></i> Station Name:</strong> <?php echo htmlspecialchars($stationInfo['sname']); ?></p>
        <p style="color: #dc3545;"><i class="fas fa-trash"></i> This station has been deleted and cannot be recovered.</p>
      </div>
      <?php } ?>
    <?php } elseif($error) { ?>
      <div class="error-icon">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <h2>Error Deleting Station</h2>
      <p class="result-message">
        There was an error while deleting the station.
      </p>
      <div class="error-details">
        <strong>Error Details:</strong><br>
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php } else { ?>
      <div class="error-icon">
        <i class="fas fa-map-pin"></i>
      </div>
      <h2>Invalid Request</h2>
      <p class="result-message">
        No station ID was provided for deletion.
      </p>
    <?php } ?>

    <div class="action-buttons">
      <a href="http://localhost/railway/insert_into_stations.php" class="btn-action">
        <i class="fas fa-map-pin"></i> Station List
      </a>
      <a href="http://localhost/railway/admin_login.php" class="btn-action">
        <i class="fas fa-tachometer-alt"></i> Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>


