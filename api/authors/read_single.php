<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $authors = new Author($db);

    $authors->id = isset($_GET['id']) ? $_GET['id'] : die();

    $authors->read_single();

    $authors_arr = array(
        'id' => $authors->$id,
        'author' => $authors->$author
    );

    print_r(json_encode($authors_arr));
