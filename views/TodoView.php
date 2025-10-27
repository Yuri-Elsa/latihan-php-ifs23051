<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌌 Galaxy Todo List</title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Exo+2:wght@300;400;600;700&display=swap');
        
        :root {
            --galaxy-purple: #6B2C91;
            --galaxy-blue: #1E3A8A;
            --galaxy-pink: #EC4899;
            --galaxy-cyan: #06B6D4;
            --space-dark: #0A0E27;
            --nebula-purple: #9333EA;
            --star-white: #F8FAFC;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Exo 2', sans-serif;
            background: #0A0E27;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated Galaxy Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(ellipse at top, #1e1b4b 0%, transparent 50%),
                radial-gradient(ellipse at bottom, #312e81 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, #7c3aed 0%, transparent 40%),
                radial-gradient(circle at 80% 20%, #ec4899 0%, transparent 40%),
                radial-gradient(circle at 40% 40%, #3b82f6 0%, transparent 40%);
            background-color: #0A0E27;
            z-index: -2;
            animation: galaxyShift 20s ease-in-out infinite;
        }
        
        @keyframes galaxyShift {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        /* Animated Stars */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s infinite;
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.5); }
        }
        
        /* Shooting Stars */
        @keyframes shooting {
            0% {
                transform: translateX(0) translateY(0);
                opacity: 1;
            }
            100% {
                transform: translateX(-1000px) translateY(500px);
                opacity: 0;
            }
        }
        
        .shooting-star {
            position: fixed;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5);
            animation: shooting 3s linear infinite;
            z-index: -1;
        }
        
        .main-container {
            padding: 2rem 1rem;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
        
        .todo-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 30px;
            border: 2px solid rgba(147, 51, 234, 0.3);
            box-shadow: 
                0 0 60px rgba(147, 51, 234, 0.3),
                0 0 100px rgba(59, 130, 246, 0.2),
                inset 0 0 60px rgba(147, 51, 234, 0.05);
            overflow: hidden;
            backdrop-filter: blur(20px);
            position: relative;
        }
        
        .todo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, 
                transparent,
                rgba(147, 51, 234, 0.8),
                rgba(59, 130, 246, 0.8),
                rgba(236, 72, 153, 0.8),
                transparent
            );
            animation: borderGlow 3s linear infinite;
        }
        
        @keyframes borderGlow {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, 
                rgba(109, 40, 217, 0.8) 0%,
                rgba(147, 51, 234, 0.8) 50%,
                rgba(168, 85, 247, 0.8) 100%
            );
            color: white;
            padding: 2.5rem 2rem;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .card-header-custom::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: headerPulse 4s ease-in-out infinite;
        }
        
        @keyframes headerPulse {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(10%, 10%) scale(1.1); }
        }
        
        .card-header-custom h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: 900;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-shadow: 
                0 0 20px rgba(255, 255, 255, 0.5),
                0 0 40px rgba(147, 51, 234, 0.8);
            position: relative;
            z-index: 1;
        }
        
        .btn-add-todo {
            background: linear-gradient(135deg, #EC4899 0%, #8B5CF6 100%);
            color: white;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            padding: 0.9rem 2rem;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            z-index: 1;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(236, 72, 153, 0.5);
        }
        
        .btn-add-todo::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-add-todo:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-add-todo:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 0 30px rgba(236, 72, 153, 0.8);
            border-color: rgba(255, 255, 255, 0.4);
        }
        
        .filter-search-section {
            background: rgba(30, 41, 59, 0.6);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            border: 1px solid rgba(147, 51, 234, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 0 30px rgba(147, 51, 234, 0.1);
        }
        
        .form-label {
            color: #E0E7FF;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-select, .form-control {
            background: rgba(15, 23, 42, 0.8);
            border: 2px solid rgba(147, 51, 234, 0.3);
            border-radius: 12px;
            color: #E0E7FF;
            padding: 0.85rem 1rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .form-select:focus, .form-control:focus {
            background: rgba(15, 23, 42, 0.95);
            border-color: #8B5CF6;
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.4);
            color: white;
        }
        
        .form-select option {
            background: #1E293B;
            color: #E0E7FF;
        }
        
        .btn-search {
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 700;
            font-family: 'Orbitron', sans-serif;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.4);
        }
        
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.6);
        }
        
        .btn-outline-secondary {
            background: rgba(100, 116, 139, 0.2);
            border: 2px solid rgba(148, 163, 184, 0.3);
            color: #CBD5E1;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background: rgba(100, 116, 139, 0.4);
            border-color: #94A3B8;
            color: white;
            transform: rotate(180deg);
        }
        
        .alert-info-custom {
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.15) 0%, 
                rgba(147, 51, 234, 0.15) 100%
            );
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 15px;
            padding: 1.2rem 1.5rem;
            color: #BFDBFE;
            backdrop-filter: blur(5px);
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 20px;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(10px);
        }
        
        .table-modern {
            margin: 0;
            color: #E0E7FF;
        }
        
        .table-modern thead {
            background: linear-gradient(135deg, 
                rgba(109, 40, 217, 0.6) 0%,
                rgba(59, 130, 246, 0.6) 100%
            );
            color: white;
            position: relative;
        }
        
        .table-modern thead th {
            padding: 1.2rem;
            font-weight: 700;
            font-family: 'Orbitron', sans-serif;
            border: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }
        
        .table-modern tbody tr {
            transition: all 0.3s ease;
            cursor: move;
            border-bottom: 1px solid rgba(147, 51, 234, 0.2);
        }
        
        .table-modern tbody tr:hover {
            background: rgba(139, 92, 246, 0.15);
            transform: scale(1.01);
            box-shadow: 0 5px 20px rgba(139, 92, 246, 0.3);
        }
        
        .table-modern tbody td {
            padding: 1.2rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(147, 51, 234, 0.15);
        }
        
        .badge-custom {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
        
        .bg-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%) !important;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
        }
        
        .bg-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%) !important;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.5);
        }
        
        .bg-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%) !important;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
        
        .btn-action {
            padding: 0.6rem 1rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            margin: 0.2rem;
            position: relative;
            overflow: hidden;
        }
        
        .btn-action::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
        }
        
        .btn-action:hover::before {
            width: 200px;
            height: 200px;
        }
        
        .btn-action:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        
        .btn-info {
            background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%);
            border-color: rgba(6, 182, 212, 0.5);
        }
        
        .btn-info:hover {
            box-shadow: 0 0 25px rgba(6, 182, 212, 0.6);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            border-color: rgba(245, 158, 11, 0.5);
        }
        
        .btn-warning:hover {
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.6);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            border-color: rgba(239, 68, 68, 0.5);
        }
        
        .btn-danger:hover {
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.6);
        }
        
        .modal-content {
            background: rgba(15, 23, 42, 0.95);
            border-radius: 25px;
            border: 2px solid rgba(147, 51, 234, 0.4);
            overflow: hidden;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 60px rgba(147, 51, 234, 0.4);
        }
        
        .modal-header {
            background: linear-gradient(135deg, 
                rgba(109, 40, 217, 0.9) 0%,
                rgba(147, 51, 234, 0.9) 100%
            );
            color: white;
            padding: 1.8rem;
            border: none;
            border-bottom: 2px solid rgba(147, 51, 234, 0.5);
        }
        
        .modal-header.bg-danger {
            background: linear-gradient(135deg, 
                rgba(239, 68, 68, 0.9) 0%,
                rgba(220, 38, 38, 0.9) 100%
            );
        }
        
        .modal-title {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .modal-body {
            padding: 2rem;
            color: #E0E7FF;
        }
        
        .drag-handle {
            cursor: move;
            color: #8B5CF6;
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }
        
        .drag-handle:hover {
            color: #A78BFA;
            transform: scale(1.2);
        }
        
        .sortable-ghost {
            opacity: 0.3;
            background: rgba(139, 92, 246, 0.2);
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #94A3B8;
        }
        
        .empty-state i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            color: #6366F1;
            opacity: 0.6;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .alert {
            border-radius: 15px;
            border: 2px solid;
            backdrop-filter: blur(10px);
            font-weight: 600;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.2);
            border-color: #10B981;
            color: #6EE7B7;
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            border-color: #EF4444;
            color: #FCA5A5;
        }
        
        .text-muted {
            color: #94A3B8 !important;
        }
        
        small.text-muted {
            color: #64748B !important;
        }
        
        /* Scrollbar Custom */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #A78BFA 0%, #F472B6 100%);
        }
        
        @media (max-width: 768px) {
            .card-header-custom h1 {
                font-size: 1.8rem;
            }
            
            .btn-add-todo {
                padding: 0.7rem 1.2rem;
                font-size: 0.9rem;
            }
        }
    </style>
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
                <h1><i class="bi bi-stars"></i> GALAXY TODO</h1>
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