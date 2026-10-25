import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StaffPublishingController::index
 * @see app/Http/Controllers/StaffPublishingController.php:18
 * @route '/staff/publishing'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/staff/publishing',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::index
 * @see app/Http/Controllers/StaffPublishingController.php:18
 * @route '/staff/publishing'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::index
 * @see app/Http/Controllers/StaffPublishingController.php:18
 * @route '/staff/publishing'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffPublishingController::index
 * @see app/Http/Controllers/StaffPublishingController.php:18
 * @route '/staff/publishing'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::surveys
 * @see app/Http/Controllers/StaffPublishingController.php:37
 * @route '/staff/manage/surveys'
 */
export const surveys = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: surveys.url(options),
    method: 'get',
})

surveys.definition = {
    methods: ["get","head"],
    url: '/staff/manage/surveys',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::surveys
 * @see app/Http/Controllers/StaffPublishingController.php:37
 * @route '/staff/manage/surveys'
 */
surveys.url = (options?: RouteQueryOptions) => {
    return surveys.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::surveys
 * @see app/Http/Controllers/StaffPublishingController.php:37
 * @route '/staff/manage/surveys'
 */
surveys.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: surveys.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffPublishingController::surveys
 * @see app/Http/Controllers/StaffPublishingController.php:37
 * @route '/staff/manage/surveys'
 */
surveys.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: surveys.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::reports
 * @see app/Http/Controllers/StaffPublishingController.php:42
 * @route '/staff/manage/reports'
 */
export const reports = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reports.url(options),
    method: 'get',
})

reports.definition = {
    methods: ["get","head"],
    url: '/staff/manage/reports',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::reports
 * @see app/Http/Controllers/StaffPublishingController.php:42
 * @route '/staff/manage/reports'
 */
reports.url = (options?: RouteQueryOptions) => {
    return reports.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::reports
 * @see app/Http/Controllers/StaffPublishingController.php:42
 * @route '/staff/manage/reports'
 */
reports.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reports.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StaffPublishingController::reports
 * @see app/Http/Controllers/StaffPublishingController.php:42
 * @route '/staff/manage/reports'
 */
reports.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reports.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::updateInsight
 * @see app/Http/Controllers/StaffPublishingController.php:144
 * @route '/staff/publishing/insights/{insight}'
 */
export const updateInsight = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateInsight.url(args, options),
    method: 'put',
})

