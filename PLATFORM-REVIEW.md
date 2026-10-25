# Kanram Academy platform review

Review date: 22 October 2026

## Current product foundation

Kanram is a live-first learning platform with public course discovery, course curriculum, student workspaces, cohort sessions, assignments, quizzes, grading, community publishing, job listings, events, and Stripe-backed checkout. The application uses Laravel 13, Inertia, Vue, Wayfinder, PostgreSQL, Redis-backed queues/cache/session defaults, and Cashier.

The management area has role bundles for administrators, teachers, social managers, and students. This review added route-level permission checks for management capabilities, permission-aware staff navigation, separate privileges for academy-wide assessments and cohorts, and applicant-data access. Administrators retain full access; teacher and publishing roles follow narrower capability grants.

## Enterprise readiness assessment

The platform has a useful product foundation, but it is not yet ready to claim enterprise production readiness. The largest outstanding areas are identity security, tenant and course data boundaries, operational controls, and automated assurance.

### Priority 1 — Identity and access

- Add email verification and secure password recovery. Laravel provides built-in verification and password-broker flows: [Email verification](https://laravel.com/docs/13.x/verification), [password resets](https://laravel.com/docs/13.x/passwords).
- Add MFA for staff and administrators, then evaluate enterprise SSO (OIDC/SAML) and domain-based provisioning.
- Build a role and permission management UI. The current admin screen assigns one of the seeded role bundles; custom role creation and permission editing are not yet available in the product UI.
- Add immutable audit events for role grants, content publication, grades, user suspension, event registration changes, and payment operations.
- Complete least-privilege checks at course and cohort scope. Teachers should only see learners and submissions in courses they teach; explicitly test cross-course and cross-user access.
- Add automated authorization coverage for every privileged route and user-data payload.

### Priority 2 — Learning delivery and integrations

- Select and integrate a live-class provider with attendance synchronization, recording lifecycle, calendar changes, and provider failure handling. Current sessions store links and schedule metadata but do not integrate with a conferencing provider.
- Define the content interoperability requirement before adding LTI, SCORM, or xAPI. Build a versioned integration boundary after choosing the needed standards and external systems.
- Add notification preferences and reliable delivery for schedule changes, assignment deadlines, grading feedback, payment receipts, and event updates.

### Priority 3 — Billing and operational controls

- Complete payment reconciliation, refunds, chargebacks, invoice/tax requirements, and staff-visible exception handling. Checkout and verified webhooks exist, but these operational workflows need explicit review before accepting production payments.
- Add queue failure monitoring, structured logs, error alerting, database backups with restore drills, and a documented incident process.
- Verify production settings for HTTPS, secure cookies, secrets, debug mode, mail, Redis, queue workers, and webhook signing secrets.
- Define data retention and export/deletion policies for learner submissions, job applications, event attendees, and payment records.

### Priority 4 — Learning quality and insight

- Add course completion/certificate rules, outcomes/rubrics, cohort-level reports, instructor feedback loops, and accessible accommodations where needed.
- Expand reporting with permission-aware exports and clear definitions for attendance, engagement, completion, and assessment results. Mature LMS platforms expose analytics while controlling which roles can see grades and learner-level records; see [Canvas analytics](https://developerdocs.instructure.com/services/canvas/resources/analytics) and [Canvas permissions](https://developerdocs.instructure.com/services/canvas/permissions/details).
- Run keyboard, screen-reader, contrast, mobile, and reduced-motion reviews across public, student, and staff workflows.

## Work completed in this review

- Added a reusable `permission` middleware alias and an `EnsureHasPermission` guard for administrative routes.
- Replaced the single administrator-only management gate with capability-specific route checks.
- Split broad capabilities so teachers can grade assigned work without gaining academy-wide assessment authoring or cohort administration.
- Added a dedicated `applications.manage` capability; publishing staff no longer receive applicant records unless authorized.
- Shared only the authenticated user's roles and permission names with Inertia and filtered management navigation to the user's capabilities.
- Updated setup and readiness documentation so development demo setup is distinct from production readiness.

## Recommended next implementation phase

The original review prioritized account security, auditability, staff scoping, and live learning operations. Their first implementation slice is recorded below; remaining rollout work should focus on staff MFA, external provider integrations, and operational readiness.

## Implementation update: 23 October 2026

- Added framework-native email verification and password reset flows. Learner and staff workspaces, event registration, and job applications require verified email; local demo roster accounts are seeded as verified.
- Added a staff audit history for successful staff-side mutations. It stores action, record identifiers, field names, HTTP status, IP address, and user agent, while excluding submitted values and credentials.
- Added an administrator-only audit history page.
- Enabled teachers to schedule and update classes only for cohorts assigned to them; cohort creation and academy-wide operations remain administrator-controlled.
- Added attendance marking by assigned teachers and administrators, including present, late, absent, excused, and attended minutes.
- Added a course-scoped gradebook with CSV export. It shows graded, submitted, and missing work distinctly, and excludes ungraded work from the running percentage.

The next highest-priority work remains staff MFA, a conferencing provider integration, attendance and replay synchronization, payment operations, operational alerts and restore drills, and stronger cross-user authorization coverage. These still require a conferencing/SSO selection and production mail/payment configuration.
