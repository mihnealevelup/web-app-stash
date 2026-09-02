<?php
namespace Controllers;
// showcase: pagina individuala a filmului (trailer, sinopsis, casting, galerie)

use Models\Film;

class ShowcaseController extends BaseController {

    public function show($id) {
        $filmModel = new Film();

        // acceptam atat id numeric cat si slug seo-friendly
        $film = ctype_digit((string) $id)
            ? $filmModel->find((int) $id)
            : $filmModel->findBySlug($id);

        if (!$film) {
            http_response_code(404);
            $this->render('showcase/show', [
                'title' => 'Film not found',
                'film'  => null,
                'cast'  => [],
                'crew'  => []
            ]);
            return;
        }

        // grupam echipa pe tipul rolului: actorii separat de restul
        $talents = $filmModel->getTalents($film['id']);
        $cast = [];
        $crew = [];
        foreach ($talents as $talent) {
            if ($talent['role_type'] === 'actor') {
                $cast[] = $talent;
            } else {
                $crew[] = $talent;
            }
        }

        $this->render('showcase/show', [
            'title' => $film['title'],
            'film'  => $film,
            'cast'  => $cast,
            'crew'  => $crew
        ]);
    }
}
