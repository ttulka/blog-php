<?php
namespace blog;

require_once 'mvc/Controller.php';

use mvc\Controller;

class SitemapController extends Controller {

    private $sitemap;

    public function __construct(Sitemap $sitemap) {
        $this->sitemap = $sitemap;
    }

    public function sitemap() {
        $this->addModelAttribute('entries', $this->sitemap->entries());
        $this->render('sitemap', 'xml');
    }
}