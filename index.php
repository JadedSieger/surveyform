<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Rental Form</title>
  <link rel="stylesheet" href="rent-form.css" />
</head>
<body>

  <div class="form-container">
    <h2>Rent an Item</h2>

    <form action="submit.php" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
      </div>

      <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="first_name" required />
      </div>

      <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="last_name" required />
      </div>

      <div class="form-group">
        <label for="duration">Duration of Rent (days):</label>
        <input type="number" id="duration" name="duration" min="1" required />
      </div>

      <div class="form-group">
        <label for="item">Item to be Rented:</label>
        <select id="item" name="item" required>
          <option value="">-- Select an item --</option>
          <option value="Laptop">Laptop</option>
          <option value="Projector">Projector</option>
          <option value="Camera">Camera</option>
          <option value="Microphone">Microphone</option>
        </select>
      </div>

      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </div>

</body>
</html>
