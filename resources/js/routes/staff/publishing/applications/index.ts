import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:286
 * @route '/staff/publishing/applications/{application}'
 */
export const update = (args: { application: number | { id: number } } | [application: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/staff/publishing/applications/{application}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:286
 * @route '/staff/publishing/applications/{application}'
 */
update.url = (args: { application: number | { id: number } } | [application: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { application: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { application: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    application: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        application: typeof args.application === 'object'
                ? args.application.id
                : args.application,
                }

    return update.definition.url
            .replace('{application}', parsedArgs.application.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::update
 * @see app/Http/Controllers/StaffPublishingController.php:286
 * @route '/staff/publishing/applications/{application}'
 */
update.patch = (args: { application: number | { id: number } } | [application: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})
const applications = {
    update: Object.assign(update, update),
}

export default applications