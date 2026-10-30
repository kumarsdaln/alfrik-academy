import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StaffController::dashboard
 * @see app/Http/Controllers/StaffController.php:217
 * @route '/staff'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/staff',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::dashboard
 * @see app/Http/Controllers/StaffController.php:217
 * @route '/staff'
 */
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::dashboard
 * @see app/Http/Controllers/StaffController.php:217
 * @route '/staff'
 */
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::dashboard
 * @see app/Http/Controllers/StaffController.php:217
 * @route '/staff'
 */
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffController::gradebook
 * @see app/Http/Controllers/StaffController.php:18
 * @route '/staff/gradebook'
 */
export const gradebook = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: gradebook.url(options),
    method: 'get',
})

gradebook.definition = {
    methods: ["get","head"],
    url: '/staff/gradebook',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::gradebook
 * @see app/Http/Controllers/StaffController.php:18
 * @route '/staff/gradebook'
 */
gradebook.url = (options?: RouteQueryOptions) => {
    return gradebook.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::gradebook
 * @see app/Http/Controllers/StaffController.php:18
 * @route '/staff/gradebook'
 */
gradebook.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: gradebook.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::gradebook
 * @see app/Http/Controllers/StaffController.php:18
 * @route '/staff/gradebook'
 */
gradebook.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: gradebook.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffController::exportGradebook
 * @see app/Http/Controllers/StaffController.php:28
 * @route '/staff/gradebook/export'
 */
export const exportGradebook = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportGradebook.url(options),
    method: 'get',
})

exportGradebook.definition = {
    methods: ["get","head"],
    url: '/staff/gradebook/export',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::exportGradebook
 * @see app/Http/Controllers/StaffController.php:28
 * @route '/staff/gradebook/export'
 */
exportGradebook.url = (options?: RouteQueryOptions) => {
    return exportGradebook.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::exportGradebook
 * @see app/Http/Controllers/StaffController.php:28
 * @route '/staff/gradebook/export'
 */
exportGradebook.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportGradebook.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::exportGradebook
 * @see app/Http/Controllers/StaffController.php:28
 * @route '/staff/gradebook/export'
 */
exportGradebook.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportGradebook.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffController::reviews
 * @see app/Http/Controllers/StaffController.php:369
 * @route '/staff/reviews'
 */
export const reviews = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reviews.url(options),
    method: 'get',
})

reviews.definition = {
    methods: ["get","head"],
    url: '/staff/reviews',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::reviews
 * @see app/Http/Controllers/StaffController.php:369
 * @route '/staff/reviews'
 */
reviews.url = (options?: RouteQueryOptions) => {
    return reviews.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::reviews
 * @see app/Http/Controllers/StaffController.php:369
 * @route '/staff/reviews'
 */
reviews.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reviews.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::reviews
 * @see app/Http/Controllers/StaffController.php:369
 * @route '/staff/reviews'
 */
reviews.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reviews.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffController::review
 * @see app/Http/Controllers/StaffController.php:394
 * @route '/staff/reviews/{submissionId}'
 */
export const review = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: review.url(args, options),
    method: 'get',
})

review.definition = {
    methods: ["get","head"],
    url: '/staff/reviews/{submissionId}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffController::review
 * @see app/Http/Controllers/StaffController.php:394
 * @route '/staff/reviews/{submissionId}'
 */
review.url = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return review.definition.url
            .replace('{submissionId}', parsedArgs.submissionId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffController::review
 * @see app/Http/Controllers/StaffController.php:394
 * @route '/staff/reviews/{submissionId}'
 */
review.get = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: review.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffController::review
 * @see app/Http/Controllers/StaffController.php:394
 * @route '/staff/reviews/{submissionId}'
 */
review.head = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: review.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffController::grade
 * @see app/Http/Controllers/StaffController.php:418
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
 * @see app/Http/Controllers/StaffController.php:418
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
 * @see app/Http/Controllers/StaffController.php:418
 * @route '/staff/reviews/{submissionId}'
 */
grade.post = (args: { submissionId: string | number } | [submissionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: grade.url(args, options),
    method: 'post',
})
const StaffController = { dashboard, gradebook, exportGradebook, reviews, review, grade }

export default StaffController