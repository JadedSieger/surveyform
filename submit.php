<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize inputs
  $email = htmlspecialchars($_POST['email']);
  $first = htmlspecialchars($_POST['first_name']);
  $last = htmlspecialchars($_POST['last_name']);
  $duration = intval($_POST['duration']);
  $item = htmlspecialchars($_POST['item']);
  $phone = htmlspecialchars($_POST['phone_number']);

  // Connect to DB
  $conn = getDBConnection();

  // Insert into DB
  $stmt = $conn->prepare("INSERT INTO rental_requests 
    (submitted_at, contact_email, last_name, first_name, phone_number, rent_duration, item_code) 
    VALUES (NOW(), ?, ?, ?, ?, ?, ?)");
  
  if ($stmt) {
    $stmt->bind_param("ssssss", $email, $last, $first, $phone, $duration, $item);
    $stmt->execute();
    $stmt->close();
  } else {
    die("Database error: " . $conn->error);
  }

  $conn->close();
} else {
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Rental Confirmation</title>
  <link rel="stylesheet" href="rent-form.css" />
</head>
<body>

  <div class="form-container">
    <h2>Registration Complete</h2>
    <div style="background:#e0ffe0; padding:15px; border-radius:6px; margin-bottom:20px;">
      <strong>Your rental request has been recorded in our system.</strong><br><br>
      <b>Email:</b> <?= $email ?><br>
      <b>Name:</b> <?= $first . ' ' . $last ?><br>
      <b>Phone:</b> <?= $phone ?><br>
      <b>Duration:</b> <?= $duration ?> day(s)<br>
      <b>Item:</b> <?= $item ?>
    </div>
    <a href="index.php" class="submit-btn" style="text-align:center; display:block;">Back to Form</a>
  </div>

</body>
</html>
