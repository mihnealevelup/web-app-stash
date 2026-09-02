<?php
// panoul principal al zonei de administrare
/** @var array $stats */
/** @var string $username */
/** @var string $role */
$cards = [
    ['label' => 'Films',   'value' => $stats['films'],   'href' => '/admin/films',   'accent' => 'primary'],
    ['label' => 'Talents', 'value' => $stats['talents'], 'href' => '/admin/talents', 'accent' => 'success'],
    ['label' => 'News',    'value' => $stats['news'],    'href' => '/news',          'accent' => 'info'],
];
?>
<h1 class="h3 mb-1">Dashboard</h1>
<p class="text-muted mb-4">
    Signed in as <strong><?= htmlspecialchars($username) ?></strong>
    with the <span class="text-capitalize"><?= htmlspecialchars($role) ?></span> role.
</p>

<div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
    <?php foreach ($cards as $card): ?>
        <div class="col">
            <a href="<?= $card['href'] ?>" class="text-decoration-none">
                <div class="card stat-card border-0 shadow-sm h-100 border-start border-4 border-<?= $card['accent'] ?>">
                    <div class="card-body">
                        <p class="text-uppercase text-muted small mb-1"><?= $card['label'] ?></p>
                        <p class="display-6 fw-bold mb-0"><?= (int) $card['value'] ?></p>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h2 class="h6 text-uppercase text-muted mb-3">Your permissions</h2>
        <ul class="list-unstyled mb-0 small">
            <li class="mb-1">&#10003; View the dashboard</li>
            <li class="mb-1">
                <?= \Services\AuthService::hasMinRole('manager') ? '&#10003;' : '&#10007;' ?>
                Create and edit films and talents
            </li>
            <li class="mb-1">
                <?= \Services\AuthService::hasRole('admin') ? '&#10003;' : '&#10007;' ?>
                Delete records and manage users
            </li>
        </ul>
    </div>
</div>
