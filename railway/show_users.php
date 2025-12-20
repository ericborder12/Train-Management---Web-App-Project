<?php
require "db.php";

$cdquery="SELECT * FROM user";
$cdresult=mysqli_query($conn,$cdquery);
$users = mysqli_fetch_all($cdresult, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>View Users - Railway Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }
    .users-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .users-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 30px;
      margin-bottom: 20px;
    }
    .users-header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #667eea;
      padding-bottom: 20px;
    }
    .users-header h2 {
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
  <div class="users-container">
    <div class="users-card">
      <div class="users-header">
        <h2><i class="fas fa-users"></i> All Users</h2>
      </div>
      
      <?php if(!empty($users)) { ?>
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th><i class="fas fa-hashtag"></i> ID</th>
              <th><i class="fas fa-envelope"></i> Email</th>
              <th><i class="fas fa-phone"></i> Mobile</th>
              <th><i class="fas fa-birthday-cake"></i> DOB</th>
              <th colspan="2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($users as $user) { ?>
            <tr>
              <td><strong><?php echo $user['id']; ?></strong></td>
              <td><?php echo $user['emailid']; ?></td>
              <td><?php echo $user['mobileno']; ?></td>
              <td><?php echo date('d/m/Y', strtotime($user['dob'])); ?></td>
              <td>
                <a href="http://localhost/railway/edit_user.php?id=<?php echo $user['id']; ?>" class="btn-edit">
                  <i class="fas fa-edit"></i> Edit
                </a>
              </td>
              <td>
                <a href="http://localhost/railway/delete_user.php?id=<?php echo $user['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')">
                  <i class="fas fa-trash"></i> Delete
                </a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>
      <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No users found.
      </div>
      <?php } ?>
    </div>
    
    <div class="action-links">
      <a href="http://localhost/railway/new_user_form.html" class="btn-add">
        <i class="fas fa-user-plus"></i> Add New User
      </a>
      <a href="http://localhost/railway/admin_login.php" class="back-btn">
        <i class="fas fa-tachometer-alt"></i> Admin Panel
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
