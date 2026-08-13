<!DOCTYPE html>
<html>
<head>
    <title>Online Job Application</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
        }

        .container {
            width: 500px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        input[type="radio"] {
            width: auto;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Online Job Application</h2>

    <form action="process.php" method="POST" enctype="multipart/form-data">

        <label>Applicant ID:</label>
        <input type="text" name="applicant_id">

        <label>Full Name:</label>
        <input type="text" name="name">

        <label>Email:</label>
        <input type="email" name="email">

        <label>Phone Number:</label>
        <input type="text" name="phone">

        <label>Password:</label>
        <input type="password" name="password">

        <label>Gender:</label>
        <input type="radio" name="gender" value="Male"> Male
        <input type="radio" name="gender" value="Female"> Female

        <label>Job Position:</label>
        <select name="job">
            <option value="">-- Select Position --</option>
            <option value="Software Developer">Software Developer</option>
            <option value="Web Developer">Web Developer</option>
            <option value="Database Administrator">Database Administrator</option>
            <option value="Network Engineer">Network Engineer</option>
        </select>

        <label>Educational Qualification:</label>
        <input type="text" name="qualification">

        <label>Address:</label>
        <textarea name="address" rows="4"></textarea>

        <label>Upload CV:</label>
        <input type="file" name="cv">

        <input type="submit" value="Submit Application">

    </form>

</div>

</body>
</html>