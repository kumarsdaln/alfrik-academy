<?php

namespace App\Enums;

final class ActivityEvent
{
    // Authentication
    public const AUTH_LOGIN = 'auth.login';
    public const AUTH_LOGOUT = 'auth.logout';
    public const AUTH_PASSWORD_CHANGED = 'auth.password_changed';

    // Account and profile
    public const PROFILE_UPDATED = 'profile.updated';
    public const PROFILE_AVATAR_UPDATED = 'profile.avatar_updated';
    public const ACCOUNT_DEACTIVATED = 'account.deactivated';

    // Courses and learning
    public const COURSE_ENROLLED = 'course.enrolled';
    public const COURSE_COMPLETED = 'course.completed';
    public const LESSON_COMPLETED = 'lesson.completed';
    public const QUIZ_STARTED = 'quiz.started';
    public const QUIZ_SUBMITTED = 'quiz.submitted';
    public const ASSIGNMENT_SUBMITTED = 'assignment.submitted';
    public const ASSIGNMENT_GRADED = 'assignment.graded';
    public const LIVE_SESSION_ATTENDED = 'live_session.attended';
    public const COURSE_REVIEW_SUBMITTED = 'course_review.submitted';

    // Payments and subscriptions
    public const PAYMENT_COMPLETED = 'payment.completed';
    public const PAYMENT_FAILED = 'payment.failed';
    public const PAYMENT_REFUNDED = 'payment.refunded';
    public const CHECKOUT_STARTED = 'checkout.started';
    public const SUBSCRIPTION_CREATED = 'subscription.created';
    public const SUBSCRIPTION_RENEWED = 'subscription.renewed';
    public const SUBSCRIPTION_CANCELLED = 'subscription.cancelled';
    public const SUBSCRIPTION_EXPIRED = 'subscription.expired';

    // Webinars and events
    public const EVENT_REGISTERED = 'event.registered';
    public const EVENT_REGISTRATION_CANCELLED = 'event.registration_cancelled';
    public const EVENT_PAYMENT_COMPLETED = 'event.payment_completed';
    public const EVENT_PAYMENT_REFUNDED = 'event.payment_refunded';

    // Careers
    public const JOB_APPLICATION_SUBMITTED = 'job_application.submitted';
    public const JOB_APPLICATION_WITHDRAWN = 'job_application.withdrawn';
    public const JOB_APPLICATION_STATUS_CHANGED = 'job_application.status_changed';

    // Insights and surveys
    public const INSIGHT_PUBLISHED = 'insight.published';
    public const SURVEY_SUBMITTED = 'survey.submitted';

    // Contact and community content
    public const CONTACT_INQUIRY_SUBMITTED = 'contact_inquiry.submitted';
    public const LEARNER_STORY_PUBLISHED = 'learner_story.published';

    // Administration and content management
    public const COURSE_PUBLISHED = 'course.published';
    public const COURSE_UNPUBLISHED = 'course.unpublished';
    public const JOB_POST_PUBLISHED = 'job_post.published';
    public const JOB_POST_UNPUBLISHED = 'job_post.unpublished';
    public const EVENT_PUBLISHED = 'event.published';
    public const EVENT_UNPUBLISHED = 'event.unpublished';
    public const PUBLIC_PAGE_CONTENT_UPDATED = 'public_page_content.updated';
    public const USER_ACTIVATED = 'user.activated';
    public const USER_DEACTIVATED = 'user.deactivated';
    public const USER_ROLE_CHANGED = 'user.role_changed';
    public const CONTACT_INQUIRY_HANDLED = 'contact_inquiry.handled';

    private function __construct()
    {
    }
}