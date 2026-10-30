import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Careers\JobController::index
 * @see app/Http/Controllers/Careers/JobController.php:14
 * @route '/careers'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/careers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Careers\JobController::index
 * @see app/Http/Controllers/Careers/JobController.php:14
 * @route '/careers'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Careers\JobController::index
 * @see app/Http/Controllers/Careers/JobController.php:14
 * @route '/careers'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Careers\JobController::index
 * @see app/Http/Controllers/Careers/JobController.php:14
 * @route '/careers'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Careers\JobController::show
 * @see app/Http/Controllers/Careers/JobController.php:59
 * @route '/careers/{slug}'
 */
export const show = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/careers/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Careers\JobController::show
 * @see app/Http/Controllers/Careers/JobController.php:59
 * @route '/careers/{slug}'
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
* @see \App\Http\Controllers\Careers\JobController::show
 * @see app/Http/Controllers/Careers/JobController.php:59
 * @route '/careers/{slug}'
 */
show.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Careers\JobController::show
 * @see app/Http/Controllers/Careers/JobController.php:59
 * @route '/careers/{slug}'
 */
show.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Careers\JobSubmissionController::submit
 * @see app/Http/Controllers/Careers/JobSubmissionController.php:14
 * @route '/careers/submit'
 */
export const submit = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/careers/submit',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Careers\JobSubmissionController::submit
 * @see app/Http/Controllers/Careers/JobSubmissionController.php:14
 * @route '/careers/submit'
 */
submit.url = (options?: RouteQueryOptions) => {
    return submit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Careers\JobSubmissionController::submit
 * @see app/Http/Controllers/Careers/JobSubmissionController.php:14
 * @route '/careers/submit'
 */
submit.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Careers\JobApplicationController::apply
 * @see app/Http/Controllers/Careers/JobApplicationController.php:13
 * @route '/careers/{slug}/apply'
 */
export const apply = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: apply.url(args, options),
    method: 'post',
})

apply.definition = {
    methods: ["post"],
    url: '/careers/{slug}/apply',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Careers\JobApplicationController::apply
 * @see app/Http/Controllers/Careers/JobApplicationController.php:13
 * @route '/careers/{slug}/apply'
 */
apply.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return apply.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Careers\JobApplicationController::apply
 * @see app/Http/Controllers/Careers/JobApplicationController.php:13
 * @route '/careers/{slug}/apply'
 */
apply.post = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: apply.url(args, options),
    method: 'post',
})
const careers = {
    index: Object.assign(index, index),
show: Object.assign(show, show),
submit: Object.assign(submit, submit),
apply: Object.assign(apply, apply),
}

export default careers