<?php
// formular reutilizat de create si edit pentru talente
/** @var array $talent */
/** @var array $roleTypes */
/** @var string $formAction */
/** @var string $submitLabel */
/** @var string $csrf_token */
?>
<h1 class="h3 mb-4"><?= htmlspecialchars($title) ?></h1>

<form method="POST" action="<?= htmlspecialchars($formAction) ?>" class="row g-3 col-lg-9">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

    <div class="col-md-7">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required
               value="<?= htmlspecialchars($talent['name'] ?? '') ?>">
    </div>

    <div class="col-md-5">
        <label for="role_type" class="form-label">Role</label>
        <select class="form-select" id="role_type" name="role_type">
            <?php foreach ($roleTypes as $roleType): ?>
                <option value="<?= $roleType ?>" <?= (($talent['role_type'] ?? '') === $roleType) ? 'selected' : '' ?>>
                    <?= ucfirst($roleType) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-12">
        <label for="bio" class="form-label">Biography</label>
        <textarea class="form-control" id="bio" name="bio" rows="5"><?= htmlspecialchars($talent['bio'] ?? '') ?></textarea>
    </div>

    <div class="col-12">
        <label for="photo" class="form-label">Photo URL</label>
        <input type="url" class="form-control" id="photo" name="photo"
               value="<?= htmlspecialchars($talent['photo'] ?? '') ?>">
    </div>

    <div class="col-12 pt-2">
        <button type="submit" class="btn btn-primary px-4"><?= htmlspecialchars($submitLabel) ?></button>
        <a href="/admin/talents" class="btn btn-link">Cancel</a>
    </div>
</form>
