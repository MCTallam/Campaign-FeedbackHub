<?php
// Enable error reporting to debug issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize variables
$name = $email = $feedback = $rating = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Database credentials
    $servername = "localhost";
    $username = "root"; // Default XAMPP MySQL username
    $password = ""; // Default XAMPP MySQL password
    $dbname = "campaign_feedback"; // Ensure this matches your database name

    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Capture form data and sanitize inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $feedback = $conn->real_escape_string($_POST['feedback']);
    $rating = (int)$_POST['rating']; // Cast rating to integer

    // Prepare and bind statement to insert data, including submission_date
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback, rating, submission_date) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
    $stmt->bind_param("sssi", $name, $email, $feedback, $rating);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        $successMessage = "Feedback submitted successfully!";
        // Clear the form by resetting the values
        $name = $email = $feedback = $rating = "";
    } else {
        $successMessage = "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampaignPulse Feedback Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Submit Your Feedback</h2>

        <!-- Display success message if feedback is submitted -->
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="mb-3">
                <label for="feedback" class="form-label">Feedback:</label>
                <textarea class="form-control" id="feedback" name="feedback" rows="4" required><?php echo htmlspecialchars($feedback); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating:</label>
                <select class="form-select" id="rating" name="rating" required>
                    <option value="">Select a rating</option>
                    <option value="1" <?php if ($rating == 1) echo 'selected'; ?>>1 - Poor</option>
                    <option value="2" <?php if ($rating == 2) echo 'selected'; ?>>2 - Fair</option>
                    <option value="3" <?php if ($rating == 3) echo 'selected'; ?>>3 - Good</option>
                    <option value="4" <?php if ($rating == 4) echo 'selected'; ?>>4 - Very Good</option>
                    <option value="5" <?php if ($rating == 5) echo 'selected'; ?>>5 - Excellent</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
