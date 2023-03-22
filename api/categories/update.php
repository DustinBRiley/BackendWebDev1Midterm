<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $categories = new Category($db);

    $categories->id = isset($_GET['id']) ? $_GET['id'] : null;
    $categories->category = isset($_GET['category']) ? $_GET['category'] : null;

    if($categories->category == null) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    if($categories->update()) {
        echo json_encode(array('message' => "updated category ($categories->id, $categories->category)"));
    }