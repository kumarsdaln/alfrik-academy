import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import courses from './courses'
import quizzes from './quizzes'
import lessons from './lessons'
import assignments from './assignments'
import sessions from './sessions'
import purchasesCfbf63 from './purchases'
/**
* @see \App\Http\Controllers\StudentProfileController::profile
 * @see app/Http/Controllers/StudentProfileController.php:22
 * @route '/learn/profile'
 */
export const profile = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(options),
    method: 'get',
})

profile.definition = {
    methods: ["get","head"],
    url: '/learn/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentProfileController::profile
 * @see app/Http/Controllers/StudentProfileController.php:22
 * @route '/learn/profile'
 */
profile.url = (options?: RouteQueryOptions) => {
    return profile.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::profile
 * @see app/Http/Controllers/StudentProfileController.php:22
 * @route '/learn/profile'
 */
profile.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: profile.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentProfileController::profile
 * @see app/Http/Controllers/StudentProfileController.php:22
 * @route '/learn/profile'
 */
profile.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: profile.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::schedule
 * @see app/Http/Controllers/StudentLearningController.php:187
 * @route '/learn/schedule'
 */
export const schedule = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: schedule.url(options),
    method: 'get',
})

schedule.definition = {
    methods: ["get","head"],
    url: '/learn/schedule',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::schedule
 * @see app/Http/Controllers/StudentLearningController.php:187
 * @route '/learn/schedule'
 */
schedule.url = (options?: RouteQueryOptions) => {
    return schedule.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::schedule
 * @see app/Http/Controllers/StudentLearningController.php:187
 * @route '/learn/schedule'
 */
schedule.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: schedule.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::schedule
 * @see app/Http/Controllers/StudentLearningController.php:187
 * @route '/learn/schedule'
 */
schedule.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: schedule.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::calendar
 * @see app/Http/Controllers/StudentLearningController.php:1027
 * @route '/learn/calendar.ics'
 */
export const calendar = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: calendar.url(options),
    method: 'get',
})

calendar.definition = {
    methods: ["get","head"],
    url: '/learn/calendar.ics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::calendar
 * @see app/Http/Controllers/StudentLearningController.php:1027
 * @route '/learn/calendar.ics'
 */
calendar.url = (options?: RouteQueryOptions) => {
    return calendar.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::calendar
 * @see app/Http/Controllers/StudentLearningController.php:1027
 * @route '/learn/calendar.ics'
 */
calendar.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: calendar.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::calendar
 * @see app/Http/Controllers/StudentLearningController.php:1027
 * @route '/learn/calendar.ics'
 */
calendar.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: calendar.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentBillingController::purchases
 * @see app/Http/Controllers/StudentBillingController.php:188
 * @route '/learn/purchases'
 */
export const purchases = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: purchases.url(options),
    method: 'get',
})

purchases.definition = {
    methods: ["get","head"],
    url: '/learn/purchases',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentBillingController::purchases
 * @see app/Http/Controllers/StudentBillingController.php:188
 * @route '/learn/purchases'
 */
purchases.url = (options?: RouteQueryOptions) => {
    return purchases.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::purchases
 * @see app/Http/Controllers/StudentBillingController.php:188
 * @route '/learn/purchases'
 */
purchases.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: purchases.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentBillingController::purchases
 * @see app/Http/Controllers/StudentBillingController.php:188
 * @route '/learn/purchases'
 */
purchases.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: purchases.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentBillingController::activity
 * @see app/Http/Controllers/StudentBillingController.php:364
 * @route '/learn/activity'
 */
export const activity = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: activity.url(options),
    method: 'get',
})

activity.definition = {
    methods: ["get","head"],
    url: '/learn/activity',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentBillingController::activity
 * @see app/Http/Controllers/StudentBillingController.php:364
 * @route '/learn/activity'
 */
activity.url = (options?: RouteQueryOptions) => {
    return activity.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::activity
 * @see app/Http/Controllers/StudentBillingController.php:364
 * @route '/learn/activity'
 */
activity.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: activity.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentBillingController::activity
 * @see app/Http/Controllers/StudentBillingController.php:364
 * @route '/learn/activity'
 */
activity.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: activity.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentBillingController::events
 * @see app/Http/Controllers/StudentBillingController.php:270
 * @route '/learn/events'
 */
export const events = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})

events.definition = {
    methods: ["get","head"],
    url: '/learn/events',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentBillingController::events
 * @see app/Http/Controllers/StudentBillingController.php:270
 * @route '/learn/events'
 */
events.url = (options?: RouteQueryOptions) => {
    return events.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentBillingController::events
 * @see app/Http/Controllers/StudentBillingController.php:270
 * @route '/learn/events'
 */
events.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: events.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentBillingController::events
 * @see app/Http/Controllers/StudentBillingController.php:270
 * @route '/learn/events'
 */
events.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: events.url(options),
    method: 'head',
})
const learn = {
    courses: Object.assign(courses, courses),
quizzes: Object.assign(quizzes, quizzes),
lessons: Object.assign(lessons, lessons),
assignments: Object.assign(assignments, assignments),
schedule: Object.assign(schedule, schedule),
calendar: Object.assign(calendar, calendar),
sessions: Object.assign(sessions, sessions),
purchases: Object.assign(purchases, purchasesCfbf63),
activity: Object.assign(activity, activity),
events: Object.assign(events, events),
}

export default learn