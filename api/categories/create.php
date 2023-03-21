<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $categories = new Category($db);

    $data = json_decode(file_get_contents("php://input"));

    $categories->category = $data->category;

    if($categories->create()) {
        echo json_encode(array('message' => 'Category created'));
    }
    else {
        echo json_encode(array('message' => 'Category not created'));
    }