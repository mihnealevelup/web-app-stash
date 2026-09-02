<?php
// pagina individuala a filmului: trailer, sinopsis, distributie si echipa
/** @var array|null $film */
/** @var array $cast */
/** @var array $crew */

if (!$film): ?>
    <div class="container my-5">
        <div class="alert alert-warning">
            <h1 class="h4">Film not found</h1>
            <p class="mb-0">The film you are looking for is not in the catalogue. <a href="/catalog">Back to the catalogue</a>.</p>
        </div>
    </div>
<?php return; endif;

$statusLabels = [
    'development'     => ['In development', 'secondary'],
    'production'      => ['In production', 'warning'],
    'post-production' => ['In post-production', 'info'],
    'released'        => ['Released', 'success']
];
$status = $statusLabels[$film['status']] ?? ['Unknown', 'secondary'];
?>
<article class="showcase">
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/catalog">Catalog</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($film['title']) ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-4">
                <img src="<?= htmlspecialchars($film['poster'] ?: '/assets/images/no-poster.jpg') ?>"
                     class="img-fluid rounded shadow-sm w-100"
                     alt="Poster for <?= htmlspecialchars($film['title']) ?>">
            </div>

            <div class="col-lg-8">
                <span class="badge bg-<?= $status[1] ?> mb-2"><?= htmlspecialchars($status[0]) ?></span>
                <h1 class="display-6 fw-bold mb-2"><?= htmlspecialchars($film['title']) ?></h1>
                <p class="text-muted mb-4">
                    <?= htmlspecialchars($film['genre'] ?? '') ?>
                    <?php if (!empty($film['release_year'])): ?>
                        &middot; <?= htmlspecialchars($film['release_year']) ?>
                    <?php endif; ?>
                </p>

                <h2 class="h5">Synopsis</h2>
                <p class="lead fs-6"><?= nl2br(htmlspecialchars($film['synopsis'] ?? 'Synopsis coming soon.')) ?></p>

                <?php if (!empty($film['trailer_url'])): ?>
                    <h2 class="h5 mt-4">Trailer</h2>
                    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                        <iframe src="<?= htmlspecialchars($film['trailer_url']) ?>"
                                title="Trailer for <?= htmlspecialchars($film['title']) ?>"
                                allowfullscreen loading="lazy"></iframe>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($cast)): ?>
            <h2 class="h4 mt-5 mb-3">Cast</h2>
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                <?php foreach ($cast as $person): ?>
                    <div class="col">
                        <div class="card h-100 border-0 bg-transparent text-center">
                            <img src="<?= htmlspecialchars($person['photo'] ?: '/assets/images/no-photo.jpg') ?>"
                                 class="rounded-circle mx-auto mb-2 talent-photo"
                                 alt="<?= htmlspecialchars($person['name']) ?>">
                            <div class="card-body p-0">
                                <p class="fw-semibold mb-0 small"><?= htmlspecialchars($person['name']) ?></p>
                                <?php if (!empty($person['character_name'])): ?>
                                    <p class="text-muted small mb-0"><?= htmlspecialchars($person['character_name']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($crew)): ?>
            <h2 class="h4 mt-5 mb-3">Crew</h2>
            <ul class="list-group list-group-flush col-lg-6">
                <?php foreach ($crew as $person): ?>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span><?= htmlspecialchars($person['name']) ?></span>
                        <span class="text-muted text-capitalize"><?= htmlspecialchars($person['role_type']) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</article>
