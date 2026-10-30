# Alfrik Academy — live-first learning and community platform

Initial product scaffold for a learning platform centered on instructor-led cohorts, with supplemental video lessons and assessments.

## Stack

- Laravel 13 / PHP 8.3+
- Inertia.js 3 + Vue 3
- Wayfinder-generated TypeScript route/action helpers
- PostgreSQL for application data
- Redis for cache, sessions, and queues

## Start locally

1. Copy `.env.example` to `.env` and set the database, Redis, mail, and app URL values.
2. Install dependencies with `composer install` and `npm install`.
3. Generate the application key with `php artisan key:generate`.
4. Create the PostgreSQL database named in `DB_DATABASE`.
5. Run `php artisan migrate --seed`.
6. Start the Laravel and Vite development servers with `composer run dev`.

The seed creates the initial `admin`, `teacher`, `social_manager`, and `student` role bundles. In `APP_ENV=local` only, it also creates `student@northstar.test` and `admin@northstar.test`, both with the password `password`; never use these demo credentials outside a local development database.

## Preview pages

- `/` public marketing site and course discovery
- `/insights` independent articles, knowledge, updates, and events
- `/careers` community opportunities with logged-in learner applications
- `/login` and `/register` session authentication
- `/learn` student dashboard preview (student, teacher, or admin role required)
- `/staff` staff dashboard preview (admin, teacher, or social manager role required)
- `/staff/publishing` publishing desk (permission-gated; learner applications are limited to authorized reviewers)

Insights, community job posts, and learner applications are database-backed. Staff can publish articles, news, events, and roles; learners can express interest in roles, and authorized staff can update application status. The demo seeder adds clearly labeled example posts for local previews.

## Current foundation

- Product and delivery plan: `../LMS-PLAN.md`
- Core relational schema for courses, modules, lessons, cohorts, live sessions, attendance, enrollments, progress, quizzes, assignments, reviews, roles, and permissions
- Eloquent models for the core course, cohort, session, enrollment, and access-control relationships
- Database-backed insights publishing, opportunity listings, and job applications
- Redis/PostgreSQL environment defaults in `.env.example`
- Role-to-permission access control for academy management routes, with navigation filtered to the signed-in user's permissions
- Signed email verification and rate-limited password recovery; learner and staff workspaces require verified email addresses
- Scoped teacher live-class scheduling and manual attendance records, including attended minutes
- Assignment gradebook with course-scoped teacher visibility and CSV export
- Staff mutation audit history that records actor, action, record identifiers, changed field names, request IP, and user agent without storing submitted values or credentials
- Separate permissions for grading, academy-wide assessment authoring, cohort administration, event operations, and applicant records
- Stripe webhook signature verification, server-confirmed course/event payments, and development payment bypass support
- Rate limits on authentication, public submissions, checkout, publishing, grading, and event registration
- Inertia shared auth identity and permission payload and Wayfinder Vite generation

## Enterprise readiness roadmap

The current codebase is a development-ready product foundation, not yet a production enterprise LMS. Staff MFA/SSO, conferencing-provider attendance and recording synchronization, payment reconciliation/refund workflows, operational monitoring and backup restore drills, data retention/export/deletion controls, and broad authorization/accessibility coverage still need completion before launch. Add integrations such as LTI/SCORM and SIS synchronization only after requirements and providers are selected.
