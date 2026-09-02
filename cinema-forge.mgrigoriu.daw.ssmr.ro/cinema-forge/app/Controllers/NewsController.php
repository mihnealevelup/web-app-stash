<?php
namespace Controllers;
// news: listare stiri (interne din baza de date + parsate din rss extern)

use Models\News;
use Services\RssService;

class NewsController extends BaseController {

    public function index() {
        $newsModel = new News();

        // stirile proprii, administrate din baza de date
        $internal = $newsModel->getInternal();

        // continut parsat dintr-o sursa externa, nu doar un link sau un iframe
        $external = RssService::fetch(RssService::DEFAULT_FEED, 6);

        $this->render('news/index', [
            'title'    => 'News',
            'internal' => $internal,
            'external' => $external,
            'feedName' => RssService::DEFAULT_FEED_NAME
        ]);
    }
}
