<?php
namespace Controllers;
// film manager: crud complet pentru filme, rezervat rolurilor admin si manager

use Models\Film;
use Helpers\CSRF;
use Helpers\Security;

class FilmManagerController extends BaseController {
    protected $layout = 'admin';
    private $filmModel;

    public function __construct() {
        parent::__construct();
        // separarea rolurilor: crew are acces la dashboard, dar nu si la crud
        $this->requireRole('manager');
        $this->filmModel = new Film();
    }

    public function index() {
        $films = $this->filmModel->findAll([], 'release_year DESC, title ASC');
        $this->render('admin/films/index', [
            'title' => 'Film manager',
            'films' => $films
        ]);
    }

    public function create() {
        $this->render('admin/films/create', [
            'title'      => 'Add film',
            'csrf_token' => CSRF::generateCSRFToken()
        ]);
    }

    public function store() {
        $this->guardPost();

        $data = $this->collect();
        $data['slug'] = Security::slugify($data['title']);

        if ($data['title'] === '') {
            $_SESSION['error'] = 'The title is required.';
            $this->redirect('/admin/films/create');
        }

        if ($this->filmModel->create($data)) {
            $_SESSION['success'] = 'Film created successfully.';
        } else {
            $_SESSION['error'] = 'Failed to create the film.';
        }

        $this->redirect('/admin/films');
    }

    public function edit($id) {
        $film = $this->filmModel->find((int) $id);
        if (!$film) {
            $_SESSION['error'] = 'That film does not exist.';
            $this->redirect('/admin/films');
        }

        $this->render('admin/films/edit', [
            'title'      => 'Edit film',
            'film'       => $film,
            'csrf_token' => CSRF::generateCSRFToken()
        ]);
    }

    public function update($id) {
        $this->guardPost();

        if ($this->filmModel->update((int) $id, $this->collect())) {
            $_SESSION['success'] = 'Film updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update the film.';
        }

        $this->redirect('/admin/films');
    }

    public function delete($id) {
        $this->guardPost();

        // stergerea este permisa doar administratorului
        $this->requireRole('admin');

        if ($this->filmModel->delete((int) $id)) {
            $_SESSION['success'] = 'Film deleted successfully.';
        } else {
            $_SESSION['error'] = 'Failed to delete the film.';
        }

        $this->redirect('/admin/films');
    }

    // citim campurile permise dintr-un singur loc, ca sa nu repetam codul
    private function collect() {
        return [
            'title'        => Security::clean($_POST['title'] ?? ''),
            'synopsis'     => Security::clean($_POST['synopsis'] ?? ''),
            'release_year' => (int) ($_POST['release_year'] ?? date('Y')),
            'genre'        => Security::clean($_POST['genre'] ?? ''),
            'poster'       => Security::clean($_POST['poster'] ?? ''),
            'trailer_url'  => Security::clean($_POST['trailer_url'] ?? ''),
            'status'       => in_array($_POST['status'] ?? '', ['development', 'production', 'post-production', 'released'], true)
                ? $_POST['status']
                : 'development'
        ];
    }

    private function guardPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/films');
        }
        if (!CSRF::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            http_response_code(403);
            die('Invalid CSRF token');
        }
    }
}
