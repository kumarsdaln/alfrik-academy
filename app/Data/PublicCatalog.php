<?php

namespace App\Data;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PublicCatalog
{
    public static function courses(): array
    {
        $courses = [
            [
                'title' => 'Product Design Sprint', 'slug' => 'product-design-sprint', 'category' => 'Design', 'category_slug' => 'design', 'image' => '/images/learning/product-design.png',
                'mentor' => 'Maya Chen', 'mentor_slug' => 'maya-chen', 'mentor_title' => 'Product design lead · ex-Figma',
                'weeks' => 8, 'price' => 189, 'rating' => 4.9, 'reviews_count' => 128, 'students' => 1240, 'color' => 'violet', 'icon' => '✳',
                'level' => 'Beginner friendly', 'live_classes' => 12, 'recorded_lessons' => 18, 'class_size' => 'Up to 18 learners',
                'next_start' => 'November 9, 2026', 'schedule' => 'Mondays & Wednesdays · 6:30 PM IST', 'duration' => '8 weeks · 2 live classes each week',
                'summary' => 'Go from a rough idea to a polished, tested product experience. Learn with a small cohort and get thoughtful feedback every step of the way.',
                'description' => 'A hands-on product design program for curious people who want to make useful, welcoming digital experiences. You will work on one real product challenge from first interview to final prototype, with live critique and mentor guidance throughout.',
                'outcomes' => ['Turn research into clear product opportunities', 'Map user journeys and shape information architecture', 'Create accessible wireframes and reusable interface systems', 'Prototype, test, and present a product direction'],
                'curriculum' => [
                    ['title' => 'Start with the person', 'weeks' => 'Week 1', 'summary' => 'Find the human story behind a product problem.', 'lessons' => ['Welcome and cohort studio', 'Asking better research questions', 'Interview practice: listen for what matters', 'Synthesis live lab'], 'live' => true],
                    ['title' => 'Make sense of the mess', 'weeks' => 'Week 2', 'summary' => 'Turn observations into a focused opportunity.', 'lessons' => ['Affinity mapping together', 'Jobs to be done, in plain language', 'Write a useful problem statement', 'Mentor office hours'], 'live' => true],
                    ['title' => 'Shape the experience', 'weeks' => 'Weeks 3–4', 'summary' => 'Build a journey and explore more than one answer.', 'lessons' => ['Journey maps that reveal friction', 'Information architecture and navigation', 'Sketching three directions', 'Live concept critique'], 'live' => true],
                    ['title' => 'Design the details', 'weeks' => 'Weeks 5–6', 'summary' => 'Create a flexible visual system and a clickable prototype.', 'lessons' => ['Interface patterns and accessibility', 'Tokens, type, and color', 'Components that work together', 'Prototyping in Figma'], 'live' => true],
                    ['title' => 'Try it with real people', 'weeks' => 'Week 7', 'summary' => 'Test the prototype, learn from friction, and refine.', 'lessons' => ['Writing a usability plan', 'Moderating a friendly test', 'What to fix first', 'Redesign review with Maya'], 'live' => true],
                    ['title' => 'Tell the story', 'weeks' => 'Week 8', 'summary' => 'Share your work with a portfolio-ready case study.', 'lessons' => ['Build the narrative, not just the screens', 'Presenting your design decisions', 'Final cohort showcase', 'Next steps and peer celebration'], 'live' => true],
                ],
                'reviews' => [
                    ['author' => 'Jordan Lee', 'role' => 'Product designer · Cohort 24', 'rating' => 5, 'quote' => 'I came for the design skills. I left with a whole new way to think — and a group chat I’ll probably keep forever.'],
                    ['author' => 'Priya Nair', 'role' => 'UX designer · Cohort 21', 'rating' => 5, 'quote' => 'The live critique made the difference. I could try something, get unstuck, and try again that same week.'],
                ],
            ],
            [
                'title' => 'Full-stack Web Development', 'slug' => 'full-stack-web-development', 'category' => 'Development', 'category_slug' => 'development', 'image' => '/images/learning/web-development.png',
                'mentor' => 'Ethan Brooks', 'mentor_slug' => 'ethan-brooks', 'mentor_title' => 'Staff engineer · ex-Stripe',
                'weeks' => 12, 'price' => 249, 'rating' => 4.9, 'reviews_count' => 204, 'students' => 2180, 'color' => 'blue', 'icon' => '⌘',
                'level' => 'Beginner friendly', 'live_classes' => 18, 'recorded_lessons' => 26, 'class_size' => 'Up to 20 learners',
                'next_start' => 'November 12, 2026', 'schedule' => 'Tuesdays & Thursdays · 7:00 PM IST', 'duration' => '12 weeks · 2 live classes each week',
                'summary' => 'Build and ship a thoughtful web app from the first component to the final deployment, with a mentor and a cohort beside you.',
                'description' => 'Learn the patterns behind modern web apps by building one. We will move from the browser to the database and back, pairing clear explanations with weekly live coding, code review, and a supportive small cohort.',
                'outcomes' => ['Build responsive interfaces with Vue and modern JavaScript', 'Design and consume REST APIs', 'Model relational data and write secure server code', 'Deploy a full-stack project and explain your technical decisions'],
                'curriculum' => [
                    ['title' => 'The web, made visible', 'weeks' => 'Weeks 1–2', 'summary' => 'Understand the browser and build your first useful interface.', 'lessons' => ['How a request travels', 'Semantic HTML and accessible forms', 'CSS layout studio', 'JavaScript fundamentals live lab'], 'live' => true],
                    ['title' => 'Interfaces that respond', 'weeks' => 'Weeks 3–4', 'summary' => 'Turn static screens into reactive, reusable experiences.', 'lessons' => ['Vue components and props', 'State, events, and forms', 'Client-side validation', 'A live component workshop'], 'live' => true],
                    ['title' => 'Data and APIs', 'weeks' => 'Weeks 5–6', 'summary' => 'Connect your interface to a server and model real information.', 'lessons' => ['HTTP and REST, step by step', 'Database tables and relationships', 'Build an API endpoint', 'Pair-programming API clinic'], 'live' => true],
                    ['title' => 'Build the application', 'weeks' => 'Weeks 7–9', 'summary' => 'Bring authentication, business rules, and testing together.', 'lessons' => ['Sessions and sign-in flows', 'Authorization and validation', 'Queues and background work', 'Code review: make it maintainable'], 'live' => true],
                    ['title' => 'Make it ready for people', 'weeks' => 'Weeks 10–11', 'summary' => 'Polish, protect, and deploy the work.', 'lessons' => ['Security essentials', 'Performance and error handling', 'Deploy your application', 'Production-readiness review'], 'live' => true],
                    ['title' => 'Ship and share', 'weeks' => 'Week 12', 'summary' => 'Present your full-stack project and plan what comes next.', 'lessons' => ['Demo day preparation', 'Project showcase', 'Peer feedback round', 'Portfolio and next steps'], 'live' => true],
                ],
                'reviews' => [
                    ['author' => 'Arjun Mehta', 'role' => 'Junior developer · Cohort 19', 'rating' => 5, 'quote' => 'I finally understood how the front end and back end fit together. The live pair sessions made the hard parts feel manageable.'],
                    ['author' => 'Elena Cruz', 'role' => 'Career changer · Cohort 23', 'rating' => 5, 'quote' => 'I shipped a real app instead of collecting tabs of tutorials. Ethan and the cohort kept me moving.'],
                ],
            ],
            [
                'title' => 'Brand Strategy & Storytelling', 'slug' => 'brand-strategy-storytelling', 'category' => 'Business', 'category_slug' => 'business', 'image' => '/images/learning/brand-strategy.png',
                'mentor' => 'Olivia Park', 'mentor_slug' => 'olivia-park', 'mentor_title' => 'Founder · Good Things Studio',
                'weeks' => 6, 'price' => 149, 'rating' => 4.8, 'reviews_count' => 96, 'students' => 860, 'color' => 'orange', 'icon' => '◉',
                'level' => 'All experience levels', 'live_classes' => 9, 'recorded_lessons' => 14, 'class_size' => 'Up to 16 learners',
                'next_start' => 'November 16, 2026', 'schedule' => 'Mondays & Wednesdays · 5:00 PM IST', 'duration' => '6 weeks · 2 live classes each week',
                'summary' => 'Find the sharp, human truth at the heart of your brand and learn how to tell it everywhere your audience meets you.',
                'description' => 'A practical strategy studio for founders, marketers, and makers. Leave with a clear positioning, a voice that sounds like you, and a story system you can use across your website, product, and campaigns.',
                'outcomes' => ['Clarify your audience and point of difference', 'Write a positioning and message hierarchy', 'Develop a consistent brand voice', 'Build a useful story system for everyday marketing'],
                'curriculum' => [
                    ['title' => 'Listen before you speak', 'weeks' => 'Week 1', 'summary' => 'Understand your audience, category, and point of view.', 'lessons' => ['Brand as a promise', 'Audience listening lab', 'Category and competitor scan', 'Olivia’s live strategy teardown'], 'live' => true],
                    ['title' => 'Find the clear idea', 'weeks' => 'Weeks 2–3', 'summary' => 'Build a position people can understand and remember.', 'lessons' => ['The useful difference', 'Positioning canvas workshop', 'Message hierarchy', 'Peer clarity clinic'], 'live' => true],
                    ['title' => 'Give the brand a voice', 'weeks' => 'Week 4', 'summary' => 'Sound like a real person in every channel.', 'lessons' => ['Voice traits that guide writing', 'Show, don’t claim', 'Rewrite the homepage together', 'Live copy feedback'], 'live' => true],
                    ['title' => 'Tell it everywhere', 'weeks' => 'Weeks 5–6', 'summary' => 'Make your story useful across a real customer journey.', 'lessons' => ['Stories across the funnel', 'Campaign idea studio', 'Build the brand playbook', 'Final brand story showcase'], 'live' => true],
                ],
                'reviews' => [
                    ['author' => 'Nina Patel', 'role' => 'Founder · Cohort 18', 'rating' => 5, 'quote' => 'Olivia helped me find the words for what I had been trying to say for years. I use the playbook every week.'],
                    ['author' => 'Marcus Reed', 'role' => 'Marketing lead · Cohort 20', 'rating' => 5, 'quote' => 'A warm, practical room full of honest feedback. Our brand finally sounds like the people behind it.'],
                ],
            ],
        ];

        if (! Schema::hasTable('courses')) {
            return $courses;
        }

        $mentorProfiles = collect(self::mentors())->keyBy('slug');
        $databaseCourses = Course::query()
            ->with(['category', 'mentors', 'modules.lessons', 'reviews.user', 'cohorts.sessions'])
            ->where('status', 'published')
            ->orderBy('slug')
            ->get()
            ->map(function (Course $course) use ($mentorProfiles): array {
                $mentor = $course->mentors->first();
                $mentorSlug = Str::slug($mentor?->name ?? 'Alfrik Academy mentor');
                $mentorProfile = $mentorProfiles->get($mentorSlug);
                $cohort = $course->cohorts->sortBy('starts_on')->first();
                $nextSession = $cohort?->sessions->first(fn ($session) => $session->starts_at?->isFuture());
                $reviews = $course->reviews->map(fn ($review) => [
                    'author' => $review->user?->name ?? 'Alfrik learner',
                    'role' => 'Alfrik learner · Cohort member',
                    'rating' => $review->rating,
                    'quote' => $review->body,
                ])->values()->all();

                return [
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'category' => $course->category?->name ?? 'Learning',
                    'category_slug' => $course->category?->slug ?? 'learning',
                    'image' => $course->cover_image ?: '/images/learning/product-design.png',
                    'mentor' => $mentor?->name ?? 'Alfrik Academy team',
                    'mentor_slug' => $mentorSlug,
                    'mentor_title' => $mentorProfile['role'] ?? $mentor?->pivot?->title ?? 'Cohort mentor',
                    'weeks' => $course->duration_weeks,
                    'price' => number_format($course->price_minor / 100, 0, '.', ''),
                    'rating' => $course->reviews->isNotEmpty() ? round((float) $course->reviews->avg('rating'), 1) : 'New',
                    'reviews_count' => $course->reviews->count(),
                    'students' => $course->enrollments()->count(),
                    'color' => 'violet',
                    'icon' => '✦',
                    'level' => Str::headline($course->level),
                    'live_classes' => max(2, $course->duration_weeks * 2),
                    'recorded_lessons' => $course->modules->flatMap->lessons->count(),
                    'class_size' => 'Up to '.($cohort?->capacity ?? 18).' learners',
                    'next_start' => $nextSession?->starts_at?->format('F j, Y') ?? $cohort?->starts_on?->format('F j, Y') ?? 'Enrollment open',
                    'schedule' => $nextSession
                        ? $nextSession->starts_at->timezone($cohort?->timezone ?? 'UTC')->format('l · g:i A T')
                        : 'Live cohort schedule shared after enrollment',
                    'duration' => $course->duration_weeks.' weeks · 2 live classes each week',
                    'summary' => $course->subtitle ?? $course->description,
                    'description' => $course->description,
                    'outcomes' => $course->modules->take(4)->map(fn ($module) => $module->description ?: $module->title)->values()->all(),
                    'curriculum' => $course->modules->map(fn ($module) => [
                        'title' => $module->title,
                        'weeks' => 'Week '.$module->position,
                        'summary' => $module->description ?? 'Build practical skills with your cohort.',
                        'lessons' => $module->lessons->pluck('title')->values()->all(),
                        'live' => true,
                    ])->values()->all(),
                    'reviews' => $reviews,
                ];
            });

        $databaseBySlug = $databaseCourses->keyBy('slug');
        $staticSlugs = collect($courses)->pluck('slug')->all();
        $courses = collect($courses)->map(fn (array $course) => array_replace($course, $databaseBySlug->get($course['slug'], [])))->all();

        return [...$courses, ...$databaseCourses->reject(fn (array $course) => in_array($course['slug'], $staticSlugs, true))->values()->all()];
    }

