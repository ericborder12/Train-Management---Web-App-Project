<?php
require "db.php";

$cdquery = "SELECT id, sname FROM station";
$cdresult = mysqli_query($conn, $cdquery);
$stations = mysqli_fetch_all($cdresult, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Stations - Railway Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .admin-container {
      max-width: 1000px;
      margin: 0 auto;
    }
    .admin-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 30px;
      margin-bottom: 20px;
    }
    .admin-header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #667eea;
      padding-bottom: 20px;
    }
    .admin-header h2 {
      color: #333;
      font-weight: 700;
      margin: 0;
    }
    .form-section {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 15px;
      margin-bottom: 30px;
      border: 2px solid #667eea;
    }
    .form-section h4 {
      color: #333;
      font-weight: 700;
      margin-bottom: 20px;
      border-bottom: 2px solid #667eea;
      padding-bottom: 10px;
    }
    .form-group-custom {
      display: flex;
      gap: 10px;
      margin-bottom: 0;
    }
    .form-group-custom input {
      flex: 1;
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
    .btn-add {
      background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
      color: #333;
      border: none;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .btn-add:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(67, 233, 123, 0.3);
      color: #333;
    }
    .stations-header {
      text-align: center;
      margin-bottom: 20px;
      border-bottom: 3px solid #667eea;
      padding-bottom: 15px;
    }
    .stations-header h3 {
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
    .btn-edit {
      background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
      border: none;
      color: white;
      font-weight: 600;
      padding: 8px 12px;
      border-radius: 5px;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-right: 5px;
    }
    .btn-edit:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);
      color: white;
    }
    .btn-delete {
      background: #dc3545;
      border: none;
      color: white;
      font-weight: 600;
      padding: 8px 12px;
      border-radius: 5px;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .btn-delete:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
      color: white;
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
    .empty-state {
      text-align: center;
      padding: 40px;
      color: #999;
    }
  </style>
</head>
<body>
  <div class="admin-container">
    <div class="admin-card">
      <div class="admin-header">
        <h2><i class="fas fa-map-pin"></i> Station Management</h2>
      </div>

      <div class="form-section">
        <h4><i class="fas fa-plus-circle"></i> Add New Station</h4>
        <form action="insert_into_station.php" method="post">
          <div class="form-group-custom">
            <input type="text" name="sname" placeholder="Enter station name" required>
            <button type="submit" class="btn-add">
              <i class="fas fa-plus"></i> Add
            </button>
          </div>
        </form>
      </div>

      <div class="stations-header">
        <h3><i class="fas fa-list"></i> All Stations</h3>
      </div>

      <?php if(!empty($stations)) { ?>
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th width="15%"><i class="fas fa-hashtag"></i> ID</th>
              <th width="55%"><i class="fas fa-map-marker-alt"></i> Station Name</th>
              <th width="30%" colspan="2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($stations as $station) { ?>
            <tr>
              <td><strong><?php echo $station['id']; ?></strong></td>
              <td><?php echo htmlspecialchars($station['sname']); ?></td>
              <td>
                <a href="http://localhost/railway/edit_station.php?id=<?php echo $station['id']; ?>" class="btn-edit">
                  <i class="fas fa-edit"></i> Edit
                </a>
              </td>
              <td>
                <a href="http://localhost/railway/delete_station.php?id=<?php echo $station['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')">
                  <i class="fas fa-trash"></i> Delete
                </a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>
      <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>No stations found. Add your first station above.</p>
      </div>
      <?php } ?>
    </div>

    <div class="action-links">
      <a href="http://localhost/railway/admin_login.php" class="back-btn">
        <i class="fas fa-tachometer-alt"></i> Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
