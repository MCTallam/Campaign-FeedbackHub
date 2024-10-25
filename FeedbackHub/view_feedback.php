<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "campaign_feedback"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, email, feedback, rating, submission_date FROM feedback ORDER BY submission_date DESC";
$result = $conn->query($sql);

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

$conn->close();

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
