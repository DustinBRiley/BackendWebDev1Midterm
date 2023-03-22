<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $authors = new Author($db);

    $authors->author = isset($_GET['author']) ? $_GET['author'] : null;

    if($authors->author == null) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    if($authors->create()) {
        echo json_encode(array('message' => "created author ($authors->id, $authors->author)"));
    }