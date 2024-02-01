<?php

    // database details
    $host = "localhost";
    $username = "Arka";
    $password = "Arkasql0*";
    $dbname = "form_test";

    // creating a connection
    $con = mysqli_connect($host, $username, $password, $dbname);

    // to ensure that the connection is made
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $email = $_POST["email"];
        $password = $_POST["password"];
        $gender = $_POST["gender"];
        $country = $_POST["country"];
        
        // Checkboxes are an array in HTML, so we use implode to display selected options
        $hobbies = isset($_POST["hobbies"]) ? implode(", ", $_POST["hobbies"]) : "None";
    
    // Handle image upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    
        // Insert data into the database
        $sql = "INSERT INTO form_data ( Email, Password, Gender, Country ,Hobbies, Photo ) VALUES ('$email', '$password', '$gender', '$country', '$hobbies', '$targetFile')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    // Close the database connection
    $conn->close();
   ?>