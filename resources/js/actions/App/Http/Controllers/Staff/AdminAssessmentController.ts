import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::index
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:16
 * @route '/staff/manage/assessments'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/staff/manage/assessments',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::index
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:16
 * @route '/staff/manage/assessments'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::index
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:16
 * @route '/staff/manage/assessments'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::index
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:16
 * @route '/staff/manage/assessments'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::storeAssignment
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:27
 * @route '/staff/manage/assignments'
 */
export const storeAssignment = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeAssignment.url(options),
    method: 'post',
})

storeAssignment.definition = {
    methods: ["post"],
    url: '/staff/manage/assignments',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::storeAssignment
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:27
 * @route '/staff/manage/assignments'
 */
storeAssignment.url = (options?: RouteQueryOptions) => {
    return storeAssignment.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::storeAssignment
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:27
 * @route '/staff/manage/assignments'
 */
storeAssignment.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeAssignment.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::updateAssignment
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:42
 * @route '/staff/manage/assignments/{assignmentId}'
 */
export const updateAssignment = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateAssignment.url(args, options),
    method: 'put',
})

updateAssignment.definition = {
    methods: ["put"],
    url: '/staff/manage/assignments/{assignmentId}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::updateAssignment
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:42
 * @route '/staff/manage/assignments/{assignmentId}'
 */
updateAssignment.url = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { assignmentId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    assignmentId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        assignmentId: args.assignmentId,
                }

    return updateAssignment.definition.url
            .replace('{assignmentId}', parsedArgs.assignmentId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::updateAssignment
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:42
 * @route '/staff/manage/assignments/{assignmentId}'
 */
updateAssignment.put = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateAssignment.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::storeQuiz
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:55
 * @route '/staff/manage/quizzes'
 */
export const storeQuiz = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeQuiz.url(options),
    method: 'post',
})

storeQuiz.definition = {
    methods: ["post"],
    url: '/staff/manage/quizzes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::storeQuiz
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:55
 * @route '/staff/manage/quizzes'
 */
storeQuiz.url = (options?: RouteQueryOptions) => {
    return storeQuiz.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::storeQuiz
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:55
 * @route '/staff/manage/quizzes'
 */
storeQuiz.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeQuiz.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::updateQuiz
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:94
 * @route '/staff/manage/quizzes/{quizId}'
 */
export const updateQuiz = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateQuiz.url(args, options),
    method: 'patch',
})

updateQuiz.definition = {
    methods: ["patch"],
    url: '/staff/manage/quizzes/{quizId}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::updateQuiz
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:94
 * @route '/staff/manage/quizzes/{quizId}'
 */
updateQuiz.url = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { quizId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    quizId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        quizId: args.quizId,
                }

    return updateQuiz.definition.url
            .replace('{quizId}', parsedArgs.quizId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminAssessmentController::updateQuiz
 * @see app/Http/Controllers/Staff/AdminAssessmentController.php:94
 * @route '/staff/manage/quizzes/{quizId}'
 */
updateQuiz.patch = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: updateQuiz.url(args, options),
    method: 'patch',
})
const AdminAssessmentController = { index, storeAssignment, updateAssignment, storeQuiz, updateQuiz }

export default AdminAssessmentController