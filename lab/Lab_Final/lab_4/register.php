<?php

$student_name = $_POST["student_name"];
$student_id = $_POST["student_id"];
$email = $_POST["email"];
$department = $_POST["department"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];


// Student Name
if (empty($student_name)) {

    echo "Student Name is required.";
    exit;

}

if (!preg_match("/^[a-zA-Z ]+$/", $student_name)) {

    echo "Student Name should contain only letters and spaces.";
    exit;

}


// Student ID
if (empty($student_id)) {

    echo "Student ID is required.";
    exit;

}

if (strlen($student_id) < 4) {

    echo "Student ID must contain at least 4 characters.";
    exit;

}


// Email
if (empty($email)) {

    echo "Email is required.";
    exit;

}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo "Please enter a valid email address.";
    exit;

}


// Department
if (empty($department)) {

    echo "Department must be selected.";
    exit;

}


// Password
if (empty($password)) {

    echo "Password is required.";
    exit;

}

if (strlen($password) < 6) {

    echo "Password must contain at least 6 characters.";
    exit;

}


// Confirm Password
if ($password != $confirm_password) {

    echo "Passwords do not match.";
    exit;

}


// Create Cookies
setcookie("student_name", $student_name, time() + 3600);

setcookie("student_id", $student_id, time() + 3600);


echo "Registration Successful!";

echo "<br><br>";

echo "Student Name: " . $student_name;

echo "<br>";

echo "Student ID: " . $student_id;

echo "<br><br>";

echo "<a href='read_cookie.php'>Read Cookie</a>";

?>