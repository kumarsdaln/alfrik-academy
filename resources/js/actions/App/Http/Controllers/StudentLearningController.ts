import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\StudentLearningController::dashboard
 * @see app/Http/Controllers/StudentLearningController.php:23
 * @route '/learn'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/learn',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::dashboard
 * @see app/Http/Controllers/StudentLearningController.php:23
 * @route '/learn'
 */
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::dashboard
 * @see app/Http/Controllers/StudentLearningController.php:23
 * @route '/learn'
 */
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::dashboard
 * @see app/Http/Controllers/StudentLearningController.php:23
 * @route '/learn'
 */
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::courses
 * @see app/Http/Controllers/StudentLearningController.php:249
 * @route '/learn/courses'
 */
export const courses = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(options),
    method: 'get',
})

courses.definition = {
    methods: ["get","head"],
    url: '/learn/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::courses
 * @see app/Http/Controllers/StudentLearningController.php:249
 * @route '/learn/courses'
 */
courses.url = (options?: RouteQueryOptions) => {
    return courses.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::courses
 * @see app/Http/Controllers/StudentLearningController.php:249
 * @route '/learn/courses'
 */
courses.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::courses
 * @see app/Http/Controllers/StudentLearningController.php:249
 * @route '/learn/courses'
 */
courses.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: courses.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::course
 * @see app/Http/Controllers/StudentLearningController.php:410
 * @route '/learn/courses/{course}'
 */
export const course = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: course.url(args, options),
    method: 'get',
})

