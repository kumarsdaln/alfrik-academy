import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::index
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:20
 * @route '/staff/manage/events'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/staff/manage/events',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::index
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:20
 * @route '/staff/manage/events'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::index
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:20
 * @route '/staff/manage/events'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::index
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:20
 * @route '/staff/manage/events'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

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
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::show
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:30
 * @route '/staff/manage/events/{webinarEvent}'
 */
export const show = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/staff/manage/events/{webinarEvent}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::show
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:30
 * @route '/staff/manage/events/{webinarEvent}'
 */
show.url = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{webinarEvent}', parsedArgs.webinarEvent.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::show
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:30
 * @route '/staff/manage/events/{webinarEvent}'
 */
show.get = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::show
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:30
 * @route '/staff/manage/events/{webinarEvent}'
 */
show.head = (args: { webinarEvent: number | { id: number } } | [webinarEvent: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
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

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::updateRegistration
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:75
 * @route '/staff/manage/events/{webinarEvent}/registrations/{registration}'
 */
export const updateRegistration = (args: { webinarEvent: number | { id: number }, registration: number | { id: number } } | [webinarEvent: number | { id: number }, registration: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateRegistration.url(args, options),
    method: 'patch',
})

updateRegistration.definition = {
    methods: ["patch"],
    url: '/staff/manage/events/{webinarEvent}/registrations/{registration}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::updateRegistration
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:75
 * @route '/staff/manage/events/{webinarEvent}/registrations/{registration}'
 */
updateRegistration.url = (args: { webinarEvent: number | { id: number }, registration: number | { id: number } } | [webinarEvent: number | { id: number }, registration: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    webinarEvent: args[0],
                    registration: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        webinarEvent: typeof args.webinarEvent === 'object'
                ? args.webinarEvent.id
                : args.webinarEvent,
                                registration: typeof args.registration === 'object'
                ? args.registration.id
                : args.registration,
                }

    return updateRegistration.definition.url
            .replace('{webinarEvent}', parsedArgs.webinarEvent.toString())
            .replace('{registration}', parsedArgs.registration.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminWebinarEventController::updateRegistration
 * @see app/Http/Controllers/Staff/AdminWebinarEventController.php:75
 * @route '/staff/manage/events/{webinarEvent}/registrations/{registration}'
 */
updateRegistration.patch = (args: { webinarEvent: number | { id: number }, registration: number | { id: number } } | [webinarEvent: number | { id: number }, registration: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateRegistration.url(args, options),
    method: 'patch',
})
const AdminWebinarEventController = { index, store, show, update, updateRegistration }

export default AdminWebinarEventController