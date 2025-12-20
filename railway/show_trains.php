<?php
require "db.php";

$cdquery="SELECT * FROM train";
$cdresult=mysqli_query($conn,$cdquery);
$trains = mysqli_fetch_all($cdresult, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Trains - Railway Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .trains-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .trains-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 30px;
      margin-bottom: 20px;
    }
    .trains-header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #667eea;
      padding-bottom: 20px;
    }
    .trains-header h2 {
      color: #333;
      font-weight: 700;
      margin: 0;
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
    .btn-schedule {
      background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      border: none;
      color: white;
      font-weight: 600;
      padding: 8px 15px;
      border-radius: 5px;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .btn-schedule:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);
      color: white;
    }
    .btn-add {
      background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
      border: none;
      color: #333;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-block;
      margin-right: 10px;
    }
    .btn-add:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(67, 233, 123, 0.3);
      color: #333;
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
    .action-links {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="trains-container">
    <div class="trains-card">
      <div class="trains-header">
        <h2><i class="fas fa-train"></i> All Trains</h2>
      </div>
      
      <?php if(!empty($trains)) { ?>
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th><i class="fas fa-hashtag"></i> No.</th>
              <th><i class="fas fa-heading"></i> Name</th>
              <th><i class="fas fa-map-marker-alt"></i> From</th>
              <th><i class="fas fa-clock"></i> Depart</th>
              <th><i class="fas fa-location-dot"></i> To</th>
              <th><i class="fas fa-clock"></i> Arrive</th>
              <th><i class="fas fa-calendar"></i> Day</th>
              <th><i class="fas fa-route"></i> Distance</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($trains as $train) { ?>
            <tr>
              <td><strong><?php echo $train['trainno']; ?></strong></td>
              <td><?php echo $train['tname']; ?></td>
              <td><?php echo $train['sp']; ?></td>
              <td><?php echo $train['st']; ?></td>
              <td><?php echo $train['dp']; ?></td>
              <td><?php echo $train['dt']; ?></td>
              <td><?php echo $train['dd']; ?></td>
              <td><?php echo $train['distance']; ?> km</td>
              <td>
                <a href="http://localhost/railway/schedule.php?trainno=<?php echo $train['trainno']; ?>" class="btn-schedule">
                  <i class="fas fa-info-circle"></i> Details
                </a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>
      <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No trains available.
      </div>
      <?php } ?>
    </div>
    
    <div class="action-links">
      <a href="http://localhost/railway/insert_into_train_3.php" class="btn-add">
        <i class="fas fa-plus"></i> Add New Train
      </a>
      <a href="http://localhost/railway/admin_login.php" class="back-btn">
        <i class="fas fa-tachometer-alt"></i> Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