course.definition = {
    methods: ["get","head"],
    url: '/learn/courses/{course}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::course
 * @see app/Http/Controllers/StudentLearningController.php:410
 * @route '/learn/courses/{course}'
 */
course.url = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { course: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
            args = { course: args.slug }
        }
    
    if (Array.isArray(args)) {
        args = {
                    course: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        course: typeof args.course === 'object'
                ? args.course.slug
                : args.course,
                }

    return course.definition.url
            .replace('{course}', parsedArgs.course.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::course
 * @see app/Http/Controllers/StudentLearningController.php:410
 * @route '/learn/courses/{course}'
 */
course.get = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: course.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::course
 * @see app/Http/Controllers/StudentLearningController.php:410
 * @route '/learn/courses/{course}'
 */
course.head = (args: { course: string | { slug: string } } | [course: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: course.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::quiz
 * @see app/Http/Controllers/StudentLearningController.php:490
 * @route '/learn/quizzes/{quizId}'
 */
export const quiz = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: quiz.url(args, options),
    method: 'get',
})

quiz.definition = {
    methods: ["get","head"],
    url: '/learn/quizzes/{quizId}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::quiz
 * @see app/Http/Controllers/StudentLearningController.php:490
 * @route '/learn/quizzes/{quizId}'
 */
quiz.url = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return quiz.definition.url
            .replace('{quizId}', parsedArgs.quizId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::quiz
 * @see app/Http/Controllers/StudentLearningController.php:490
 * @route '/learn/quizzes/{quizId}'
 */
quiz.get = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: quiz.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::quiz
 * @see app/Http/Controllers/StudentLearningController.php:490
 * @route '/learn/quizzes/{quizId}'
 */
quiz.head = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: quiz.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::submitQuiz
 * @see app/Http/Controllers/StudentLearningController.php:598
 * @route '/learn/quizzes/{quizId}'
 */
export const submitQuiz = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitQuiz.url(args, options),
    method: 'post',
})

submitQuiz.definition = {
    methods: ["post"],
    url: '/learn/quizzes/{quizId}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentLearningController::submitQuiz
 * @see app/Http/Controllers/StudentLearningController.php:598
 * @route '/learn/quizzes/{quizId}'
 */
submitQuiz.url = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return submitQuiz.definition.url
            .replace('{quizId}', parsedArgs.quizId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::submitQuiz
 * @see app/Http/Controllers/StudentLearningController.php:598
 * @route '/learn/quizzes/{quizId}'
 */
submitQuiz.post = (args: { quizId: string | number } | [quizId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitQuiz.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentLearningController::lesson
 * @see app/Http/Controllers/StudentLearningController.php:744
 * @route '/learn/lessons/{lesson}'
 */
export const lesson = (args: { lesson: number | { id: number } } | [lesson: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: lesson.url(args, options),
    method: 'get',
})

lesson.definition = {
    methods: ["get","head"],
    url: '/learn/lessons/{lesson}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::lesson
 * @see app/Http/Controllers/StudentLearningController.php:744
 * @route '/learn/lessons/{lesson}'
 */
lesson.url = (args: { lesson: number | { id: number } } | [lesson: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { lesson: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { lesson: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    lesson: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        lesson: typeof args.lesson === 'object'
                ? args.lesson.id
                : args.lesson,
                }

    return lesson.definition.url
            .replace('{lesson}', parsedArgs.lesson.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::lesson
 * @see app/Http/Controllers/StudentLearningController.php:744
 * @route '/learn/lessons/{lesson}'
 */
lesson.get = (args: { lesson: number | { id: number } } | [lesson: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: lesson.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::lesson
 * @see app/Http/Controllers/StudentLearningController.php:744
 * @route '/learn/lessons/{lesson}'
 */
lesson.head = (args: { lesson: number | { id: number } } | [lesson: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: lesson.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::completeLesson
 * @see app/Http/Controllers/StudentLearningController.php:808
 * @route '/learn/lessons/{lesson}/complete'
 */
export const completeLesson = (args: { lesson: number | { id: number } } | [lesson: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: completeLesson.url(args, options),
    method: 'post',
})

completeLesson.definition = {
    methods: ["post"],
    url: '/learn/lessons/{lesson}/complete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentLearningController::completeLesson
 * @see app/Http/Controllers/StudentLearningController.php:808
 * @route '/learn/lessons/{lesson}/complete'
 */
completeLesson.url = (args: { lesson: number | { id: number } } | [lesson: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { lesson: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { lesson: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    lesson: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        lesson: typeof args.lesson === 'object'
                ? args.lesson.id
                : args.lesson,
                }

    return completeLesson.definition.url
            .replace('{lesson}', parsedArgs.lesson.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::completeLesson
 * @see app/Http/Controllers/StudentLearningController.php:808
 * @route '/learn/lessons/{lesson}/complete'
 */
completeLesson.post = (args: { lesson: number | { id: number } } | [lesson: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: completeLesson.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentLearningController::assignments
 * @see app/Http/Controllers/StudentLearningController.php:328
 * @route '/learn/assignments'
 */
export const assignments = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: assignments.url(options),
    method: 'get',
})

assignments.definition = {
    methods: ["get","head"],
    url: '/learn/assignments',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::assignments
 * @see app/Http/Controllers/StudentLearningController.php:328
 * @route '/learn/assignments'
 */
assignments.url = (options?: RouteQueryOptions) => {
    return assignments.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::assignments
 * @see app/Http/Controllers/StudentLearningController.php:328
 * @route '/learn/assignments'
 */
assignments.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: assignments.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::assignments
 * @see app/Http/Controllers/StudentLearningController.php:328
 * @route '/learn/assignments'
 */
assignments.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: assignments.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::assignment
 * @see app/Http/Controllers/StudentLearningController.php:829
 * @route '/learn/assignments/{assignmentId}'
 */
export const assignment = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: assignment.url(args, options),
    method: 'get',
})

assignment.definition = {
    methods: ["get","head"],
    url: '/learn/assignments/{assignmentId}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::assignment
 * @see app/Http/Controllers/StudentLearningController.php:829
 * @route '/learn/assignments/{assignmentId}'
 */
assignment.url = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return assignment.definition.url
            .replace('{assignmentId}', parsedArgs.assignmentId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::assignment
 * @see app/Http/Controllers/StudentLearningController.php:829
 * @route '/learn/assignments/{assignmentId}'
 */
assignment.get = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: assignment.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::assignment
 * @see app/Http/Controllers/StudentLearningController.php:829
 * @route '/learn/assignments/{assignmentId}'
 */
assignment.head = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: assignment.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::submitAssignment
 * @see app/Http/Controllers/StudentLearningController.php:875
 * @route '/learn/assignments/{assignmentId}'
 */
export const submitAssignment = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitAssignment.url(args, options),
    method: 'post',
})

submitAssignment.definition = {
    methods: ["post"],
    url: '/learn/assignments/{assignmentId}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\StudentLearningController::submitAssignment
 * @see app/Http/Controllers/StudentLearningController.php:875
 * @route '/learn/assignments/{assignmentId}'
 */
submitAssignment.url = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return submitAssignment.definition.url
            .replace('{assignmentId}', parsedArgs.assignmentId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::submitAssignment
 * @see app/Http/Controllers/StudentLearningController.php:875
 * @route '/learn/assignments/{assignmentId}'
 */
submitAssignment.post = (args: { assignmentId: string | number } | [assignmentId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submitAssignment.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\StudentLearningController::schedule
 * @see app/Http/Controllers/StudentLearningController.php:187
 * @route '/learn/schedule'
 */
export const schedule = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: schedule.url(options),
    method: 'get',
})

schedule.definition = {
    methods: ["get","head"],
    url: '/learn/schedule',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::schedule
 * @see app/Http/Controllers/StudentLearningController.php:187
 * @route '/learn/schedule'
 */
schedule.url = (options?: RouteQueryOptions) => {
    return schedule.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::schedule
 * @see app/Http/Controllers/StudentLearningController.php:187
 * @route '/learn/schedule'
 */
schedule.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: schedule.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::schedule
 * @see app/Http/Controllers/StudentLearningController.php:187
 * @route '/learn/schedule'
 */
schedule.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: schedule.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::calendar
 * @see app/Http/Controllers/StudentLearningController.php:1027
 * @route '/learn/calendar.ics'
 */
export const calendar = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: calendar.url(options),
    method: 'get',
})

calendar.definition = {
    methods: ["get","head"],
    url: '/learn/calendar.ics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::calendar
 * @see app/Http/Controllers/StudentLearningController.php:1027
 * @route '/learn/calendar.ics'
 */
calendar.url = (options?: RouteQueryOptions) => {
    return calendar.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::calendar
 * @see app/Http/Controllers/StudentLearningController.php:1027
 * @route '/learn/calendar.ics'
 */
calendar.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: calendar.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::calendar
 * @see app/Http/Controllers/StudentLearningController.php:1027
 * @route '/learn/calendar.ics'
 */
calendar.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: calendar.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\StudentLearningController::session
 * @see app/Http/Controllers/StudentLearningController.php:993
 * @route '/learn/sessions/{liveSession}'
 */
export const session = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: session.url(args, options),
    method: 'get',
})

session.definition = {
    methods: ["get","head"],
    url: '/learn/sessions/{liveSession}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\StudentLearningController::session
 * @see app/Http/Controllers/StudentLearningController.php:993
 * @route '/learn/sessions/{liveSession}'
 */
session.url = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { liveSession: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { liveSession: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    liveSession: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        liveSession: typeof args.liveSession === 'object'
                ? args.liveSession.id
                : args.liveSession,
                }

    return session.definition.url
            .replace('{liveSession}', parsedArgs.liveSession.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\StudentLearningController::session
 * @see app/Http/Controllers/StudentLearningController.php:993
 * @route '/learn/sessions/{liveSession}'
 */
session.get = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: session.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\StudentLearningController::session
 * @see app/Http/Controllers/StudentLearningController.php:993
 * @route '/learn/sessions/{liveSession}'
 */
session.head = (args: { liveSession: number | { id: number } } | [liveSession: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: session.url(args, options),
    method: 'head',
})
const StudentLearningController = { dashboard, courses, course, quiz, submitQuiz, lesson, completeLesson, assignments, assignment, submitAssignment, schedule, calendar, session }

export default StudentLearningController