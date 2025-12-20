<?php
require "db.php";

$stationId = isset($_GET["id"]) ? $_GET["id"] : null;
$station = null;
$success = false;
$error = "";
$isEditing = false;

if($_POST && isset($_POST["station"]) && $_POST["station"] != "") {
  // Update station
  $sql = "UPDATE `station` SET `sname`='" . $conn->real_escape_string($_POST["station"]) . "' WHERE id='" . $stationId . "'";
  
  if ($conn->query($sql) === TRUE) {
    $success = true;
  } else {
    $error = $conn->error;
  }
} else {
  // Show edit form
  if($stationId) {
    $cdquery = "SELECT * FROM station WHERE id='" . $stationId . "'";
    $cdresult = mysqli_query($conn, $cdquery);
    $station = mysqli_fetch_array($cdresult);
    if($station) {
      $isEditing = true;
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $success ? "Station Updated" : "Edit Station"; ?> - Railway Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .form-container {
      max-width: 600px;
      margin: 0 auto;
    }
    .form-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 30px;
      margin-bottom: 20px;
    }
    .form-header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #667eea;
      padding-bottom: 20px;
    }
    .form-header h2 {
      color: #333;
      font-weight: 700;
      margin: 0;
    }
    .form-group-custom {
      margin-bottom: 20px;
    }
    .form-group-custom label {
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
      display: block;
    }
    .form-group-custom input {
      width: 100%;
      padding: 12px;
      border: 2px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    .form-group-custom input:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .btn-update {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
      margin-top: 10px;
    }
    .btn-update:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      color: white;
    }
    .success-icon {
      color: #43e97b;
      font-size: 80px;
      margin-bottom: 20px;
      text-align: center;
    }
    .success-message {
      background: #d4edda;
      border: 2px solid #c3e6cb;
      color: #155724;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
      text-align: center;
    }
    .error-message {
      background: #f8d7da;
      border: 2px solid #f5c6cb;
      color: #721c24;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .back-btn {
      background: #6c757d;
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: inline-block;
      margin-top: 10px;
      margin-right: 10px;
    }
    .back-btn:hover {
      background: #5a6268;
      transform: translateY(-3px);
      color: white;
    }
    .action-links {
      display: flex;
      gap: 10px;
      margin-top: 20px;
      flex-wrap: wrap;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <div class="form-card">
      <?php if($success) { ?>
        <div class="form-header">
          <h2><i class="fas fa-map-pin"></i> Station Updated</h2>
        </div>
        <div class="success-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="success-message">
          <strong>Success!</strong><br>
          Station details have been updated successfully.
        </div>
      <?php } elseif($isEditing && $station) { ?>
        <div class="form-header">
          <h2><i class="fas fa-map-pin"></i> Edit Station</h2>
        </div>

        <form action="edit_station.php?id=<?php echo htmlspecialchars($stationId); ?>" method="post">
          <div class="form-group-custom">
            <label><i class="fas fa-hashtag"></i> Station ID</label>
            <input type="text" value="<?php echo htmlspecialchars($station["id"]); ?>" disabled>
          </div>

          <div class="form-group-custom">
            <label><i class="fas fa-map-marker-alt"></i> Station Name *</label>
            <input type="text" name="station" value="<?php echo htmlspecialchars($station["sname"]); ?>" placeholder="Enter station name" required>
          </div>

          <button type="submit" class="btn-update">
            <i class="fas fa-save"></i> Update Station
          </button>
        </form>
      <?php } elseif($error) { ?>
        <div class="form-header">
          <h2><i class="fas fa-exclamation-circle"></i> Error</h2>
        </div>
        <div class="error-message">
          <strong>Error:</strong><br>
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php } else { ?>
        <div class="form-header">
          <h2><i class="fas fa-map-pin"></i> Station Not Found</h2>
        </div>
        <p style="text-align: center; color: #666;">The requested station could not be found.</p>
      <?php } ?>

      <div class="action-links">
        <a href="http://localhost/railway/insert_into_stations.php" class="back-btn">
          <i class="fas fa-list"></i> Station List
        </a>
        <a href="http://localhost/railway/admin_login.php" class="back-btn">
          <i class="fas fa-tachometer-alt"></i> Admin Panel
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>



