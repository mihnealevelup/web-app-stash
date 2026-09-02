<?php
namespace Controllers;
// public, nu necesita log in

use Models\Film;
use Helpers\TableGenerator;

class CatalogController extends BaseController {

    public function index() {
        $filmModel = new Film();

        // Obtinem parametrii de filtrare
        $genre = $_GET['genre'] ?? null;
        $year = $_GET['year'] ?? null;

        // Construim conditii filtrare (doar filmele lansatevor fi publice pe site)
        $where = ['status' => 'released'];
        if ($genre) {
            $where['genre'] = $genre;
        }
        if ($year) {
            $where['release_year'] = $year;
        }

        $films = $filmModel->findAll($where, 'release_year DESC, title ASC');

        // Obtinem optiuni de filtrare
        $genres = $filmModel->getDistinctGenres();
        $years = $filmModel->getDistinctYears();

        $genreOptions = !empty($genres) ? array_combine($genres, $genres) : [];
        $yearOptions = !empty($years) ? array_combine($years, $years) : [];

        // Generam HTML prin TableGenerator
        $filtersHtml = TableGenerator::renderFilters([
            'genre' => [
                'label' => 'Genres',
                'options' => $genreOptions,
                'selected' => $genre
            ],
            'year' => [
                'label' => 'Years',
                'options' => $yearOptions,
                'selected' => $year
            ]
        ], '/catalog');

        $gridHtml = TableGenerator::renderGrid($films, [
            'image' => 'poster',
            'title' => 'title',
            'subtitle' => 'release_year',
            'link' => '/film/:id',
            'linkText' => 'View Details',
            'defaultImage' => '/assets/images/no-poster.jpg',
            'columns' => 4
        ]);

        $this->render('catalog/index', [
            'title' => 'Film Catalog',
            'filters' => $filtersHtml,
            'grid' => $gridHtml
        ]);
    }
}