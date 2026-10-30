import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentProfileController::learning
 * @see app/Http/Controllers/StudentProfileController.php:36
 * @route '/learn/settings/learning'
 */
export const learning = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: learning.url(options),
    method: 'get',
})

learning.definition = {
    methods: ["get","head"],
    url: '/learn/settings/learning',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentProfileController::learning
 * @see app/Http/Controllers/StudentProfileController.php:36
 * @route '/learn/settings/learning'
 */
learning.url = (options?: RouteQueryOptions) => {
    return learning.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::learning
 * @see app/Http/Controllers/StudentProfileController.php:36
 * @route '/learn/settings/learning'
 */
learning.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: learning.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentProfileController::learning
 * @see app/Http/Controllers/StudentProfileController.php:36
 * @route '/learn/settings/learning'
 */
learning.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: learning.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentProfileController::notifications
 * @see app/Http/Controllers/StudentProfileController.php:46
 * @route '/learn/settings/notifications'
 */
export const notifications = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: notifications.url(options),
    method: 'get',
})

notifications.definition = {
    methods: ["get","head"],
    url: '/learn/settings/notifications',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentProfileController::notifications
 * @see app/Http/Controllers/StudentProfileController.php:46
 * @route '/learn/settings/notifications'
 */
notifications.url = (options?: RouteQueryOptions) => {
    return notifications.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::notifications
 * @see app/Http/Controllers/StudentProfileController.php:46
 * @route '/learn/settings/notifications'
 */
notifications.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: notifications.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentProfileController::notifications
 * @see app/Http/Controllers/StudentProfileController.php:46
 * @route '/learn/settings/notifications'
 */
notifications.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: notifications.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentProfileController::security
 * @see app/Http/Controllers/StudentProfileController.php:65
 * @route '/learn/settings/security'
 */
export const security = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: security.url(options),
    method: 'get',
})

security.definition = {
    methods: ["get","head"],
    url: '/learn/settings/security',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentProfileController::security
 * @see app/Http/Controllers/StudentProfileController.php:65
 * @route '/learn/settings/security'
 */
security.url = (options?: RouteQueryOptions) => {
    return security.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::security
 * @see app/Http/Controllers/StudentProfileController.php:65
 * @route '/learn/settings/security'
 */
security.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: security.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentProfileController::security
 * @see app/Http/Controllers/StudentProfileController.php:65
 * @route '/learn/settings/security'
 */
security.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: security.url(options),
    method: 'head',
})