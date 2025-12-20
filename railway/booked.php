<?php
require "db.php";

$query="SELECT * FROM resv where status='BOOKED' ";
$result=mysqli_query($conn,$query);
$bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Booked Tickets - Railway Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .bookings-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .bookings-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 30px;
      margin-bottom: 20px;
    }
    .bookings-header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #30cfd0;
      padding-bottom: 20px;
    }
    .bookings-header h2 {
      color: #333;
      font-weight: 700;
      margin: 0;
    }
    .badge-booked {
      background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead {
      background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
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
    .back-btn {
      background: #667eea;
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: inline-block;
    }
    .back-btn:hover {
      background: #764ba2;
      transform: translateY(-3px);
      color: white;
    }
  </style>
</head>
<body>
  <div class="bookings-container">
    <div class="bookings-card">
      <div class="bookings-header">
        <h2><i class="fas fa-check-circle"></i> Booked Tickets</h2>
        <p class="text-muted mb-0">Active reservations</p>
      </div>
      
      <?php if(!empty($bookings)) { ?>
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th><i class="fas fa-ticket-alt"></i> PNR</th>
              <th><i class="fas fa-user"></i> User ID</th>
              <th><i class="fas fa-train"></i> Train</th>
              <th><i class="fas fa-calendar"></i> Date</th>
              <th><i class="fas fa-tag"></i> Class</th>
              <th><i class="fas fa-chair"></i> Seats</th>
              <th><i class="fas fa-money-bill-wave"></i> Fare (VND)</th>
              <th><i class="fas fa-status"></i> Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($bookings as $booking) { ?>
            <tr>
              <td><strong><?php echo $booking['pnr']; ?></strong></td>
              <td><?php echo $booking['id']; ?></td>
              <td><?php echo $booking['trainno']; ?></td>
              <td><?php echo date('d/m/Y', strtotime($booking['doj'])); ?></td>
              <td><?php echo $booking['class']; ?></td>
              <td><?php echo $booking['nos']; ?></td>
              <td><?php echo number_format($booking['tfare'], 0, '.', ','); ?> VND</td>
              <td><span class="badge badge-booked"><?php echo $booking['status']; ?></span></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>
      <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No booked tickets found.
      </div>
      <?php } ?>
    </div>
    
    <div style="text-align: center;">
      <a href="http://localhost/railway/admin_login.php" class="back-btn">
        <i class="fas fa-tachometer-alt"></i> Back to Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



