import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:87
 * @route '/staff/manage/courses/{course}/modules'
 */
export const store = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/courses/{course}/modules',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:87
 * @route '/staff/manage/courses/{course}/modules'
 */
store.url = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { course: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    course: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        course: typeof args.course === 'object'
                ? args.course.id
                : args.course,
                }

    return store.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:87
 * @route '/staff/manage/courses/{course}/modules'
 */
store.post = (args: { course: number | { id: number } } | [course: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroy
 * @see app/Http/Controllers/Staff/AdminCourseController.php:113
 * @route '/staff/manage/courses/{course}/modules/{module}'
 */
export const destroy = (args: { course: number | { id: number }, module: number | { id: number } } | [course: number | { id: number }, module: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/staff/manage/courses/{course}/modules/{module}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroy
 * @see app/Http/Controllers/Staff/AdminCourseController.php:113
 * @route '/staff/manage/courses/{course}/modules/{module}'
 */
destroy.url = (args: { course: number | { id: number }, module: number | { id: number } } | [course: number | { id: number }, module: number | { id: number } ], options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace('{module}', parsedArgs.module.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroy
 * @see app/Http/Controllers/Staff/AdminCourseController.php:113
 * @route '/staff/manage/courses/{course}/modules/{module}'
 */
destroy.delete = (args: { course: number | { id: number }, module: number | { id: number } } | [course: number | { id: number }, module: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const modules = {
    store: Object.assign(store, store),
destroy: Object.assign(destroy, destroy),
}

export default modules