    public static function mentors(): array
    {
        $mentors = [
            ['name' => 'Maya Chen', 'slug' => 'maya-chen', 'initials' => 'MC', 'image' => '/images/learning/maya-chen.png', 'field' => 'DESIGN & STRATEGY', 'role' => 'Product design lead · ex-Figma', 'color' => 'lilac', 'years' => '10+', 'learners' => '1,200+', 'courses' => ['product-design-sprint'], 'intro' => 'I help teams make useful things feel obvious, welcoming, and a little delightful.', 'bio' => 'Maya is a product design leader who has spent the last decade helping teams turn complicated tools into clear experiences. Her classroom is known for thoughtful critique, open sketching, and the belief that better questions make better interfaces.', 'specialties' => ['Product discovery', 'Design systems', 'Prototyping', 'Accessible interfaces'], 'quote' => 'A good critique gives you somewhere interesting to go next.'],
            ['name' => 'Ethan Brooks', 'slug' => 'ethan-brooks', 'initials' => 'EB', 'image' => '/images/learning/ethan-brooks.png', 'field' => 'DEVELOPMENT', 'role' => 'Staff engineer · ex-Stripe', 'color' => 'yellow', 'years' => '12+', 'learners' => '2,100+', 'courses' => ['full-stack-web-development'], 'intro' => 'I make the invisible parts of software feel learnable, one good question at a time.', 'bio' => 'Ethan is a staff engineer and patient teacher. He has built developer tools and payment systems at scale, and loves showing how a few sturdy concepts make the whole stack easier to understand.', 'specialties' => ['Laravel and PHP', 'Vue and JavaScript', 'API design', 'Practical architecture'], 'quote' => 'You do not need to know everything before you start building.'],
            ['name' => 'Olivia Park', 'slug' => 'olivia-park', 'initials' => 'OP', 'image' => '/images/learning/olivia-park.png', 'field' => 'BRAND & BUSINESS', 'role' => 'Founder · Good Things Studio', 'color' => 'pink', 'years' => '9+', 'learners' => '850+', 'courses' => ['brand-strategy-storytelling'], 'intro' => 'I help good businesses find their point of view and say it like they mean it.', 'bio' => 'Olivia founded Good Things Studio to help independent businesses build brands with both a point of view and a practical plan. Her workshops are energetic, generous, and full of real examples.', 'specialties' => ['Brand positioning', 'Messaging systems', 'Creative direction', 'Founder storytelling'], 'quote' => 'Your story is strongest when it sounds unmistakably like you.'],
        ];
        if (! Schema::hasTable('course_mentors') || ! Schema::hasTable('courses')) {
            return $mentors;
        }

        $databaseMentors = User::query()->whereHas('courses')->with('courses.category')->orderBy('name')->get()->map(function (User $user) use ($mentors): array {
            $courses = $user->courses;
            $slug = Str::slug($user->name);
            $profile = collect($mentors)->firstWhere('slug', $slug);
            $categories = $courses->pluck('category.name')->filter()->unique()->values()->all();
            $students = $courses->sum(fn (Course $course) => $course->enrollments()->where('status', 'active')->count());

            return array_replace($profile ?? [], [
                'name' => $user->name,
                'slug' => $slug,
                'initials' => collect(explode(' ', $user->name))->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode(''),
                'image' => $user->avatar_path ?: ($profile['image'] ?? '/images/learning/live-class.png'),
                'field' => strtoupper(implode(' & ', $categories) ?: 'LEARNING MENTOR'),
                'role' => $courses->first()?->pivot?->title ?: ($profile['role'] ?? 'Alfrik Academy mentor'),
                'learners' => number_format($students).'+',
                'courses' => $courses->pluck('slug')->values()->all(),
                'intro' => $user->bio ? str($user->bio)->limit(150)->toString() : ($profile['intro'] ?? 'I help learners build practical skills with a supportive cohort.'),
                'bio' => $user->bio ?: ($profile['bio'] ?? 'A working practitioner who makes room for questions, practice, and thoughtful feedback.'),
                'specialties' => $categories ?: ($profile['specialties'] ?? []),
                'years' => $profile['years'] ?? 'Working mentor',
                'color' => $profile['color'] ?? 'lilac',
                'quote' => $profile['quote'] ?? 'A good class helps you find the next question worth exploring.',
            ]);
        });
        $databaseBySlug = $databaseMentors->keyBy('slug');
        $staticSlugs = collect($mentors)->pluck('slug')->all();

        return collect($mentors)->map(fn (array $mentor) => array_replace($mentor, $databaseBySlug->get($mentor['slug'], [])))
            ->concat($databaseMentors->reject(fn (array $mentor) => in_array($mentor['slug'], $staticSlugs, true)))
            ->values()->all();
    }

