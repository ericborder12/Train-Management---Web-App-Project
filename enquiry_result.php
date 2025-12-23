<?php
session_start();
require "db.php";

$doj = $_POST["doj"];
$_SESSION["doj"] = "$doj";
$sp = $_POST["sp"];
$_SESSION["sp"] = "$sp";
$dp = $_POST["dp"];
$_SESSION["dp"] = "$dp";

$query = mysqli_query($conn, "SELECT t.trainno, t.tname, c.sp, s1.departure_time, c.dp, s2.arrival_time, t.dd, c.class, c.fare, c.seatsleft FROM train as t, classseats as c, schedule as s1, schedule as s2 where s1.trainno=t.trainno AND s2.trainno=t.trainno AND s1.sname='" . $sp . "' AND s2.sname='" . $dp . "' AND t.trainno=c.trainno AND c.sp='" . $sp . "' AND c.dp='" . $dp . "' AND c.doj='" . $doj . "'");

$trains = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Search Results - Railway Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
    }

    .results-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .results-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      padding: 30px;
      margin-bottom: 20px;
    }

    .results-header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #667eea;
      padding-bottom: 20px;
    }

    .results-header h2 {
      color: #333;
      font-weight: 700;
      margin: 0;
    }

    .search-summary {
      background: #f8f9fa;
      padding: 15px 20px;
      border-radius: 10px;
      margin-bottom: 20px;
      border-left: 5px solid #667eea;
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 15px;
    }

    .summary-item {
      text-align: center;
    }

    .summary-label {
      font-size: 12px;
      color: #667eea;
      font-weight: 600;
      text-transform: uppercase;
    }

    .summary-value {
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
      font-size: 14px;
    }

    td {
      padding: 15px;
      border-bottom: 1px solid #ddd;
    }

    tbody tr:hover {
      background: #f8f9fa;
    }

    .booking-form {
      background: #f8f9fa;
      padding: 25px;
      border-radius: 15px;
      margin-top: 30px;
      border: 2px solid #667eea;
    }

    .booking-form h4 {
      color: #333;
      font-weight: 700;
      margin-bottom: 20px;
      border-bottom: 2px solid #667eea;
      padding-bottom: 10px;
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

    .btn-book {
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
    }

    .btn-book:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      color: white;
    }

    .action-links {
      display: flex;
      gap: 10px;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .btn-link {
      background: #667eea;
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: inline-block;
      cursor: pointer;
    }

    .btn-link:hover {
      background: #764ba2;
      transform: translateY(-3px);
      color: white;
    }

    .alert-custom {
      background: #fff3cd;
      border: 2px solid #ffc107;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      color: #856404;
      font-weight: 600;
      margin: 20px 0;
    }

    .empty-results {
      text-align: center;
      padding: 40px;
      color: #999;
    }
  </style>
</head>

<body>
  <div class="results-container">
    <div class="results-card">
      <div class="results-header">
        <h2><i class="fas fa-search"></i> Available Trains</h2>
      </div>

      <div class="search-summary">
        <div class="summary-item">
          <div class="summary-label"><i class="fas fa-map-marker-alt"></i> From</div>
          <div class="summary-value"><?php echo htmlspecialchars($sp); ?></div>
        </div>
        <div class="summary-item">
          <div class="summary-label"><i class="fas fa-arrow-right"></i></div>
          <div class="summary-value" style="opacity: 0;">-</div>
        </div>
        <div class="summary-item">
          <div class="summary-label"><i class="fas fa-map-marker-alt"></i> To</div>
          <div class="summary-value"><?php echo htmlspecialchars($dp); ?></div>
        </div>
        <div class="summary-item">
          <div class="summary-label"><i class="fas fa-calendar"></i> Date</div>
          <div class="summary-value"><?php echo date('d/m/Y', strtotime($doj)); ?></div>
        </div>
      </div>

      <?php if (!empty($trains)) { ?>
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th><i class="fas fa-train"></i> Train No</th>
                <th><i class="fas fa-heading"></i> Name</th>
                <th><i class="fas fa-clock"></i> Departure</th>
                <th><i class="fas fa-flag-checkered"></i> Arrival</th>
                <th><i class="fas fa-layer-group"></i> Class</th>
                <th><i class="fas fa-money-bill-wave"></i> Fare (VND)</th>
                <th><i class="fas fa-chair"></i> Seats</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($trains as $train) { ?>
                <tr>
                  <td><strong><?php echo $train['trainno']; ?></strong></td>
                  <td><?php echo $train['tname']; ?></td>
                  <td><strong><?php echo $train['departure_time']; ?></strong></td>
                  <td><?php echo $train['arrival_time']; ?></td>
                  <td><?php echo $train['class']; ?></td>
                  <td><?php echo number_format($train['fare'], 0, '.', ','); ?> VND</td>
                  <td>
                    <span
                      style="background: #667eea; color: white; padding: 5px 10px; border-radius: 20px; font-weight: 600;">
                      <?php echo $train['seatsleft']; ?>
                    </span>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <div class="booking-form">
          <h4><i class="fas fa-credit-card"></i> Proceed with Booking</h4>

          <form action="resvn.php" method="post" id="bookingForm">

            <!-- Login info (resvn.php cần) -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group-custom">
                  <label><i class="fas fa-phone"></i> Registered Mobile No *</label>
                  <input type="text" name="mno" placeholder="Enter your registered mobile number" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group-custom">
                  <label><i class="fas fa-lock"></i> Password *</label>
                  <input type="password" name="password" placeholder="Enter your password" required>
                </div>
              </div>
            </div>

            <!-- Train selection -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group-custom">
                  <label><i class="fas fa-train"></i> Select Train *</label>
                  <select name="tno" id="tno" required>
                    <option value="">-- Choose train --</option>
                    <?php foreach ($trains as $train) { ?>
                      <option value="<?php echo htmlspecialchars($train['trainno']); ?>"
                        data-class="<?php echo htmlspecialchars($train['class']); ?>"
                        data-fare="<?php echo (int) $train['fare']; ?>"
                        data-seats="<?php echo (int) $train['seatsleft']; ?>">
                        <?php echo htmlspecialchars($train['trainno']); ?> -
                        <?php echo htmlspecialchars($train['tname']); ?>
                        (<?php echo htmlspecialchars($train['departure_time']); ?> →
                        <?php echo htmlspecialchars($train['arrival_time']); ?>)
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group-custom">
                  <label><i class="fas fa-layer-group"></i> Class *</label>
                  <input type="text" name="class" id="class" readonly required>
                </div>
              </div>
            </div>

            <!-- Fare + Seats -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group-custom">
                  <label><i class="fas fa-money-bill-wave"></i> Fare (per seat)</label>
                  <input type="text" id="fare_text" readonly>
                  <input type="hidden" name="fare" id="fare">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group-custom">
                  <label><i class="fas fa-users"></i> Number of Seats *</label>
                  <input type="number" name="nos" id="nos" min="1" max="10" placeholder="Enter number of seats" required>
                  <small id="seats_hint" style="color:#666;"></small>
                </div>
              </div>
            </div>

            <!-- Payment method -->
            <div class="form-group-custom">
              <label><i class="fas fa-credit-card"></i> Payment Method *</label>
              <select name="pay_method" id="pay_method" required>
                <option value="">-- Choose payment method --</option>
                <option value="QR">QR (Scan)</option>
                <option value="COD">Pay at Counter (COD)</option>
                <option value="CARD">Card</option>
              </select>
            </div>

            <!-- QR box -->
            <div id="qr_box"
              style="display:none; background:#fff; border:2px dashed #667eea; padding:15px; border-radius:12px; margin-top:10px;">
              <div style="font-weight:700; margin-bottom:10px;">
                <i class="fas fa-qrcode"></i> Scan QR to Pay
              </div>

              <div style="display:flex; gap:15px; flex-wrap:wrap; align-items:center;">
                <img src="qr.png" alt="QR" style="max-width:220px; border-radius:10px; border:1px solid #ddd;">
                <div style="min-width:260px;">
                  <div style="margin-bottom:8px;">
                    After scanning and paying, enter transaction reference (optional):
                  </div>
                  <input type="text" name="txn_ref" class="form-control" placeholder="Transaction reference (optional)">
                  <div style="font-size:12px; color:#666; margin-top:8px;">
                    *QR image is loaded from <b>qr.png</b> in your project folder.
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn-book" style="margin-top:18px;">
              <i class="fas fa-ticket-alt"></i> Proceed with Booking
            </button>
          </form>
        </div>

      <?php } else { ?>
        <div class="empty-results">
          <i class="fas fa-frown" style="font-size: 64px; margin-bottom: 20px; color: #667eea;"></i>
          <h4>No Trains Found</h4>
          <p>Unfortunately, no trains are available for your selected route and date.</p>
        </div>
      <?php } ?>
    </div>

    <div class="action-links">
      <a href="http://localhost/railway/enquiry.php" class="btn-link">
        <i class="fas fa-redo"></i> New Search
      </a>
      <a href="http://localhost/railway/index.htm" class="btn-link">
        <i class="fas fa-home"></i> Go to Home
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      const tno = document.getElementById('tno');
      const classInput = document.getElementById('class');
      const fareText = document.getElementById('fare_text');
      const fareHidden = document.getElementById('fare');
      const seatsHint = document.getElementById('seats_hint');
      const nos = document.getElementById('nos');

      const payMethod = document.getElementById('pay_method');
      const qrBox = document.getElementById('qr_box');

      function formatVND(n) {
        try { return Number(n).toLocaleString('en-US'); } catch (e) { return n; }
      }

      tno.addEventListener('change', function () {
        const opt = tno.options[tno.selectedIndex];
        const c = opt.getAttribute('data-class') || '';
        const f = opt.getAttribute('data-fare') || '';
        const s = opt.getAttribute('data-seats') || '';

        classInput.value = c;
        fareHidden.value = f;
        fareText.value = f ? (formatVND(f) + " VND") : "";

        if (s) {
          seatsHint.textContent = "Seats left: " + s;
          // set max seats user can book (<=10 and <= seats left)
          const maxSeats = Math.max(1, Math.min(10, parseInt(s, 10)));
          nos.max = maxSeats;
        } else {
          seatsHint.textContent = "";
          nos.max = 10;
        }
      });

      payMethod.addEventListener('change', function () {
        qrBox.style.display = (payMethod.value === 'QR') ? 'block' : 'none';
      });
    })();
  </script>

</body>

</html>