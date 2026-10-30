import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\PublicController::courses
 * @see app/Http/Controllers/PublicController.php:93
 * @route '/courses'
 */
export const courses = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(options),
    method: 'get',
})

courses.definition = {
    methods: ["get","head"],
    url: '/courses',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::courses
 * @see app/Http/Controllers/PublicController.php:93
 * @route '/courses'
 */
courses.url = (options?: RouteQueryOptions) => {
    return courses.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::courses
 * @see app/Http/Controllers/PublicController.php:93
 * @route '/courses'
 */
courses.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: courses.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::courses
 * @see app/Http/Controllers/PublicController.php:93
 * @route '/courses'
 */
courses.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: courses.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::course
 * @see app/Http/Controllers/PublicController.php:114
 * @route '/courses/{slug}'
 */
export const course = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: course.url(args, options),
    method: 'get',
})

course.definition = {
    methods: ["get","head"],
    url: '/courses/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::course
 * @see app/Http/Controllers/PublicController.php:114
 * @route '/courses/{slug}'
 */
course.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return course.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::course
 * @see app/Http/Controllers/PublicController.php:114
 * @route '/courses/{slug}'
 */
course.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: course.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::course
 * @see app/Http/Controllers/PublicController.php:114
 * @route '/courses/{slug}'
 */
course.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: course.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::howItWorks
 * @see app/Http/Controllers/PublicController.php:164
 * @route '/how-it-works'
 */
export const howItWorks = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: howItWorks.url(options),
    method: 'get',
})

howItWorks.definition = {
    methods: ["get","head"],
    url: '/how-it-works',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::howItWorks
 * @see app/Http/Controllers/PublicController.php:164
 * @route '/how-it-works'
 */
howItWorks.url = (options?: RouteQueryOptions) => {
    return howItWorks.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::howItWorks
 * @see app/Http/Controllers/PublicController.php:164
 * @route '/how-it-works'
 */
howItWorks.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: howItWorks.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::howItWorks
 * @see app/Http/Controllers/PublicController.php:164
 * @route '/how-it-works'
 */
howItWorks.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: howItWorks.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::mentors
 * @see app/Http/Controllers/PublicController.php:169
 * @route '/mentors'
 */
export const mentors = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mentors.url(options),
    method: 'get',
})

mentors.definition = {
    methods: ["get","head"],
    url: '/mentors',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::mentors
 * @see app/Http/Controllers/PublicController.php:169
 * @route '/mentors'
 */
mentors.url = (options?: RouteQueryOptions) => {
    return mentors.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::mentors
 * @see app/Http/Controllers/PublicController.php:169
 * @route '/mentors'
 */
mentors.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mentors.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::mentors
 * @see app/Http/Controllers/PublicController.php:169
 * @route '/mentors'
 */
mentors.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: mentors.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::mentor
 * @see app/Http/Controllers/PublicController.php:174
 * @route '/mentors/{slug}'
 */
export const mentor = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mentor.url(args, options),
    method: 'get',
})

mentor.definition = {
    methods: ["get","head"],
    url: '/mentors/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::mentor
 * @see app/Http/Controllers/PublicController.php:174
 * @route '/mentors/{slug}'
 */
mentor.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return mentor.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::mentor
 * @see app/Http/Controllers/PublicController.php:174
 * @route '/mentors/{slug}'
 */
mentor.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mentor.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::mentor
 * @see app/Http/Controllers/PublicController.php:174
 * @route '/mentors/{slug}'
 */
mentor.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: mentor.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::stories
 * @see app/Http/Controllers/PublicController.php:183
 * @route '/stories'
 */
export const stories = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: stories.url(options),
    method: 'get',
})

stories.definition = {
    methods: ["get","head"],
    url: '/stories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::stories
 * @see app/Http/Controllers/PublicController.php:183
 * @route '/stories'
 */
stories.url = (options?: RouteQueryOptions) => {
    return stories.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::stories
 * @see app/Http/Controllers/PublicController.php:183
 * @route '/stories'
 */
stories.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: stories.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::stories
 * @see app/Http/Controllers/PublicController.php:183
 * @route '/stories'
 */
stories.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: stories.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::story
 * @see app/Http/Controllers/PublicController.php:188
 * @route '/stories/{slug}'
 */
export const story = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: story.url(args, options),
    method: 'get',
})

story.definition = {
    methods: ["get","head"],
    url: '/stories/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::story
 * @see app/Http/Controllers/PublicController.php:188
 * @route '/stories/{slug}'
 */
story.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return story.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::story
 * @see app/Http/Controllers/PublicController.php:188
 * @route '/stories/{slug}'
 */
story.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: story.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::story
 * @see app/Http/Controllers/PublicController.php:188
 * @route '/stories/{slug}'
 */
story.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: story.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::about
 * @see app/Http/Controllers/PublicController.php:232
 * @route '/about'
 */
export const about = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})

about.definition = {
    methods: ["get","head"],
    url: '/about',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::about
 * @see app/Http/Controllers/PublicController.php:232
 * @route '/about'
 */
about.url = (options?: RouteQueryOptions) => {
    return about.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::about
 * @see app/Http/Controllers/PublicController.php:232
 * @route '/about'
 */
about.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: about.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::about
 * @see app/Http/Controllers/PublicController.php:232
 * @route '/about'
 */
about.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: about.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::faq
 * @see app/Http/Controllers/PublicController.php:237
 * @route '/faq'
 */
export const faq = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: faq.url(options),
    method: 'get',
})

faq.definition = {
    methods: ["get","head"],
    url: '/faq',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::faq
 * @see app/Http/Controllers/PublicController.php:237
 * @route '/faq'
 */
faq.url = (options?: RouteQueryOptions) => {
    return faq.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::faq
 * @see app/Http/Controllers/PublicController.php:237
 * @route '/faq'
 */
faq.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: faq.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::faq
 * @see app/Http/Controllers/PublicController.php:237
 * @route '/faq'
 */
faq.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: faq.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PublicController::contact
 * @see app/Http/Controllers/PublicController.php:242
 * @route '/contact'
 */
export const contact = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: contact.url(options),
    method: 'get',
})

contact.definition = {
    methods: ["get","head"],
    url: '/contact',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PublicController::contact
 * @see app/Http/Controllers/PublicController.php:242
 * @route '/contact'
 */
contact.url = (options?: RouteQueryOptions) => {
    return contact.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PublicController::contact
 * @see app/Http/Controllers/PublicController.php:242
 * @route '/contact'
 */
contact.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: contact.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\PublicController::contact
 * @see app/Http/Controllers/PublicController.php:242
 * @route '/contact'
 */
contact.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: contact.url(options),
    method: 'head',
})
const PublicController = { courses, course, howItWorks, mentors, mentor, stories, story, about, faq, contact }

export default PublicController