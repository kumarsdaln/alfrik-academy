<?php

namespace Database\Seeders;

use App\Models\Insight;
use App\Models\JobPost;
use App\Models\Course;
use App\Models\LearnerStory;
use App\Models\User;
use App\Models\WebinarEvent;
use App\Data\PublicCatalog;
use Illuminate\Database\Seeder;

class DiscoveryDemoSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->where('email', 'admin@northstar.test')->first();
        if (! $author) {
            return;
        }

        foreach (PublicCatalog::stories() as $story) {
            LearnerStory::query()->updateOrCreate(['slug' => $story['slug']], [
                'course_id' => Course::query()->where('slug', $story['course_slug'])->value('id'),
                'name' => $story['name'], 'role' => $story['role'], 'cohort' => $story['cohort'],
                'outcome' => $story['outcome'], 'quote' => $story['quote'], 'story' => $story['story'],
                'color' => $story['color'], 'status' => 'published', 'published_at' => now()->subDays(2),
            ]);
        }

        foreach ([
            ['title' => 'How to turn a live class project into a portfolio story', 'slug' => 'portfolio-story-from-live-project', 'type' => 'article', 'category' => 'Career craft', 'excerpt' => 'A clear process for documenting your decisions, showing your work, and making a project easy for a hiring team to understand.', 'body' => "A strong portfolio project tells a story: what problem you explored, what you learned, what you tried, and how the final work changed along the way.\n\nStart with the context. Describe the audience and constraints in plain language. Then show a few meaningful iterations rather than only the polished final screen. Explain what feedback changed your direction and why.\n\nFinish with the outcome and the next question you would explore. In a live cohort, your mentor and classmates can help you find the clearest evidence of your thinking.", 'reading_minutes' => 3],
            ['title' => 'Kanram opens a monthly mentor office hour', 'slug' => 'monthly-mentor-office-hours', 'type' => 'news', 'category' => 'Academy news', 'excerpt' => 'Learners and alumni can bring portfolio questions, career goals, and work-in-progress to a rotating live mentor session.', 'body' => "Starting this month, Kanram learners and alumni can join a live mentor office hour on the last Thursday of each month.\n\nEach session will include a short introduction from a working practitioner, followed by small-group portfolio and career conversations. Sign-up details will be shared with enrolled learners through their course workspace.", 'reading_minutes' => 2],
            ['title' => 'Build a more useful creative portfolio', 'slug' => 'creative-portfolio-workshop', 'type' => 'event', 'category' => 'Live event', 'excerpt' => 'A practical online workshop on choosing projects, explaining your process, and making your portfolio easier to navigate.', 'body' => "Join the Kanram mentor team for a guided portfolio workshop. Bring one project you are currently working on and leave with a clearer outline, a stronger case study structure, and peer feedback.\n\nThis online event is open to active learners and alumni. The next date will be announced soon.", 'reading_minutes' => 2],
        ] as $attributes) {
            Insight::query()->updateOrCreate(['slug' => $attributes['slug']], [
                ...$attributes, 'author_id' => $author->id, 'status' => 'published', 'published_at' => now()->subDays(3),
            ]);
        }

        foreach ([
            ['title' => 'Demo listing — Junior Product Designer', 'slug' => 'demo-junior-product-designer', 'company' => 'Sample community partner', 'location' => 'Remote · India', 'workplace_type' => 'remote', 'employment_type' => 'full_time', 'seniority' => 'Early career', 'salary_range' => '₹6–9 LPA (sample)', 'summary' => 'A sample opportunity showing how early-career roles appear in the Kanram community board.', 'description' => "This is a clearly labelled sample listing for previewing the community careers board. Replace or remove it before sharing real roles.\n\nThe sample role highlights collaboration, accessible product thinking, and an eagerness to learn from a multidisciplinary team.", 'skills' => ['Figma', 'Prototyping', 'Product thinking']],
            ['title' => 'Demo listing — Content Design Intern', 'slug' => 'demo-content-design-intern', 'company' => 'Sample community partner', 'location' => 'Hybrid · Bengaluru', 'workplace_type' => 'hybrid', 'employment_type' => 'internship', 'seniority' => 'Internship', 'salary_range' => 'Paid internship (sample)', 'summary' => 'A sample internship listing for learners interested in writing clear, helpful product experiences.', 'description' => "This is a clearly labelled sample listing for previewing the community careers board. Replace or remove it before sharing real roles.\n\nThe sample role works with designers and researchers to make product journeys easier to understand.", 'skills' => ['Writing', 'Research', 'UX content']],
        ] as $attributes) {
            JobPost::query()->updateOrCreate(['slug' => $attributes['slug']], [
                ...$attributes, 'posted_by' => $author->id, 'status' => 'published', 'published_at' => now()->subDay(),
            ]);
        }

        $events = [
            [
                'slug' => 'sample-live-product-discovery-webinar',
                'title' => 'Sample webinar: Find the story behind a product problem',
                'event_type' => 'webinar',
                'summary' => 'A preview event for the Kanram live learning series. Explore how good questions and shared critique can turn a vague idea into a useful direction.',
                'description' => "This sample listing demonstrates the webinar experience. Replace it with your real event details and add the meeting room link in the admin workspace before inviting attendees.\n\nIn this live session, we will practice moving from assumptions to useful questions, compare ways to make sense of what people tell us, and share a simple next step you can bring to your own work.",
                'cover_image' => '/images/learning/live-class.png',
                'starts_at' => now('Asia/Kolkata')->addDays(14)->setTime(18, 30),
                'duration_minutes' => 60, 'host_name' => 'Maya Chen', 'host_title' => 'Product design lead · Kanram mentor',
                'capacity' => 60, 'price_minor' => 0, 'currency' => 'inr',
            ],
            [
                'slug' => 'demo-portfolio-story-clinic',
                'title' => 'Demo event: Portfolio story clinic',
                'event_type' => 'workshop',
                'summary' => 'Bring one project and shape it into a clear, compelling case study with mentor feedback.',
                'description' => "This demo workshop shows how a paid, small-group event appears on the Kanram site. Bring a project you are proud of and one question you are still working through.\n\nWe will outline the problem, identify the decisions that shaped your work, and practice presenting the result. Each participant will leave with a stronger case study outline and practical feedback.",
                'cover_image' => '/images/learning/maya-chen.png',
                'starts_at' => now('Asia/Kolkata')->addDays(21)->setTime(17, 0),
                'duration_minutes' => 90, 'host_name' => 'Maya Chen', 'host_title' => 'Product design lead · Kanram mentor',
                'capacity' => 24, 'price_minor' => 49900, 'currency' => 'inr',
            ],
            [
                'slug' => 'demo-designing-with-ai-webinar',
                'title' => 'Demo webinar: Designing thoughtfully with AI',
                'event_type' => 'webinar',
                'summary' => 'A practical conversation about where AI can help a design team and where human judgment matters most.',
                'description' => "This sample webinar explores practical ways to bring AI tools into a design workflow while keeping research, accessibility, and human judgment at the center.\n\nWe will look at useful prompts, discuss common failure modes, and leave time for questions from the audience.",
                'cover_image' => '/images/learning/product-design.png',
                'starts_at' => now('Asia/Kolkata')->addDays(28)->setTime(19, 0),
                'duration_minutes' => 60, 'host_name' => 'Ethan Brooks', 'host_title' => 'Product strategist · Kanram mentor',
                'capacity' => 100, 'price_minor' => 14900, 'currency' => 'inr',
            ],
            [
                'slug' => 'demo-career-transitions-roundtable',
                'title' => 'Demo event: Career transitions roundtable',
                'event_type' => 'community_event',
                'summary' => 'Hear how creative professionals navigated a career change, then bring your own next-step questions.',
                'description' => "Join a relaxed, free community conversation about career transitions. Our guests will share what surprised them, which skills carried over, and how they built momentum while changing direction.\n\nThe final half of the session is open Q&A. Bring a question or simply listen in.",
                'cover_image' => '/images/learning/olivia-park.png',
                'starts_at' => now('Asia/Kolkata')->addDays(35)->setTime(18, 0),
                'duration_minutes' => 75, 'host_name' => 'Olivia Park', 'host_title' => 'Career coach · Kanram mentor',
                'capacity' => 80, 'price_minor' => 0, 'currency' => 'inr',
            ],
            [
                'slug' => 'demo-accessible-ux-audit-workshop',
                'title' => 'Demo workshop: Run an accessible UX audit',
                'event_type' => 'workshop',
                'summary' => 'Learn a practical audit process for spotting barriers and prioritizing useful accessibility improvements.',
                'description' => "This hands-on workshop walks through an accessibility audit for a digital product. We will practice keyboard checks, review contrast and content structure, and turn observations into clear recommendations.\n\nNo specialist tools are needed. Participants will receive a sample checklist and time to discuss their own product questions.",
                'cover_image' => '/images/learning/brand-strategy.png',
                'starts_at' => now('Asia/Kolkata')->addDays(42)->setTime(16, 30),
                'duration_minutes' => 90, 'host_name' => 'Maya Chen', 'host_title' => 'Product design lead · Kanram mentor',
                'capacity' => 30, 'price_minor' => 79900, 'currency' => 'inr',
            ],
            [
                'slug' => 'demo-creative-work-and-better-briefs',
                'title' => 'Demo open class: Better briefs for creative work',
                'event_type' => 'open_class',
                'summary' => 'Turn a loose request into a shared brief with clearer goals, constraints, and room to explore.',
                'description' => "Join a free sample open class on writing better creative briefs. We will compare a vague request with a useful brief, surface the questions that unlock context, and practice agreeing on outcomes before work begins.\n\nThis session is welcoming to designers, marketers, founders, and anyone who works with creative teams.",
                'cover_image' => '/images/learning/live-class.png',
                'starts_at' => now('Asia/Kolkata')->addDays(49)->setTime(18, 30),
                'duration_minutes' => 60, 'host_name' => 'Ethan Brooks', 'host_title' => 'Product strategist · Kanram mentor',
                'capacity' => 70, 'price_minor' => 0, 'currency' => 'inr',
            ],
            [
                'slug' => 'demo-shipping-your-first-web-project',
                'title' => 'Demo webinar: Ship your first web project',
                'event_type' => 'webinar',
                'summary' => 'A friendly walkthrough of the decisions behind taking a small web project from local preview to launch.',
                'description' => "This demo webinar introduces the final steps in publishing a small web project. We will cover a simple pre-launch checklist, accessibility and performance basics, and how to choose a hosting setup that fits your needs.\n\nBring questions about your own project for the live Q&A.",
                'cover_image' => '/images/learning/web-development.png',
                'starts_at' => now('Asia/Kolkata')->addDays(56)->setTime(19, 0),
                'duration_minutes' => 60, 'host_name' => 'Sam Rivera', 'host_title' => 'Web developer · Kanram mentor',
                'capacity' => 100, 'price_minor' => 19900, 'currency' => 'inr',
            ],
        ];

        foreach ($events as $event) {
            WebinarEvent::query()->updateOrCreate(['slug' => $event['slug']], [
                ...$event,
                'timezone' => 'Asia/Kolkata',
                'meeting_url' => null,
                'replay_url' => null,
                'status' => 'published',
                'published_at' => now(),
                'created_by' => $author->id,
            ]);
        }
    }
}
