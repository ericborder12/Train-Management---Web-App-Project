<?php
session_start();
require "db.php";

$query = "SELECT * FROM train";
$result = mysqli_query($conn, $query);
$trains = mysqli_fetch_all($result, MYSQLI_ASSOC);

$showForm = false;
$showSeatsForm = false;
$trainDetails = null;
$stations = array();
$segmentCount = 0;

if(isset($_POST["tno"]) && $_POST["tno"] != "") {
  $trainno = $_POST["tno"];
  $_SESSION["trainno"] = $trainno;
  $doj = $_POST["doj"];
  $_SESSION["doj"] = $doj;

  $cdquery = "SELECT * FROM train WHERE trainno='" . $trainno . "'";
  $cdresult = mysqli_query($conn, $cdquery);
  $trainDetails = mysqli_fetch_array($cdresult);

  $cdquery = "SELECT sname FROM schedule WHERE trainno='" . $trainno . "' ORDER BY distance ASC";
  $cdresult = mysqli_query($conn, $cdquery);
  $stations = mysqli_fetch_all($cdresult, MYSQLI_ASSOC);
  $segmentCount = count($stations) - 1;

  $_SESSION["ns"] = $segmentCount;
  for($i = 0; $i < count($stations); $i++) {
    $_SESSION["st".$i] = $stations[$i]['sname'];
  }

  $showSeatsForm = true;
} else {
  $showForm = true;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Class Seats - Railway Admin</title>
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
      max-width: 1200px;
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
    .train-info {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 5px solid #667eea;
    }
    .train-info-item {
      display: flex;
      justify-content: space-between;
      margin: 10px 0;
      padding: 8px 0;
      border-bottom: 1px solid #ddd;
    }
    .train-info-item:last-child {
      border-bottom: none;
    }
    .train-info-label {
      font-weight: 600;
      color: #667eea;
    }
    .train-info-value {
      color: #333;
      font-weight: 500;
    }
    .seats-table-wrapper {
      overflow-x: auto;
      margin: 20px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }
    th {
      padding: 12px;
      text-align: center;
      font-weight: 600;
      font-size: 12px;
    }
    td {
      padding: 12px;
      text-align: center;
      border: 1px solid #ddd;
    }
    .class-label {
      background: #f8f9fa;
      font-weight: 600;
      color: #333;
      text-align: left;
    }
    .route-label {
      background: #f0f4ff;
      font-weight: 600;
      color: #333;
    }
    .form-input {
      padding: 8px !important;
      border: 1px solid #ddd !important;
      border-radius: 5px !important;
      font-size: 14px !important;
    }
    .form-input:focus {
      border-color: #667eea !important;
      box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1) !important;
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
        <h2><i class="fas fa-layer-group"></i> Add Class Seats by Route Segment</h2>
      </div>

      <?php if($showForm) { ?>
        <form action="insert_into_classseats_3.php" method="post">
          <div class="form-group-custom">
            <label><i class="fas fa-train"></i> Select Train *</label>
            <select name="tno" required>
              <option value="">-- Select a Train --</option>
              <?php foreach($trains as $train) { ?>
              <option value="<?php echo $train['trainno']; ?>">
                <?php echo htmlspecialchars($train['tname']) . " (" . htmlspecialchars($train['sp']) . " → " . htmlspecialchars($train['dp']) . ")"; ?>
              </option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group-custom">
            <label><i class="fas fa-calendar"></i> Date of Journey *</label>
            <input type="date" name="doj" required>
          </div>

          <button type="submit" class="btn-submit">
            <i class="fas fa-arrow-right"></i> View Train Details & Add Seats
          </button>
        </form>

      <?php } elseif($showSeatsForm && $trainDetails) { ?>
        <div class="train-info">
          <div class="train-info-item">
            <span class="train-info-label"><i class="fas fa-hashtag"></i> Train No:</span>
            <span class="train-info-value"><?php echo htmlspecialchars($trainDetails['trainno']); ?></span>
          </div>
          <div class="train-info-item">
            <span class="train-info-label"><i class="fas fa-heading"></i> Train Name:</span>
            <span class="train-info-value"><?php echo htmlspecialchars($trainDetails['tname']); ?></span>
          </div>
          <div class="train-info-item">
            <span class="train-info-label"><i class="fas fa-route"></i> Route:</span>
            <span class="train-info-value"><?php echo htmlspecialchars($trainDetails['sp']) . " → " . htmlspecialchars($trainDetails['dp']); ?></span>
          </div>
          <div class="train-info-item">
            <span class="train-info-label"><i class="fas fa-calendar"></i> Date of Journey:</span>
            <span class="train-info-value"><?php echo date('d/m/Y', strtotime($_SESSION["doj"])); ?></span>
          </div>
        </div>

        <p style="text-align: center; color: #667eea; font-weight: 600; margin: 20px 0;">
          <i class="fas fa-info-circle"></i> Enter seats and fares for each class and route segment
        </p>

        <form action="insert_into_classseats_4.php" method="post">
          <div class="seats-table-wrapper">
            <table>
              <thead>
                <tr>
                  <th colspan="2" style="text-align: center;">Route Segment</th>
                  <th colspan="2">AC 1 Tier</th>
                  <th colspan="2">AC 2 Tier</th>
                  <th colspan="2">AC 3 Tier</th>
                  <th colspan="2">Chair Car</th>
                  <th colspan="2">Executive</th>
                  <th colspan="2">Sleeper</th>
                </tr>
                <tr>
                  <th style="text-align: left;">From</th>
                  <th style="text-align: left;">To</th>
                  <th>Seats</th>
                  <th>Fare</th>
                  <th>Seats</th>
                  <th>Fare</th>
                  <th>Seats</th>
                  <th>Fare</th>
                  <th>Seats</th>
                  <th>Fare</th>
                  <th>Seats</th>
                  <th>Fare</th>
                  <th>Seats</th>
                  <th>Fare</th>
                </tr>
              </thead>
              <tbody>
                <?php for($i = 0; $i < $segmentCount; $i++) { ?>
                <tr>
                  <td class="route-label" style="text-align: left;"><?php echo htmlspecialchars($stations[$i]['sname']); ?></td>
                  <td class="route-label" style="text-align: left;"><?php echo htmlspecialchars($stations[$i+1]['sname']); ?></td>
                  <td><input type="number" name="s1<?php echo $i; ?>" class="form-input" value="0" min="0"></td>
                  <td><input type="number" name="f1<?php echo $i; ?>" class="form-input" step="0.01" value="0" min="0"></td>
                  <td><input type="number" name="s2<?php echo $i; ?>" class="form-input" value="0" min="0"></td>
                  <td><input type="number" name="f2<?php echo $i; ?>" class="form-input" step="0.01" value="0" min="0"></td>
                  <td><input type="number" name="s3<?php echo $i; ?>" class="form-input" value="0" min="0"></td>
                  <td><input type="number" name="f3<?php echo $i; ?>" class="form-input" step="0.01" value="0" min="0"></td>
                  <td><input type="number" name="s4<?php echo $i; ?>" class="form-input" value="0" min="0"></td>
                  <td><input type="number" name="f4<?php echo $i; ?>" class="form-input" step="0.01" value="0" min="0"></td>
                  <td><input type="number" name="s5<?php echo $i; ?>" class="form-input" value="0" min="0"></td>
                  <td><input type="number" name="f5<?php echo $i; ?>" class="form-input" step="0.01" value="0" min="0"></td>
                  <td><input type="number" name="s6<?php echo $i; ?>" class="form-input" value="0" min="0"></td>
                  <td><input type="number" name="f6<?php echo $i; ?>" class="form-input" step="0.01" value="0" min="0"></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

          <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Save All Class Seats
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


