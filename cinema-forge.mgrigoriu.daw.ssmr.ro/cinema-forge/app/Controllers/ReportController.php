<?php
namespace Controllers;
// rapoarte: vizualizare in pagina si export in formate care nu sunt html sau csv

use Models\Film;
use Models\Talent;
use Services\ReportService;

class ReportController extends BaseController {
    protected $layout = 'admin';

    public function __construct() {
        parent::__construct();
        $this->requireRole('manager');
    }

    public function index() {
        $filmModel = new Film();
        $films = $filmModel->findAll([], 'release_year DESC, title ASC');

        // gruparea pe status ne da un rezumat scurt in capul raportului
        $byStatus = [];
        foreach ($films as $film) {
            $status = $film['status'];
            $byStatus[$status] = ($byStatus[$status] ?? 0) + 1;
        }

        $this->render('admin/reports/index', [
            'title'    => 'Reports',
            'films'    => $films,
            'byStatus' => $byStatus
        ]);
    }

    // export excel: deschis nativ de excel si libreoffice
    public function filmsExcel() {
        $films = (new Film())->findAll([], 'release_year DESC, title ASC');
        ReportService::excel('cinema-forge-films', [
            'id' => '#', 'title' => 'Title', 'genre' => 'Genre',
            'release_year' => 'Year', 'status' => 'Status'
        ], $films);
    }

    public function talentsExcel() {
        $talents = (new Talent())->findAll([], 'role_type ASC, name ASC');
        ReportService::excel('cinema-forge-talents', [
            'id' => '#', 'name' => 'Name', 'role_type' => 'Role'
        ], $talents);
    }

    public function filmsCsv() {
        $films = (new Film())->findAll([], 'release_year DESC, title ASC');
        ReportService::csv('cinema-forge-films', [
            'id' => '#', 'title' => 'Title', 'genre' => 'Genre',
            'release_year' => 'Year', 'status' => 'Status'
        ], $films);
    }
}
