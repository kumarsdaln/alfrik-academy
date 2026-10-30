import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentProfileController::show
 * @see app/Http/Controllers/StudentProfileController.php:22
 * @route '/learn/profile'
 */
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/learn/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentProfileController::show
 * @see app/Http/Controllers/StudentProfileController.php:22
 * @route '/learn/profile'
 */
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::show
 * @see app/Http/Controllers/StudentProfileController.php:22
 * @route '/learn/profile'
 */
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentProfileController::show
 * @see app/Http/Controllers/StudentProfileController.php:22
 * @route '/learn/profile'
 */
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:77
 * @route '/learn/profile'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/learn/profile',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:77
 * @route '/learn/profile'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::update
 * @see app/Http/Controllers/StudentProfileController.php:77
 * @route '/learn/profile'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\StudentProfileController::learningPreferences
 * @see app/Http/Controllers/StudentProfileController.php:36
 * @route '/learn/settings/learning'
 */
export const learningPreferences = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: learningPreferences.url(options),
    method: 'get',
})

learningPreferences.definition = {
    methods: ["get","head"],
    url: '/learn/settings/learning',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentProfileController::learningPreferences
 * @see app/Http/Controllers/StudentProfileController.php:36
 * @route '/learn/settings/learning'
 */
learningPreferences.url = (options?: RouteQueryOptions) => {
    return learningPreferences.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::learningPreferences
 * @see app/Http/Controllers/StudentProfileController.php:36
 * @route '/learn/settings/learning'
 */
learningPreferences.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: learningPreferences.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentProfileController::learningPreferences
 * @see app/Http/Controllers/StudentProfileController.php:36
 * @route '/learn/settings/learning'
 */
learningPreferences.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: learningPreferences.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentProfileController::updatePreferences
 * @see app/Http/Controllers/StudentProfileController.php:97
 * @route '/learn/settings/learning'
 */
export const updatePreferences = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePreferences.url(options),
    method: 'put',
})

updatePreferences.definition = {
    methods: ["put"],
    url: '/learn/settings/learning',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StudentProfileController::updatePreferences
 * @see app/Http/Controllers/StudentProfileController.php:97
 * @route '/learn/settings/learning'
 */
updatePreferences.url = (options?: RouteQueryOptions) => {
    return updatePreferences.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::updatePreferences
 * @see app/Http/Controllers/StudentProfileController.php:97
 * @route '/learn/settings/learning'
 */
updatePreferences.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePreferences.url(options),
    method: 'put',
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
* @see \App\Http\Controllers\StudentProfileController::updateNotifications
 * @see app/Http/Controllers/StudentProfileController.php:111
 * @route '/learn/settings/notifications'
 */
export const updateNotifications = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateNotifications.url(options),
    method: 'put',
})

updateNotifications.definition = {
    methods: ["put"],
    url: '/learn/settings/notifications',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StudentProfileController::updateNotifications
 * @see app/Http/Controllers/StudentProfileController.php:111
 * @route '/learn/settings/notifications'
 */
updateNotifications.url = (options?: RouteQueryOptions) => {
    return updateNotifications.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::updateNotifications
 * @see app/Http/Controllers/StudentProfileController.php:111
 * @route '/learn/settings/notifications'
 */
updateNotifications.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateNotifications.url(options),
    method: 'put',
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

/**
* @see \App\Http\Controllers\StudentProfileController::updatePassword
 * @see app/Http/Controllers/StudentProfileController.php:152
 * @route '/learn/settings/security'
 */
export const updatePassword = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePassword.url(options),
    method: 'put',
})

updatePassword.definition = {
    methods: ["put"],
    url: '/learn/settings/security',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StudentProfileController::updatePassword
 * @see app/Http/Controllers/StudentProfileController.php:152
 * @route '/learn/settings/security'
 */
updatePassword.url = (options?: RouteQueryOptions) => {
    return updatePassword.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentProfileController::updatePassword
 * @see app/Http/Controllers/StudentProfileController.php:152
 * @route '/learn/settings/security'
 */
updatePassword.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePassword.url(options),
    method: 'put',
})
const StudentProfileController = { show, update, learningPreferences, updatePreferences, notifications, updateNotifications, security, updatePassword }

export default StudentProfileController