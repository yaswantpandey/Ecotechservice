<?php
// ============================================================
// Ecotech Service — Public event pages
// ============================================================

require_once ROOT_PATH . '/app/controllers/BaseController.php';

class EventController extends BaseController {

    /**
     * Events & Builder Sprints Hub (/events).
     */
    public function index(): void
    {
        $this->view('events/index', [
            'pageTitle'       => 'Tech Events, Hackathons & Builder Sprints | ' . APP_NAME,
            'metaDescription' => 'Explore upcoming hackathons, architecture clinics, and engineering workshops hosted or mentored by Ecotech Service. Free participation for student and professional builders.',
            'metaKeywords'    => 'tech events, hackathons india 2027, hack2skill sudarshan, developer sprints, architecture clinics, engineering workshops, ecotech service',
            'canonicalPath'   => 'events',
            'ogImage'         => url('assets/img/logo.png'),
        ]);
    }

    /**
     * Hack2Skill × Sudarshan hackathon.
     *
     * Every fact shown on the page is read from $event, $tracks, $timeline,
     * $rewards and $judging below, so the copy can be corrected from one
     * place. Values tagged CONFIRM are placeholders — replace them with the
     * official numbers from the Hack2Skill event listing before publishing.
     */
    public function hack2skillXSudarshan(): void
    {
        $event = [
            'slug'        => 'hack2skill-x-sudarshan',
            'name'        => 'Hack2Skill × Sudarshan Hackathon',
            'partner'     => 'Hack2Skill',
            'host'        => 'Sudarshan',
            'tagline'     => 'A 36-hour build sprint for teams solving real problems in manufacturing, materials and the supply chain that feeds them.',
            'summary'     => 'Ecotech Service is on the mentor panel. We will be in the room for the full build window — reviewing architecture, unblocking deployments and helping teams ship something that actually runs.',
            'starts'      => '2027-01-09T09:00:00+05:30', // CONFIRM
            'ends'        => '2027-01-10T21:00:00+05:30', // CONFIRM
            'mode'        => 'Hybrid — online shortlisting, in-person finale', // CONFIRM
            'venue'       => 'Pune, Maharashtra (venue shared with shortlisted teams)', // CONFIRM
            'team_size'   => '2 to 4 members',
            'eligibility' => 'Students, recent graduates and working professionals in India, 18 and above', // CONFIRM
            'fee'         => 'Free to enter',
            'register_url'      => 'https://hack2skill.com/hackathons-listing', // CONFIRM — link to the event page
            'registration_note' => 'Registration closes 18 December 2026, 23:59 IST', // CONFIRM
            'mentor_note' => 'Ecotech Service reviews architecture and deployment questions during the build window.',
            'email'       => 'ecotech.servic@gmail.com',
        ];

        $tracks = [
            [
                'name'  => 'Plant-floor intelligence',
                'brief' => 'Turn machine, sensor or log data into something an operator can act on inside a shift — anomaly detection, downtime prediction, quality drift.',
            ],
            [
                'name'  => 'Materials and formulation',
                'brief' => 'Tools that shorten the loop between a formulation request and a validated result: experiment tracking, property prediction, specification search.',
            ],
            [
                'name'  => 'Supply chain visibility',
                'brief' => 'Traceability from raw material to dispatch, with honest answers about delays, batch status and inventory held across partners.',
            ],
            [
                'name'  => 'Sustainability reporting',
                'brief' => 'Measure and report emissions, water use or waste against a real audit standard without a spreadsheet holding the whole thing together.',
            ],
        ];

        $timeline = [
            ['date' => '2026-11-16', 'label' => 'Registrations open',            'detail' => 'Team registration and problem statement release on Hack2Skill.'],
            ['date' => '2026-12-18', 'label' => 'Registration closes',           'detail' => 'Final date to register a team and submit the idea abstract.'],
            ['date' => '2026-12-22', 'label' => 'Shortlist announced',           'detail' => 'Selected teams are published and invited to the finale.'],
            ['date' => '2027-01-09', 'label' => 'Build window opens',            'detail' => 'Opening briefing, track walkthrough, then the clock starts.'],
            ['date' => '2027-01-10', 'label' => 'Submissions and final pitch',   'detail' => 'Code freeze, five-minute pitches, judging and results.'],
        ];

        $rewards = [
            ['place' => 'Winner',        'value' => '₹50,000', 'note' => 'Cash prize, Hack2Skill certificate and a fast-track interview with the Sudarshan technology team.'],
            ['place' => 'First runner-up',  'value' => '₹25,000', 'note' => 'Cash prize and certificate.'],
            ['place' => 'Second runner-up', 'value' => '₹15,000', 'note' => 'Cash prize and certificate.'],
            ['place' => 'Track winners',    'value' => '₹5,000 each', 'note' => 'One award per track, judged separately from the overall podium.'],
        ];

        $judging = [
            ['Problem fit',        '25%', 'Does the build address the track it entered, or a nearby problem that was easier to demo?'],
            ['Working software',   '30%', 'A deployed, clickable product scores over slides describing one.'],
            ['Technical depth',    '20%', 'Data handling, architecture choices and how the team defends them under questioning.'],
            ['Usability',          '15%', 'Can the intended user finish the core task without a walkthrough?'],
            ['Path to production', '10%', 'What it would take to run this for a real plant or partner, including cost and risk.'],
        ];

        $faqs = [
            ['Who can take part?',
             'Teams of two to four, aged 18 or above, studying or working in India. Solo entries are not accepted, but we run a team-formation thread on the Hack2Skill community before registration closes.'],
            ['Is there a registration fee?',
             'No. Entry is free for every selected team, and meals are provided at the in-person finale. Travel is not reimbursed.'],
            ['What can we build with?',
             'Any stack. There is no mandated platform. If you want a starting point, our internship tracks use PHP, MySQL, React and Postgres — but a well-built product in another language is judged the same way.'],
            ['Do we need a finished product at registration?',
             'No. Registration needs a team and a short abstract describing the problem and your intended approach. The build happens on site.'],
            ['Will Ecotech Service review our code?',
             'Yes. Our engineers are available through the build window for architecture and deployment reviews. Ask for a slot at the mentor desk — we do not touch your repository directly.'],
            ['Who owns the intellectual property?',
             'The team keeps ownership of what it builds. Sudarshan and Hack2Skill receive a non-exclusive licence to showcase the project for judging and promotion. Full terms are in the Hack2Skill event listing.'],
        ];

        $this->view('events/hack2skill_x_sudarshan', [
            'event'    => $event,
            'tracks'   => $tracks,
            'timeline' => $timeline,
            'rewards'  => $rewards,
            'judging'  => $judging,
            'faqs'     => $faqs,

            'pageTitle'       => 'Hack2Skill × Sudarshan Hackathon — dates, tracks and prizes | ' . APP_NAME,
            'metaDescription' => 'Hack2Skill and Sudarshan are running a 36-hour hybrid hackathon for manufacturing, materials and supply chain teams. Dates, tracks, prizes, judging criteria and how to register.',
            'metaKeywords'    => 'hack2skill sudarshan hackathon, hackathon 2027, manufacturing hackathon India, materials innovation challenge, hybrid hackathon Pune, ecotech service events',
            'canonicalPath'   => 'events/' . $event['slug'],
            'ogImage'         => url('assets/img/logo.png'),
        ]);
    }
}
