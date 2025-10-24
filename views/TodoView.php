<!DOCTYPE html>
<html>
<head>
    <title>PHP - Aplikasi Todolist</title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container-fluid p-5">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Todo List</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodo">Tambah Data</button>
            </div>
            <hr />
            <?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    ✅ <?= $_SESSION['success'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    ❌ <?= $_SESSION['error'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php unset($_SESSION['error']); endif; ?>

            <!-- FILTER & SEARCH -->
<form method="GET" class="d-flex mb-3">
    <input type="hidden" name="page" value="index">
    
    <!-- ✅ Filter Dropdown -->
    <select name="filter" class="form-select me-2" style="max-width: 200px;" onchange="this.form.submit()">
        <option value="all" <?= isset($filter) && $filter == 'all' ? 'selected' : '' ?>>Semua</option>
        <option value="done" <?= isset($filter) && $filter == 'done' ? 'selected' : '' ?>>Selesai</option>
        <option value="undone" <?= isset($filter) && $filter == 'undone' ? 'selected' : '' ?>>Belum Selesai</option>
    </select>
    
    <!-- ✅ Search Input -->
    <input type="text" name="search" class="form-control me-2"
        value="<?= htmlspecialchars($search ?? '') ?>"
        placeholder="Cari berdasarkan judul atau deskripsi...">
    
    <button type="submit" class="btn btn-outline-primary">Cari</button>
    
    <!-- ✅ Reset Button -->
    <?php if (!empty($search) || $filter != 'all'): ?>
        <a href="?page=index" class="btn btn-outline-secondary ms-2">Reset</a>
    <?php endif; ?>
</form>

<!-- ✅ Info Filter Aktif -->
<?php if ($filter != 'all' || !empty($search)): ?>
<div class="alert alert-info py-2">
    <?php if ($filter == 'done'): ?>
        📊 Menampilkan todo <strong>Selesai</strong>
    <?php elseif ($filter == 'undone'): ?>
        📊 Menampilkan todo <strong>Belum Selesai</strong>
    <?php endif; ?>
    
    <?php if (!empty($search)): ?>
        <?= $filter != 'all' ? 'dengan' : '📊' ?> pencarian: "<strong><?= htmlspecialchars($search) ?></strong>"
    <?php endif; ?>
    
    <span class="text-muted">(<?= count($todos) ?> hasil ditemukan)</span>
</div>
<?php endif; ?>

            <!-- TABEL TODO -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Aktivitas</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Dibuat</th>
                        <th scope="col">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($todos)): ?>
                    <?php foreach ($todos as $i => $todo): ?>
                    <tr data-id="<?= $todo['id'] ?>">
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($todo['activity']) ?></td>
                        <td><?= htmlspecialchars($todo['title']) ?></td>
                        <td><?= htmlspecialchars($todo['description']) ?></td>
                        <td>
                            <?php if ($todo['is_finished']): ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Belum Selesai</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d F Y - H:i', strtotime($todo['created_at'])) ?></td>
                        <td>
                            <button class="btn btn-sm btn-info text-white"
                                onclick="showTodoDetail('<?= addslashes($todo['title']) ?>', '<?= addslashes($todo['description']) ?>', <?= $todo['is_finished'] ? 'true' : 'false' ?>)">
                                Detail
                            </button>

                            <button class="btn btn-sm btn-warning"
                            onclick="showModalEditTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['activity'])) ?>', <?= $todo['is_finished'] ? '1' : '0' ?>)">
                            Ubah
                            </button>

                            <button class="btn btn-sm btn-danger"
                                onclick="showModalDeleteTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['activity'])) ?>')">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data tersedia!</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL ADD TODO -->
<div class="modal fade" id="addTodo" tabindex="-1" aria-labelledby="addTodoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTodoLabel">Tambah Data Todo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=create" method="POST">
    <div class="modal-body">
        <div class="mb-3">
            <label for="inputActivity" class="form-label">Aktivitas</label>
            <input type="text" name="activity" class="form-control" id="inputActivity"
                placeholder="Contoh: Belajar PHP dasar" required>
        </div>
        <div class="mb-3">
            <label for="inputTitle" class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" id="inputTitle"
                placeholder="Masukkan judul todo" required>
        </div>
        <div class="mb-3">
            <label for="inputDescription" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" id="inputDescription"
                placeholder="Tuliskan deskripsi todo"></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

        </div>
    </div>
</div>

<!-- MODAL EDIT TODO -->
<div class="modal fade" id="editTodo" tabindex="-1" aria-labelledby="editTodoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTodoLabel">Ubah Data Todo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=update" method="POST">
                <input name="id" type="hidden" id="inputEditTodoId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputEditActivity" class="form-label">Aktivitas</label>
                        <input type="text" name="activity" class="form-control" id="inputEditActivity"
                            placeholder="Contoh: Belajar membuat aplikasi website sederhana" required>
                    </div>
                    <div class="mb-3">
                        <label for="selectEditStatus" class="form-label">Status</label>
                        <select class="form-select" name="status" id="selectEditStatus">
                            <option value="0">Belum Selesai</option>
                            <option value="1">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DELETE TODO -->
<div class="modal fade" id="deleteTodo" tabindex="-1" aria-labelledby="deleteTodoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTodoLabel">Hapus Data Todo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    Kamu akan menghapus todo <strong class="text-danger" id="deleteTodoActivity"></strong>.
                    Apakah kamu yakin?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a id="btnDeleteTodo" class="btn btn-danger">Ya, Tetap Hapus</a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL TODO -->
<div class="modal fade" id="detailTodo" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Todo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <h6 id="detailTitle"></h6>
        <p id="detailDescription"></p>
        <p>Status: <span id="detailStatus" class="badge"></span></p>
      </div>
    </div>
  </div>
</div>

<script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
<script>
function showModalEditTodo(todoId, activity, status) {
    document.getElementById("inputEditTodoId").value = todoId;
    document.getElementById("inputEditActivity").value = activity;
    document.getElementById("selectEditStatus").value = status;
    new bootstrap.Modal(document.getElementById("editTodo")).show();
}

function showModalDeleteTodo(todoId, activity) {
    document.getElementById("deleteTodoActivity").innerText = activity;
    document.getElementById("btnDeleteTodo").setAttribute("href", `?page=delete&id=${todoId}`);
    new bootstrap.Modal(document.getElementById("deleteTodo")).show();
}

function showTodoDetail(title, desc, status) {
    document.getElementById('detailTitle').innerText = title;
    document.getElementById('detailDescription').innerText = desc;
    document.getElementById('detailStatus').innerText = status ? 'Selesai' : 'Belum';
    document.getElementById('detailStatus').className = status ? 'badge bg-success' : 'badge bg-danger';
    new bootstrap.Modal(document.getElementById('detailTodo')).show();
}
</script>

<!-- ✅ Tambahan logika agar nomor urut tetap update -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
const tbody = document.querySelector("tbody");
if (tbody) {
    Sortable.create(tbody, {
        animation: 150,
        onEnd: function(evt) {
            // Ambil ID dan urutan baru
            let orders = [];
            document.querySelectorAll("tbody tr").forEach((row, index) => {
                orders.push({ id: row.dataset.id, order: index + 1 });
                // ✅ update kolom nomor urut secara langsung
                row.querySelector("td:first-child").innerText = index + 1;
            });
            // Kirim ke backend
            fetch('update_order.php', {
                method: 'POST',
                body: JSON.stringify(orders),
                headers: { 'Content-Type': 'application/json' }
            });
        }
    });
}
</script>
</body>
</html>

