import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Insights\SurveyController::store
 * @see app/Http/Controllers/Insights/SurveyController.php:78
 * @route '/surveys/{slug}/responses'
 */
export const store = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/surveys/{slug}/responses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Insights\SurveyController::store
 * @see app/Http/Controllers/Insights/SurveyController.php:78
 * @route '/surveys/{slug}/responses'
 */
store.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { slug: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    slug: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        slug: args.slug,
                }

    return store.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Insights\SurveyController::store
 * @see app/Http/Controllers/Insights/SurveyController.php:78
 * @route '/surveys/{slug}/responses'
 */
store.post = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})
const responses = {
    store: Object.assign(store, store),
}

export default responses