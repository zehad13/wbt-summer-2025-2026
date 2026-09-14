<?php
$conn = mysqli_connect("localhost","root","","studentdatabase");
if (!$conn)
    {
        die("connection failed:". mysqli_connect_error());

    }
echo"connect succesrfully"
?> 
