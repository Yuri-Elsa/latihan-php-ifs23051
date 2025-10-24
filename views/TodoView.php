<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Aplikasi Todo List Modern</title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #6366f1;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-bg: #f9fafb;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            padding: 2rem 1rem;
            min-height: 100vh;
        }
        
        .todo-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border: none;
        }
        
        .card-header-custom h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-add-todo {
            background: white;
            color: #667eea;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-add-todo:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.3);
        }
        
        .filter-search-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
        }
        
        .form-select, .form-control {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem;
            transition: all 0.3s;
        }
        
        .form-select:focus, .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.1);
        }
        
        .btn-search {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }
        
        .alert-info-custom {
            background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
            border: 2px solid #667eea40;
            border-radius: 12px;
            padding: 1rem 1.5rem;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 15px;
        }
        
        .table-modern {
            margin: 0;
        }
        
        .table-modern thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .table-modern thead th {
            padding: 1rem;
            font-weight: 600;
            border: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table-modern tbody tr {
            transition: all 0.3s;
            cursor: move;
        }
        
        .table-modern tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
        }
        
        .table-modern tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .badge-custom {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            margin: 0.2rem;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border: none;
        }
        
        .modal-title {
            font-weight: 700;
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .drag-handle {
            cursor: move;
            color: #9ca3af;
            font-size: 1.2rem;
        }
        
        .sortable-ghost {
            opacity: 0.4;
            background: #f3f4f6;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #9ca3af;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .card-header-custom h1 {
                font-size: 1.5rem;
            }
            
            .btn-add-todo {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="container main-container">
    <div class="todo-card">
        <!-- Header -->
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h1><i class="bi bi-check-circle-fill"></i> Todo List</h1>
                <button class="btn btn-add-todo" data-bs-toggle="modal" data-bs-target="#addTodo">
                    <i class="bi bi-plus-circle"></i> Tambah Todo
                </button>
            </div>
        </div>
        
        <div class="card-body p-4">
            <!-- Alert Messages -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); endif; ?>

            <!-- Filter & Search Section -->
            <div class="filter-search-section">
                <form method="GET" class="row g-3">
                    <input type="hidden" name="page" value="index">
                    
                    <div class="col-md-3">
                        <label class="form-label fw-bold"><i class="bi bi-funnel"></i> Filter Status</label>
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="all" <?= isset($filter) && $filter == 'all' ? 'selected' : '' ?>>📋 Semua</option>
                            <option value="done" <?= isset($filter) && $filter == 'done' ? 'selected' : '' ?>>✅ Selesai</option>
                            <option value="undone" <?= isset($filter) && $filter == 'undone' ? 'selected' : '' ?>>⏳ Belum Selesai</option>
                        </select>
                    </div>
                    
                    <div class="col-md-7">
                        <label class="form-label fw-bold"><i class="bi bi-search"></i> Pencarian</label>
                        <input type="text" name="search" class="form-control"
                            value="<?= htmlspecialchars($search ?? '') ?>"
                            placeholder="Cari berdasarkan aktivitas, judul, atau deskripsi...">
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary btn-search flex-grow-1">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <?php if (!empty($search) || $filter != 'all'): ?>
                            <a href="?page=index" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
                
                <!-- Filter Info -->
                <?php if ($filter != 'all' || !empty($search)): ?>
                <div class="alert-info-custom mt-3">
                    <i class="bi bi-info-circle-fill"></i>
                    <?php if ($filter == 'done'): ?>
                        Menampilkan todo <strong>Selesai</strong>
                    <?php elseif ($filter == 'undone'): ?>
                        Menampilkan todo <strong>Belum Selesai</strong>
                    <?php endif; ?>
                    
                    <?php if (!empty($search)): ?>
                        <?= $filter != 'all' ? 'dengan' : '' ?> pencarian: "<strong><?= htmlspecialchars($search) ?></strong>"
                    <?php endif; ?>
                    
                    <span class="badge bg-primary"><?= count($todos) ?> hasil</span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th width="40"><i class="bi bi-arrows-move"></i></th>
                            <th width="50">#</th>
                            <th>Aktivitas</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="todoTableBody">
                    <?php if (!empty($todos)): ?>
                        <?php foreach ($todos as $i => $todo): ?>
                        <tr data-id="<?= $todo['id'] ?>">
                            <td class="text-center">
                                <i class="bi bi-grip-vertical drag-handle"></i>
                            </td>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <strong><?= htmlspecialchars($todo['activity']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($todo['title']) ?></td>
                            <td>
                                <?php if ($todo['is_finished']): ?>
                                    <span class="badge badge-custom bg-success">
                                        <i class="bi bi-check-circle"></i> Selesai
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-custom bg-warning text-dark">
                                        <i class="bi bi-clock"></i> Belum Selesai
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i>
                                    <?= date('d M Y', strtotime($todo['created_at'])) ?>
                                </small>
                            </td>
                            <td>
                                <button class="btn btn-info btn-action text-white btn-sm"
                                    onclick="showTodoDetail(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>', '<?= htmlspecialchars(addslashes($todo['description'])) ?>', <?= $todo['is_finished'] ? 'true' : 'false' ?>, '<?= date('d F Y - H:i', strtotime($todo['created_at'])) ?>', '<?= date('d F Y - H:i', strtotime($todo['updated_at'])) ?>')">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <button class="btn btn-warning btn-action btn-sm"
                                    onclick="showModalEditTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['activity'])) ?>', '<?= htmlspecialchars(addslashes($todo['title'])) ?>', '<?= htmlspecialchars(addslashes($todo['description'])) ?>', <?= $todo['is_finished'] ? '1' : '0' ?>)">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button class="btn btn-danger btn-action btn-sm"
                                    onclick="showModalDeleteTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5>Tidak Ada Data</h5>
                                    <p class="text-muted">Belum ada todo yang tersedia. Tambahkan todo baru untuk memulai!</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD TODO -->
<div class="modal fade" id="addTodo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Todo Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="?page=create" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputActivity" class="form-label fw-bold">
                            <i class="bi bi-lightning-charge"></i> Aktivitas *
                        </label>
                        <input type="text" name="activity" class="form-control" id="inputActivity"
                            placeholder="Contoh: Belajar PHP dasar" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label fw-bold">
                            <i class="bi bi-card-heading"></i> Judul *
                        </label>
                        <input type="text" name="title" class="form-control" id="inputTitle"
                            placeholder="Judul todo (harus unik)" required>
                        <small class="text-muted">Judul harus unik dan tidak boleh sama dengan todo lain</small>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescription" class="form-label fw-bold">
                            <i class="bi bi-text-paragraph"></i> Deskripsi
                        </label>
                        <textarea name="description" class="form-control" id="inputDescription" rows="4"
                            placeholder="Tuliskan deskripsi detail tentang todo ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT TODO -->
<div class="modal fade" id="editTodo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Ubah Data Todo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="?page=update" method="POST">
                <input name="id" type="hidden" id="inputEditTodoId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputEditActivity" class="form-label fw-bold">
                            <i class="bi bi-lightning-charge"></i> Aktivitas *
                        </label>
                        <input type="text" name="activity" class="form-control" id="inputEditActivity" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditTitle" class="form-label fw-bold">
                            <i class="bi bi-card-heading"></i> Judul *
                        </label>
                        <input type="text" name="title" class="form-control" id="inputEditTitle" required>
                        <small class="text-muted">Judul harus unik</small>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditDescription" class="form-label fw-bold">
                            <i class="bi bi-text-paragraph"></i> Deskripsi
                        </label>
                        <textarea name="description" class="form-control" id="inputEditDescription" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="selectEditStatus" class="form-label fw-bold">
                            <i class="bi bi-check-square"></i> Status
                        </label>
                        <select class="form-select" name="status" id="selectEditStatus">
                            <option value="0">⏳ Belum Selesai</option>
                            <option value="1">✅ Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DELETE TODO -->
<div class="modal fade" id="deleteTodo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-trash"></i> Hapus Data Todo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-3">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">Apakah Anda yakin?</h5>
                    <p class="text-muted">
                        Anda akan menghapus todo: <br>
                        <strong class="text-danger" id="deleteTodoTitle"></strong>
                    </p>
                    <p class="text-muted small">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <a id="btnDeleteTodo" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL TODO -->
<div class="modal fade" id="detailTodo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-info-circle"></i> Detail Todo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold text-muted small">JUDUL</label>
                        <h4 id="detailTitle" class="mt-1"></h4>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold text-muted small">DESKRIPSI</label>
                        <p id="detailDescription" class="mt-1" style="white-space: pre-wrap;"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-muted small">STATUS</label>
                        <div class="mt-1">
                            <span id="detailStatus" class="badge badge-custom"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-muted small">ID TODO</label>
                        <p id="detailId" class="mt-1 mb-0 text-muted">#<span></span></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted small">DIBUAT PADA</label>
                        <p id="detailCreatedAt" class="mt-1 mb-0">
                            <i class="bi bi-calendar-plus text-primary"></i> <span></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted small">DIUPDATE PADA</label>
                        <p id="detailUpdatedAt" class="mt-1 mb-0">
                            <i class="bi bi-calendar-check text-success"></i> <span></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// Function untuk menampilkan modal edit
function showModalEditTodo(todoId, activity, title, description, status) {
    document.getElementById("inputEditTodoId").value = todoId;
    document.getElementById("inputEditActivity").value = activity;
    document.getElementById("inputEditTitle").value = title;
    document.getElementById("inputEditDescription").value = description;
    document.getElementById("selectEditStatus").value = status;
    new bootstrap.Modal(document.getElementById("editTodo")).show();
}

// Function untuk menampilkan modal delete
function showModalDeleteTodo(todoId, title) {
    document.getElementById("deleteTodoTitle").innerText = title;
    document.getElementById("btnDeleteTodo").setAttribute("href", `?page=delete&id=${todoId}`);
    new bootstrap.Modal(document.getElementById("deleteTodo")).show();
}

// Function untuk menampilkan detail todo
function showTodoDetail(id, title, desc, status, createdAt, updatedAt) {
    document.getElementById('detailId').querySelector('span').innerText = id;
    document.getElementById('detailTitle').innerText = title;
    document.getElementById('detailDescription').innerText = desc || 'Tidak ada deskripsi';
    
    const statusBadge = document.getElementById('detailStatus');
    if (status) {
        statusBadge.innerHTML = '<i class="bi bi-check-circle"></i> Selesai';
        statusBadge.className = 'badge badge-custom bg-success';
    } else {
        statusBadge.innerHTML = '<i class="bi bi-clock"></i> Belum Selesai';
        statusBadge.className = 'badge badge-custom bg-warning text-dark';
    }
    
    document.getElementById('detailCreatedAt').querySelector('span').innerText = createdAt;
    document.getElementById('detailUpdatedAt').querySelector('span').innerText = updatedAt;
    
    new bootstrap.Modal(document.getElementById('detailTodo')).show();
}

// Sortable.js untuk drag & drop
const tbody = document.getElementById("todoTableBody");
if (tbody && tbody.children.length > 0 && !tbody.querySelector('.empty-state')) {
    Sortable.create(tbody, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
        onEnd: function(evt) {
            // Update nomor urut
            let orders = [];
            document.querySelectorAll("#todoTableBody tr[data-id]").forEach((row, index) => {
                const id = row.dataset.id;
                orders.push({ id: id, order: index + 1 });
                // Update nomor di kolom pertama (setelah handle)
                row.querySelectorAll('td')[1].innerText = index + 1;
            });
            
            // Kirim ke backend untuk menyimpan urutan
            fetch('update_order.php', {
                method: 'POST',
                body: JSON.stringify(orders),
                headers: { 'Content-Type': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Order updated successfully:', data);
            })
            .catch(error => {
                console.error('Error updating order:', error);
            });
        }
    });
}

// Auto dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
</body>
</html>