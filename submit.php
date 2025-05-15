<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Optionally, you can process the data here (e.g., save to database)
  
  // Sanitize inputs (optional if you're not showing them)
  $email = htmlspecialchars($_POST['email']);
  $first = htmlspecialchars($_POST['first_name']);
  $last = htmlspecialchars($_POST['last_name']);
  $duration = htmlspecialchars($_POST['duration']);
  $item = htmlspecialchars($_POST['item']);

  // You could save to a file or DB here if needed

  // Then show confirmation page:
} else {
  // Redirect back if accessed directly
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
      <strong>Your rental request has been received.</strong><br><br>
      <b>Email:</b> <?= $email ?><br>
      <b>Name:</b> <?= $first . ' ' . $last ?><br>
      <b>Duration:</b> <?= $duration ?> day(s)<br>
      <b>Item:</b> <?= $item ?>
    </div>
    <a href="index.php" class="submit-btn" style="text-align:center; display:block;">Back to Form</a>
  </div>

</body>
</html>
