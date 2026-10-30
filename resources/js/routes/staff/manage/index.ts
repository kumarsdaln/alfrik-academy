import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
import courses0cf7c0 from './courses'
import categories from './categories'
import modules from './modules'
import lessons from './lessons'
import stories73b158 from './stories'
import publicPagesDa5469 from './public-pages'
import events735790 from './events'
import users48860f from './users'
import sessions2b6d10 from './sessions'
import cohorts from './cohorts'
import assignments from './assignments'
import quizzes from './quizzes'
import reviews83e781 from './reviews'
import inquiries02e891 from './inquiries'
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::index
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:32
 * @route '/staff/manage'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/staff/manage',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::index
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:32
 * @route '/staff/manage'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::index
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:32
 * @route '/staff/manage'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::index
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:32
 * @route '/staff/manage'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::audit
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:25
 * @route '/staff/manage/audit'
 */
export const audit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: audit.url(options),
    method: 'get',
})

audit.definition = {
    methods: ["get","head"],
    url: '/staff/manage/audit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::audit
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:25
 * @route '/staff/manage/audit'
 */
audit.url = (options?: RouteQueryOptions) => {
    return audit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::audit
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:25
 * @route '/staff/manage/audit'
 */
audit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: audit.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::audit
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:25
 * @route '/staff/manage/audit'
 */
audit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: audit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::courses
 * @see app/Http/Controllers/Staff/AdminCourseController.php:21
 * @route '/staff/manage/courses'
 */
export const courses = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(options),
    method: 'get',
})

courses.definition = {
    methods: ["get","head"],
    url: '/staff/manage/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::courses
 * @see app/Http/Controllers/Staff/AdminCourseController.php:21
 * @route '/staff/manage/courses'
 */
courses.url = (options?: RouteQueryOptions) => {
    return courses.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::courses
 * @see app/Http/Controllers/Staff/AdminCourseController.php:21
 * @route '/staff/manage/courses'
 */
courses.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminCourseController::courses
 * @see app/Http/Controllers/Staff/AdminCourseController.php:21
 * @route '/staff/manage/courses'
 */
courses.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: courses.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::stories
 * @see app/Http/Controllers/Staff/AdminStoryController.php:17
 * @route '/staff/manage/stories'
 */
export const stories = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: stories.url(options),
    method: 'get',
})

stories.definition = {
    methods: ["get","head"],
    url: '/staff/manage/stories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::stories
 * @see app/Http/Controllers/Staff/AdminStoryController.php:17
 * @route '/staff/manage/stories'
 */
stories.url = (options?: RouteQueryOptions) => {
    return stories.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminStoryController::stories
 * @see app/Http/Controllers/Staff/AdminStoryController.php:17
 * @route '/staff/manage/stories'
 */
stories.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: stories.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminStoryController::stories
 * @see app/Http/Controllers/Staff/AdminStoryController.php:17
 * @route '/staff/manage/stories'
 */
stories.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: stories.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminPublicPageController::publicPages
 * @see app/Http/Controllers/Staff/AdminPublicPageController.php:15
 * @route '/staff/manage/public-pages'
 */
export const publicPages = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: publicPages.url(options),
    method: 'get',
})

publicPages.definition = {
    methods: ["get","head"],
    url: '/staff/manage/public-pages',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminPublicPageController::publicPages
 * @see app/Http/Controllers/Staff/AdminPublicPageController.php:15
 * @route '/staff/manage/public-pages'
 */
publicPages.url = (options?: RouteQueryOptions) => {
    return publicPages.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminPublicPageController::publicPages
 * @see app/Http/Controllers/Staff/AdminPublicPageController.php:15
 * @route '/staff/manage/public-pages'
 */
publicPages.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: publicPages.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminPublicPageController::publicPages
 * @see app/Http/Controllers/Staff/AdminPublicPageController.php:15
 * @route '/staff/manage/public-pages'
 */
publicPages.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: publicPages.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::events
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:20
 * @route '/staff/manage/events'
 */
export const events = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})

events.definition = {
    methods: ["get","head"],
    url: '/staff/manage/events',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::events
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:20
 * @route '/staff/manage/events'
 */
events.url = (options?: RouteQueryOptions) => {
    return events.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::events
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:20
 * @route '/staff/manage/events'
 */
events.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::events
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:20
 * @route '/staff/manage/events'
 */
events.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: events.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::users
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:41
 * @route '/staff/manage/users'
 */
export const users = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: users.url(options),
    method: 'get',
})

users.definition = {
    methods: ["get","head"],
    url: '/staff/manage/users',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::users
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:41
 * @route '/staff/manage/users'
 */
users.url = (options?: RouteQueryOptions) => {
    return users.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::users
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:41
 * @route '/staff/manage/users'
 */
users.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: users.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::users
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:41
 * @route '/staff/manage/users'
 */
users.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: users.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::sessions
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:87
 * @route '/staff/manage/sessions'
 */
export const sessions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: sessions.url(options),
    method: 'get',
})

