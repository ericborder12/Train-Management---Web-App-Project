<?php
require "db.php";

$query = "SELECT * FROM train";
$result = mysqli_query($conn, $query);
$trains = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Train Classes - Railway Admin</title>
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
      max-width: 700px;
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
    .btn-next {
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
    .btn-next:hover {
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
        <h2><i class="fas fa-layer-group"></i> Add Train Classes & Seats</h2>
        <p>Step 1 of 2: Select Train</p>
      </div>

      <div class="form-step">
        <i class="fas fa-circle" style="color: #667eea;"></i> Step 1 - Train & Class Information
      </div>

      <form action="insert_into_classseats_2.php" method="post">
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

        <div class="form-group-custom">
          <label><i class="fas fa-layer-group"></i> Class Name *</label>
          <input type="text" name="class" placeholder="E.g., AC 1 Tier, AC 2 Tier, Sleeper" required>
        </div>

        <div class="form-group-custom">
          <label><i class="fas fa-money-bill-wave"></i> Fare per Seat (VND) *</label>
          <input type="number" name="fps" step="0.01" placeholder="E.g., 1500" required>
        </div>

        <div class="form-group-custom">
          <label><i class="fas fa-chair"></i> Total Seats *</label>
          <input type="number" name="seatsleft" min="1" placeholder="E.g., 72" required>
        </div>

        <button type="submit" class="btn-next">
          <i class="fas fa-arrow-right"></i> Next Step
        </button>
      </form>

      <a href="http://localhost/railway/admin_login.php" class="back-btn">
        <i class="fas fa-tachometer-alt"></i> Back to Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


