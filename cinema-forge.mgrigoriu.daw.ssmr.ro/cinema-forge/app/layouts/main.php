<?php
// layout principal pentru zona publica
use Services\AuthService;

$pageTitle = isset($title) && $title !== '' ? $title . ' | ' . APP_NAME : APP_NAME;
$metaDescription = $metaDescription ?? 'Cinema Forge is an independent film production house: feature films, documentaries and the people who make them.';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta property="og:type" content="website">
    <link rel="canonical" href="<?= htmlspecialchars(APP_URL . ($_SERVER['REQUEST_URI'] ?? '/')) ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/images/favicon-96.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <span class="brand-mark">&#9679;</span> Cinema Forge
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="/catalog">Catalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="/news">News</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                    <?php if (AuthService::isLoggedIn()): ?>
                        <li class="nav-item"><a class="nav-link" href="/admin">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link text-warning" href="/logout">Log out</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/login">Staff login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <?= $content ?>
    </main>

    <footer class="bg-dark text-white-50 mt-5">
        <div class="container py-4">
            <div class="row gy-3">
                <div class="col-md-6">
                    <h6 class="text-white mb-2">Cinema Forge</h6>
                    <p class="mb-0 small">Independent film production house. Bucharest, Romania.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a class="link-light small me-3" href="/catalog">Catalog</a>
                    <a class="link-light small me-3" href="/news">News</a>
                    <a class="link-light small" href="/contact">Contact</a>
                    <p class="mb-0 small mt-2">&copy; <?= date('Y') ?> Cinema Forge. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
