import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Careers\JobSubmissionController::store
 * @see app/Http/Controllers/Careers/JobSubmissionController.php:14
 * @route '/careers/submit'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/careers/submit',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Careers\JobSubmissionController::store
 * @see app/Http/Controllers/Careers/JobSubmissionController.php:14
 * @route '/careers/submit'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Careers\JobSubmissionController::store
 * @see app/Http/Controllers/Careers/JobSubmissionController.php:14
 * @route '/careers/submit'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})
const JobSubmissionController = { store }

export default JobSubmissionController