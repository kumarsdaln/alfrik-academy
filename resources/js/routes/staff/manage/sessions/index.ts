import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
import attendanceC12b95 from './attendance'
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::store
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:121
 * @route '/staff/manage/sessions'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/sessions',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::store
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:121
 * @route '/staff/manage/sessions'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::store
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:121
 * @route '/staff/manage/sessions'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:160
 * @route '/staff/manage/sessions/{liveSession}'
 */
export const update = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/staff/manage/sessions/{liveSession}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:160
 * @route '/staff/manage/sessions/{liveSession}'
 */
update.url = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { liveSession: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { liveSession: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    liveSession: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        liveSession: typeof args.liveSession === 'object'
                ? args.liveSession.id
                : args.liveSession,
                }

    return update.definition.url
            .replace('{liveSession}', parsedArgs.liveSession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:160
 * @route '/staff/manage/sessions/{liveSession}'
 */
update.patch = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::attendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:184
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
export const attendance = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: attendance.url(args, options),
    method: 'get',
})

attendance.definition = {
    methods: ["get","head"],
    url: '/staff/manage/sessions/{liveSession}/attendance',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::attendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:184
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
attendance.url = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { liveSession: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { liveSession: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    liveSession: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        liveSession: typeof args.liveSession === 'object'
                ? args.liveSession.id
                : args.liveSession,
                }

    return attendance.definition.url
            .replace('{liveSession}', parsedArgs.liveSession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::attendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:184
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
attendance.get = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: attendance.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::attendance
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:184
 * @route '/staff/manage/sessions/{liveSession}/attendance'
 */
attendance.head = (args: { liveSession: string | number | { id: string | number } } | [liveSession: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: attendance.url(args, options),
    method: 'head',
})
const sessions = {
    store: Object.assign(store, store),
update: Object.assign(update, update),
attendance: Object.assign(attendance, attendanceC12b95),
}

export default sessions