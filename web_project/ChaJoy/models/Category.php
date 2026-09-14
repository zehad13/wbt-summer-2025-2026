<?php

function getAllCategories($conn)
{
    $result = $conn->query(
        "SELECT * FROM categories ORDER BY name ASC"
    );

    $categories = [];

    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    return $categories;
}


function findCategoryById($conn, $id)
{
    $stmt = $conn->prepare(
        "SELECT * FROM categories WHERE id = ? LIMIT 1"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $category = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return $category;
}


function createCategory($conn, $name)
{
    $stmt = $conn->prepare(
        "INSERT INTO categories (name) VALUES (?)"
    );

    $stmt->bind_param("s", $name);

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function updateCategory($conn, $id, $name)
{
    $stmt = $conn->prepare(
        "UPDATE categories SET name = ? WHERE id = ?"
    );

    $stmt->bind_param("si", $name, $id);

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}


function categoryInUse($conn, $id)
{
    $stmt = $conn->prepare(
        "SELECT COUNT(*) AS total
         FROM beverages
         WHERE category_id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();

    $stmt->close();

    return (int)$row['total'] > 0;
}


function deleteCategory($conn, $id)
{
    if (categoryInUse($conn, $id)) {
        return false;
    }

    $stmt = $conn->prepare(
        "DELETE FROM categories WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    $success = $stmt->execute();

    $stmt->close();

    return $success;
}

?>