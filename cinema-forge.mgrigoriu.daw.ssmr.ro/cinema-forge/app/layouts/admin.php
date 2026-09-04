<?php
// layout pentru panoul de administrare
use Services\AuthService;

$pageTitle = isset($title) && $title !== '' ? $title . ' | Admin' : 'Admin';
$role = AuthService::getRole();
$currentUri = $_SERVER['REQUEST_URI'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/images/favicon-96.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="admin-body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="/admin">Cinema Forge <span class="badge bg-secondary align-middle">admin</span></a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-white-50 small d-none d-md-inline">
                    <?= htmlspecialchars(AuthService::getUsername() ?? '') ?>
                    &middot; <span class="badge bg-info text-dark"><?= htmlspecialchars($role ?? '') ?></span>
                </span>
                <a class="btn btn-sm btn-outline-light" href="/" target="_blank" rel="noopener">View site</a>
                <a class="btn btn-sm btn-outline-warning" href="/logout">Log out</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-lg-2 bg-dark py-4 min-vh-100 d-none d-lg-block">
                <ul class="nav flex-column admin-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($currentUri, '/admin') === 0 && $currentUri === '/admin' ? 'active' : '' ?>" href="/admin">Dashboard</a>
                    </li>
                    <?php if (AuthService::hasMinRole('manager')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($currentUri, '/admin/films') === 0 ? 'active' : '' ?>" href="/admin/films">Films</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($currentUri, '/admin/talents') === 0 ? 'active' : '' ?>" href="/admin/talents">Talents</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/reports">Reports</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </aside>

            <section class="col-lg-10 py-4 px-4">
                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= htmlspecialchars($_SESSION['success']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?= $content ?>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
