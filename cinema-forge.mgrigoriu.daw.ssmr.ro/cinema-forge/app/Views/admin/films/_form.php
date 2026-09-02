<?php
// formular reutilizat de create si edit, ca sa nu duplicam campurile
/** @var array $film */
/** @var string $formAction */
/** @var string $submitLabel */
/** @var string $csrf_token */
$statuses = ['development' => 'In development', 'production' => 'In production',
    'post-production' => 'In post-production', 'released' => 'Released'];
?>
<h1 class="h3 mb-4"><?= htmlspecialchars($title) ?></h1>

<form method="POST" action="<?= htmlspecialchars($formAction) ?>" class="row g-3 col-lg-9">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

    <div class="col-md-8">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required
               value="<?= htmlspecialchars($film['title'] ?? '') ?>">
    </div>

    <div class="col-md-4">
        <label for="release_year" class="form-label">Release year</label>
        <input type="number" class="form-control" id="release_year" name="release_year"
               min="1900" max="2100" value="<?= htmlspecialchars($film['release_year'] ?? date('Y')) ?>">
    </div>

    <div class="col-md-6">
        <label for="genre" class="form-label">Genre</label>
        <input type="text" class="form-control" id="genre" name="genre"
               value="<?= htmlspecialchars($film['genre'] ?? '') ?>">
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
            <?php foreach ($statuses as $value => $label): ?>
                <option value="<?= $value ?>" <?= (($film['status'] ?? '') === $value) ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-12">
        <label for="synopsis" class="form-label">Synopsis</label>
        <textarea class="form-control" id="synopsis" name="synopsis" rows="5"><?= htmlspecialchars($film['synopsis'] ?? '') ?></textarea>
    </div>

    <div class="col-md-6">
        <label for="poster" class="form-label">Poster URL</label>
        <input type="url" class="form-control" id="poster" name="poster"
               value="<?= htmlspecialchars($film['poster'] ?? '') ?>">
    </div>

    <div class="col-md-6">
        <label for="trailer_url" class="form-label">Trailer embed URL</label>
        <input type="url" class="form-control" id="trailer_url" name="trailer_url"
               value="<?= htmlspecialchars($film['trailer_url'] ?? '') ?>">
    </div>

    <div class="col-12 pt-2">
        <button type="submit" class="btn btn-primary px-4"><?= htmlspecialchars($submitLabel) ?></button>
        <a href="/admin/films" class="btn btn-link">Cancel</a>
    </div>
</form>
