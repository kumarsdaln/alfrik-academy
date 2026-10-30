<?php

namespace App\Providers;

use App\Events\ActivityOccurred;
use App\Listeners\ConfirmCourseCheckout;
use App\Listeners\RecordUserActivity;
use App\Listeners\RecordUserLogin;
use App\Listeners\RecordUserLogout;
use App\Models\AssignmentSubmission;
use App\Models\ContactInquiry;
use App\Models\CourseReview;
use App\Models\Enrollment;
use App\Models\Insight;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\LearnerStory;
use App\Models\LessonProgress;
use App\Models\Payment;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Models\WebinarEvent;
use App\Models\WebinarRegistration;
use App\Observers\AssignmentSubmissionObserver;
use App\Observers\ContactInquiryObserver;
use App\Observers\CourseReviewObserver;
use App\Observers\EnrollmentObserver;
use App\Observers\InsightObserver;
use App\Observers\JobApplicationObserver;
use App\Observers\JobPostObserver;
use App\Observers\LearnerStoryObserver;
use App\Observers\LessonProgressObserver;
use App\Observers\PaymentObserver;
use App\Observers\QuizAttemptObserver;
use App\Observers\UserObserver;
use App\Observers\WebinarEventObserver;
use App\Observers\WebinarRegistrationObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(WebhookReceived::class, ConfirmCourseCheckout::class);
        Event::listen(ActivityOccurred::class, RecordUserActivity::class);
        Event::listen(Login::class, RecordUserLogin::class);
        Event::listen(Logout::class, RecordUserLogout::class);

        // User and account activities
        User::observe(UserObserver::class);

        // Learning activities
        Enrollment::observe(EnrollmentObserver::class);
        LessonProgress::observe(LessonProgressObserver::class);
        QuizAttempt::observe(QuizAttemptObserver::class);
        AssignmentSubmission::observe(AssignmentSubmissionObserver::class);
        CourseReview::observe(CourseReviewObserver::class);

        // Payments
        Payment::observe(PaymentObserver::class);

        // Career activities
        JobApplication::observe(JobApplicationObserver::class);
        JobPost::observe(JobPostObserver::class);

        // Webinar activities
        WebinarRegistration::observe(WebinarRegistrationObserver::class);
        WebinarEvent::observe(WebinarEventObserver::class);

        // Content activities
        Insight::observe(InsightObserver::class);
        LearnerStory::observe(LearnerStoryObserver::class);

        // Contact inquiries
        ContactInquiry::observe(ContactInquiryObserver::class);
    }
}
