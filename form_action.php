<?php
function generateSalt($length = 22)
{
    return substr(base64_encode(random_bytes($length)), 0, $length);
}
// Database connection parameters
//$servername = "your_database_server";
//$username = "your_database_username";
//$password = "your_database_password";
//$dbname = "your_database_name";
$servername = "localhost";
$username = "Arka";
$password = "Arkasql0*";
$dbname = "form_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $checkbox = isset($_POST["checkbox"]) ? 1 : 0;
    $radio = $_POST["radio"];

    //encryption of password wile storing it by using salting and then hashing
    $userInputPassword = $password;
    // Generate a random salt
    $salt = generateSalt();
    // Combine the password and salt
    $combinedPassword = $userInputPassword . $salt;
    // Hash the combined password using bcrypt
    $hashedPassword = password_hash($combinedPassword, PASSWORD_BCRYPT);

    // Handle image upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        // Define the target directory to store uploaded files
        $targetDirectory = "uploads/";

        // Generate a unique filename to avoid overwriting existing files
        $targetFileName = $targetDirectory . uniqid() . "_" . basename($_FILES["image"]["name"]);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFileName)) {
            echo "File uploaded successfully. Stored at: " . $targetFileName;
        } else {
            // echo "Error uploading file.";
            echo "Upload Error: " . $_FILES["image"]["error"];
        }
    }
    else {
        echo "Error: " . $_FILES["image"]["error"];
    }

    // Insert data into the database
    $sql = "INSERT INTO form_data ( Email, Password, Checkbox, Radio ,Photo ) VALUES ('$email', '$hashedPassword', '$checkbox', '$radio', '$targetFile')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Close the database connection
$conn->close();
?>