<?php
// Database credentials
$servername = "localhost";
$username = "root"; // default XAMPP MySQL username is "root"
$password = ""; // default XAMPP MySQL password is blank
$dbname = "campaign_feedback"; // ensure this matches the database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from feedback table
$sql = "SELECT name, email, feedback, rating, submission_date FROM feedback ORDER BY submission_date DESC";
$result = $conn->query($sql);

// Display the data in an HTML table
if ($result->num_rows > 0) {
    echo "Data exists.";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Name</th><th>Email</th><th>Feedback</th><th>Rating</th><th>Date Submitted</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['feedback']) . "</td>";
        echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
        echo "<td>" . htmlspecialchars($row['submission_date']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No feedback available.";
}

// Close connection
$conn->close();

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
