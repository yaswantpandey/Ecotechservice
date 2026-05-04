<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

class AboutController extends BaseController {

    public function index(): void {
        $this->view('about', [
            'pageTitle' => 'About Us - ' . APP_NAME,
            'metaDescription' => 'Learn about Ecotech Service, a digital solutions team focused on sustainable web development, marketing, and technology services for growing businesses.',
            'canonicalPath' => 'about',
        ]);
    }
}
