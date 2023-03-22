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

    $quotes->quote = isset($_GET['quote']) ? $_GET['quote'] : null;
    $quotes->author = isset($_GET['author_id']) ? $_GET['author_id'] : null;
    $quotes->category = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    if($quotes->quote == null || $quotes->author == null || $quotes->category == null) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    if($quotes->create()) {
        echo json_encode(array('message' => "created quote ($quotes->id, $quotes->quote, $quotes->author, $quotes->category)"));
    }