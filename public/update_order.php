<?php
require_once('../models/TodoModel.php');

$data = json_decode(file_get_contents("php://input"), true);
$todoModel = new TodoModel();

foreach ($data as $item) {
    $todoModel->updateOrder($item['id'], $item['order']);
}

echo json_encode(['status' => 'success']);