sessions.definition = {
    methods: ["get","head"],
    url: '/staff/manage/sessions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::sessions
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:87
 * @route '/staff/manage/sessions'
 */
sessions.url = (options?: RouteQueryOptions) => {
    return sessions.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::sessions
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:87
 * @route '/staff/manage/sessions'
 */
sessions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: sessions.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::sessions
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:87
 * @route '/staff/manage/sessions'
 */
sessions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: sessions.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::assessments
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:16
 * @route '/staff/manage/assessments'
 */
export const assessments = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: assessments.url(options),
    method: 'get',
})

assessments.definition = {
    methods: ["get","head"],
    url: '/staff/manage/assessments',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::assessments
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:16
 * @route '/staff/manage/assessments'
 */
assessments.url = (options?: RouteQueryOptions) => {
    return assessments.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::assessments
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:16
 * @route '/staff/manage/assessments'
 */
assessments.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: assessments.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::assessments
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:16
 * @route '/staff/manage/assessments'
 */
assessments.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: assessments.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::reviews
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:249
 * @route '/staff/manage/reviews'
 */
export const reviews = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reviews.url(options),
    method: 'get',
})

reviews.definition = {
    methods: ["get","head"],
    url: '/staff/manage/reviews',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::reviews
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:249
 * @route '/staff/manage/reviews'
 */
reviews.url = (options?: RouteQueryOptions) => {
    return reviews.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::reviews
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:249
 * @route '/staff/manage/reviews'
 */
reviews.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reviews.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::reviews
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:249
 * @route '/staff/manage/reviews'
 */
reviews.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reviews.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::inquiries
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:264
 * @route '/staff/manage/inquiries'
 */
export const inquiries = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: inquiries.url(options),
    method: 'get',
})

inquiries.definition = {
    methods: ["get","head"],
    url: '/staff/manage/inquiries',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::inquiries
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:264
 * @route '/staff/manage/inquiries'
 */
inquiries.url = (options?: RouteQueryOptions) => {
    return inquiries.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::inquiries
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:264
 * @route '/staff/manage/inquiries'
 */
inquiries.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: inquiries.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::inquiries
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:264
 * @route '/staff/manage/inquiries'
 */
inquiries.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: inquiries.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::surveys
 * @see app/Http/Controllers/StaffPublishingController.php:66
 * @route '/staff/manage/surveys'
 */
export const surveys = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: surveys.url(options),
    method: 'get',
})

surveys.definition = {
    methods: ["get","head"],
    url: '/staff/manage/surveys',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::surveys
 * @see app/Http/Controllers/StaffPublishingController.php:66
 * @route '/staff/manage/surveys'
 */
surveys.url = (options?: RouteQueryOptions) => {
    return surveys.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::surveys
 * @see app/Http/Controllers/StaffPublishingController.php:66
 * @route '/staff/manage/surveys'
 */
surveys.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: surveys.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffPublishingController::surveys
 * @see app/Http/Controllers/StaffPublishingController.php:66
 * @route '/staff/manage/surveys'
 */
surveys.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: surveys.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::reports
 * @see app/Http/Controllers/StaffPublishingController.php:71
 * @route '/staff/manage/reports'
 */
export const reports = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reports.url(options),
    method: 'get',
})

reports.definition = {
    methods: ["get","head"],
    url: '/staff/manage/reports',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::reports
 * @see app/Http/Controllers/StaffPublishingController.php:71
 * @route '/staff/manage/reports'
 */
reports.url = (options?: RouteQueryOptions) => {
    return reports.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::reports
 * @see app/Http/Controllers/StaffPublishingController.php:71
 * @route '/staff/manage/reports'
 */
reports.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reports.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffPublishingController::reports
 * @see app/Http/Controllers/StaffPublishingController.php:71
 * @route '/staff/manage/reports'
 */
reports.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reports.url(options),
    method: 'head',
})
const manage = {
    index: Object.assign(index, index),
audit: Object.assign(audit, audit),
courses: Object.assign(courses, courses0cf7c0),
categories: Object.assign(categories, categories),
modules: Object.assign(modules, modules),
lessons: Object.assign(lessons, lessons),
stories: Object.assign(stories, stories73b158),
publicPages: Object.assign(publicPages, publicPagesDa5469),
events: Object.assign(events, events735790),
users: Object.assign(users, users48860f),
sessions: Object.assign(sessions, sessions2b6d10),
cohorts: Object.assign(cohorts, cohorts),
assessments: Object.assign(assessments, assessments),
assignments: Object.assign(assignments, assignments),
quizzes: Object.assign(quizzes, quizzes),
reviews: Object.assign(reviews, reviews83e781),
inquiries: Object.assign(inquiries, inquiries02e891),
surveys: Object.assign(surveys, surveys),
reports: Object.assign(reports, reports),
}

export default manage