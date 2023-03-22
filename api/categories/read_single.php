<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $categories = new Category($db);

    $categories->id = isset($_GET['id']) ? $_GET['id'] : die();

    $result = $categories->read_single();

    $num = $result->rowCount();

    if($num > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode($row);
    }
    else {
        echo json_encode(array('message' => 'category_id Not Found'));
    }
