<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');

    $method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'POST':
            include_once '../../api/categories/create.php';
            break;
        case 'DELETE':
            include_once '../../api/categories/delete.php';
            break;
        case 'PUT':
            include_once '../../api/categories/update.php';
            break;
        case 'OPTIONS':
            exit();
            break;
        default:
            if(isset($_GET['id'])) {
              include_once '../../api/categories/read_single.php';
            }
            else {
              include_once '../../api/categories/read.php';
            }
            break;
    }