updateInsight.definition = {
    methods: ["put"],
    url: '/staff/publishing/insights/{insight}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::updateInsight
 * @see app/Http/Controllers/StaffPublishingController.php:144
 * @route '/staff/publishing/insights/{insight}'
 */
updateInsight.url = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { insight: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { insight: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    insight: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        insight: typeof args.insight === 'object'
                ? args.insight.id
                : args.insight,
                }

    return updateInsight.definition.url
            .replace('{insight}', parsedArgs.insight.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::updateInsight
 * @see app/Http/Controllers/StaffPublishingController.php:144
 * @route '/staff/publishing/insights/{insight}'
 */
updateInsight.put = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateInsight.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::destroyInsight
 * @see app/Http/Controllers/StaffPublishingController.php:178
 * @route '/staff/publishing/insights/{insight}'
 */
export const destroyInsight = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyInsight.url(args, options),
    method: 'delete',
})

destroyInsight.definition = {
    methods: ["delete"],
    url: '/staff/publishing/insights/{insight}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::destroyInsight
 * @see app/Http/Controllers/StaffPublishingController.php:178
 * @route '/staff/publishing/insights/{insight}'
 */
destroyInsight.url = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { insight: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { insight: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    insight: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        insight: typeof args.insight === 'object'
                ? args.insight.id
                : args.insight,
                }

    return destroyInsight.definition.url
            .replace('{insight}', parsedArgs.insight.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::destroyInsight
 * @see app/Http/Controllers/StaffPublishingController.php:178
 * @route '/staff/publishing/insights/{insight}'
 */
destroyInsight.delete = (args: { insight: string | number | { id: string | number } } | [insight: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyInsight.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::updateJob
 * @see app/Http/Controllers/StaffPublishingController.php:186
 * @route '/staff/publishing/jobs/{jobPost}'
 */
export const updateJob = (args: { jobPost: string | number | { id: string | number } } | [jobPost: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateJob.url(args, options),
    method: 'put',
})

updateJob.definition = {
    methods: ["put"],
    url: '/staff/publishing/jobs/{jobPost}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::updateJob
 * @see app/Http/Controllers/StaffPublishingController.php:186
 * @route '/staff/publishing/jobs/{jobPost}'
 */
updateJob.url = (args: { jobPost: string | number | { id: string | number } } | [jobPost: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { jobPost: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { jobPost: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    jobPost: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        jobPost: typeof args.jobPost === 'object'
                ? args.jobPost.id
                : args.jobPost,
                }

    return updateJob.definition.url
            .replace('{jobPost}', parsedArgs.jobPost.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::updateJob
 * @see app/Http/Controllers/StaffPublishingController.php:186
 * @route '/staff/publishing/jobs/{jobPost}'
 */
updateJob.put = (args: { jobPost: string | number | { id: string | number } } | [jobPost: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateJob.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::closeJob
 * @see app/Http/Controllers/StaffPublishingController.php:205
 * @route '/staff/publishing/jobs/{jobPost}'
 */
export const closeJob = (args: { jobPost: string | number | { id: string | number } } | [jobPost: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: closeJob.url(args, options),
    method: 'delete',
})

closeJob.definition = {
    methods: ["delete"],
    url: '/staff/publishing/jobs/{jobPost}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::closeJob
 * @see app/Http/Controllers/StaffPublishingController.php:205
 * @route '/staff/publishing/jobs/{jobPost}'
 */
closeJob.url = (args: { jobPost: string | number | { id: string | number } } | [jobPost: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { jobPost: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { jobPost: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    jobPost: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        jobPost: typeof args.jobPost === 'object'
                ? args.jobPost.id
                : args.jobPost,
                }

    return closeJob.definition.url
            .replace('{jobPost}', parsedArgs.jobPost.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::closeJob
 * @see app/Http/Controllers/StaffPublishingController.php:205
 * @route '/staff/publishing/jobs/{jobPost}'
 */
closeJob.delete = (args: { jobPost: string | number | { id: string | number } } | [jobPost: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: closeJob.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::storeInsight
 * @see app/Http/Controllers/StaffPublishingController.php:83
 * @route '/staff/publishing/insights'
 */
export const storeInsight = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeInsight.url(options),
    method: 'post',
})

storeInsight.definition = {
    methods: ["post"],
    url: '/staff/publishing/insights',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::storeInsight
 * @see app/Http/Controllers/StaffPublishingController.php:83
 * @route '/staff/publishing/insights'
 */
storeInsight.url = (options?: RouteQueryOptions) => {
    return storeInsight.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::storeInsight
 * @see app/Http/Controllers/StaffPublishingController.php:83
 * @route '/staff/publishing/insights'
 */
storeInsight.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeInsight.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::storeJob
 * @see app/Http/Controllers/StaffPublishingController.php:114
 * @route '/staff/publishing/jobs'
 */
export const storeJob = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeJob.url(options),
    method: 'post',
})

storeJob.definition = {
    methods: ["post"],
    url: '/staff/publishing/jobs',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::storeJob
 * @see app/Http/Controllers/StaffPublishingController.php:114
 * @route '/staff/publishing/jobs'
 */
storeJob.url = (options?: RouteQueryOptions) => {
    return storeJob.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::storeJob
 * @see app/Http/Controllers/StaffPublishingController.php:114
 * @route '/staff/publishing/jobs'
 */
storeJob.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeJob.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StaffPublishingController::updateApplication
 * @see app/Http/Controllers/StaffPublishingController.php:135
 * @route '/staff/publishing/applications/{application}'
 */
export const updateApplication = (args: { application: string | number | { id: string | number } } | [application: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateApplication.url(args, options),
    method: 'patch',
})

updateApplication.definition = {
    methods: ["patch"],
    url: '/staff/publishing/applications/{application}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\StaffPublishingController::updateApplication
 * @see app/Http/Controllers/StaffPublishingController.php:135
 * @route '/staff/publishing/applications/{application}'
 */
updateApplication.url = (args: { application: string | number | { id: string | number } } | [application: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return updateApplication.definition.url
            .replace('{application}', parsedArgs.application.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StaffPublishingController::updateApplication
 * @see app/Http/Controllers/StaffPublishingController.php:135
 * @route '/staff/publishing/applications/{application}'
 */
updateApplication.patch = (args: { application: string | number | { id: string | number } } | [application: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateApplication.url(args, options),
    method: 'patch',
})
const StaffPublishingController = { index, surveys, reports, updateInsight, destroyInsight, updateJob, closeJob, storeInsight, storeJob, updateApplication }

export default StaffPublishingController