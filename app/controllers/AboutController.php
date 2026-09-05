<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class AboutController extends BaseController {

    public function index(): void {
        $this->view('about', [
            'pageTitle'       => 'About Us — Technology Partners & Developers | ' . APP_NAME,
            'metaDescription' => 'Learn about Ecotech Service, our software engineering culture, cybersecurity focus, and our mission to build reliable, high-performance digital products.',
            'metaKeywords'    => 'about ecotech service, web development agency, cybersecurity team, software engineers lucknow, it consulting company',
            'canonicalPath'   => 'about',
        ]);
    }
}
