import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:256
 * @route '/staff/manage/reviews/{review}'
 */
export const update = (args: { review: string | number | { id: string | number } } | [review: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/staff/manage/reviews/{review}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:256
 * @route '/staff/manage/reviews/{review}'
 */
update.url = (args: { review: string | number | { id: string | number } } | [review: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { review: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { review: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    review: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        review: typeof args.review === 'object'
                ? args.review.id
                : args.review,
                }

    return update.definition.url
            .replace('{review}', parsedArgs.review.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminOperationsController::update
 * @see app/Http/Controllers/Staff/AdminOperationsController.php:256
 * @route '/staff/manage/reviews/{review}'
 */
update.patch = (args: { review: string | number | { id: string | number } } | [review: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})
const reviews = {
    update: Object.assign(update, update),
}

export default reviews