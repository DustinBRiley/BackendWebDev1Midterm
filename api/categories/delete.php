<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $categories = new Category($db);

    $categories->id = isset($_GET['id']) ? $_GET['id'] : null;

    if($categories->delete()) {
        echo json_encode(array('message' => "$categories->id deleted"));
    }