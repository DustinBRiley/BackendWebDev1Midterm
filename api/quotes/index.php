<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

    $method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'POST':
            include_once '../../api/quotes/create.php';
            break;
        case 'DELETE':
            include_once '../../api/quotes/delete.php';
            break;
        case 'PUT':
            include_once '../../api/quotes/update.php';
            break;
        case 'OPTIONS':
            exit();
            break;
        default:
            if(isset($_GET['id']) || isset($_GET['author_id']) || isset($_GET['category_id'])) {
              include_once '../../api/quotes/read_single.php';
            }
            else {
              include_once '../../api/quotes/read.php';
            }
            break;
    }