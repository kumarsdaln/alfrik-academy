<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiscoveryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Staff\AdminAssessmentController;
use App\Http\Controllers\Staff\AdminCourseController;
use App\Http\Controllers\Staff\AdminOperationsController;
use App\Http\Controllers\Staff\AdminPublicPageController;
use App\Http\Controllers\Staff\AdminStoryController;
use App\Http\Controllers\Staff\AdminWebinarEventController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffPublishingController;
use App\Http\Controllers\StudentBillingController;
use App\Http\Controllers\StudentLearningController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\WebinarEventController;
use App\Http\Middleware\RequireStripeWebhookSecret;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Laravel\Cashier\Http\Middleware\VerifyWebhookSignature;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/courses', [PublicController::class, 'courses'])->name('courses.index');
Route::get('/courses/{slug}', [PublicController::class, 'course'])->name('courses.show');
Route::get('/how-it-works', [PublicController::class, 'howItWorks'])->name('how');
Route::get('/mentors', [PublicController::class, 'mentors'])->name('mentors.index');
Route::get('/mentors/{slug}', [PublicController::class, 'mentor'])->name('mentors.show');
Route::get('/stories', [PublicController::class, 'stories'])->name('stories.index');
Route::get('/stories/{slug}', [PublicController::class, 'story'])->name('stories.show');
Route::get('/events', [WebinarEventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [WebinarEventController::class, 'show'])->name('events.show');
Route::post('/events/{event:slug}/register', [WebinarEventController::class, 'register'])->middleware(['auth', 'verified', 'role:student,teacher,admin,social_manager', 'throttle:5,1'])->name('events.register');
Route::get('/surveys', [DiscoveryController::class, 'surveys'])->name('surveys.index');
Route::get('/surveys/{slug}', [DiscoveryController::class, 'survey'])->name('surveys.show');
Route::post('/surveys/{slug}/responses', [DiscoveryController::class, 'submitSurvey'])->middleware('throttle:5,1')->name('surveys.responses.store');
Route::get('/reports', [DiscoveryController::class, 'reports'])->name('reports.index');
Route::get('/reports/{slug}', [DiscoveryController::class, 'report'])->name('reports.show');
Route::get('/insights', [DiscoveryController::class, 'insights'])->name('insights.index');
Route::get('/insights/{slug}', [DiscoveryController::class, 'insight'])->name('insights.show');
Route::get('/careers', [DiscoveryController::class, 'jobs'])->name('careers.index');
Route::post('/careers', [DiscoveryController::class, 'submitJob'])->middleware('throttle:5,1')->name('careers.submit');
Route::get('/careers/{slug}', [DiscoveryController::class, 'job'])->name('careers.show');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegistration'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->middleware('throttle:3,1')->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:5,1')->name('password.update');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::post('/notifications/{notification}/open', [NotificationController::class, 'open'])->name('notifications.open');
    Route::post('/careers/{slug}/apply', [DiscoveryController::class, 'apply'])->middleware(['verified', 'throttle:10,1'])->name('careers.apply');
    Route::middleware('verified')->group(function () {
        Route::get('/learn/profile', [StudentProfileController::class, 'show'])->middleware('role:student,teacher,admin')->name('learn.profile');
        Route::put('/learn/profile', [StudentProfileController::class, 'update'])->middleware('role:student,teacher,admin')->name('learn.profile.update');
        Route::get('/learn/settings/learning', [StudentProfileController::class, 'learningPreferences'])->middleware('role:student,teacher,admin')->name('learn.settings.learning');
        Route::put('/learn/settings/learning', [StudentProfileController::class, 'updatePreferences'])->middleware('role:student,teacher,admin')->name('learn.settings.learning.update');
        Route::get('/learn/settings/notifications', [StudentProfileController::class, 'notifications'])->middleware('role:student,teacher,admin')->name('learn.settings.notifications');
        Route::put('/learn/settings/notifications', [StudentProfileController::class, 'updateNotifications'])->middleware('role:student,teacher,admin')->name('learn.settings.notifications.update');
        Route::get('/learn/settings/security', [StudentProfileController::class, 'security'])->middleware('role:student,teacher,admin')->name('learn.settings.security');
        Route::put('/learn/settings/security', [StudentProfileController::class, 'updatePassword'])->middleware(['role:student,teacher,admin', 'throttle:5,1'])->name('learn.settings.security.update');        Route::get('/learn', [StudentLearningController::class, 'dashboard'])->middleware('role:student,teacher,admin')->name('learn');
        Route::get('/learn/purchases', [StudentBillingController::class, 'purchases'])->middleware('role:student')->name('learn.purchases');
        Route::get('/learn/activity', [StudentBillingController::class, 'activity'])->middleware('role:student')->name('learn.activity');
        Route::get('/learn/events', [StudentBillingController::class, 'events'])->middleware('role:student')->name('learn.events');
        Route::get('/learn/purchases/return', [StudentBillingController::class, 'checkoutReturn'])->middleware('role:student')->name('learn.purchases.return');
        Route::post('/courses/{slug}/checkout', [StudentBillingController::class, 'checkout'])->middleware(['role:student', 'throttle:5,1'])->name('courses.checkout');
        Route::get('/learn/courses', [StudentLearningController::class, 'courses'])->middleware('role:student,teacher,admin')->name('learn.courses.index');
        Route::get('/learn/courses/{course:slug}', [StudentLearningController::class, 'course'])->middleware('role:student,teacher,admin')->name('learn.courses.show');
        Route::get('/learn/quizzes/{quizId}', [StudentLearningController::class, 'quiz'])->whereNumber('quizId')->middleware('role:student,teacher,admin')->name('learn.quizzes.show');
        Route::post('/learn/quizzes/{quizId}', [StudentLearningController::class, 'submitQuiz'])->whereNumber('quizId')->middleware('role:student,teacher,admin')->name('learn.quizzes.submit');
        Route::get('/learn/lessons/{lesson}', [StudentLearningController::class, 'lesson'])->middleware('role:student,teacher,admin')->name('learn.lessons.show');
        Route::post('/learn/lessons/{lesson}/complete', [StudentLearningController::class, 'completeLesson'])->middleware('role:student,teacher,admin')->name('learn.lessons.complete');
        Route::get('/learn/assignments', [StudentLearningController::class, 'assignments'])->middleware('role:student,teacher,admin')->name('learn.assignments.index');
        Route::get('/learn/assignments/{assignmentId}', [StudentLearningController::class, 'assignment'])->whereNumber('assignmentId')->middleware('role:student,teacher,admin')->name('learn.assignments.show');
        Route::post('/learn/assignments/{assignmentId}', [StudentLearningController::class, 'submitAssignment'])->whereNumber('assignmentId')->middleware('role:student,teacher,admin')->name('learn.assignments.submit');
        Route::get('/learn/schedule', [StudentLearningController::class, 'schedule'])->middleware('role:student,teacher,admin')->name('learn.schedule');
        Route::get('/learn/calendar.ics', [StudentLearningController::class, 'calendar'])->middleware('role:student,teacher,admin')->name('learn.calendar');
        Route::get('/learn/sessions/{liveSession}', [StudentLearningController::class, 'session'])->middleware('role:student,teacher,admin')->name('learn.sessions.show');

        Route::get('/staff', [StaffController::class, 'dashboard'])->middleware('role:admin,teacher,social_manager')->name('staff');
        Route::get('/staff/gradebook', [StaffController::class, 'gradebook'])->middleware('permission:assessments.grade')->name('staff.gradebook');
        Route::get('/staff/gradebook/export', [StaffController::class, 'exportGradebook'])->middleware('permission:assessments.grade')->name('staff.gradebook.export');
        Route::prefix('/staff/manage')->name('staff.manage.')->group(function () {
            Route::get('/', [AdminOperationsController::class, 'index'])->middleware('permission:reports.view')->name('index');
            Route::get('/audit', [AdminOperationsController::class, 'audit'])->middleware('permission:audit.view')->name('audit');
            Route::get('/courses', [AdminCourseController::class, 'index'])->middleware('permission:courses.manage')->name('courses');
            Route::post('/courses', [AdminCourseController::class, 'store'])->middleware('permission:courses.manage')->name('courses.store');
            Route::get('/courses/{course}', [AdminCourseController::class, 'edit'])->whereNumber('course')->middleware('permission:courses.manage')->name('courses.edit');
            Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->whereNumber('course')->middleware('permission:courses.manage')->name('courses.update');
            Route::post('/categories', [AdminCourseController::class, 'storeCategory'])->middleware('permission:courses.manage')->name('categories.store');
            Route::post('/courses/{course}/modules', [AdminCourseController::class, 'storeModule'])->whereNumber('course')->middleware('permission:courses.manage')->name('modules.store');
            Route::delete('/courses/{course}/modules/{module}', [AdminCourseController::class, 'destroyModule'])->whereNumber('course')->whereNumber('module')->middleware('permission:courses.manage')->name('modules.destroy');
            Route::post('/courses/{course}/modules/{module}/lessons', [AdminCourseController::class, 'storeLesson'])->whereNumber('course')->whereNumber('module')->middleware('permission:courses.manage')->name('lessons.store');
            Route::delete('/courses/{course}/modules/{module}/lessons/{lesson}', [AdminCourseController::class, 'destroyLesson'])->whereNumber('course')->whereNumber('module')->whereNumber('lesson')->middleware('permission:courses.manage')->name('lessons.destroy');

            Route::get('/stories', [AdminStoryController::class, 'index'])->middleware('permission:marketing.manage')->name('stories');
            Route::post('/stories', [AdminStoryController::class, 'store'])->middleware('permission:marketing.manage')->name('stories.store');
            Route::put('/stories/{story}', [AdminStoryController::class, 'update'])->whereNumber('story')->middleware('permission:marketing.manage')->name('stories.update');
            Route::delete('/stories/{story}', [AdminStoryController::class, 'destroy'])->whereNumber('story')->middleware('permission:marketing.manage')->name('stories.destroy');
            Route::get('/public-pages', [AdminPublicPageController::class, 'index'])->middleware('permission:marketing.manage')->name('public-pages');
            Route::put('/public-pages/{pageKey}', [AdminPublicPageController::class, 'update'])->middleware('permission:marketing.manage')->name('public-pages.update');

            Route::get('/events', [AdminWebinarEventController::class, 'index'])->middleware('permission:events.manage')->name('events');
            Route::post('/events', [AdminWebinarEventController::class, 'store'])->middleware('permission:events.manage')->name('events.store');
            Route::get('/events/{webinarEvent}', [AdminWebinarEventController::class, 'show'])->whereNumber('webinarEvent')->middleware('permission:events.manage')->name('events.edit');
            Route::put('/events/{webinarEvent}', [AdminWebinarEventController::class, 'update'])->whereNumber('webinarEvent')->middleware('permission:events.manage')->name('events.update');
            Route::patch('/events/{webinarEvent}/registrations/{registration}', [AdminWebinarEventController::class, 'updateRegistration'])->whereNumber('webinarEvent')->whereNumber('registration')->middleware('permission:events.manage')->name('events.registrations.update');

            Route::get('/users', [AdminOperationsController::class, 'users'])->middleware('permission:users.manage')->name('users');
            Route::post('/users', [AdminOperationsController::class, 'storeUser'])->middleware('permission:users.manage')->name('users.store');
            Route::patch('/users/{user}', [AdminOperationsController::class, 'updateUser'])->whereNumber('user')->middleware('permission:users.manage')->name('users.update');

            Route::get('/sessions', [AdminOperationsController::class, 'sessions'])->middleware('permission:sessions.manage')->name('sessions');
            Route::post('/cohorts', [AdminOperationsController::class, 'storeCohort'])->middleware('permission:cohorts.manage')->name('cohorts.store');
            Route::post('/sessions', [AdminOperationsController::class, 'storeSession'])->middleware('permission:sessions.manage')->name('sessions.store');
            Route::patch('/sessions/{liveSession}', [AdminOperationsController::class, 'updateSession'])->whereNumber('liveSession')->middleware('permission:sessions.manage')->name('sessions.update');
            Route::get('/sessions/{liveSession}/attendance', [AdminOperationsController::class, 'attendance'])->whereNumber('liveSession')->middleware('permission:sessions.manage')->name('sessions.attendance');
            Route::put('/sessions/{liveSession}/attendance', [AdminOperationsController::class, 'updateAttendance'])->whereNumber('liveSession')->middleware('permission:sessions.manage')->name('sessions.attendance.update');

            Route::get('/assessments', [AdminAssessmentController::class, 'index'])->middleware('permission:assessments.manage')->name('assessments');
            Route::post('/assignments', [AdminAssessmentController::class, 'storeAssignment'])->middleware('permission:assessments.manage')->name('assignments.store');
            Route::put('/assignments/{assignmentId}', [AdminAssessmentController::class, 'updateAssignment'])->whereNumber('assignmentId')->middleware('permission:assessments.manage')->name('assignments.update');
            Route::post('/quizzes', [AdminAssessmentController::class, 'storeQuiz'])->middleware('permission:assessments.manage')->name('quizzes.store');
            Route::patch('/quizzes/{quizId}', [AdminAssessmentController::class, 'updateQuiz'])->middleware('permission:assessments.manage')->name('quizzes.update');

            Route::get('/reviews', [AdminOperationsController::class, 'reviews'])->middleware('permission:reviews.moderate')->name('reviews');
            Route::patch('/reviews/{review}', [AdminOperationsController::class, 'updateReview'])->whereNumber('review')->middleware('permission:reviews.moderate')->name('reviews.update');
            Route::get('/inquiries', [AdminOperationsController::class, 'inquiries'])->middleware('permission:inquiries.manage')->name('inquiries');
            Route::patch('/inquiries/{inquiryId}', [AdminOperationsController::class, 'updateInquiry'])->whereNumber('inquiryId')->middleware('permission:inquiries.manage')->name('inquiries.update');
        });
        Route::get('/staff/publishing', [StaffPublishingController::class, 'index'])->middleware('permission:marketing.manage')->name('staff.publishing');
        Route::get('/staff/manage/surveys', [StaffPublishingController::class, 'surveys'])->middleware('permission:marketing.manage')->name('staff.manage.surveys');
        Route::get('/staff/manage/reports', [StaffPublishingController::class, 'reports'])->middleware('permission:marketing.manage')->name('staff.manage.reports');
        Route::put('/staff/publishing/insights/{insight}', [StaffPublishingController::class, 'updateInsight'])->whereNumber('insight')->middleware('permission:marketing.manage')->name('staff.publishing.insights.update');
        Route::delete('/staff/publishing/insights/{insight}', [StaffPublishingController::class, 'destroyInsight'])->whereNumber('insight')->middleware('permission:marketing.manage')->name('staff.publishing.insights.destroy');
        Route::put('/staff/publishing/jobs/{jobPost}', [StaffPublishingController::class, 'updateJob'])->whereNumber('jobPost')->middleware('permission:marketing.manage')->name('staff.publishing.jobs.update');
        Route::delete('/staff/publishing/jobs/{jobPost}', [StaffPublishingController::class, 'closeJob'])->whereNumber('jobPost')->middleware('permission:marketing.manage')->name('staff.publishing.jobs.close');
        Route::post('/staff/publishing/insights', [StaffPublishingController::class, 'storeInsight'])->middleware(['permission:marketing.manage', 'throttle:10,1'])->name('staff.publishing.insights.store');
        Route::post('/staff/publishing/jobs', [StaffPublishingController::class, 'storeJob'])->middleware(['permission:marketing.manage', 'throttle:10,1'])->name('staff.publishing.jobs.store');
        Route::patch('/staff/publishing/applications/{application}', [StaffPublishingController::class, 'updateApplication'])->middleware('permission:applications.manage')->name('staff.publishing.applications.update');
        Route::get('/staff/reviews', [StaffController::class, 'reviews'])->middleware('permission:assessments.grade')->name('staff.reviews');
        Route::get('/staff/reviews/{submissionId}', [StaffController::class, 'review'])->whereNumber('submissionId')->middleware('permission:assessments.grade')->name('staff.reviews.show');
        Route::post('/staff/reviews/{submissionId}', [StaffController::class, 'grade'])->whereNumber('submissionId')->middleware(['permission:assessments.grade', 'throttle:30,1'])->name('staff.reviews.grade');
    });
});

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook'])
    ->middleware([RequireStripeWebhookSecret::class, VerifyWebhookSignature::class])
    ->name('cashier.webhook');
