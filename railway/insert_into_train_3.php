<?php
session_start();
require "db.php";

$cdquery = "SELECT sname FROM station";
$cdresult = mysqli_query($conn, $cdquery);
$stations = mysqli_fetch_all($cdresult, MYSQLI_ASSOC);

$ns = isset($_POST["ns"]) ? $_POST["ns"] : 0;
$showForm = false;
$showStations = false;

if(isset($_POST["ns"]) && $_POST["ns"] > 0) {
  $showStations = true;
  $tname = $_POST["tname"];
  $_SESSION["tname"] = $tname;
  $sp = $_POST["sp"];
  $_SESSION["sp"] = $sp;
  $st = $_POST["st"];
  $_SESSION["st"] = $st;
  $dp = $_POST["dp"];
  $_SESSION["dp"] = $dp;
  $dt = $_POST["dt"];
  $_SESSION["dt"] = $dt;
  $dd = $_POST["dd"];
  $_SESSION["dd"] = $dd;
  $ns = $_POST["ns"];
  $_SESSION["ns"] = $ns;
  $ds = $_POST["ds"];
  $_SESSION["ds"] = $ds;
} else {
  $showForm = true;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Train Schedule - Railway Admin</title>
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
      max-width: 900px;
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
    .form-header p {
      color: #666;
      margin: 10px 0 0 0;
    }
    .form-section {
      margin-bottom: 25px;
    }
    .form-section-title {
      font-weight: 700;
      color: #333;
      margin: 20px 0 15px 0;
      padding: 10px 0;
      border-bottom: 2px solid #ddd;
    }
    .form-group-custom {
      margin-bottom: 15px;
    }
    .form-group-custom label {
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
      display: block;
    }
    .form-group-custom input,
    .form-group-custom select {
      width: 100%;
      padding: 12px;
      border: 2px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
      font-family: inherit;
    }
    .form-group-custom input:focus,
    .form-group-custom select:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .btn-submit {
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
    .btn-submit:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      color: white;
    }
    .form-step {
      color: #667eea;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    thead {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }
    th {
      padding: 12px;
      text-align: left;
      font-weight: 600;
      font-size: 14px;
    }
    td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }
    tbody tr:nth-child(odd) {
      background: #f8f9fa;
    }
    .station-row {
      background: white !important;
    }
    .station-row input,
    .station-row select {
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 5px;
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
    }
    .back-btn:hover {
      background: #5a6268;
      transform: translateY(-3px);
      color: white;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <div class="form-card">
      <div class="form-header">
        <h2><i class="fas fa-train"></i> Add Train Schedule</h2>
        <p><?php echo $showStations ? "Step 2 of 2: Intermediate Stations" : "Step 1 of 2: Train Information"; ?></p>
      </div>

      <?php if($showForm) { ?>
        <div class="form-step">
          <i class="fas fa-circle" style="color: #667eea;"></i> Step 1 - Train Information
        </div>

        <form action="insert_into_train_3.php" method="post">
          <div class="form-section">
            <div class="form-section-title"><i class="fas fa-info-circle"></i> Train Details</div>
            <div class="form-group-custom">
              <label><i class="fas fa-heading"></i> Train Name *</label>
              <input type="text" name="tname" placeholder="E.g., Express 2000" required>
            </div>

            <div class="form-group-custom">
              <label><i class="fas fa-map-marker-alt"></i> Starting Point *</label>
              <select name="sp" required>
                <option value="">-- Select Starting Station --</option>
                <?php foreach($stations as $station) { ?>
                <option value="<?php echo htmlspecialchars($station['sname']); ?>">
                  <?php echo htmlspecialchars($station['sname']); ?>
                </option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group-custom">
              <label><i class="fas fa-clock"></i> Departure Time *</label>
              <input type="time" name="st" required>
            </div>

            <div class="form-group-custom">
              <label><i class="fas fa-map-marker-alt"></i> Destination Point *</label>
              <select name="dp" required>
                <option value="">-- Select Destination Station --</option>
                <?php foreach($stations as $station) { ?>
                <option value="<?php echo htmlspecialchars($station['sname']); ?>">
                  <?php echo htmlspecialchars($station['sname']); ?>
                </option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group-custom">
              <label><i class="fas fa-clock"></i> Arrival Time *</label>
              <input type="time" name="dt" required>
            </div>

            <div class="form-group-custom">
              <label><i class="fas fa-ruler"></i> Total Distance (km) *</label>
              <input type="text" name="ds" placeholder="E.g., 500" required>
            </div>

            <div class="form-group-custom">
              <label><i class="fas fa-station"></i> No. of Intermediate Stations *</label>
              <input type="number" name="ns" min="0" max="20" placeholder="E.g., 3" required>
            </div>

            <div class="form-group-custom">
              <label><i class="fas fa-calendar"></i> Day of Arrival *</label>
              <input type="text" name="dd" placeholder="E.g., Monday" required>
            </div>
          </div>

          <button type="submit" class="btn-submit">
            <i class="fas fa-arrow-right"></i> Next: Add Stations
          </button>
        </form>

      <?php } elseif($showStations) { ?>
        <div class="form-step">
          <i class="fas fa-circle" style="color: #667eea;"></i> Step 2 - Intermediate Stations
        </div>

        <table>
          <thead>
            <tr>
              <th><i class="fas fa-map-marker-alt"></i> Station</th>
              <th><i class="fas fa-arrow-down"></i> Arrival Time</th>
              <th><i class="fas fa-arrow-up"></i> Departure Time</th>
              <th><i class="fas fa-ruler"></i> Distance (km)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong><?php echo htmlspecialchars($sp); ?></strong> (Starting)</td>
              <td><?php echo htmlspecialchars($st); ?></td>
              <td><?php echo htmlspecialchars($st); ?></td>
              <td>0</td>
            </tr>
          </tbody>
        </table>

        <form action="insert_into_train_4.php" method="post">
          <table>
            <thead>
              <tr>
                <th><i class="fas fa-map-marker-alt"></i> Station</th>
                <th><i class="fas fa-arrow-down"></i> Arrival Time</th>
                <th><i class="fas fa-arrow-up"></i> Departure Time</th>
                <th><i class="fas fa-ruler"></i> Distance (km)</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              for($temp = 1; $temp <= $ns; $temp++) {
              ?>
              <tr class="station-row">
                <td>
                  <select name="stn<?php echo $temp; ?>" required>
                    <option value="">-- Select Station --</option>
                    <?php foreach($stations as $station) { ?>
                    <option value="<?php echo htmlspecialchars($station['sname']); ?>">
                      <?php echo htmlspecialchars($station['sname']); ?>
                    </option>
                    <?php } ?>
                  </select>
                </td>
                <td>
                  <input type="time" name="st<?php echo $temp; ?>" required>
                </td>
                <td>
                  <input type="time" name="dt<?php echo $temp; ?>" required>
                </td>
                <td>
                  <input type="number" name="ds<?php echo $temp; ?>" placeholder="0" required>
                </td>
              </tr>
              <?php } ?>
              <tr>
                <td><strong><?php echo htmlspecialchars($dp); ?></strong> (Destination)</td>
                <td><?php echo htmlspecialchars($dt); ?></td>
                <td><?php echo htmlspecialchars($dt); ?></td>
                <td><?php echo htmlspecialchars($ds); ?></td>
              </tr>
            </tbody>
          </table>

          <button type="submit" class="btn-submit">
            <i class="fas fa-check"></i> Complete Train Setup
          </button>
        </form>

      <?php } ?>

      <a href="http://localhost/railway/admin_login.php" class="back-btn">
        <i class="fas fa-tachometer-alt"></i> Back to Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


