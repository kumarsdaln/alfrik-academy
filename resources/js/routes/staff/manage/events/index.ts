import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
import registrations from './registrations'
/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::store
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:38
 * @route '/staff/manage/events'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/events',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::store
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:38
 * @route '/staff/manage/events'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::store
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:38
 * @route '/staff/manage/events'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::edit
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:30
 * @route '/staff/manage/events/{webinarEvent}'
 */
export const edit = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/staff/manage/events/{webinarEvent}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::edit
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:30
 * @route '/staff/manage/events/{webinarEvent}'
 */
edit.url = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { webinarEvent: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { webinarEvent: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    webinarEvent: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        webinarEvent: typeof args.webinarEvent === 'object'
                ? args.webinarEvent.id
                : args.webinarEvent,
                }

    return edit.definition.url
            .replace('{webinarEvent}', parsedArgs.webinarEvent.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::edit
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:30
 * @route '/staff/manage/events/{webinarEvent}'
 */
edit.get = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::edit
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:30
 * @route '/staff/manage/events/{webinarEvent}'
 */
edit.head = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::update
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:55
 * @route '/staff/manage/events/{webinarEvent}'
 */
export const update = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/staff/manage/events/{webinarEvent}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::update
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:55
 * @route '/staff/manage/events/{webinarEvent}'
 */
update.url = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { webinarEvent: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { webinarEvent: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    webinarEvent: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        webinarEvent: typeof args.webinarEvent === 'object'
                ? args.webinarEvent.id
                : args.webinarEvent,
                }

    return update.definition.url
            .replace('{webinarEvent}', parsedArgs.webinarEvent.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::update
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:55
 * @route '/staff/manage/events/{webinarEvent}'
 */
update.put = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
const events = {
    store: Object.assign(store, store),
edit: Object.assign(edit, edit),
update: Object.assign(update, update),
registrations: Object.assign(registrations, registrations),
}

export default events