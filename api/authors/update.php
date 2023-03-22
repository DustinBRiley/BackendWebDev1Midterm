<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $authors = new Author($db);

    $authors->id = isset($_GET['id']) ? $_GET['id'] : null;
    $authors->author = isset($_GET['author']) ? $_GET['author'] : null;

    if($authors->author == null) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    if($authors->update()) {
        echo json_encode(array('message' => "updated author ($authors->id, $authors->author)"));
    }