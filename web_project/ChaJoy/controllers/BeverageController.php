<?php


function beverageController_home($conn) {

    $popularBeverages = getPopularBeverages($conn, 6);

    require __DIR__ . '/../views/customer/home.php';
}




function beverageController_listing($conn) {

    $categories = getAllCategories($conn);

    $keyword = clean($_GET['q'] ?? '');
    $categoryId = (int)($_GET['category'] ?? 0);

    $beverages = searchBeverages($conn, $keyword, $categoryId);

    require __DIR__ . '/../views/customer/beverages.php';
}




function beverageController_ajaxSearch($conn) {

    $keyword = clean($_GET['q'] ?? '');
    $categoryId = (int)($_GET['category'] ?? 0);

    $beverages = searchBeverages($conn, $keyword, $categoryId);

    $data = [];


    foreach ($beverages as $b) {

        $data[] = [

            'id' => (int)$b['id'],

            'name' => $b['name'],

            'category_name' => $b['category_name'],

            'price' => number_format(
                (float)$b['price'],
                2
            ),

            'image' => $b['image'],

            'stock' => (int)$b['stock'],

            'is_available' => (int)$b['is_available'],

            'description' => truncateText(
                $b['description'],
                70
            )
        ];
    }


    echo json_encode([
        'success' => true,
        'count' => count($data),
        'beverages' => $data
    ]);
}




function beverageController_details($conn) {

    $id = (int)($_GET['id'] ?? 0);

    $beverage = findBeverageById($conn, $id);


    if (!$beverage) {

        http_response_code(404);

        echo "<h2 style='font-family:sans-serif;text-align:center;margin-top:80px;'>Beverage not found</h2>";

        return;
    }


    require __DIR__ . '/../views/customer/beverage_details.php';
}

?>