<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Ticket - Railway Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-enquiry { max-width:720px; width:100%; border-radius:12px; padding:28px; box-shadow:0 18px 50px rgba(0,0,0,0.2); background:#fff; }
        .form-label { font-weight:600; }
        .small-link{ display:block; margin-top:12px; text-align:center; color:#667eea; }
    </style>
</head>
<body>
<?php
session_start();
$_SESSION = array();
session_destroy();
?>
    <div class="card-enquiry">
        <h3 class="mb-2">Find Trains</h3>
        <p class="text-muted">Search for trains and book your ticket</p>

        <div class="mb-3">
          <div class="alert alert-light p-3" style="border-left:5px solid #667eea;">
            <h6 class="mb-2">Ticket Types</h6>
            <div class="table-responsive">
              <table class="table table-sm mb-0">
                <thead>
                  <tr>
                    <th>Code</th>
                    <th>Description (Vietnamese)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td>AC1</td><td>Khoang điều hòa hạng nhất</td></tr>
                  <tr><td>AC2</td><td>Khoang điều hòa hạng hai</td></tr>
                  <tr><td>AC3</td><td>Khoang điều hòa hạng ba</td></tr>
                  <tr><td>CC</td><td>Ghế ngồi</td></tr>
                  <tr><td>EC</td><td>Ghế ngồi cao cấp</td></tr>
                  <tr><td>SL</td><td>Giường nằm thường</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <form action="enquiry_result.php" method="post">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Starting Point</label>
                    <select id="sp" name="sp" class="form-select" required>
                        <option value="">Select station</option>
                        <?php
                        require "db.php";
                        $cdquery = "SELECT sname FROM station";
                        $cdresult = mysqli_query($conn,$cdquery);
                        while ($cdrow = mysqli_fetch_array($cdresult)) {
                            $cdTitle = htmlspecialchars($cdrow['sname']);
                            echo "<option value=\"$cdTitle\">$cdTitle</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Destination Point</label>
                    <select id="dp" name="dp" class="form-select" required>
                        <option value="">Select station</option>
                        <?php
                        require "db.php";
                        $cdquery = "SELECT sname FROM station";
                        $cdresult = mysqli_query($conn,$cdquery);
                        while ($cdrow = mysqli_fetch_array($cdresult)) {
                            $cdTitle = htmlspecialchars($cdrow['sname']);
                            echo "<option value=\"$cdTitle\">$cdTitle</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date</label>
                    <input type="date" name="doj" class="form-control" required>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%); border:none;">Search</button>
                <a href="index.htm" class="btn btn-outline-secondary">Home</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