    public static function stories(): array
    {
        return [
            ['slug' => 'jordan-found-a-new-way-to-design', 'name' => 'Jordan Lee', 'initials' => 'JL', 'role' => 'Product designer at Linear', 'course' => 'Product Design Sprint', 'course_slug' => 'product-design-sprint', 'cohort' => 'Cohort 24', 'color' => 'lilac', 'quote' => 'I came for the design skills. I left with a whole new way to think — and a group chat I’ll probably keep forever.', 'story' => 'Jordan joined Alfrik Academy wanting a stronger product design process. The weekly studio gave them a place to try ideas early, get honest feedback, and learn how to explain the decisions behind the work. Their final case study became the portfolio piece that helped them move into a product designer role.', 'outcome' => 'Moved into a product design role', 'mark' => '✳'],
            ['slug' => 'arjun-shipped-his-first-app', 'name' => 'Arjun Mehta', 'initials' => 'AM', 'role' => 'Junior developer', 'course' => 'Full-stack Web Development', 'course_slug' => 'full-stack-web-development', 'cohort' => 'Cohort 19', 'color' => 'blue', 'quote' => 'I stopped collecting tutorials and shipped something real. The cohort made the difficult weeks feel possible.', 'story' => 'Arjun had worked through online lessons for months but struggled to connect the pieces. Building one application with Ethan and a small cohort gave him a clear path through the browser, API, and database. He now has a deployed project he can confidently talk through.', 'outcome' => 'Built and deployed a portfolio app', 'mark' => '⌘'],
            ['slug' => 'nina-found-the-words-for-her-brand', 'name' => 'Nina Patel', 'initials' => 'NP', 'role' => 'Founder at Little Field', 'course' => 'Brand Strategy & Storytelling', 'course_slug' => 'brand-strategy-storytelling', 'cohort' => 'Cohort 18', 'color' => 'orange', 'quote' => 'Olivia helped me find the words for what I had been trying to say for years. I use the playbook every week.', 'story' => 'Nina had a business customers loved but found it hard to explain what made it different. In the live brand studio, she listened to customers, shaped a clear position, and built a messaging playbook she now uses across her site and product launches.', 'outcome' => 'Created a practical brand playbook', 'mark' => '◉'],
        ];
    }

