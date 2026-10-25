# Kanram Academy public experience: design research

## V4: connect learning to community and work

### Research review

- Canvas course tools include groups and discussion spaces alongside course content, conferences, files, and collaboration. This supports bringing conversation and shared work into the learning environment instead of treating the LMS as a video shelf. ([Canvas course features](https://canvas.ucr.edu/features))
- LinkedIn Learning Career Hub links career goals and role guides with personalized learning plans and internal job discovery. This informed a smaller, community-scale connection between learning content and career opportunities. ([Career Hub overview](https://www.linkedin.com/help/linkedin/answer/a700872))

### V4 implementation

- Add a public Insights hub for staff-published articles, academy news, and events, with type filters, search, pagination, article pages, and related reading.
- Add a public Careers board with searchable roles, work and employment type, location, skills, salary range, expiry dates, and external application links.
- Let signed-in learners express interest in internal listings; give admin and social media manager roles a publishing workspace and a simple application status pipeline.
- Seed clearly labeled sample articles and listings for local preview. Replace the sample listings with verified opportunities before launch.

### Follow-up product work

Discussion threads, reactions, learner-to-learner messaging, personalized skill profiles, recommendations, notifications, employer verification, and richer application/resume workflows need their own privacy and moderation decisions before implementation.

## V3: live cohort learning and assessment

### Research review

- Maven's student home combines the weekly syllabus, projects, reflections and live events; learners see a join action near the event and the replay after it. Its live teaching guidance emphasizes workshops, Q&A, project reviews and learner demos over slide-heavy sessions. ([Student Home](https://help.maven.com/en/articles/9081204-student-home), [student syllabus and schedule](https://help.maven.com/en/articles/5597459-home-student-syllabus-schedule))
- Moodle separates a quiz's attempt rules from its questions and supports attempt limits, score reporting and post-attempt review. This informed a quiz flow that records attempts on the server, calculates marks from stored answer keys, and shows correct answers only after submission. ([Quiz settings](https://docs.moodle.org/503/en/Quiz_settings), [Using Quiz](https://docs.moodle.org/503/en/Using_Quiz))
- Moodle's completion guidance treats completion as a visible condition tied to actual activity (such as a submitted assignment or graded quiz), rather than relying on an unverified percentage. ([Tracking progress](https://docs.moodle.org/503/en/Tracking_progress))
- Canvas connects assignments to the course modules, grades and calendar so deadlines and assessment status can be found where learners already work. ([Canvas Basics Guide](https://community.canvaslms.com/html/assets/Canvas_Basics_Guide.pdf))

### V3 implementation plan

1. Keep the cohort calendar and next live session at the center of the learner dashboard; the live event is the primary learning moment.
2. Surface published course quizzes in the enrolled syllabus, with question count, attempt limits and previous results.
3. Add a complete learner quiz flow: access control through active enrollment, single-choice questions, server-side answer validation and scoring, pass threshold, attempt limits, and review after submission.
4. Seed one practice quiz for the demo course so the workflow can be explored locally.
5. Add a staff review queue for submitted project work, with a score, written feedback, and learner/course scoping; connect dashboard counts to real cohort data.
6. Keep the implementation incremental: use the existing quiz/attempt and submission tables and retain assignment submission, calendar export, lesson progress, and replay access.

### V3 delivery boundary

This release implements the learner-side quiz workflow and teacher assignment review on top of the existing schema. Quiz authoring and analytics for teachers, timed attempts, question banks, discussions, certificates and integrated video conferencing remain follow-up work; they need dedicated management flows and operational integrations rather than decorative UI.

## Product direction

Kanram Academy is a live-first learning platform. The public site should help a prospective learner answer four questions quickly: what will I learn, who will teach me, when will we meet, and what will the complete program look like?

## Reference patterns

- **Maven course discovery:** the marketplace puts the program and cohort timing together, helping people compare live offerings by topic and start date. Its student syllabus guidance describes a weekly home for events, lessons, resources, and projects, with modules organized around learning outcomes. [Maven courses](https://maven.com/courses) · [Maven syllabus and schedule guide](https://help.maven.com/en/articles/5597459-home-student-syllabus-schedule)
- **Outschool class formats:** the official guide distinguishes scheduled live classes from self-paced classes and makes duration and meeting cadence explicit. Kanram Academy similarly gives live schedule, cohort start, duration, and class size clear placement. [Outschool class formats](https://support.outschool.com/en/articles/19491-how-do-outschool-classes-work)

## Design decisions

- Put live cohorts first. Show the mentor, start date, schedule, live-session count, and cohort size before supporting recordings.
- Make course details inspectable before sign-in. The curriculum page lists modules, weeks, learning summaries, and sessions, with enrollment as a separate action.
- Reduce decorative noise without removing warmth. Use original photo-led moments from live classes, course work, and mentor portraits; pair them with warm neutral surfaces, muted sage accents, fine dividers, and serif headlines with readable sans-serif body text.
- Make information easier to scan. Use one clear page headline, consistent content width, short course metadata, and visible page-to-page navigation.
- Use a two-family type system: Newsreader for large editorial headlines and reading moments, Instrument Sans for navigation, controls, labels, and body copy. Newsreader is specifically designed for continuous on-screen reading and includes variable font support; Instrument Sans is a variable sans-serif designed for precise yet expressive display and interface use. [Newsreader source](https://github.com/productiontype/Newsreader) · [Instrument Sans source](https://github.com/Instrument/instrument-sans)
- Keep supportive content secondary. Recordings and learning resources support the scheduled classes; they do not compete with them for attention.

## Applied to

The homepage, course catalog, course detail, and supporting public pages (mentors, stories, how it works, about, FAQ, contact). The public navigation remains responsive and exposes each page on small screens.

## Image assets

Original editorial-style images are in `public/images/learning/` and are used for the live-class hero, course cards and details, mentor profiles, and learner stories. Mentor portraits are illustrative generated placeholders for the sample mentor profiles; replace them with approved real portraits before launch.
# V2: live cohort learning

## Product research

The strongest pattern across established cohort learning products is to make the student home the operational center of the cohort: one place for the syllabus, live events, project work, and the course community. Maven's student home combines a syllabus and schedule, and describes live events as workshops, office hours, Q&A, project review, and cohort connection. Its recording guidance says replays should appear on the student schedule so absent students can catch up. Its projects guidance places prompts and submissions in the syllabus and encourages instructor and peer feedback. ([Student home](https://help.maven.com/en/articles/5597459-home-student-syllabus-schedule), [recordings](https://help.maven.com/en/articles/6380851-sharing-session-recordings), [projects](https://help.maven.com/en/articles/5597496-projects), [community](https://help.maven.com/en/articles/6289166-community-overview))

## V2 product decisions

- **Live schedule first:** student dashboard surfaces the next cohort sessions and a full upcoming/past schedule, with timezone-aware times.
- **Cohort access:** session links, session detail and recordings are only visible to a student with an active enrollment in that cohort.
- **Replay continuity:** past session recordings sit beside the schedule and on the student home.
- **Calendar utility:** an authenticated iCalendar download lets students add their cohort's sessions to their personal calendar.
- **Syllabus and progress:** enrolled courses open a structured module/lesson view. Students can open lesson resources and record completion; the dashboard progress is calculated from that record.
- **Assignment awareness:** the dashboard highlights due, not-yet-submitted assignments so project work stays visible between live classes.
- **Demo path:** local seeding creates a sample mentor, student enrollment, course syllabus, upcoming class, past replay and assignment. The fake schedule has no real meeting destination or recording; the seeded URLs are placeholders and must be replaced before a real cohort runs.

These choices keep live interaction as the center of the product while giving students a useful asynchronous path around it.
