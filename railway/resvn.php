<?php
session_start();
require "db.php";

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$mobile = $_POST["mno"] ?? "";
$pwd = $_POST["password"] ?? "";

$stmt = $conn->prepare("SELECT id FROM user WHERE mobileno = ? AND password = ?");
$stmt->bind_param("ss", $mobile, $pwd);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  echo "No such login !!! <br><br>";
  echo "<a href=\"http://localhost/railway/enquiry_result.php\">Go Back!!!</a><br>";
  die();
}

$row = $result->fetch_assoc();
$temp = $row['id'];

$_SESSION["id"] = "$temp";

$tno = $_POST["tno"] ?? "";
$_SESSION["tno"] = "$tno";

$class = $_POST["class"] ?? "";
$_SESSION["class"] = "$class";

$nos = (int) ($_POST["nos"] ?? 0);
$_SESSION["nos"] = "$nos";

if ($nos <= 0) {
  echo "Invalid number of seats.<br>";
  echo "<a href=\"http://localhost/railway/enquiry_result.php\">Go Back!!!</a><br>";
  die();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Passenger Details</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      min-height: 100vh;
      background-image: url('pnglogin.jpg');
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      margin: 0;
    }

    .overlay {
      min-height: 100vh;
      background: linear-gradient(135deg, rgba(102, 126, 234, .70), rgba(118, 75, 162, .70));
      padding: 30px 12px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      border: 0;
      border-radius: 18px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
      overflow: hidden;
      max-width: 980px;
      width: 100%;
    }

    .card-header {
      background: rgba(255, 255, 255, .10);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, .15);
      padding: 18px 22px;
    }

    .header-title {
      margin: 0;
      font-weight: 800;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 10px;
      letter-spacing: .2px;
    }

    .sub {
      color: rgba(255, 255, 255, .85);
      margin: 6px 0 0 0;
      font-size: 14px;
    }

    .card-body {
      background: #fff;
      padding: 22px;
    }

    .pill {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      background: #f6f7ff;
      border: 1px solid #e7e9ff;
      border-radius: 12px;
      font-weight: 600;
      color: #333;
    }

    .pill small {
      font-weight: 700;
      color: #667eea;
      text-transform: uppercase;
      letter-spacing: .6px;
    }

    .form-label {
      font-weight: 700;
      color: #333;
    }

    .form-control,
    .form-select {
      border-radius: 12px;
      padding: 12px 12px;
      border: 1px solid #dfe3ff;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 .25rem rgba(102, 126, 234, .15);
    }

    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: 0;
      border-radius: 12px;
      padding: 12px 16px;
      font-weight: 800;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 14px 30px rgba(102, 126, 234, .30);
    }

    .btn-outline-secondary {
      border-radius: 12px;
      padding: 12px 16px;
      font-weight: 700;
    }

    .passenger-card {
      border: 1px solid #eef0ff;
      background: #fbfbff;
      border-radius: 14px;
      padding: 14px;
      margin-bottom: 12px;
    }

    .passenger-badge {
      width: 34px;
      height: 34px;
      border-radius: 10px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: #fff;
      font-weight: 900;
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 0 0 auto;
    }
  </style>
</head>

<body>
  <div class="overlay">
    <div class="card">
      <div class="card-header">
        <h4 class="header-title">
          <i class="fa-solid fa-ticket"></i>
          Passenger Details & Payment
        </h4>
        <p class="sub">Fill passenger info, choose payment method, then confirm booking.</p>
      </div>

      <div class="card-body">
        <div class="d-flex flex-wrap gap-2 mb-3">
          <div class="pill"><small><i class="fa-solid fa-user"></i> User ID</small>
            <?php echo htmlspecialchars($temp); ?></div>
          <div class="pill"><small><i class="fa-solid fa-train"></i> Train</small> <?php echo htmlspecialchars($tno); ?>
          </div>
          <div class="pill"><small><i class="fa-solid fa-layer-group"></i> Class</small>
            <?php echo htmlspecialchars($class); ?></div>
          <div class="pill"><small><i class="fa-solid fa-users"></i> Seats</small> <?php echo htmlspecialchars($nos); ?>
          </div>
        </div>

        <form action="new_png.php" method="post">
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label"><i class="fa-solid fa-credit-card"></i> Payment Method</label>
              <select name="pay_method" class="form-select" required>
                <option value="QR">QR (Scan QR / Banking)</option>
                <option value="COD">Pay at Counter (COD)</option>
                <option value="CARD">Card</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label"><i class="fa-solid fa-circle-info"></i> Note (optional)</label>
              <input type="text" name="pay_note" class="form-control" placeholder="E.g. pay later / special request">
            </div>
          </div>

          <h5 class="fw-bold mb-3"><i class="fa-solid fa-id-card"></i> Passenger Information</h5>

          <?php for ($i = 0; $i < $nos; $i++) { ?>
            <div class="passenger-card">
              <div class="d-flex align-items-center gap-3 mb-2">
                <div class="passenger-badge"><?php echo ($i + 1); ?></div>
                <div class="fw-bold">Passenger <?php echo ($i + 1); ?></div>
              </div>

              <div class="row g-3">
                <div class="col-md-5">
                  <label class="form-label">Name</label>
                  <input type="text" name="pname[]" class="form-control" placeholder="Passenger Name" required>
                </div>
                <div class="col-md-3">
                  <label class="form-label">Age</label>
                  <input type="number" name="page[]" class="form-control" placeholder="Age" min="0" required>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Gender</label>
                  <td>
                    <select name="pgender[]" class="form-control" required>
                      <option value="">-- Select --</option>
                      <option value="M">Male</option>
                      <option value="F">Female</option>
                    </select>
                  </td>
                </div>
              </div>
            </div>
          <?php } ?>

          <div class="d-flex gap-2 mt-4 flex-wrap">
            <a class="btn btn-outline-secondary" href="http://localhost/railway/enquiry.php">
              <i class="fa-solid fa-arrow-left"></i> Back to Enquiry
            </a>

            <button type="submit" class="btn btn-primary ms-auto">
              <i class="fa-solid fa-check"></i> Confirm Booking
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$stmt->close();
$conn->close();
?>