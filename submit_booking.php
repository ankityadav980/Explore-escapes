<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Leave blank for XAMPP
$dbname = "user_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destination = $_POST['destination'];
    $people_count = $_POST['people_count'];
    $arrival_date = $_POST['arrival_date'];
    $leaving_date = $_POST['leaving_date'];
    $details = $_POST['details'];

    // Insert data into the database
    $sql = "INSERT INTO bookings (destination, people_count, arrival_date, leaving_date, details) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $destination, $people_count, $arrival_date, $leaving_date, $details);

    if ($stmt->execute()) {
        echo "<div style='text-align: center; margin-top: 20%;'>
                <h2>Booking successful!</h2>
                <p>You will be redirected shortly...</p>
              </div>";
        // Redirect to the homepage or previous page after 5 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = document.referrer || '/';
                }, 5000);
              </script>";
    } else {
        echo "<div style='text-align: center; margin-top: 20%;'>
                <h2>Error: " . htmlspecialchars($stmt->error) . "</h2>
                <p>Redirecting back...</p>
              </div>";
        // Redirect back to the form after 5 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = document.referrer;
                }, 5000);
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
