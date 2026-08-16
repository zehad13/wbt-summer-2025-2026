<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>

<body>

<h2>Student Registration Form</h2>

<form method="POST" action="register.php">

    Student Name:
    <input type="text" name="student_name">
    <br><br>

    Student ID:
    <input type="text" name="student_id">
    <br><br>

    Email:
    <input type="text" name="email">
    <br><br>

    Department:
    <select name="department">
        <option value="">Select Department</option>
        <option value="CSE">CSE</option>
        <option value="EEE">EEE</option>
        <option value="BBA">BBA</option>
    </select>

    <br><br>

    Password:
    <input type="password" name="password">
    <br><br>

    Confirm Password:
    <input type="password" name="confirm_password">
    <br><br>

    <input type="submit" name="submit" value="Register">

</form>

<br>

<form method="POST" action="delete_cookie.php">

    <input type="submit" value="Clear Cookie">

</form>

</body>
</html>