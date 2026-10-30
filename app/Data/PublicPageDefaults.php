<?php

namespace App\Data;

class PublicPageDefaults
{
    public static function all(): array
    {
        return [
            'about' => [
                'eyebrow' => 'ABOUT ALFRIK ACADEMY', 'title' => 'Learning should feel', 'emphasis' => 'like being in it together.',
                'intro' => 'We make small, live learning programs for people who want to grow their skills and do meaningful work with others.',
                'section_title' => 'Practice is better with people.',
                'section_body' => 'Our programs bring expert mentors and curious learners into the same room. You learn by asking, making, sharing drafts, and trying again. Every cohort is small enough for real conversation and useful feedback.',
                'section_support' => 'Recordings and resources support your progress, while live classes remain the center of the experience.',
                'values' => ['Be generous with feedback', 'Make room for questions', 'Learn by doing the work'],
                'cta_title' => 'Find a good place to begin.',
            ],
            'how' => [
                'eyebrow' => 'A CLASSROOM BUILT AROUND PEOPLE', 'title' => 'Show up. Make things.', 'emphasis' => 'Move forward.',
                'intro' => 'Alfrik Academy programs turn learning into a shared practice: live sessions, useful feedback, and work you can take into the world.',
                'steps' => [
                    ['number' => '01', 'title' => 'Find your next thing', 'text' => 'Browse programs by topic, meet the mentors, and read the full curriculum before you decide.'],
                    ['number' => '02', 'title' => 'Join a small cohort', 'text' => 'Choose a start date and a schedule that fits. Meet the people who will learn alongside you.'],
                    ['number' => '03', 'title' => 'Show up and make', 'text' => 'Bring real questions to live classes, try the work between sessions, and get useful feedback.'],
                    ['number' => '04', 'title' => 'Share what you built', 'text' => 'Finish with a project, a new point of view, and a group of people who know what you can do.'],
                ],
                'callout_title' => 'Live is where the learning comes together.',
                'callout_body' => 'Ask the question, compare approaches, and get feedback while the work is still in progress. Recordings and lesson resources help you keep pace between classes.',
            ],
            'faq' => [
                'eyebrow' => 'GOOD QUESTIONS', 'title' => 'A few things you', 'emphasis' => 'might be wondering.',
                'intro' => 'Still unsure? Our team can help you choose the right course and schedule.',
                'items' => collect(PublicCatalog::faqs())->map(fn ($faq) => ['question' => $faq['question'], 'answer' => $faq['answer']])->all(),
            ],
        ];
    }
}
