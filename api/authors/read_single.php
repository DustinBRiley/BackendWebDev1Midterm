<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $authors = new Author($db);

    $authors->id = isset($_GET['id']) ? $_GET['id'] : null;

    $result = $authors->read_single();

    $num = $result->rowCount();

    if($num > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode($row);
    }
    else {
        echo json_encode(array('message' => 'author_id Not Found'));
    }

