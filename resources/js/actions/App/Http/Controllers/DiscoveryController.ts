import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\DiscoveryController::surveys
 * @see app/Http/Controllers/DiscoveryController.php:18
 * @route '/surveys'
 */
export const surveys = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: surveys.url(options),
    method: 'get',
})

surveys.definition = {
    methods: ["get","head"],
    url: '/surveys',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DiscoveryController::surveys
 * @see app/Http/Controllers/DiscoveryController.php:18
 * @route '/surveys'
 */
surveys.url = (options?: RouteQueryOptions) => {
    return surveys.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::surveys
 * @see app/Http/Controllers/DiscoveryController.php:18
 * @route '/surveys'
 */
surveys.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: surveys.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DiscoveryController::surveys
 * @see app/Http/Controllers/DiscoveryController.php:18
 * @route '/surveys'
 */
surveys.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: surveys.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DiscoveryController::survey
 * @see app/Http/Controllers/DiscoveryController.php:28
 * @route '/surveys/{slug}'
 */
export const survey = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: survey.url(args, options),
    method: 'get',
})

survey.definition = {
    methods: ["get","head"],
    url: '/surveys/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DiscoveryController::survey
 * @see app/Http/Controllers/DiscoveryController.php:28
 * @route '/surveys/{slug}'
 */
survey.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return survey.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::survey
 * @see app/Http/Controllers/DiscoveryController.php:28
 * @route '/surveys/{slug}'
 */
survey.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: survey.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DiscoveryController::survey
 * @see app/Http/Controllers/DiscoveryController.php:28
 * @route '/surveys/{slug}'
 */
survey.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: survey.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DiscoveryController::submitSurvey
 * @see app/Http/Controllers/DiscoveryController.php:33
 * @route '/surveys/{slug}/responses'
 */
export const submitSurvey = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitSurvey.url(args, options),
    method: 'post',
})

submitSurvey.definition = {
    methods: ["post"],
    url: '/surveys/{slug}/responses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DiscoveryController::submitSurvey
 * @see app/Http/Controllers/DiscoveryController.php:33
 * @route '/surveys/{slug}/responses'
 */
submitSurvey.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return submitSurvey.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::submitSurvey
 * @see app/Http/Controllers/DiscoveryController.php:33
 * @route '/surveys/{slug}/responses'
 */
submitSurvey.post = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitSurvey.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DiscoveryController::reports
 * @see app/Http/Controllers/DiscoveryController.php:23
 * @route '/reports'
 */
export const reports = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reports.url(options),
    method: 'get',
})

reports.definition = {
    methods: ["get","head"],
    url: '/reports',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DiscoveryController::reports
 * @see app/Http/Controllers/DiscoveryController.php:23
 * @route '/reports'
 */
reports.url = (options?: RouteQueryOptions) => {
    return reports.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::reports
 * @see app/Http/Controllers/DiscoveryController.php:23
 * @route '/reports'
 */
reports.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reports.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DiscoveryController::reports
 * @see app/Http/Controllers/DiscoveryController.php:23
 * @route '/reports'
 */
reports.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reports.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DiscoveryController::report
 * @see app/Http/Controllers/DiscoveryController.php:76
 * @route '/reports/{slug}'
 */
export const report = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: report.url(args, options),
    method: 'get',
})

report.definition = {
    methods: ["get","head"],
    url: '/reports/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DiscoveryController::report
 * @see app/Http/Controllers/DiscoveryController.php:76
 * @route '/reports/{slug}'
 */
report.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return report.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::report
 * @see app/Http/Controllers/DiscoveryController.php:76
 * @route '/reports/{slug}'
 */
report.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: report.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DiscoveryController::report
 * @see app/Http/Controllers/DiscoveryController.php:76
 * @route '/reports/{slug}'
 */
report.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: report.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DiscoveryController::insights
 * @see app/Http/Controllers/DiscoveryController.php:81
 * @route '/insights'
 */
export const insights = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: insights.url(options),
    method: 'get',
})

