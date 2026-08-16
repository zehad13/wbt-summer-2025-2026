<?php

if (isset($_COOKIE["student_name"]) && isset($_COOKIE["student_id"])) {

    echo "Welcome Back!";

    echo "<br><br>";

    echo "Student Name: " . $_COOKIE["student_name"];

    echo "<br>";

    echo "Student ID: " . $_COOKIE["student_id"];

} else {

    echo "No saved student information found.";

}

?>