<?php
$studentName = "A. R. M. ZEHAD";
$studentID = "23-54502-3";
$foodChoice = 1;   
$quantity = 6;

switch ($foodChoice) {
    case 1:
        $foodItem = "Burger";
        $price = 5;
        break;

    case 2:
        $foodItem = "Pizza";
        $price = 8;
        break;

    case 3:
        $foodItem = "Sandwich";
        $price = 4;
        break;

    case 4:
        $foodItem = "Coffee";
        $price = 3;
        break;

    default:
        $foodItem = "Invalid Item";
        $price = 0;
}


$subtotal = $price * $quantity;

if ($subtotal >= 30) {
    $discountPercent = 20;
} elseif ($subtotal >= 20) {
    $discountPercent = 10;
} else {
    $discountPercent = 0;
}

$discountAmount = ($subtotal * $discountPercent) / 100;
$finalBill = $subtotal - $discountAmount;


echo "====================================<br>";
echo "      UNIVERSITY CAFETERIA<br>";
echo "====================================<br>";

echo "Student Name : " . $studentName . "<br>";
echo "Student ID   : " . $studentID . "<br>";
echo "Food Item    : " . $foodItem . "<br>";
echo "Price        : $" . $price . "<br>";
echo "Quantity     : " . $quantity . "<br><br>";

echo "<b>Ordered Items:</b><br>";

for ($i = 1; $i <= $quantity; $i++) {
    echo "Item $i : $foodItem <br>";
}

echo "<br>";
echo "Subtotal      : $" . $subtotal . "<br>";
echo "Discount      : " . $discountPercent . "%<br>";
echo "Discount Amt  : $" . $discountAmount . "<br>";
echo "Final Bill    : $" . $finalBill . "<br>";

echo "<br>Thank you for visiting!<br>";
echo "====================================";

?>