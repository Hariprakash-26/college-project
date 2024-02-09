<?php

$uname1 = $_POST['uname1'];
$email1  = $_POST['email1'];
$upswd1 = $_POST['upswd1'];
$upswd2 = $_POST['upswd2'];

if (!empty($uname1) && !empty($email1) && !empty($upswd1) && !empty($upswd2)) {

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "register";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT email1 FROM register WHERE email1 = ? LIMIT 1";
        $INSERT = "INSERT INTO register (uname1, email1, upswd1, upswd2) VALUES (?, ?, ?, ?)";

        // Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email1);
        $stmt->execute();
        $stmt->bind_result($existingEmail);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        // Checking email existence
        if ($rnum == 0) {
            $stmt->close();

            // Insert plain text password
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $uname1, $email1, $upswd1, $upswd2);
            $stmt->execute();
            echo "New record inserted successfully";
        } else {
            echo "Someone already registered using this email";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}
?>
