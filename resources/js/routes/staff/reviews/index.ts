import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\StaffController::show
 * @see app/Http/Controllers/StaffController.php:172
 * @route '/staff/reviews/{submissionId}'
 */
export const show = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/staff/reviews/{submissionId}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::show
 * @see app/Http/Controllers/StaffController.php:172
 * @route '/staff/reviews/{submissionId}'
 */
show.url = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { submissionId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    submissionId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        submissionId: args.submissionId,
                }

    return show.definition.url
            .replace('{submissionId}', parsedArgs.submissionId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::show
 * @see app/Http/Controllers/StaffController.php:172
 * @route '/staff/reviews/{submissionId}'
 */
show.get = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::show
 * @see app/Http/Controllers/StaffController.php:172
 * @route '/staff/reviews/{submissionId}'
 */
show.head = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffController::grade
 * @see app/Http/Controllers/StaffController.php:189
 * @route '/staff/reviews/{submissionId}'
 */
export const grade = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: grade.url(args, options),
    method: 'post',
})

grade.definition = {
    methods: ["post"],
    url: '/staff/reviews/{submissionId}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StaffController::grade
 * @see app/Http/Controllers/StaffController.php:189
 * @route '/staff/reviews/{submissionId}'
 */
grade.url = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { submissionId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    submissionId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        submissionId: args.submissionId,
                }

    return grade.definition.url
            .replace('{submissionId}', parsedArgs.submissionId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::grade
 * @see app/Http/Controllers/StaffController.php:189
 * @route '/staff/reviews/{submissionId}'
 */
grade.post = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: grade.url(args, options),
    method: 'post',
})
const reviews = {
    show: Object.assign(show, show),
grade: Object.assign(grade, grade),
}

export default reviews