import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\AdminCourseController::index
 * @see app/Http/Controllers/Staff/AdminCourseController.php:21
 * @route '/staff/manage/courses'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/staff/manage/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::index
 * @see app/Http/Controllers/Staff/AdminCourseController.php:21
 * @route '/staff/manage/courses'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::index
 * @see app/Http/Controllers/Staff/AdminCourseController.php:21
 * @route '/staff/manage/courses'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminCourseController::index
 * @see app/Http/Controllers/Staff/AdminCourseController.php:21
 * @route '/staff/manage/courses'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:40
 * @route '/staff/manage/courses'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/staff/manage/courses',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:40
 * @route '/staff/manage/courses'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::store
 * @see app/Http/Controllers/Staff/AdminCourseController.php:40
 * @route '/staff/manage/courses'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::edit
 * @see app/Http/Controllers/Staff/AdminCourseController.php:76
 * @route '/staff/manage/courses/{course}'
 */
export const edit = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/staff/manage/courses/{course}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::edit
 * @see app/Http/Controllers/Staff/AdminCourseController.php:76
 * @route '/staff/manage/courses/{course}'
 */
edit.url = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::edit
 * @see app/Http/Controllers/Staff/AdminCourseController.php:76
 * @route '/staff/manage/courses/{course}'
 */
edit.get = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\AdminCourseController::edit
 * @see app/Http/Controllers/Staff/AdminCourseController.php:76
 * @route '/staff/manage/courses/{course}'
 */
edit.head = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::update
 * @see app/Http/Controllers/Staff/AdminCourseController.php:56
 * @route '/staff/manage/courses/{course}'
 */
export const update = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/staff/manage/courses/{course}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::update
 * @see app/Http/Controllers/Staff/AdminCourseController.php:56
 * @route '/staff/manage/courses/{course}'
 */
update.url = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::update
 * @see app/Http/Controllers/Staff/AdminCourseController.php:56
 * @route '/staff/manage/courses/{course}'
 */
update.put = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeCategory
 * @see app/Http/Controllers/Staff/AdminCourseController.php:30
 * @route '/staff/manage/categories'
 */
export const storeCategory = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeCategory.url(options),
    method: 'post',
})

storeCategory.definition = {
    methods: ["post"],
    url: '/staff/manage/categories',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeCategory
 * @see app/Http/Controllers/Staff/AdminCourseController.php:30
 * @route '/staff/manage/categories'
 */
storeCategory.url = (options?: RouteQueryOptions) => {
    return storeCategory.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeCategory
 * @see app/Http/Controllers/Staff/AdminCourseController.php:30
 * @route '/staff/manage/categories'
 */
storeCategory.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeCategory.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeModule
 * @see app/Http/Controllers/Staff/AdminCourseController.php:87
 * @route '/staff/manage/courses/{course}/modules'
 */
export const storeModule = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeModule.url(args, options),
    method: 'post',
})

storeModule.definition = {
    methods: ["post"],
    url: '/staff/manage/courses/{course}/modules',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeModule
 * @see app/Http/Controllers/Staff/AdminCourseController.php:87
 * @route '/staff/manage/courses/{course}/modules'
 */
storeModule.url = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions) => {
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

    return storeModule.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeModule
 * @see app/Http/Controllers/Staff/AdminCourseController.php:87
 * @route '/staff/manage/courses/{course}/modules'
 */
storeModule.post = (args: { course: string | number | { id: string | number } } | [course: string | number | { id: string | number } ] | string | number | { id: string | number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeModule.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroyModule
 * @see app/Http/Controllers/Staff/AdminCourseController.php:113
 * @route '/staff/manage/courses/{course}/modules/{module}'
 */
export const destroyModule = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyModule.url(args, options),
    method: 'delete',
})

destroyModule.definition = {
    methods: ["delete"],
    url: '/staff/manage/courses/{course}/modules/{module}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroyModule
 * @see app/Http/Controllers/Staff/AdminCourseController.php:113
 * @route '/staff/manage/courses/{course}/modules/{module}'
 */
destroyModule.url = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
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

    return destroyModule.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace('{module}', parsedArgs.module.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroyModule
 * @see app/Http/Controllers/Staff/AdminCourseController.php:113
 * @route '/staff/manage/courses/{course}/modules/{module}'
 */
destroyModule.delete = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyModule.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeLesson
 * @see app/Http/Controllers/Staff/AdminCourseController.php:96
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons'
 */
export const storeLesson = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeLesson.url(args, options),
    method: 'post',
})

storeLesson.definition = {
    methods: ["post"],
    url: '/staff/manage/courses/{course}/modules/{module}/lessons',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeLesson
 * @see app/Http/Controllers/Staff/AdminCourseController.php:96
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons'
 */
storeLesson.url = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
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

    return storeLesson.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace('{module}', parsedArgs.module.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::storeLesson
 * @see app/Http/Controllers/Staff/AdminCourseController.php:96
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons'
 */
storeLesson.post = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeLesson.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroyLesson
 * @see app/Http/Controllers/Staff/AdminCourseController.php:121
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons/{lesson}'
 */
export const destroyLesson = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number }, lesson: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number }, lesson: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyLesson.url(args, options),
    method: 'delete',
})

destroyLesson.definition = {
    methods: ["delete"],
    url: '/staff/manage/courses/{course}/modules/{module}/lessons/{lesson}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroyLesson
 * @see app/Http/Controllers/Staff/AdminCourseController.php:121
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons/{lesson}'
 */
destroyLesson.url = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number }, lesson: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number }, lesson: string | number | { id: string | number } ], options?: RouteQueryOptions) => {
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

    return destroyLesson.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace('{module}', parsedArgs.module.toString())
            .replace('{lesson}', parsedArgs.lesson.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\AdminCourseController::destroyLesson
 * @see app/Http/Controllers/Staff/AdminCourseController.php:121
 * @route '/staff/manage/courses/{course}/modules/{module}/lessons/{lesson}'
 */
destroyLesson.delete = (args: { course: string | number | { id: string | number }, module: string | number | { id: string | number }, lesson: string | number | { id: string | number } } | [course: string | number | { id: string | number }, module: string | number | { id: string | number }, lesson: string | number | { id: string | number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyLesson.url(args, options),
    method: 'delete',
})
const AdminCourseController = { index, store, edit, update, storeCategory, storeModule, destroyModule, storeLesson, destroyLesson }

export default AdminCourseController