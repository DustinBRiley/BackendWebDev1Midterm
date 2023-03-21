<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $categories = new Category($db);

    $categories->id = isset($_GET['id']) ? $_GET['id'] : die();

    $categories->read_single();

    $categories_arr = array(
        'id' => $categories->$id,
        'category' => $categories->$category
    );

    print_r(json_encode($categories_arr));
