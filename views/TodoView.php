<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Yuri</title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<!-- Stars Background -->
<div class="stars" id="stars"></div>

<!-- Shooting Stars -->
<div class="shooting-star" style="top: 10%; right: 20%; animation-delay: 0s;"></div>
<div class="shooting-star" style="top: 30%; right: 60%; animation-delay: 2s;"></div>
<div class="shooting-star" style="top: 50%; right: 40%; animation-delay: 4s;"></div>

<div class="container main-container">
    <div class="todo-card">
        <!-- Header -->
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h1><i class="bi bi-list-check"></i> Todo List</h1>
                <button class="btn btn-add-todo" data-bs-toggle="modal" data-bs-target="#addTodo">
                    <i class="bi bi-plus-circle"></i> NEW MISSION
                </button>
            </div>
        </div>
        
        <div class="card-body p-4">
            <!-- Alert Messages -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); endif; ?>

            <!-- Filter & Search Section -->
            <div class="filter-search-section">
                <form method="GET" class="row g-3">
                    <input type="hidden" name="page" value="index">
                    
                    <div class="col-md-3">
                        <label class="form-label"><i class="bi bi-funnel-fill"></i> Filter Status</label>
                        <select name="filter" class="form-select" onchange="this.form.submit()">
                            <option value="all" <?= isset($filter) && $filter == 'all' ? 'selected' : '' ?>>🌌 All Missions</option>
                            <option value="done" <?= isset($filter) && $filter == 'done' ? 'selected' : '' ?>>✨ Completed</option>
                            <option value="undone" <?= isset($filter) && $filter == 'undone' ? 'selected' : '' ?>>🚀 In Progress</option>
                        </select>
                    </div>
                    
                    <div class="col-md-7">
                        <label class="form-label"><i class="bi bi-search"></i> Search Mission</label>
                        <input type="text" name="search" class="form-control"
                            value="<?= htmlspecialchars($search ?? '') ?>"
                            placeholder="Search across the galaxy...">
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary btn-search flex-grow-1">
                            <i class="bi bi-search"></i> SCAN
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
                        Showing <strong>Completed</strong> missions
                    <?php elseif ($filter == 'undone'): ?>
                        Showing <strong>In Progress</strong> missions
                    <?php endif; ?>
                    
                    <?php if (!empty($search)): ?>
                        <?= $filter != 'all' ? 'with' : '' ?> search: "<strong><?= htmlspecialchars($search) ?></strong>"
                    <?php endif; ?>
                    
                    <span class="badge bg-primary"><?= count($todos) ?> found</span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th width="40"><i class="bi bi-grip-vertical"></i></th>
                            <th width="50">#</th>
                            <th>Activity</th>
                            <th>Mission</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th width="200">Actions</th>
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
                                        <i class="bi bi-check-circle-fill"></i> DONE
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-custom bg-warning text-dark">
                                        <i class="bi bi-hourglass-split"></i> ONGOING
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event"></i>
                                    <?= date('d M Y', strtotime($todo['created_at'])) ?>
                                </small>
                            </td>
                            <td>
                                <button class="btn btn-info btn-action text-white btn-sm"
                                    onclick="showTodoDetail(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>', '<?= htmlspecialchars(addslashes($todo['description'])) ?>', <?= $todo['is_finished'] ? 'true' : 'false' ?>, '<?= date('d F Y - H:i', strtotime($todo['created_at'])) ?>', '<?= date('d F Y - H:i', strtotime($todo['updated_at'])) ?>')">
                                    <i class="bi bi-eye-fill"></i>
                                </button>

                                <button class="btn btn-warning btn-action btn-sm"
                                    onclick="showModalEditTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['activity'])) ?>', '<?= htmlspecialchars(addslashes($todo['title'])) ?>', '<?= htmlspecialchars(addslashes($todo['description'])) ?>', <?= $todo['is_finished'] ? '1' : '0' ?>)">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>

                                <button class="btn btn-danger btn-action btn-sm"
                                    onclick="showModalDeleteTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-rocket-takeoff"></i>
                                    <h5>No Missions Found</h5>
                                    <p class="text-muted">Start your journey by creating a new mission!</p>
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
                <h5 class="modal-title"><i class="bi bi-plus-circle-fill"></i> NEW MISSION</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="?page=create" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputActivity" class="form-label">
                            <i class="bi bi-lightning-charge-fill"></i> Activity *
                        </label>
                        <input type="text" name="activity" class="form-control" id="inputActivity"
                            placeholder="e.g., Study Advanced PHP" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">
                            <i class="bi bi-card-heading"></i> Mission Title *
                        </label>
                        <input type="text" name="title" class="form-control" id="inputTitle"
                            placeholder="Unique mission title" required>
                        <small class="text-muted">Title must be unique across all missions</small>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescription" class="form-label">
                            <i class="bi bi-text-paragraph"></i> Description
                        </label>
                        <textarea name="description" class="form-control" id="inputDescription" rows="4"
                            placeholder="Describe your mission details..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> CANCEL
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-rocket-takeoff"></i> LAUNCH
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
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> EDIT MISSION</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="?page=update" method="POST">
                <input name="id" type="hidden" id="inputEditTodoId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputEditActivity" class="form-label">
                            <i class="bi bi-lightning-charge-fill"></i> Activity *
                        </label>
                        <input type="text" name="activity" class="form-control" id="inputEditActivity" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditTitle" class="form-label">
                            <i class="bi bi-card-heading"></i> Mission Title *
                        </label>
                        <input type="text" name="title" class="form-control" id="inputEditTitle" required>
                        <small class="text-muted">Title must be unique</small>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditDescription" class="form-label">
                            <i class="bi bi-text-paragraph"></i> Description
                        </label>
                        <textarea name="description" class="form-control" id="inputEditDescription" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="selectEditStatus" class="form-label">
                            <i class="bi bi-check-square-fill"></i> Mission Status
                        </label>
                        <select class="form-select" name="status" id="selectEditStatus">
                            <option value="0">🚀 In Progress</option>
                            <option value="1">✨ Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> CANCEL
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle-fill"></i> UPDATE
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
                <h5 class="modal-title"><i class="bi bi-trash-fill"></i> DELETE MISSION</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-3">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-white">Are you sure?</h5>
                    <p class="text-muted">
                        You are about to delete mission: <br>
                        <strong class="text-danger" id="deleteTodoTitle"></strong>
                    </p>
                    <p class="text-muted small">This action cannot be undone!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> CANCEL
                </button>
                <a id="btnDeleteTodo" class="btn btn-danger">
                    <i class="bi bi-trash-fill"></i> YES, DELETE
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
                <h5 class="modal-title"><i class="bi bi-info-circle-fill"></i> MISSION DETAILS</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold text-muted small">MISSION TITLE</label>
                        <h4 id="detailTitle" class="mt-1 text-white"></h4>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold text-muted small">DESCRIPTION</label>
                        <p id="detailDescription" class="mt-1 text-white" style="white-space: pre-wrap;"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-muted small">STATUS</label>
                        <div class="mt-1">
                            <span id="detailStatus" class="badge badge-custom"></span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold text-muted small">MISSION ID</label>
                        <p id="detailId" class="mt-1 mb-0 text-muted">#<span></span></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted small">CREATED AT</label>
                        <p id="detailCreatedAt" class="mt-1 mb-0 text-white">
                            <i class="bi bi-calendar-plus text-primary"></i> <span></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted small">UPDATED AT</label>
                        <p id="detailUpdatedAt" class="mt-1 mb-0 text-white">
                            <i class="bi bi-calendar-check text-success"></i> <span></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> CLOSE
                </button>
            </div>
        </div>
    </div>
</div>

<script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// Generate stars
const starsContainer = document.getElementById('stars');
for (let i = 0; i < 200; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    star.style.left = Math.random() * 100 + '%';
    star.style.top = Math.random() * 100 + '%';
    star.style.animationDelay = Math.random() * 3 + 's';
    starsContainer.appendChild(star);
}

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
    document.getElementById('detailDescription').innerText = desc || 'No description available';
    
    const statusBadge = document.getElementById('detailStatus');
    if (status) {
        statusBadge.innerHTML = '<i class="bi bi-check-circle-fill"></i> COMPLETED';
        statusBadge.className = 'badge badge-custom bg-success';
    } else {
        statusBadge.innerHTML = '<i class="bi bi-hourglass-split"></i> IN PROGRESS';
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