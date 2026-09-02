<?php
namespace Controllers;
// talent manager: crud pentru regizori, actori, producatori si scenaristi

use Models\Talent;
use Helpers\CSRF;
use Helpers\Security;

class TalentManagerController extends BaseController {
    protected $layout = 'admin';
    private $talentModel;

    const ROLE_TYPES = ['actor', 'director', 'producer', 'writer'];

    public function __construct() {
        parent::__construct();
        $this->requireRole('manager');
        $this->talentModel = new Talent();
    }

    public function index() {
        $talents = $this->talentModel->findAll([], 'role_type ASC, name ASC');
        $this->render('admin/talents/index', [
            'title'   => 'Talent manager',
            'talents' => $talents
        ]);
    }

    public function create() {
        $this->render('admin/talents/create', [
            'title'      => 'Add talent',
            'roleTypes'  => self::ROLE_TYPES,
            'csrf_token' => CSRF::generateCSRFToken()
        ]);
    }

    public function store() {
        $this->guardPost();

        $data = $this->collect();
        if ($data['name'] === '') {
            $_SESSION['error'] = 'The name is required.';
            $this->redirect('/admin/talents/create');
        }

        if ($this->talentModel->create($data)) {
            $_SESSION['success'] = 'Talent created successfully.';
        } else {
            $_SESSION['error'] = 'Failed to create the talent.';
        }

        $this->redirect('/admin/talents');
    }

    public function edit($id) {
        $talent = $this->talentModel->find((int) $id);
        if (!$talent) {
            $_SESSION['error'] = 'That talent does not exist.';
            $this->redirect('/admin/talents');
        }

        $this->render('admin/talents/edit', [
            'title'      => 'Edit talent',
            'talent'     => $talent,
            'roleTypes'  => self::ROLE_TYPES,
            'csrf_token' => CSRF::generateCSRFToken()
        ]);
    }

    public function update($id) {
        $this->guardPost();

        if ($this->talentModel->update((int) $id, $this->collect())) {
            $_SESSION['success'] = 'Talent updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update the talent.';
        }

        $this->redirect('/admin/talents');
    }

    public function delete($id) {
        $this->guardPost();
        $this->requireRole('admin');

        if ($this->talentModel->delete((int) $id)) {
            $_SESSION['success'] = 'Talent deleted successfully.';
        } else {
            $_SESSION['error'] = 'Failed to delete the talent.';
        }

        $this->redirect('/admin/talents');
    }

    private function collect() {
        return [
            'name'      => Security::clean($_POST['name'] ?? ''),
            'role_type' => in_array($_POST['role_type'] ?? '', self::ROLE_TYPES, true)
                ? $_POST['role_type']
                : 'actor',
            'bio'       => Security::clean($_POST['bio'] ?? ''),
            'photo'     => Security::clean($_POST['photo'] ?? '')
        ];
    }

    private function guardPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/talents');
        }
        if (!CSRF::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            die('Invalid CSRF token');
        }
    }
}
