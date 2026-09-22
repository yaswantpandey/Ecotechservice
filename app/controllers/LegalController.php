<?php
require_once ROOT_PATH . '/app/controllers/BaseController.php';

/**
 * Legal pages — Privacy Policy and Terms of Service.
 * Both are linked from the sitewide footer and are real, substantive documents.
 */
class LegalController extends BaseController {

    /** Last substantive revision of the legal documents. */
    private const REVISED = '2026-09-22';

    public function privacy(): void {
        $this->view('legal/privacy', [
            'revised'         => self::REVISED,
            'pageTitle'       => 'Privacy Policy & Data Handling | ' . APP_NAME,
            'metaDescription' => 'How EcoTech Services collects, processes, stores and deletes data — including client production data handled during engineering engagements, sub-processors, retention periods and your rights.',
            'metaKeywords'    => 'ecotech services privacy policy, data handling, data processing agreement, DPDP Act compliance, subprocessors',
            'canonicalPath'   => 'privacy',
        ]);
    }

    public function terms(): void {
        $this->view('legal/terms', [
            'revised'         => self::REVISED,
            'pageTitle'       => 'Terms of Service | ' . APP_NAME,
            'metaDescription' => 'Terms governing EcoTech Services engineering engagements: scope and change control, intellectual property and code ownership, fees, confidentiality, warranties, liability and termination.',
            'metaKeywords'    => 'ecotech services terms of service, engineering engagement terms, code ownership, service agreement',
            'canonicalPath'   => 'terms',
        ]);
    }
}
