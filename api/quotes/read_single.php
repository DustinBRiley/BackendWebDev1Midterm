<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quotes = new Quote($db);

    $quotes->id = isset($_GET['id']) ? $_GET['id'] : null;
    $quotes->author = isset($_GET['author_id']) ? $_GET['author_id'] : null;
    $quotes->category = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    $result = $quotes->read_single();

    $num = $result->rowCount();

    if($num > 0) {
        if($quotes->id != null) {
          $row = $result->fetch(PDO::FETCH_ASSOC);
          
          echo json_encode($row);
          exit();
        }
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            array_push($quotes_arr, $quote_item);
        }

        echo json_encode($quotes_arr);
    }
    else {
        echo json_encode(array('message' => 'No Quotes Found'));
    }