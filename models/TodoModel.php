<?php
require_once(__DIR__ . '/../config.php');

class TodoModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = pg_connect('host=' . DB_HOST . ' port=' . DB_PORT . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASSWORD);
        if (!$this->conn) {
            die('Koneksi database gagal');
        }
    }

    public function getAllTodos($filter = 'all', $search = '')
    {
        $conditions = [];
        $params = [];

        if ($filter === 'done') {
            $conditions[] = 'is_finished = TRUE';
        } elseif ($filter === 'undone') {
            $conditions[] = 'is_finished = FALSE';
        }

        if (!empty($search)) {
            // ✅ SEARCH di 3 kolom: activity, title, description
            $conditions[] = '(LOWER(activity) LIKE LOWER($' . (count($params) + 1) . ') 
                              OR LOWER(title) LIKE LOWER($' . (count($params) + 1) . ')
                              OR LOWER(description) LIKE LOWER($' . (count($params) + 1) . '))';
            $params[] = "%$search%";
        }

        $where = count($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $query = "SELECT * FROM todo $where ORDER BY sort_order ASC, id ASC";

        $result = pg_query_params($this->conn, $query, $params);
        $todos = [];
        while ($row = pg_fetch_assoc($result)) {
            // KONVERSI BOOLEAN POSTGRESQL KE PHP BOOLEAN
            $row['is_finished'] = ($row['is_finished'] === 't' || $row['is_finished'] === true || $row['is_finished'] === '1');
            $todos[] = $row;
        }
        return $todos;
    }

    public function createTodo($activity, $title, $description)
    {
        // VALIDASI: Cek judul yang sama (case-insensitive)
        $check = pg_query_params(
            $this->conn, 
            'SELECT COUNT(*) FROM todo WHERE LOWER(title) = LOWER($1)', 
            [$title]
        );
        $exists = pg_fetch_result($check, 0, 0);
        
        if ($exists > 0) {
            return ['error' => 'Judul todo sudah ada! Gunakan judul yang berbeda.'];
        }

        // INSERT todo baru
        $query = 'INSERT INTO todo (activity, title, description, is_finished, sort_order) 
                  VALUES ($1, $2, $3, FALSE, 0)';
        $result = pg_query_params($this->conn, $query, [$activity, $title, $description]);

        return $result ? ['success' => true] : ['error' => 'Gagal menambah todo.'];
    }

    public function updateTodo($id, $activity, $status)
    {
        // KONVERSI STATUS KE BOOLEAN YANG BENAR
        $is_finished = ($status === '1' || $status === 1 || $status === true || $status === 'true');
        
        // GUNAKAN PLACEHOLDER $3 UNTUK BOOLEAN
        $query = 'UPDATE todo SET activity=$1, is_finished=$2 WHERE id=$3';
        $result = pg_query_params($this->conn, $query, [
            $activity,
            $is_finished ? 'true' : 'false',
            $id
        ]);
        
        return $result !== false;
    }

    public function deleteTodo($id)
    {
        $query = 'DELETE FROM todo WHERE id=$1';
        $result = pg_query_params($this->conn, $query, [$id]);
        return $result !== false;
    }

    public function updateOrder($id, $order)
    {
        $query = 'UPDATE todo SET sort_order=$1 WHERE id=$2';
        return pg_query_params($this->conn, $query, [$order, $id]);
    }
}