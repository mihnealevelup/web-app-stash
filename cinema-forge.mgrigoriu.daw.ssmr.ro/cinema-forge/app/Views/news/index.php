<?php
// stiri interne din baza de date plus continut parsat dintr-o sursa externa
/** @var array $internal */
/** @var array $external */
/** @var string $feedName */
?>
<div class="container my-5">
    <h1 class="h3 mb-4">News</h1>

    <div class="row g-5">
        <div class="col-lg-7">
            <h2 class="h5 text-uppercase text-secondary small mb-3">From the studio</h2>

            <?php if (empty($internal)): ?>
                <div class="alert alert-info">No records found.</div>
            <?php else: ?>
                <?php foreach ($internal as $item): ?>
                    <article class="pb-4 mb-4 border-bottom">
                        <h3 class="h5 mb-1"><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="text-muted small mb-2">
                            <?= $item['published_at'] ? date('d.m.Y', strtotime($item['published_at'])) : '' ?>
                        </p>
                        <p class="mb-0"><?= htmlspecialchars($item['excerpt'] ?? '') ?></p>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="col-lg-5">
            <h2 class="h5 text-uppercase text-secondary small mb-3">
                From the industry
                <span class="badge bg-light text-dark fw-normal ms-1"><?= htmlspecialchars($feedName) ?></span>
            </h2>

            <?php if (empty($external)): ?>
                <div class="alert alert-secondary small mb-0">
                    The external source is temporarily unavailable. Studio news is unaffected.
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($external as $item): ?>
                        <a class="list-group-item list-group-item-action px-0"
                           href="<?= htmlspecialchars($item['link']) ?>" target="_blank" rel="noopener noreferrer">
                            <p class="fw-semibold mb-1 small"><?= htmlspecialchars($item['title']) ?></p>
                            <p class="text-muted small mb-1"><?= htmlspecialchars($item['description']) ?></p>
                            <p class="text-muted mb-0" style="font-size:.75rem"><?= htmlspecialchars($item['date']) ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
                <p class="text-muted mt-3 mb-0" style="font-size:.75rem">
                    Headlines are downloaded and parsed server-side, then rendered as native page content.
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>
