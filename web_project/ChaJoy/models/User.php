<?php
function findUserByEmail($conn, $email)
{
    $stmt = $conn->prepare(
        "SELECT * FROM users
         WHERE email = ?
         LIMIT 1"
    );

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    $stmt->close();

    return $user;
}



function findUserById($conn, $id)
{
    $stmt = $conn->prepare(
        "SELECT * FROM users
         WHERE id = ?
         LIMIT 1"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    $stmt->close();

    return $user;
}



function createUser(
    $conn,
    $fullName,
    $email,
    $phone,
    $hashedPassword,
    $address,
    $role = 'customer'
) {
    $stmt = $conn->prepare(
        "INSERT INTO users
        (full_name, email, phone, password, address, role)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssssss",
        $fullName,
        $email,
        $phone,
        $hashedPassword,
        $address,
        $role
    );

    $success = $stmt->execute();

    $newId = $conn->insert_id;

    $stmt->close();

    if ($success) {
        return $newId;
    } else {
        return false;
    }
}




function updateUserProfile(
    $conn,
    $userId,
    $fullName,
    $phone,
    $address
) {
    $stmt = $conn->prepare(
        "UPDATE users
         SET full_name = ?,
             phone = ?,
             address = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "sssi",
        $fullName,
        $phone,
        $address,
        $userId
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}




function updateUserPassword(
    $conn,
    $userId,
    $hashedPassword
) {
    $stmt = $conn->prepare(
        "UPDATE users
         SET password = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "si",
        $hashedPassword,
        $userId
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}




function getAllCustomers($conn)
{
    $result = $conn->query(
        "SELECT * FROM users
         WHERE role = 'customer'
         ORDER BY created_at DESC"
    );

    $customers = [];

    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }

    return $customers;
}


function getAllDeliveryPersonnel($conn)
{
    $result = $conn->query(
        "SELECT * FROM users
         WHERE role = 'delivery'
         ORDER BY full_name ASC"
    );

    $list = [];

    while ($row = $result->fetch_assoc()) {
        $list[] = $row;
    }

    return $list;
}




function countUsersByRole($conn, $role)
{
    $stmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM users
         WHERE role = ?"
    );

    $stmt->bind_param("s", $role);

    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return (int)$row['total'];
}

?>