<?php
function clean($value) {

    return htmlspecialchars(
        trim($value ?? ""),
        ENT_QUOTES,
        'UTF-8'
    );
}


function redirect($path) {

    header(
        "Location: " . BASE_URL . ltrim($path, '/')
    );

    exit();
}


function flash($key, $message = null) {

    if ($message !== null) {

        $_SESSION['flash'][$key] = $message;

        return;
    }


    if (isset($_SESSION['flash'][$key])) {

        $msg = $_SESSION['flash'][$key];

        unset($_SESSION['flash'][$key]);

        return $msg;
    }


    return "";
}




function formatMoney($amount) {

    return "Tk " . number_format(
        (float)$amount,
        2
    );
}


function generateOrderId() {

    $prefix = "CHJ" . date("ymd");

    $random = strtoupper(
        substr(
            md5(
                uniqid(
                    (string)mt_rand(),
                    true
                )
            ),
            0,
            5
        )
    );

    return $prefix . "-" . $random;
}


function slugify($text) {

    $text = strtolower(
        trim($text)
    );

    $text = str_replace(
        " ",
        "-",
        $text
    );

    return $text;
}


function truncateText($text, $limit = 80) {

    if (strlen($text) <= $limit) {

        return $text;
    }

    return substr(
        $text,
        0,
        $limit
    ) . "...";
}


function isLoggedIn() {

    return isset($_SESSION['user_id']);
}


function currentRole() {

    return $_SESSION['role'] ?? null;
}


function requireLogin() {

    if (!isLoggedIn()) {

        redirect(
            'index.php?page=login'
        );
    }
}


function requireRole($role) {

    requireLogin();


    if (currentRole() !== $role) {

        switch (currentRole()) {

            case 'admin':

                redirect(
                    'index.php?page=admin_dashboard'
                );

                break;


            case 'delivery':

                redirect(
                    'index.php?page=delivery_dashboard'
                );

                break;


            default:

                redirect(
                    'index.php?page=customer_dashboard'
                );
        }
    }
}




function isValidEmail($email) {

    return filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    ) !== false;
}


function isValidPhone($phone) {

    return preg_match(
        '/^[0-9+\-\s]{10,15}$/',
        $phone
    ) === 1;
}


?>