<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'index';
}

include('../controllers/TodoController.php');

$todoController = new TodoController();
switch ($page) {
    case 'index':
        $todoController->index();
        break;
    case 'create':
        $todoController->create();
        break;
    case 'update':
        $todoController->update();
        break;
    case 'delete':
        $todoController->delete();
        break;
    default:
        $todoController->index();
        break;
}