<?php

// Receive data using $_GET
$applicant_id = $_GET["id"] ?? "";
$name = $_GET["name"] ?? "";
$cv = $_GET["cv"] ?? "";

// Use $_REQUEST
$request_id = $_REQUEST["id"] ?? "";
$request_name = $_REQUEST["name"] ?? "";

?>

<!DOCTYPE html>
<html>

<head>
    <title>Application Successful</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
        }

        .result {
            width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
        }

        h1 {
            text-align: center;
            color: green;
        }

        p {
            font-size: 18px;
        }

        .success {
            text-align: center;
            color: green;
        }
    </style>
</head>

<body>

<div class="result">

    <h1>APPLICATION SUCCESSFUL</h1>

    <hr>

    <p>
        <strong>Applicant ID:</strong>
        <?php echo htmlspecialchars($applicant_id); ?>
    </p>

    <p>
        <strong>Name:</strong>
        <?php echo htmlspecialchars($name); ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?php echo "Submitted successfully"; ?>
    </p>

    <p>
        <strong>Uploaded CV:</strong>
        <?php echo htmlspecialchars($cv); ?>
    </p>

    <p class="success">
        Application submitted successfully.
    </p>

</div>

</body>

</html>