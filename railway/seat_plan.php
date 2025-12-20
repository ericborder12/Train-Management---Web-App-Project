<?php
require "db.php";

$trainno = isset($_GET["trainno"]) ? $_GET["trainno"] : "";
$sp = isset($_GET["sp"]) ? $_GET["sp"] : "";
$dp = isset($_GET["dp"]) ? $_GET["dp"] : "";

$cdquery = "SELECT classseats.class, classseats.seatsleft, classseats.fare FROM classseats WHERE classseats.trainno='" . $trainno . "' AND classseats.sp='" . $sp . "' AND classseats.dp='" . $dp . "'";
$cdresult = mysqli_query($conn, $cdquery);
$seats = mysqli_fetch_all($cdresult, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Seat Plan - Railway Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .seat-container {
      max-width: 900px;
      margin: 0 auto;
    }
    .seat-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 30px;
      margin-bottom: 20px;
    }
    .seat-header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #667eea;
      padding-bottom: 20px;
    }
    .seat-header h2 {
      color: #333;
      font-weight: 700;
      margin: 0 0 10px 0;
    }
    .journey-info {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 25px;
      border-left: 5px solid #667eea;
    }
    .journey-info-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 10px 0;
    }
    .journey-info-label {
      font-weight: 600;
      color: #667eea;
    }
    .journey-info-value {
      font-size: 18px;
      font-weight: 700;
      color: #333;
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
      padding: 15px;
      text-align: left;
      font-weight: 600;
    }
    td {
      padding: 15px;
      border-bottom: 1px solid #ddd;
    }
    tbody tr:hover {
      background: #f8f9fa;
    }
    .seats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      margin-top: 20px;
    }
    .seat-class-info {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      transition: all 0.3s ease;
    }
    .seat-class-info:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }
    .class-name {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 10px;
    }
    .seats-info {
      font-size: 14px;
      margin: 8px 0;
    }
    .fare {
      font-size: 18px;
      font-weight: 700;
      margin-top: 10px;
      padding-top: 10px;
      border-top: 2px solid rgba(255,255,255,0.3);
    }
    .action-links {
      display: flex;
      gap: 10px;
      margin-top: 20px;
      flex-wrap: wrap;
    }
    .btn-back {
      background: #667eea;
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: inline-block;
      cursor: pointer;
      border: none;
    }
    .btn-back:hover {
      background: #764ba2;
      transform: translateY(-3px);
      color: white;
    }
    .empty-state {
      text-align: center;
      padding: 40px;
      color: #999;
    }
  </style>
</head>
<body>
  <div class="seat-container">
    <div class="seat-card">
      <div class="seat-header">
        <h2><i class="fas fa-chair"></i> Seat Classes & Availability</h2>
      </div>

      <div class="journey-info">
        <div class="journey-info-item">
          <span class="journey-info-label"><i class="fas fa-train"></i> Train No:</span>
          <span class="journey-info-value"><?php echo htmlspecialchars($trainno); ?></span>
        </div>
        <div class="journey-info-item">
          <span class="journey-info-label"><i class="fas fa-map-marker-alt"></i> Route:</span>
          <span class="journey-info-value"><?php echo htmlspecialchars($sp) . " → " . htmlspecialchars($dp); ?></span>
        </div>
      </div>

      <?php if(!empty($seats)) { ?>
      <div class="seats-grid">
        <?php foreach($seats as $seat) { ?>
        <div class="seat-class-info">
          <div class="class-name">
            <i class="fas fa-tag"></i> <?php echo htmlspecialchars($seat['class']); ?>
          </div>
          <div class="seats-info">
            <i class="fas fa-chair"></i> Seats Left: <strong><?php echo $seat['seatsleft']; ?></strong>
          </div>
          <div class="fare">
            ₹<?php echo number_format($seat['fare'], 2); ?> per seat
          </div>
        </div>
        <?php } ?>
      </div>
      <?php } else { ?>
      <div class="empty-state">
        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
        <p>No seat information available for this route.</p>
      </div>
      <?php } ?>
    </div>

    <div class="action-links">
      <a href="http://localhost/railway/schedule.php?trainno=<?php echo htmlspecialchars($trainno); ?>" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back to Schedule
      </a>
      <a href="http://localhost/railway/show_trains.php" class="btn-back">
        <i class="fas fa-list"></i> Train List
      </a>
      <a href="http://localhost/railway/admin_login.php" class="btn-back">
        <i class="fas fa-tachometer-alt"></i> Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
