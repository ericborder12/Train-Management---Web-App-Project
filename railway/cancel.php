<?php 
session_start();
require "db.php";

$pnr = $_POST["cancpnr"];
$uid = $_SESSION["id"];

$sql = "UPDATE resv SET status='CANCELLED' WHERE resv.pnr='" . $pnr . "' AND resv.id='" . $uid . "'";

$success = false;
$error = "";

if ($conn->query($sql) === TRUE) {
  $success = true;
} else {
  $error = $conn->error;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cancellation Result - Railway Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .result-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      padding: 40px 30px;
      max-width: 600px;
      width: 100%;
      text-align: center;
    }
    .success-icon {
      color: #43e97b;
      font-size: 80px;
      margin-bottom: 20px;
    }
    .error-icon {
      color: #ff6b6b;
      font-size: 80px;
      margin-bottom: 20px;
    }
    h2 {
      color: #333;
      font-weight: 700;
      margin: 20px 0;
    }
    .result-message {
      font-size: 16px;
      color: #666;
      margin: 20px 0;
      line-height: 1.6;
    }
    .pnr-display {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 10px;
      margin: 20px 0;
      border-left: 4px solid #667eea;
    }
    .pnr-label {
      font-weight: 600;
      color: #667eea;
      font-size: 12px;
      text-transform: uppercase;
    }
    .pnr-value {
      font-size: 24px;
      font-weight: 700;
      color: #333;
      margin-top: 8px;
    }
    .error-details {
      background: #f8d7da;
      border: 2px solid #f5c6cb;
      color: #721c24;
      padding: 15px;
      border-radius: 10px;
      margin: 20px 0;
    }
    .action-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-top: 30px;
      flex-wrap: wrap;
    }
    .btn-home {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 8px;
      transition: all 0.3s ease;
      display: inline-block;
      border: none;
      cursor: pointer;
    }
    .btn-home:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      color: white;
    }
  </style>
</head>
<body>
  <div class="result-card">
    <?php if($success) { ?>
      <div class="success-icon">
        <i class="fas fa-check-circle"></i>
      </div>
      <h2>Cancellation Successful!</h2>
      <p class="result-message">
        Your ticket has been successfully cancelled. The fare will be refunded to your registered account within 5-7 business days.
      </p>
      <div class="pnr-display">
        <div class="pnr-label">Cancelled Ticket (PNR)</div>
        <div class="pnr-value"><?php echo htmlspecialchars($pnr); ?></div>
      </div>
    <?php } else { ?>
      <div class="error-icon">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <h2>Cancellation Failed</h2>
      <p class="result-message">
        We encountered an error while processing your cancellation request.
      </p>
      <div class="error-details">
        <strong>Error Details:</strong><br>
        <?php echo htmlspecialchars($error); ?>
      </div>
      <p class="result-message">
        Please verify the PNR number and try again, or contact customer support for assistance.
      </p>
    <?php } ?>

    <div class="action-buttons">
      <a href="http://localhost/railway/index.htm" class="btn-home">
        <i class="fas fa-home"></i> Go to Home
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
