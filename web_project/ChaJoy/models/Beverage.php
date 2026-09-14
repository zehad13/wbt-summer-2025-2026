<?php
function getAllBeverages($conn) {

    $sql = "SELECT b.*, c.name AS category_name
            FROM beverages b
            JOIN categories c ON b.category_id = c.id
            ORDER BY b.created_at DESC";

    $result = $conn->query($sql);

    $beverages = [];

    while ($row = $result->fetch_assoc()) {
        $beverages[] = $row;
    }

    return $beverages;
}


function getPopularBeverages($conn, $limit = 6) {

    $sql = "SELECT b.*, c.name AS category_name
            FROM beverages b
            JOIN categories c ON b.category_id = c.id
            WHERE b.is_available = 1
            ORDER BY b.id ASC
            LIMIT ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $limit);

    $stmt->execute();

    $result = $stmt->get_result();

    $beverages = [];

    while ($row = $result->fetch_assoc()) {
        $beverages[] = $row;
    }

    $stmt->close();

    return $beverages;
}


function findBeverageById($conn, $id) {

    $sql = "SELECT b.*, c.name AS category_name
            FROM beverages b
            JOIN categories c ON b.category_id = c.id
            WHERE b.id = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $beverage = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return $beverage;
}

function searchBeverages($conn, $keyword = "", $categoryId = 0) {

    $keyword = trim($keyword);

    $sql = "SELECT b.*, c.name AS category_name
            FROM beverages b
            JOIN categories c ON b.category_id = c.id
            WHERE 1 = 1";

    $params = [];

    $types = "";


    if ($keyword !== "") {

        $sql .= " AND LOWER(b.name) LIKE ?";

        $params[] = "%" . strtolower($keyword) . "%";

        $types .= "s";
    }


    if ($categoryId > 0) {

        $sql .= " AND b.category_id = ?";

        $params[] = $categoryId;

        $types .= "i";
    }


    $sql .= " ORDER BY b.name ASC";


    $stmt = $conn->prepare($sql);


    if ($types !== "") {

        $stmt->bind_param($types, ...$params);
    }


    $stmt->execute();

    $result = $stmt->get_result();

    $beverages = [];


    while ($row = $result->fetch_assoc()) {

        $beverages[] = $row;
    }


    $stmt->close();

    return $beverages;
}


function createBeverage(
    $conn,
    $categoryId,
    $name,
    $description,
    $price,
    $image,
    $stock,
    $isAvailable
) {

    $sql = "INSERT INTO beverages
            (category_id, name, description, price, image, stock, is_available)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "issdsii",
        $categoryId,
        $name,
        $description,
        $price,
        $image,
        $stock,
        $isAvailable
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function updateBeverage(
    $conn,
    $id,
    $categoryId,
    $name,
    $description,
    $price,
    $stock,
    $isAvailable,
    $image = null
) {

    if ($image) {

        $sql = "UPDATE beverages
                SET category_id=?,
                    name=?,
                    description=?,
                    price=?,
                    stock=?,
                    is_available=?,
                    image=?
                WHERE id=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "issdiisi",
            $categoryId,
            $name,
            $description,
            $price,
            $stock,
            $isAvailable,
            $image,
            $id
        );

    } else {

        $sql = "UPDATE beverages
                SET category_id=?,
                    name=?,
                    description=?,
                    price=?,
                    stock=?,
                    is_available=?
                WHERE id=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "issdiii",
            $categoryId,
            $name,
            $description,
            $price,
            $stock,
            $isAvailable,
            $id
        );
    }


    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


// Delete beverage

function deleteBeverage($conn, $id) {

    $stmt = $conn->prepare(
        "DELETE FROM beverages WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function decreaseStock($conn, $beverageId, $qty) {

    $stmt = $conn->prepare(
        "UPDATE beverages
         SET stock = stock - ?
         WHERE id = ? AND stock >= ?"
    );

    $stmt->bind_param(
        "iii",
        $qty,
        $beverageId,
        $qty
    );

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}

function countLowStockBeverages($conn, $threshold = 5) {

    $stmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM beverages
         WHERE stock <= ?"
    );

    $stmt->bind_param(
        "i",
        $threshold
    );

    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return (int)$row['total'];
}


function countAvailableBeverages($conn) {

    $result = $conn->query(
        "SELECT COUNT(*) AS total
         FROM beverages
         WHERE is_available = 1"
    );

    return (int)$result->fetch_assoc()['total'];
}

?>