import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:96
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons'
 */
export const store = (args: { course: number | { id: number }, module: number | { id: number } } | [course: number | { id: number }, module: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/courses/{course}/modules/{module}/lessons',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:96
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons'
 */
store.url = (args: { course: number | { id: number }, module: number | { id: number } } | [course: number | { id: number }, module: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    course: args[0],
                    module: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        course: typeof args.course === 'object'
                ? args.course.id
                : args.course,
                                module: typeof args.module === 'object'
                ? args.module.id
                : args.module,
                }

    return store.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace('{module}', parsedArgs.module.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:96
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons'
 */
store.post = (args: { course: number | { id: number }, module: number | { id: number } } | [course: number | { id: number }, module: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroy
 * @see app/Http/Controllers/Staff/AdminCourseController.php:121
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons/{lesson}'
 */
export const destroy = (args: { course: number | { id: number }, module: number | { id: number }, lesson: number | { id: number } } | [course: number | { id: number }, module: number | { id: number }, lesson: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/staff/manage/courses/{course}/modules/{module}/lessons/{lesson}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroy
 * @see app/Http/Controllers/Staff/AdminCourseController.php:121
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons/{lesson}'
 */
destroy.url = (args: { course: number | { id: number }, module: number | { id: number }, lesson: number | { id: number } } | [course: number | { id: number }, module: number | { id: number }, lesson: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    course: args[0],
                    module: args[1],
                    lesson: args[2],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        course: typeof args.course === 'object'
                ? args.course.id
                : args.course,
                                module: typeof args.module === 'object'
                ? args.module.id
                : args.module,
                                lesson: typeof args.lesson === 'object'
                ? args.lesson.id
                : args.lesson,
                }

    return destroy.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace('{module}', parsedArgs.module.toString())
            .replace('{lesson}', parsedArgs.lesson.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroy
 * @see app/Http/Controllers/Staff/AdminCourseController.php:121
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons/{lesson}'
 */
destroy.delete = (args: { course: number | { id: number }, module: number | { id: number }, lesson: number | { id: number } } | [course: number | { id: number }, module: number | { id: number }, lesson: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const lessons = {
    store: Object.assign(store, store),
destroy: Object.assign(destroy, destroy),
}

export default lessons