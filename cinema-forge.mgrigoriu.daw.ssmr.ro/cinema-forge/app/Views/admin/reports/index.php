<?php
// raport pe catalogul de filme, cu export in excel si csv
use Helpers\TableGenerator;

/** @var array $films */
/** @var array $byStatus */
$statusLabels = [
    'development' => 'In development', 'production' => 'In production',
    'post-production' => 'In post-production', 'released' => 'Released'
];
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="h3 mb-0">Film catalogue report</h1>
    <div>
        <a href="/admin/reports/films.xls" class="btn btn-success">Export to Excel</a>
        <a href="/admin/reports/films.csv" class="btn btn-outline-secondary">Export to CSV</a>
        <button onclick="window.print()" class="btn btn-outline-secondary">Print</button>
    </div>
</div>

<div class="row row-cols-2 row-cols-md-4 g-3 mb-4">
    <?php foreach ($statusLabels as $key => $label): ?>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-3">
                    <p class="text-muted small mb-1"><?= $label ?></p>
                    <p class="h4 mb-0"><?= (int) ($byStatus[$key] ?? 0) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">
        <p class="text-muted small">Generated on <?= date('d.m.Y H:i') ?> &middot; <?= count($films) ?> records.</p>
        <?= TableGenerator::render($films, [
            'id' => '#', 'title' => 'Title', 'genre' => 'Genre',
            'release_year' => 'Year', 'status' => 'Status'
        ], []) ?>
    </div>
</div>