    public static function faqs(): array
    {
        return [
            ['question' => 'Are classes live or self-paced?', 'answer' => 'Live classes are the heart of every Alfrik Academy program. You meet your mentor and cohort on a regular schedule for discussion, practice, feedback, and studio time. Short recordings and resources help you prepare or catch up between sessions.'],
            ['question' => 'Do I need experience before joining?', 'answer' => 'Most programs are beginner friendly. Each course page explains who it is for and what to bring. If you are unsure, send us a note before you enroll and we will help you find the right starting point.'],
            ['question' => 'What if I miss a live class?', 'answer' => 'We share a recording and class notes after each session. You can also ask questions in the cohort space and bring unfinished work to the next office hour.'],
            ['question' => 'How large are the cohorts?', 'answer' => 'Cohorts are intentionally small, usually 16 to 20 learners, so everyone has room to participate and receive personal feedback. The exact limit appears on each course page.'],
            ['question' => 'What is included in the course fee?', 'answer' => 'Your fee includes the live classes, mentor feedback, recordings, learning resources, cohort community, and final showcase. Any additional costs are listed on the course page before enrollment.'],
            ['question' => 'Can I ask questions before I enroll?', 'answer' => 'Absolutely. Visit the contact page and tell us what you are hoping to learn. We will help you compare courses and find a schedule that works.'],
        ];
    }
}
