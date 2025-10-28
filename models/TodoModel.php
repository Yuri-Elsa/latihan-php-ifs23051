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

    /**
     * Get all todos dengan filter dan search
     * Filter: 'all', 'done', 'undone'
     * Search: mencari di activity, title, dan description
     */
    public function getAllTodos($filter = 'all', $search = '')
    {
        $conditions = [];
        $params = [];
        $paramCount = 0;

        // Filter berdasarkan status
        if ($filter === 'done') {
            $conditions[] = 'is_finished = TRUE';
        } elseif ($filter === 'undone') {
            $conditions[] = 'is_finished = FALSE';
        }

        // Search dengan mempertahankan filter aktif
        if (!empty($search)) {
            $paramCount++;
            $searchPattern = "%$search%";
            $conditions[] = "(LOWER(activity) LIKE LOWER($$paramCount) 
                              OR LOWER(title) LIKE LOWER($$paramCount)
                              OR LOWER(description) LIKE LOWER($$paramCount))";
            $params[] = $searchPattern;
        }

        $where = count($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $query = "SELECT * FROM todo $where ORDER BY sort_order ASC, id ASC";

        $result = pg_query_params($this->conn, $query, $params);
        $todos = [];
        while ($row = pg_fetch_assoc($result)) {
            // Konversi boolean PostgreSQL ke PHP
            $row['is_finished'] = ($row['is_finished'] === 't' || $row['is_finished'] === true || $row['is_finished'] === '1');
            $todos[] = $row;
        }
        return $todos;
    }

    /**
     * Create todo baru dengan validasi activity dan title unik
     */
    public function createTodo($activity, $title, $description)
    {
        // Validasi: Cek activity yang sama (case-insensitive)
        $checkActivity = pg_query_params(
            $this->conn, 
            'SELECT COUNT(*) FROM todo WHERE LOWER(activity) = LOWER($1)', 
            [$activity]
        );
        $activityExists = pg_fetch_result($checkActivity, 0, 0);
        
        if ($activityExists > 0) {
            return ['error' => 'Aktivitas sudah ada! Gunakan aktivitas yang berbeda.'];
        }

        // Validasi: Cek judul yang sama (case-insensitive)
        $checkTitle = pg_query_params(
            $this->conn, 
            'SELECT COUNT(*) FROM todo WHERE LOWER(title) = LOWER($1)', 
            [$title]
        );
        $titleExists = pg_fetch_result($checkTitle, 0, 0);
        
        if ($titleExists > 0) {
            return ['error' => 'Judul todo sudah ada! Gunakan judul yang berbeda.'];
        }

        // Get max sort_order untuk todo baru
        $maxOrder = pg_query($this->conn, 'SELECT COALESCE(MAX(sort_order), 0) + 1 as next_order FROM todo');
        $nextOrder = pg_fetch_result($maxOrder, 0, 0);

        // Insert todo baru
        $query = 'INSERT INTO todo (activity, title, description, is_finished, sort_order, created_at, updated_at) 
                  VALUES ($1, $2, $3, FALSE, $4, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)';
        $result = pg_query_params($this->conn, $query, [$activity, $title, $description, $nextOrder]);

        return $result ? ['success' => true] : ['error' => 'Gagal menambah todo.'];
    }

    /**
     * Update todo dengan validasi activity dan title unik
     */
    public function updateTodo($id, $activity, $title, $description, $status)
    {
        // Validasi: Cek activity yang sama pada todo lain
        $checkActivity = pg_query_params(
            $this->conn, 
            'SELECT COUNT(*) FROM todo WHERE LOWER(activity) = LOWER($1) AND id != $2', 
            [$activity, $id]
        );
        $activityExists = pg_fetch_result($checkActivity, 0, 0);
        
        if ($activityExists > 0) {
            return ['error' => 'Aktivitas sudah digunakan oleh todo lain!'];
        }

        // Validasi: Cek judul yang sama pada todo lain
        $checkTitle = pg_query_params(
            $this->conn, 
            'SELECT COUNT(*) FROM todo WHERE LOWER(title) = LOWER($1) AND id != $2', 
            [$title, $id]
        );
        $titleExists = pg_fetch_result($checkTitle, 0, 0);
        
        if ($titleExists > 0) {
            return ['error' => 'Judul todo sudah digunakan oleh todo lain!'];
        }

        // Konversi status ke boolean
        $is_finished = ($status === '1' || $status === 1 || $status === true || $status === 'true');
        
        $query = 'UPDATE todo SET activity=$1, title=$2, description=$3, is_finished=$4, updated_at=CURRENT_TIMESTAMP WHERE id=$5';
        $result = pg_query_params($this->conn, $query, [
            $activity,
            $title,
            $description,
            $is_finished ? 'true' : 'false',
            $id
        ]);
        
        return $result !== false ? ['success' => true] : ['error' => 'Gagal update todo.'];
    }

    /**
     * Delete todo berdasarkan ID
     */
    public function deleteTodo($id)
    {
        $query = 'DELETE FROM todo WHERE id=$1';
        $result = pg_query_params($this->conn, $query, [$id]);
        return $result !== false;
    }

    /**
     * Update urutan sorting todo (drag & drop)
     */
    public function updateOrder($id, $order)
    {
        $query = 'UPDATE todo SET sort_order=$1, updated_at=CURRENT_TIMESTAMP WHERE id=$2';
        return pg_query_params($this->conn, $query, [$order, $id]);
    }

    /**
     * Get single todo by ID (untuk detail)
     */
    public function getTodoById($id)
    {
        $query = 'SELECT * FROM todo WHERE id=$1';
        $result = pg_query_params($this->conn, $query, [$id]);
        
        if ($row = pg_fetch_assoc($result)) {
            $row['is_finished'] = ($row['is_finished'] === 't' || $row['is_finished'] === true || $row['is_finished'] === '1');
            return $row;
        }
        return null;
    }
}