<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists!";
    } else {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (fName, lName, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fName, $lName, $email, $password);

        if ($stmt->execute()) {
            header("Location: index.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>
