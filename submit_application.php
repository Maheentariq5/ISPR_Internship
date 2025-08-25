<?php

$servername = "localhost";
$username = "root";   
$password = "";     
$dbname = "ispr_internship";

$conn = mysqli_connect($servername, $username, $password, $dbname,3307);

// Check connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $fullname   = $_POST['fullname'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $university = $_POST['university'];
    $field      = $_POST['field'];

    // Upload directory
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // File uploads
    $cvPath = $targetDir . basename($_FILES["cv"]["name"]);
    $cnicPath = $targetDir . basename($_FILES["cnic"]["name"]);
    $policePath = $targetDir . basename($_FILES["police"]["name"]);

    move_uploaded_file($_FILES["cv"]["tmp_name"], $cvPath);
    move_uploaded_file($_FILES["cnic"]["tmp_name"], $cnicPath);
    move_uploaded_file($_FILES["police"]["tmp_name"], $policePath);

    // Insert into database
    $sql = "INSERT INTO applications (fullname, email, phone, university, field, cv, cnic, police)
            VALUES ('$fullname', '$email', '$phone', '$university', '$field', '$cvPath', '$cnicPath', '$policePath')";

    if ($conn->query($sql) === TRUE) {
      
        echo "<script>
        alert ('Thank you $fullname We will contact you soon.');
         window.location.href = 'home.html';
        </script>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
