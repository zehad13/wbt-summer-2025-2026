<?php



function authController_register($conn) {

    $errors = [];

    $old = [
        'full_name' => '',
        'email' => '',
        'phone' => '',
        'address' => ''
    ];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $fullName = clean($_POST['full_name'] ?? '');
        $email = clean($_POST['email'] ?? '');
        $phone = clean($_POST['phone'] ?? '');

        $password = trim($_POST['password'] ?? '');
        $confirm = trim($_POST['confirm_password'] ?? '');

        $address = clean($_POST['address'] ?? '');


        $old = compact(
            'fullName',
            'email',
            'phone',
            'address'
        );


        

        if ($fullName === '') {
            $errors[] = "Full name is required.";
        }

        if ($email === '') {
            $errors[] = "Email is required.";
        } elseif (!isValidEmail($email)) {
            $errors[] = "Please enter a valid email address.";
        }

        if ($phone === '') {
            $errors[] = "Phone number is required.";
        } elseif (!isValidPhone($phone)) {
            $errors[] = "Please enter a valid phone number.";
        }

        if ($password === '') {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if ($confirm === '' || $confirm !== $password) {
            $errors[] = "Password confirmation does not match.";
        }

        if ($address === '') {
            $errors[] = "Address is required.";
        }


        // Check duplicate email

        if (empty($errors) && findUserByEmail($conn, $email)) {
            $errors[] = "An account with this email already exists.";
        }



        if (empty($errors)) {

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $userId = createUser(
                $conn,
                $fullName,
                $email,
                $phone,
                $hashed,
                $address,
                'customer'
            );


            if ($userId) {

                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $fullName;
                $_SESSION['role'] = 'customer';

                flash('success', "Welcome to ChaJoy, $fullName!");

                redirect('index.php?page=customer_dashboard');

            } else {

                $errors[] = "Something went wrong while creating your account. Please try again.";
            }
        }
    }


    require __DIR__ . '/../views/auth/register.php';
}




function authController_login($conn) {

    $errors = [];
    $oldEmail = '';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = clean($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $oldEmail = $email;


        if ($email === '' || $password === '') {

            $errors[] = "Email and password are both required.";

        } else {

            $user = findUserByEmail($conn, $email);


            if (!$user) {

                $errors[] = "Invalid email or password.";

            } elseif (!password_verify($password, $user['password'])) {

                $errors[] = "Invalid email or password.";

            } elseif ($user['status'] !== 'active') {

                $errors[] = "Your account has been deactivated. Please contact support.";

            } else {


                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];



                if ($user['role'] === 'admin') {

                    redirect('index.php?page=admin_dashboard');

                } elseif ($user['role'] === 'delivery') {

                    redirect('index.php?page=delivery_dashboard');

                } else {

                    redirect('index.php?page=customer_dashboard');
                }
            }
        }
    }


    require __DIR__ . '/../views/auth/login.php';
}




function authController_logout() {

    $_SESSION = [];

    session_destroy();

    redirect('index.php?page=login');
}

?>