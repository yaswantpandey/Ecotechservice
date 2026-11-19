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
            'pageTitle'       => 'PromptWars & Tech Hackathons | ' . APP_NAME,
            'metaDescription' => 'Explore PromptWars × Sudarshan and developer build sprints co-hosted and mentored by Ecotech Services. Free participation, ₹20,000 prize pool, $400 AI credits.',
            'metaKeywords'    => 'promptwars, sudarshan hackathon, hack2skill prompt wars, ecotech services events, ai hackathon 2026, vibe coding, prompt engineering india',
            'canonicalPath'   => 'events',
            'ogImage'         => 'https://h2svision.github.io/publicAssets/vision/community-prompt-wars/promptwars-banner-image.webp',
        ]);
    }

    /**
     * Backward-compatible handler for /events/hack2skill-x-sudarshan
     */
    public function hack2skillXSudarshan(): void
    {
        $this->promptwarsXSudarshan();
    }

    /**
     * Official PromptWars × Sudarshan Hackathon (/events/promptwars-x-sudarshan)
     * Data synchronized from official Hack2Skill event listing:
     * https://hack2skill.com/event/promptwars-x-sudarshan
     */
    public function promptwarsXSudarshan(): void
    {
        $event = [
            'slug'        => 'promptwars-x-sudarshan',
            'alias_slug'  => 'hack2skill-x-sudarshan',
            'name'        => 'PromptWars × Sudarshan',
            'partner'     => 'Hack2Skill',
            'host'        => 'Sudarshana',
            'co_host'     => 'Ecotech Services',
            'tagline'     => 'The Ultimate Vibe-Coding & Rapid Prototyping Hackathon',
            'summary'     => 'Welcome to PromptWars × Sudarshan — an ultimate high-energy vibe-coding and rapid prototyping hackathon where innovation meets pure execution. Brought to you in collaboration with Ecotech Services, Google for Developers, and Hack2Skill, this nationwide initiative challenges developers, AI practitioners, and student innovators across India to build functional AI solutions under real-world constraints.',
            'starts'      => '2026-11-19T08:00:00+05:30',
            'ends'        => '2026-11-23T18:00:00+05:30',
            'mode'        => '100% Online — Remote Pan-India Hackathon',
            'venue'       => 'Online / Remote (Hack2Skill Platform & WhatsApp Community)',
            'team_size'   => 'Solo / 1 Member (Individual Participation)',
            'eligibility' => 'Students, developers, and AI enthusiasts across India (Age 16+)',
            'fee'         => 'Free to enter (Zero registration fee)',
            'register_url'      => 'https://hack2skill.com/event/promptwars-x-sudarshan',
            'registration_cta'  => 'https://hack2skill.com/event/promptwars-x-sudarshan/registration',
            'whatsapp_url'      => 'https://chat.whatsapp.com/Kvfa52JBqCM25KGW5qNk2G?s=cl&p=a&mlu=4&ilr=4&iam=2',
            'registration_note' => 'Registration closes 19 November 2026, 23:59 IST',
            'submission_note'   => 'Submission window: 19 Nov 2026, 08:00 AM IST – 21 Nov 2026, 12:00 PM IST',
            'mentor_note'       => 'Ecotech Services leadership sits on the jury and mentor panel — providing live architecture reviews, prompt guidance, and offering internship tracks to standout builders.',
            'email'             => 'contact@yaswant.co.in',
            'alt_email'         => 'ecotech.servic@gmail.com',
            'phone'             => '+91 7398301184',
            'prize_pool'        => '₹20,000 INR + $400 AI Credits',
            'banner_image'      => 'https://h2svision.github.io/publicAssets/vision/community-prompt-wars/promptwars-banner-image.webp',
            'logo_image'        => 'https://h2svision.github.io/publicAssets/vision/community-prompt-wars/pwc_logo.webp',
            'sudarshan_logo'    => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER01806912/1794994610931-Sudarshan.webp',
        ];

        $tracks = [
            [
                'id'       => 'ps1',
                'name'     => 'AI Multi-Agent Crisis Command Centre',
                'category' => 'Disaster & Public Safety',
                'image'    => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER02324450/1794532934045-ps1crisiscommandcentre.webp',
                'context'  => 'During floods, fires, and accidents, critical information is fragmented across social media, local news, emergency helplines, and weather sensors.',
                'brief'    => 'Build a multi-agent system that aggregates live crisis feeds into a unified command dashboard, filters out noise, duplicates, and fabricated reports, prioritizes emergencies by severity, and generates clear action plans for first responders.',
                'tags'     => ['Multi-Agent Systems', 'Crisis Intelligence', 'Live Deduplication', 'Emergency Dispatch'],
            ],
            [
                'id'       => 'ps2',
                'name'     => 'Adaptive AI Tutor',
                'category' => 'Education & Skill Building',
                'image'    => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER02324450/1794533079078-ps2adaptiveaitutor.webp',
                'context'  => 'Traditional instruction treats every student uniformly, failing to address unique cognitive roadblocks or language barriers.',
                'brief'    => 'Build an intelligent tutoring agent that analyzes student responses to diagnose conceptual gaps, explains difficult topics in three distinct modalities (bilingual in Hindi or English, real-world analogies, and step-by-step logic), and generates personalized adaptive assessments.',
                'tags'     => ['Adaptive Learning', 'Bilingual AI (Hindi/English)', 'Misconception Analysis', 'Personalized STEM'],
            ],
            [
                'id'       => 'ps3',
                'name'     => 'Fake News & Deepfake Verifier',
                'category' => 'Misinformation & Digital Trust',
                'image'    => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER02324450/1794533168861-ps3fakenewsverifier.webp',
                'context'  => 'Viral misinformation, doctored claims, and synthetic media spread unchecked through messaging apps and social channels.',
                'brief'    => 'Build an automated verification pipeline where users submit text, images, or media URLs. The tool deconstructs the claim, cross-references credible journalistic records and knowledge bases, and delivers an evidence-backed verdict (True, False, or Unverified) with transparent reasoning.',
                'tags'     => ['Digital Forensics', 'Claim Verification', 'Multimodal Fact Checking', 'Deepfake Detection'],
            ],
            [
                'id'       => 'ps4',
                'name'     => 'Open Innovation with Essential AI',
                'category' => 'Open Innovation',
                'image'    => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER02324450/1794533304685-ps8openinnovation.webp',
                'context'  => 'Tackle a real-world problem where generative AI and prompt intelligence perform the core heavy lifting rather than acting as a thin API wrapper.',
                'brief'    => 'Identify an authentic problem in healthcare, commerce, developer tools, or public governance and build an end-to-end, functional solution. Judges reward originality, technical depth, prompt architecture, and practical production viability.',
                'tags'     => ['Vibe Coding', 'Autonomous Workflows', 'Generative Prototyping', 'Production Systems'],
            ],
        ];

        $timeline = [
            [
                'date'   => '2026-11-04',
                'time'   => '12:00 AM IST',
                'label'  => 'Registrations Open',
                'detail' => 'Official registration goes live on Hack2Skill. Problem statements and challenge tracks published.',
            ],
            [
                'date'   => '2026-11-19',
                'time'   => '11:59 PM IST',
                'label'  => 'Registration Closes',
                'detail' => 'Final deadline to register on the Hack2Skill portal and join the builder WhatsApp group.',
            ],
            [
                'date'   => '2026-11-19',
                'time'   => '08:00 AM IST',
                'label'  => 'Submission Window Opens',
                'detail' => 'Project submission portal opens. Participants submit project descriptions, working demo links, and GitHub repositories.',
            ],
            [
                'date'   => '2026-11-21',
                'time'   => '12:00 PM IST',
                'label'  => 'Code Freeze & Submissions Close',
                'detail' => 'Final cutoff for project submissions. Repositories, demo videos, and architecture overviews must be locked.',
            ],
            [
                'date'   => '2026-11-22',
                'time'   => '05:00 PM IST',
                'label'  => 'Grand Finale & Live Evaluation',
                'detail' => 'Finalists demonstrate their working solutions to the evaluation panel. Live QA and scoring.',
            ],
            [
                'date'   => '2026-11-23',
                'time'   => '06:00 PM IST',
                'label'  => 'Results & Awards Announcement',
                'detail' => 'Announcement of winners, distribution of ₹20,000 cash prizes, $400 AI credits, and internship offers.',
            ],
        ];

        $rewards = [
            [
                'place' => 'Cash Prize Pool',
                'value' => '₹20,000 INR',
                'note'  => 'Direct monetary cash rewards distributed to winning projects across the challenge tracks.',
            ],
            [
                'place' => 'AI Cloud Credits',
                'value' => '$400 USD',
                'note'  => 'Generative AI platform and cloud infrastructure credits to scale and deploy winning solutions.',
            ],
            [
                'place' => 'Ecotech Internships',
                'value' => 'Exclusive Offers',
                'note'  => 'Top performers receive direct interview slots and engineering internship opportunities with Ecotech Services.',
            ],
            [
                'place' => 'Digital Credentials',
                'value' => 'Hack2Skill Verified',
                'note'  => 'Official digital badges and verified certificates of completion awarded through the Hack2Skill platform.',
            ],
        ];

        $judging = [
            ['Working Software & Execution', '30%', 'Does the build actually run? Interactive, functional AI prototypes score significantly higher than conceptual slide decks.'],
            ['Problem Fit & Depth',         '25%', 'Does the project genuinely solve the core track problem, or is it a generic chatbot wrapper? Depth of real-world fit.'],
            ['Technical Depth & Prompting',  '20%', 'Sophistication of prompt engineering, model orchestration, system architecture, error recovery, and data flow.'],
            ['Usability & UX Experience',   '15%', 'How easily can a judge or end-user test the solution? Intuitive interface, clear visual feedback, and low friction.'],
            ['Production Feasibility',       '10%', 'Feasibility of scaling, latency management, API cost-efficiency, and resilience in a real deployment.'],
        ];

        $jury = [
            [
                'name'         => 'Yaswant Pandey',
                'role'         => 'Founder, Ecotech Services',
                'organization' => 'Ecotech Services',
                'image'        => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER01806912/1793780990125-favicon.ico',
                'linkedin'     => 'https://www.linkedin.com/in/yaswantpandey',
                'github'       => 'https://github.com/yaswantpandey',
            ],
            [
                'name'         => 'Anjanee Kumar Yadav',
                'role'         => 'Technical Coordinator',
                'organization' => 'AIMT Lucknow',
                'image'        => '',
                'linkedin'     => '',
                'github'       => '',
            ],
            [
                'name'         => 'Abhay Trivedi',
                'role'         => 'Agentic AI Specialist',
                'organization' => 'AI Practitioner',
                'image'        => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER01806912/1794996853685-abhay.webp',
                'linkedin'     => 'https://www.linkedin.com/in/abhay-trivedi-a280213aa/',
                'instagram'    => 'https://www.instagram.com/agenticabhay.ai',
            ],
        ];

        $mentors = [
            [
                'name'         => 'Rupesh Kumar',
                'role'         => 'Co-Founder, Ecotech Services',
                'organization' => 'Ecotech Services',
                'image'        => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER01806912/1793780990125-favicon.ico',
                'linkedin'     => 'https://www.linkedin.com/in/rupesh-kumar-2b7756369?utm_source=share_via&utm_content=profile&utm_medium=member_android',
                'github'       => 'https://github.com/Lucifer330',
            ],
            [
                'name'         => 'Anand Kumar',
                'role'         => 'Founder, Techverse India',
                'organization' => 'Techverse India',
                'image'        => '',
                'linkedin'     => '',
                'github'       => '',
            ],
        ];

        $partners = [
            [
                'name'  => 'Ecotech Services',
                'role'  => 'Technical & Mentorship Partner',
                'url'   => 'https://ecotechservices.tech',
                'image' => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER01806912/1793781552253-Screenshot20261104140846.webp',
            ],
            [
                'name'  => 'Hack2Skill',
                'role'  => 'Platform Partner',
                'url'   => 'https://hack2skill.com',
                'image' => 'https://h2svision.github.io/publicAssets/vision/community-prompt-wars/pwc_partners_1.webp',
            ],
            [
                'name'  => 'Google for Developers',
                'role'  => 'Ecosystem Partner',
                'url'   => 'https://developers.google.com',
                'image' => 'https://h2svision.github.io/publicAssets/vision/community-prompt-wars/pwc_partner_2.webp',
            ],
            [
                'name'  => 'Major League Hacking (MLH)',
                'role'  => 'Community Partner',
                'url'   => 'https://www.mlh.com/',
                'image' => 'https://storage.googleapis.com/vision-hack2skill-production/innovator/USER01806912/1794816025837-Screenshot20261116132943.webp',
            ],
        ];

        $faqs = [
            [
                'Is this an online or offline hackathon?',
                'This is a completely online hackathon. Participants can take part remotely from anywhere in India without needing to travel.',
            ],
            [
                'What is PromptWars × Sudarshan?',
                'PromptWars × Sudarshan is an online hackathon focused on Generative AI, Prompt Engineering, Vibe Coding, and rapid prototyping, organized by Sudarshana in collaboration with EcoTech Services, Google for Developers, and Hack2Skill.',
            ],
            [
                'What are the prizes and rewards?',
                'Participants compete for a total prize pool of ₹20,000 INR cash, $400 USD in AI credits, verified Hack2Skill achievement badges, and exclusive engineering internship opportunities with Ecotech Services for top performers.',
            ],
            [
                'Who can participate and what is the team size?',
                'This challenge is open to solo builders, developers, and AI enthusiasts across India (1 member per registration, ages 16+).',
            ],
            [
                'What should a final submission include?',
                'Submissions should include a clear project summary, selected problem statement, architectural approach, prompt/model details, and a working demo or public GitHub repository link.',
            ],
            [
                'Do I need a GitHub or LinkedIn account?',
                'Having a GitHub account is recommended for submitting your project code and deployment links. LinkedIn is useful for networking and showcasing verified achievement badges.',
            ],
            [
                'Where can I get help or clarification during the event?',
                'You can reach the organizing team via our official WhatsApp community group, or email us at contact@yaswant.co.in or ecotech.servic@gmail.com.',
            ],
        ];

        $this->view('events/hack2skill_x_sudarshan', [
            'event'    => $event,
            'tracks'   => $tracks,
            'timeline' => $timeline,
            'rewards'  => $rewards,
            'judging'  => $judging,
            'jury'     => $jury,
            'mentors'  => $mentors,
            'partners' => $partners,
            'faqs'     => $faqs,

            'pageTitle'       => 'PromptWars × Sudarshan Hackathon — Tracks, Timeline & Prizes | ' . APP_NAME,
            'metaDescription' => 'PromptWars × Sudarshan is an online AI hackathon co-hosted by Ecotech Services, Hack2Skill, and Sudarshana. ₹20,000 prize pool, $400 AI credits, 4 tracks, and internship tracks.',
            'metaKeywords'    => 'promptwars x sudarshan, hack2skill hackathon, vibe coding hackathon, ecotech services event, ai prompt hackathon 2026, google for developers india, online hackathon',
            'canonicalPath'   => 'events/' . $event['slug'],
            'ogImage'         => $event['banner_image'],
        ]);
    }
}
