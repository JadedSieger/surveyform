<?php
require_once 'db.php';

function getItemCode($itemName) {
    $mapping = [
        "Camera"     => "CAM-004",
        "Generator"  => "GEN-005",
        "Laptop"     => "LTP-003",
        "Projector"  => "PRJ-001",
        "Microphone" => "SND-002",
        "Sound System" => "SND-002"
    ];
    
    return isset($mapping[$itemName]) ? $mapping[$itemName] : null;
}

function getItemName($itemCode) {
    $mapping = [
        "CAM-004" => "Camera",
        "GEN-005" => "Generator",
        "LTP-003" => "Laptop",
        "PRJ-001" => "Projector",
        "SND-002" => "Sound System"
    ];
    
    return isset($mapping[$itemCode]) ? $mapping[$itemCode] : "Unknown";
}

function getRentalRate($conn, $itemCode) {
    $stmt = $conn->prepare("SELECT rental_rate_per_day FROM rental_items WHERE item_code = ?");
    $stmt->bind_param("s", $itemCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $rate = null;

    if ($row = $result->fetch_assoc()) {
        $rate = $row['rental_rate_per_day'];
    }

    $stmt->close();
    return $rate;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize inputs
  $email = htmlspecialchars($_POST['email']);
  $first = htmlspecialchars($_POST['first_name']);
  $last = htmlspecialchars($_POST['last_name']);
  $duration = intval($_POST['duration']);
  $itemName = htmlspecialchars($_POST['item']);
  $item = getItemCode($itemName);
  $phone = htmlspecialchars($_POST['phone_number']);

  // Connect to DB
  $conn = getDBConnection();

  // Get rental rate per day for this item code
  $rentalRate = getRentalRate($conn, $item);
  if ($rentalRate === null) {
    die("Error: Could not retrieve rental rate for item.");
  }

  $cost = $rentalRate * $duration;

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
      <b>Item:</b> <?= getItemName($item) ?><br>
      <b>Rental Rate per Day:</b> <?= number_format($rentalRate, 2) ?><br>
      <b>Total Cost:</b> <?= number_format($cost, 2) ?>
    </div>
    <a href="index.php" class="submit-btn" style="text-align:center; display:block;">Back to Form</a>
  </div>

</body>
</html>
