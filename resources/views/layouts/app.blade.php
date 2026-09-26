<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMaster Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .stat-card { border-radius: 12px; border: none; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .task-card { border-radius: 10px; border-left: 5px solid #6c757d; }
        .task-priority-High { border-left-color: #dc3545 !important; }
        .task-priority-Medium { border-left-color: #ffc107 !important; }
        .task-priority-Low { border-left-color: #0d6efd !important; }
        .badge-category { font-size: 0.75rem; background-color: #eef2f7; color: #495057; }
    </style>
</head>
<body class="py-4">
    <div class="container" style="max-width: 800px;">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>