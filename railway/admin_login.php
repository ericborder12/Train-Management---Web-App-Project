<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Railway Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .admin-card { max-width:720px; width:100%; border-radius:12px; padding:28px; box-shadow:0 18px 50px rgba(0,0,0,0.2); background:#fff; }
        .admin-links a{ display:block; margin-bottom:8px; }
    </style>
</head>
<body>
    <div class="admin-card">
        <?php
        session_start();
        if(isset($_POST['uid']) && $_POST['uid']==='admin' && isset($_POST['password']) && $_POST['password']==='admin'){
            $_SESSION['admin_login'] = true;
        }

        if(!empty($_SESSION['admin_login'])){
            echo '<h4>Admin Dashboard</h4>';
            echo '<div class="admin-links">';
            echo '<a href="insert_into_stations.php" class="btn btn-outline-primary btn-sm">Show All Stations</a>';
            echo '<a href="show_trains.php" class="btn btn-outline-primary btn-sm">Show All Trains</a>';
            echo '<a href="show_users.php" class="btn btn-outline-primary btn-sm">Show All Users</a>';
            echo '<a href="insert_into_train_3.php" class="btn btn-outline-primary btn-sm">Enter New Train</a>';
            echo '<a href="insert_into_classseats_3.php" class="btn btn-outline-primary btn-sm">Enter Train Schedule</a>';
            echo '<a href="booked.php" class="btn btn-outline-primary btn-sm">View all booked tickets</a>';
            echo '<a href="cancelled.php" class="btn btn-outline-primary btn-sm">View all cancelled tickets</a>';
            echo '</div>';
        } else {
            echo '<h4 class="mb-3">Admin Login</h4>';
            echo '<form action="admin_login.php" method="post">';
            echo '<div class="mb-2"><label class="form-label">User ID</label><input class="form-control" type="text" name="uid" required></div>';
            echo '<div class="mb-2"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>';
            echo '<div><button class="btn btn-primary">Login</button></div>';
            echo '</form>';
        }
        ?>

        <div style="margin-top:14px;"><a href="index.htm" class="btn btn-link">Go to Home Page</a></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
