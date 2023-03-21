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

    $data = json_decode(file_get_contents("php://input"));

    $authors->id = $data->id;
    $authors->author = $data->author;

    if($authors->create()) {
        echo json_encode(array('message' => 'Author updated'));
    }
    else {
        echo json_encode(array('message' => 'Author not updated'));
    }