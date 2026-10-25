import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\WebinarEventController::index
 * @see app/Http/Controllers/WebinarEventController.php:18
 * @route '/events'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/events',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\WebinarEventController::index
 * @see app/Http/Controllers/WebinarEventController.php:18
 * @route '/events'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\WebinarEventController::index
 * @see app/Http/Controllers/WebinarEventController.php:18
 * @route '/events'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\WebinarEventController::index
 * @see app/Http/Controllers/WebinarEventController.php:18
 * @route '/events'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\WebinarEventController::show
 * @see app/Http/Controllers/WebinarEventController.php:35
 * @route '/events/{event}'
 */
export const show = (args: { event: string | number | { slug: string | number } } | [event: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/events/{event}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\WebinarEventController::show
 * @see app/Http/Controllers/WebinarEventController.php:35
 * @route '/events/{event}'
 */
show.url = (args: { event: string | number | { slug: string | number } } | [event: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { event: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
            args = { event: args.slug }
        }
    
    if (Array.isArray(args)) {
        args = {
                    event: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        event: typeof args.event === 'object'
                ? args.event.slug
                : args.event,
                }

    return show.definition.url
            .replace('{event}', parsedArgs.event.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\WebinarEventController::show
 * @see app/Http/Controllers/WebinarEventController.php:35
 * @route '/events/{event}'
 */
show.get = (args: { event: string | number | { slug: string | number } } | [event: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\WebinarEventController::show
 * @see app/Http/Controllers/WebinarEventController.php:35
 * @route '/events/{event}'
 */
show.head = (args: { event: string | number | { slug: string | number } } | [event: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\WebinarEventController::register
 * @see app/Http/Controllers/WebinarEventController.php:72
 * @route '/events/{event}/register'
 */
export const register = (args: { event: string | number | { slug: string | number } } | [event: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(args, options),
    method: 'post',
})

register.definition = {
    methods: ["post"],
    url: '/events/{event}/register',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\WebinarEventController::register
 * @see app/Http/Controllers/WebinarEventController.php:72
 * @route '/events/{event}/register'
 */
register.url = (args: { event: string | number | { slug: string | number } } | [event: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { event: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
            args = { event: args.slug }
        }
    
    if (Array.isArray(args)) {
        args = {
                    event: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        event: typeof args.event === 'object'
                ? args.event.slug
                : args.event,
                }

    return register.definition.url
            .replace('{event}', parsedArgs.event.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\WebinarEventController::register
 * @see app/Http/Controllers/WebinarEventController.php:72
 * @route '/events/{event}/register'
 */
register.post = (args: { event: string | number | { slug: string | number } } | [event: string | number | { slug: string | number } ] | string | number | { slug: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(args, options),
    method: 'post',
})
const WebinarEventController = { index, show, register }

export default WebinarEventController