insights.definition = {
    methods: ["get","head"],
    url: '/insights',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DiscoveryController::insights
 * @see app/Http/Controllers/DiscoveryController.php:81
 * @route '/insights'
 */
insights.url = (options?: RouteQueryOptions) => {
    return insights.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::insights
 * @see app/Http/Controllers/DiscoveryController.php:81
 * @route '/insights'
 */
insights.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: insights.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DiscoveryController::insights
 * @see app/Http/Controllers/DiscoveryController.php:81
 * @route '/insights'
 */
insights.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: insights.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DiscoveryController::insight
 * @see app/Http/Controllers/DiscoveryController.php:105
 * @route '/insights/{slug}'
 */
export const insight = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: insight.url(args, options),
    method: 'get',
})

insight.definition = {
    methods: ["get","head"],
    url: '/insights/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DiscoveryController::insight
 * @see app/Http/Controllers/DiscoveryController.php:105
 * @route '/insights/{slug}'
 */
insight.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return insight.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::insight
 * @see app/Http/Controllers/DiscoveryController.php:105
 * @route '/insights/{slug}'
 */
insight.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: insight.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DiscoveryController::insight
 * @see app/Http/Controllers/DiscoveryController.php:105
 * @route '/insights/{slug}'
 */
insight.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: insight.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DiscoveryController::jobs
 * @see app/Http/Controllers/DiscoveryController.php:163
 * @route '/careers'
 */
export const jobs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: jobs.url(options),
    method: 'get',
})

jobs.definition = {
    methods: ["get","head"],
    url: '/careers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DiscoveryController::jobs
 * @see app/Http/Controllers/DiscoveryController.php:163
 * @route '/careers'
 */
jobs.url = (options?: RouteQueryOptions) => {
    return jobs.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::jobs
 * @see app/Http/Controllers/DiscoveryController.php:163
 * @route '/careers'
 */
jobs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: jobs.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DiscoveryController::jobs
 * @see app/Http/Controllers/DiscoveryController.php:163
 * @route '/careers'
 */
jobs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: jobs.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DiscoveryController::submitJob
 * @see app/Http/Controllers/DiscoveryController.php:182
 * @route '/careers'
 */
export const submitJob = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitJob.url(options),
    method: 'post',
})

submitJob.definition = {
    methods: ["post"],
    url: '/careers',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DiscoveryController::submitJob
 * @see app/Http/Controllers/DiscoveryController.php:182
 * @route '/careers'
 */
submitJob.url = (options?: RouteQueryOptions) => {
    return submitJob.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::submitJob
 * @see app/Http/Controllers/DiscoveryController.php:182
 * @route '/careers'
 */
submitJob.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitJob.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DiscoveryController::job
 * @see app/Http/Controllers/DiscoveryController.php:218
 * @route '/careers/{slug}'
 */
export const job = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: job.url(args, options),
    method: 'get',
})

job.definition = {
    methods: ["get","head"],
    url: '/careers/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DiscoveryController::job
 * @see app/Http/Controllers/DiscoveryController.php:218
 * @route '/careers/{slug}'
 */
job.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return job.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DiscoveryController::job
 * @see app/Http/Controllers/DiscoveryController.php:218
 * @route '/careers/{slug}'
 */
job.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: job.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\DiscoveryController::job
 * @see app/Http/Controllers/DiscoveryController.php:218
 * @route '/careers/{slug}'
 */
job.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: job.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DiscoveryController::apply
 * @see app/Http/Controllers/DiscoveryController.php:226
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
* @see \App\Http\Controllers\DiscoveryController::apply
 * @see app/Http/Controllers/DiscoveryController.php:226
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
* @see \App\Http\Controllers\DiscoveryController::apply
 * @see app/Http/Controllers/DiscoveryController.php:226
 * @route '/careers/{slug}/apply'
 */
apply.post = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: apply.url(args, options),
    method: 'post',
})
const DiscoveryController = { surveys, survey, submitSurvey, reports, report, insights, insight, jobs, submitJob, job, apply }

export default DiscoveryController