<?php
require_once(__DIR__ . '/../models/TodoModel.php');

class TodoController
{
    public function index()
    {
        $filter = $_GET['filter'] ?? 'all';
        $search = $_GET['search'] ?? '';

        $todoModel = new TodoModel();
        $todos = $todoModel->getAllTodos($filter, $search);

        include(__DIR__ . '/../views/TodoView.php');
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $activity = trim($_POST['activity'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');

            // Validasi input kosong
            if (empty($activity) || empty($title)) {
                $_SESSION['error'] = 'Aktivitas dan Judul tidak boleh kosong!';
                header('Location: index.php');
                exit;
            }

            $todoModel = new TodoModel();
            $result = $todoModel->createTodo($activity, $title, $description);

            if (isset($result['error'])) {
                $_SESSION['error'] = $result['error'];
            } else {
                $_SESSION['success'] = 'Todo berhasil ditambahkan!';
            }
        }
        header('Location: index.php');
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $activity = trim($_POST['activity'] ?? '');
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? '0';

            // Validasi
            if (!$id || empty($activity) || empty($title)) {
                $_SESSION['error'] = 'Data tidak valid! Aktivitas dan Judul wajib diisi.';
                header('Location: index.php');
                exit;
            }

            $todoModel = new TodoModel();
            $result = $todoModel->updateTodo($id, $activity, $title, $description, $status);
            
            if (isset($result['error'])) {
                $_SESSION['error'] = $result['error'];
            } elseif (isset($result['success'])) {
                $_SESSION['success'] = 'Todo berhasil diupdate!';
            } else {
                $_SESSION['error'] = 'Gagal update todo!';
            }
        }
        header('Location: index.php');
        exit;
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $todoModel = new TodoModel();
            $result = $todoModel->deleteTodo($id);
            
            if ($result) {
                $_SESSION['success'] = 'Todo berhasil dihapus!';
            } else {
                $_SESSION['error'] = 'Gagal menghapus todo!';
            }
        }
        header('Location: index.php');
        exit;
    }
}