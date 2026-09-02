<?php
namespace Controllers;

use Services\AuthService;
use Models\Film;
use Models\Talent;
use Models\News;

class DashboardController extends BaseController {
    protected $layout = 'admin';

    public function index() {
        $this->requireAuth(); // Orice rol de staff poate accesa dashboard-ul

        $filmModel = new Film();
        $talentModel = new Talent();
        $newsModel = new News();

        $this->render('admin/dashboard', [
            'username' => AuthService::getUsername(),
            'role' => AuthService::getRole(),
            'stats' => [
                'films' => $filmModel->count(),
                'talents' => $talentModel->count(),
                'news' => $newsModel->count(),
            ]
        ]);
    }
}