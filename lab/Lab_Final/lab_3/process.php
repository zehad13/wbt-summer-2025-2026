<?php

// Check whether form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = array();

    // Receive data using $_POST
    $applicant_id = trim($_POST["applicant_id"] ?? "");
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";
    $gender = $_POST["gender"] ?? "";
    $job = $_POST["job"] ?? "";
    $qualification = trim($_POST["qualification"] ?? "");
    $address = trim($_POST["address"] ?? "");


    // Applicant ID validation
    if ($applicant_id == "") {
        $errors[] = "Applicant ID is required.";
    }


    // Name validation
    if ($name == "") {
        $errors[] = "Name is required.";
    }


    // Email validation
    if ($email == "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }


    // Phone validation
    if ($phone == "") {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^[0-9]{11}$/", $phone)) {
        $errors[] = "Phone number must contain 11 digits.";
    }


    // Password validation
    if ($password == "") {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must contain at least 6 characters.";
    }


    // Gender validation
    if ($gender == "") {
        $errors[] = "Please select your gender.";
    }


    // Job validation
    if ($job == "") {
        $errors[] = "Please select a job position.";
    }


    // Qualification validation
    if ($qualification == "") {
        $errors[] = "Qualification is required.";
    }


    // Address validation
    if ($address == "") {
        $errors[] = "Address is required.";
    }


    // CV validation using $_FILES
    if (!isset($_FILES["cv"]) || $_FILES["cv"]["error"] == UPLOAD_ERR_NO_FILE) {

        $errors[] = "Please upload your CV.";

    } else {

        $cv = $_FILES["cv"];

        $fileName = $cv["name"];
        $fileSize = $cv["size"];
        $fileTmp = $cv["tmp_name"];

        // Get file extension
        $fileExtension = strtolower(
            pathinfo($fileName, PATHINFO_EXTENSION)
        );

        // Allowed extensions
        $allowedExtensions = array("pdf", "doc", "docx");

        // Check extension
        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = "Only PDF, DOC and DOCX files are allowed.";
        }

        // Maximum size = 2 MB
        if ($fileSize > 2 * 1024 * 1024) {
            $errors[] = "CV file size must not exceed 2 MB.";
        }
    }


    // If there are errors
    if (count($errors) > 0) {

        echo "<h2>Application Failed!</h2>";

        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }

        echo "<br>";
        echo "<a href='index.php'>Go Back</a>";

    } else {

        // Create uploads folder if it doesn't exist
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        // Create a unique file name
        $newFileName = time() . "_" . basename($fileName);

        $uploadPath = "uploads/" . $newFileName;

        // Move uploaded file
        if (move_uploaded_file($fileTmp, $uploadPath)) {

            // Send data using GET
            header(
                "Location: result.php?" .
                "id=" . urlencode($applicant_id) .
                "&name=" . urlencode($name) .
                "&cv=" . urlencode($newFileName)
            );

            exit();

        } else {

            echo "<h2>Application Failed!</h2>";
            echo "<p style='color:red;'>Failed to upload CV.</p>";
        }
    }

} else {

    echo "Invalid Request.";
}

?>