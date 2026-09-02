<?php
// catalogul public de filme, cu filtre pe gen si an
/** @var string $title */
/** @var string $filters */
/** @var string $grid */
?>
<section class="hero border-bottom">
    <div class="container py-5">
        <p class="text-uppercase text-secondary small mb-2 tracking-wide">Independent film production house</p>
        <h1 class="display-5 fw-bold mb-3">We make films that stay with you.</h1>
        <p class="lead text-muted mb-0 col-lg-8">
            Cinema Forge develops, produces and finishes feature films and documentaries in Romania,
            from the first draft of the screenplay to the final colour grade.
        </p>
    </div>
</section>

<div class="container my-5">
    <h2 class="h3 mb-4"><?= htmlspecialchars($title) ?></h2>

    <?= $filters ?>

    <?= $grid ?>
</div>
