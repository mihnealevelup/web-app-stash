<?php
// listarea talentelor in panoul de administrare
use Helpers\TableGenerator;
use Helpers\CSRF;
use Services\AuthService;

/** @var array $talents */
$actions = [
    ['label' => 'Edit', 'url' => '/admin/talents/edit/:id', 'class' => 'btn-outline-primary']
];
if (AuthService::hasRole('admin')) {
    $actions[] = [
        'label'   => 'Delete',
        'url'     => '/admin/talents/delete/:id',
        'class'   => 'btn-outline-danger',
        'method'  => 'post',
        'confirm' => 'Delete this talent permanently?'
    ];
}
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Talents</h1>
    <a href="/admin/talents/create" class="btn btn-primary">Add talent</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">
        <?= TableGenerator::render($talents, [
            'id'        => '#',
            'name'      => 'Name',
            'role_type' => 'Role'
        ], $actions, CSRF::generateCSRFToken()) ?>
    </div>
</div>
