<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quotes = new Quote($db);

    $data = json_decode(file_get_contents("php://input"));

    $quotes->quote = $data->quote;
    $quotes->author = $data->author_id;
    $quotes->category = $data->category_id;

    if($quotes->create()) {
        echo json_encode(array('message' => 'Quote created'));
    }
    else {
        echo json_encode(array('message' => 'Quote not created'));
    }