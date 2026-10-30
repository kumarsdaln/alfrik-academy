import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Insights\SurveyController::index
 * @see app/Http/Controllers/Insights/SurveyController.php:16
 * @route '/surveys'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/surveys',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Insights\SurveyController::index
 * @see app/Http/Controllers/Insights/SurveyController.php:16
 * @route '/surveys'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Insights\SurveyController::index
 * @see app/Http/Controllers/Insights/SurveyController.php:16
 * @route '/surveys'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Insights\SurveyController::index
 * @see app/Http/Controllers/Insights/SurveyController.php:16
 * @route '/surveys'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Insights\SurveyController::show
 * @see app/Http/Controllers/Insights/SurveyController.php:33
 * @route '/surveys/{slug}'
 */
export const show = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/surveys/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Insights\SurveyController::show
 * @see app/Http/Controllers/Insights/SurveyController.php:33
 * @route '/surveys/{slug}'
 */
show.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Insights\SurveyController::show
 * @see app/Http/Controllers/Insights/SurveyController.php:33
 * @route '/surveys/{slug}'
 */
show.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Insights\SurveyController::show
 * @see app/Http/Controllers/Insights/SurveyController.php:33
 * @route '/surveys/{slug}'
 */
show.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Insights\SurveyController::submit
 * @see app/Http/Controllers/Insights/SurveyController.php:78
 * @route '/surveys/{slug}/responses'
 */
export const submit = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/surveys/{slug}/responses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Insights\SurveyController::submit
 * @see app/Http/Controllers/Insights/SurveyController.php:78
 * @route '/surveys/{slug}/responses'
 */
submit.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return submit.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Insights\SurveyController::submit
 * @see app/Http/Controllers/Insights/SurveyController.php:78
 * @route '/surveys/{slug}/responses'
 */
submit.post = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})
const SurveyController = { index, show, submit }

export default SurveyController