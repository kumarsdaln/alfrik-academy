<script setup>
  import { courses as wayfinderCourses1, howItWorks as wayfinderHowItWorks2, course as wayfinderCourse3, stories as wayfinderStories4, mentors as wayfinderMentors5 } from './../actions/App/Http/Controllers/PublicController';
  import { insights as wayfinderInsights6, insight as wayfinderInsight7, job as wayfinderJob8, jobs as wayfinderJobs9 } from './../actions/App/Http/Controllers/DiscoveryController';
  import { reports as wayfinderReports12, report as wayfinderReport13, surveys as wayfinderSurveys14, survey as wayfinderSurvey15 } from './../actions/App/Http/Controllers/DiscoveryController';
  import { index as wayfinderIndex10, show as wayfinderShow11 } from './../actions/App/Http/Controllers/WebinarEventController';

  import { Link } from '@inertiajs/vue3';
  import PublicLayout from '../Layouts/PublicLayout.vue';
  import PublicCourseCard from '../Components/PublicCourseCard.vue';
  import PublicMentorCard from '../Components/PublicMentorCard.vue';

  defineProps({ courses: Array, stats: Object, nextSession: Object, mentors: Array, story: Object, insights: Array, insightTopics: Array, surveys: Array, reports: Array, opportunities: Array, upcomingEvents: Array });

  const learningSteps = [
    { number: '01', title: 'Meet live', text: 'Learn in a small group where questions, conversation, and mentor time are part of the class.' },
    { number: '02', title: 'Make between classes', text: 'Put each idea to work through short assignments, guided lessons, and real projects.' },
    { number: '03', title: 'Get thoughtful feedback', text: 'Share your progress, hear a clear next step, and keep moving with your cohort.' },
  ];
</script>

<template>
  <PublicLayout>
    <main class="refined-home home-v3">
      <section class="home-v3-hero wrap">
        <div class="home-v3-copy">
          <div class="home-v3-eyebrow">LIVE COHORTS · PRACTICAL LEARNING</div>
          <h1>Learn live.<br><em>Grow further.</em></h1>
          <p class="home-v3-intro">Learn alongside a small cohort and a mentor who knows the work. Show up live,
            practice on real projects, and leave with skills you can use.</p>
          <div class="home-v3-actions">
            <Link :href="wayfinderCourses1().url" class="button button-dark">Find your program
              <UiIcon name="arrow-up-right" :size="14" />
            </Link>
            <Link :href="wayfinderHowItWorks2().url" class="home-v3-how-link">How learning works
              <UiIcon name="arrow-right" :size="14" />
            </Link>
          </div>
          <div class="home-v3-proof">
            <div class="home-v3-avatars"><img :src="'/images/learning/maya-chen.png'" alt=""><img
                :src="'/images/learning/ethan-brooks.png'" alt=""><img :src="'/images/learning/olivia-park.png'" alt="">
            </div>
            <span><b>Practitioners who teach</b><small>Learn directly from people doing the work.</small></span>
          </div>
        </div>

        <div class="home-v3-visual">
          <img :src="'/images/learning/live-class.png'" alt="A mentor and learners sharing ideas in a live class">
          <div class="home-v3-visual-caption"><span>A CLASSROOM THAT TALKS BACK</span><b>Learn together.<br>Move
              forward.</b></div>
          <div v-if="nextSession" class="home-v3-live-card">
            <div class="home-v3-live-card-top"><span>NEXT LIVE STUDIO</span><span>{{ nextSession.date }}</span>
            </div>
            <b>{{ nextSession.title }}</b>
            <small>{{ nextSession.course }} · {{ nextSession.time }}</small>
            <span class="home-v3-live-mentor">
              With {{ nextSession.mentor }}
            </span>
            <Link v-if="nextSession.courseSlug" :href="wayfinderCourse3.url({ slug: nextSession.courseSlug })">Explore
              the course
              <UiIcon name="arrow-up-right" :size="12" />
            </Link>
          </div>
          <div v-else class="home-v3-photo-note">
            Small cohorts. Real conversation.
          </div>
        </div>

        <div class="home-v3-stats">
          <div><b>{{ stats.programs }}</b><span>focused programs</span></div>
          <div><b>{{ stats.mentors }}</b><span>working mentors</span></div>
          <div><b>Live first</b><span>recordings when you need them</span></div>
          <Link :href="wayfinderStories4().url"><span>See where learning can take you</span><i>
              <UiIcon name="arrow-up-right" :size="13" />
            </i></Link>
        </div>
      </section>

      <section class="home-v3-programs refined-section wrap">
        <div class="home-v3-section-heading">
          <div>
            <div class="eyebrow">A GOOD PLACE TO BEGIN</div>
            <h2>Build something<br><em>you’re proud of.</em></h2>
          </div>
          <div class="home-v3-heading-aside">
            <p>Every program brings live teaching, a clear learning path, and a small group of people working toward
              something real.</p>
            <Link :href="wayfinderCourses1().url" class="refined-text-link">Explore all {{ stats.programs }} programs
              <UiIcon name="arrow-up-right" :size="13" />
            </Link>
          </div>
        </div>

        <div class="home-v3-category-links" aria-label="Browse programs by subject">
          <Link :href="wayfinderCourses1.url({ query: { category: 'design' } })"><span>01</span> Design
            <UiIcon name="arrow-up-right" :size="12" />
          </Link>
          <Link :href="wayfinderCourses1.url({ query: { category: 'development' } })"><span>02</span> Development
            <UiIcon name="arrow-up-right" :size="12" />
          </Link>
          <Link :href="wayfinderCourses1.url({ query: { category: 'business' } })"><span>03</span> Brand & business
            <UiIcon name="arrow-up-right" :size="12" />
          </Link>
        </div>

        <div class="home-v3-course-grid">
          <PublicCourseCard v-for="(course, index) in courses" :key="course.slug" :course="course" variant="featured"
            :position="index + 1" />
        </div>
      </section>

      <section class="home-v3-learning">
        <div class="wrap">
          <div class="home-v3-section-heading home-v3-learning-heading">
            <div>
              <div class="eyebrow">A DIFFERENT KIND OF CLASSROOM</div>
              <h2>Less watching.<br><em>More becoming.</em></h2>
            </div>
            <p>Videos can explain an idea. People help you work through it. Our programs make the live room the center
              of your learning, with lessons and replays there when you need them.</p>
          </div>
          <div class="home-v3-step-grid">
            <article v-for="step in learningSteps" :key="step.number" class="home-v3-step">
              <div class="home-v3-step-top"><span>{{ step.number }}</span>
                
              </div>
              <h3>{{ step.title }}</h3>
              <p>{{ step.text }}</p>
            </article>
          </div>
          <Link :href="wayfinderHowItWorks2().url" class="home-v3-text-arrow">See how the cohort experience works
            <UiIcon name="arrow-up-right" :size="14" />
          </Link>
        </div>
      </section>

      <section class="home-v3-mentors refined-section wrap">
        <div class="home-v3-section-heading">
          <div>
            <div class="eyebrow">PEOPLE WHO KNOW THE WORK</div>
            <h2>Good people,<br><em>in your corner.</em></h2>
          </div>
          <div class="home-v3-heading-aside">
            <p>Get close to the craft with mentors who make space for questions, experiments, and honest feedback.</p>
            <Link :href="wayfinderMentors5().url" class="refined-text-link">Meet all mentors
              <UiIcon name="arrow-up-right" :size="13" />
            </Link>
          </div>
        </div>
        <div class="home-v3-mentor-grid">
          <PublicMentorCard v-for="mentor in mentors" :key="mentor.slug" :mentor="mentor" variant="featured" />
        </div>
      </section>

      <section class="home-v3-story">
        <div class="wrap home-v3-story-inner">
          <div class="home-v3-story-image"><img
              :src="courses.find(course => course.slug === story.course_slug)?.image ?? '/images/learning/live-class.png'"
              :alt="`${story.name} learner story`"><span>
              A learner story
            </span></div>
          <div class="home-v3-story-copy">
            <div class="eyebrow">{{ story.outcome }}</div>
            <blockquote>“{{ story.quote }}”</blockquote>
            <div class="home-v3-story-footer"><span><b>{{ story.name }}</b><small>{{ story.role }}</small></span>
              <Link :href="wayfinderStories4().url" class="refined-text-link">Read learner stories
                <UiIcon name="arrow-up-right" :size="13" />
              </Link>
            </div>
          </div>
        </div>
      </section>

      <section class="home-v3-community wrap">
        <div class="home-v3-section-heading">
          <div>
            <div class="eyebrow">IDEAS, UPDATES & NEXT STEPS</div>
            <h2>More to learn.<br><em>More to explore.</em></h2>
          </div>
          <div class="home-v3-heading-aside">
            <p>Find practical guides, thoughtful perspectives, useful updates, live conversations, and opportunities
              from across the world—not only the classroom.</p>
            <Link :href="wayfinderInsights6().url" class="refined-text-link">Explore the knowledge hub
              <UiIcon name="arrow-up-right" :size="13" />
            </Link>
          </div>
        </div>

        <nav v-if="insightTopics?.length" class="home-v3-topic-paths" aria-label="Explore knowledge topics">
          <div class="home-v3-topic-intro"><span class="eyebrow">FOLLOW YOUR CURIOSITY</span><b>Start with a
              subject.</b><small>Browse the ideas that matter to you.</small></div>
          <Link v-for="topic in insightTopics" :key="topic.category"
            :href="wayfinderInsights6.url({ query: { category: topic.category } })" class="home-v3-topic-link"><span>{{
              topic.category }}</span><small>{{ topic.stories_count }} {{ topic.stories_count === 1 ? 'story' :
              'stories' }}</small>
            <UiIcon name="arrow-up-right" :size="13" />
          </Link>
        </nav>

        <div class="home-v3-community-grid">
          <div class="home-v3-editorial-grid">
            <article v-for="item in insights" :key="item.id" class="home-v3-editorial-card">
              <Link :href="wayfinderInsight7.url({ slug: item.slug })" class="home-v3-editorial-image"><img
                  :src="item.cover_image || '/images/learning/live-class.png'" :alt="item.title"><span>{{ item.type
                  }}</span></Link>
              <div class="home-v3-editorial-copy">
                <div class="home-v3-editorial-meta"><span>{{ item.category || 'Kanram Journal' }}</span><span>{{
                  item.reading_minutes }} min read</span></div>
                <h3>
                  <Link :href="wayfinderInsight7.url({ slug: item.slug })">{{ item.title }}</Link>
                </h3>
                <p>{{ item.excerpt }}</p>
                <Link :href="wayfinderInsight7.url({ slug: item.slug })" class="refined-text-link">Read {{ item.type }}
                  <UiIcon name="arrow-up-right" :size="12" />
                </Link>
              </div>
            </article>
            <div v-if="!insights.length" class="home-v3-empty">
              <UiIcon name="book-open" :size="18" /><b>New ideas are on the way.</b><span>Visit the journal for
                articles, academy news, and upcoming events.</span>
              <Link :href="wayfinderInsights6().url" class="refined-text-link">Explore the journal
                <UiIcon name="arrow-up-right" :size="12" />
              </Link>
            </div>
          </div>

          <aside class="home-v3-opportunities">
            <div class="home-v3-opportunities-heading"><span class="eyebrow">FROM THE COMMUNITY</span>
              <h3>Good work<br><em>finds its people.</em></h3>
              <p>Explore roles and projects shared by the Kanram community.</p>
            </div>
            <Link v-for="job in opportunities" :key="job.id" :href="wayfinderJob8.url({ slug: job.slug })"
              class="home-v3-job-row"><span><small>{{ job.company }} · {{ job.location }}</small><b>{{ job.title
                  }}</b><small>{{ job.workplace_type.replace('_', ' ') }} · {{ job.employment_type.replace('_', ' ')
                  }}</small></span>
              <UiIcon name="arrow-up-right" :size="14" />
            </Link>
            <div v-if="!opportunities.length" class="home-v3-job-empty">Community opportunities are added here as they
              open.</div>
            <Link :href="wayfinderJobs9().url" class="home-v3-careers-link">Browse all opportunities
              <UiIcon name="arrow-up-right" :size="12" />
            </Link>
          </aside>
        </div>
        <section class="home-v3-research" aria-labelledby="home-research-heading">
          <div class="home-v3-research-heading">
            <div>
              <div class="eyebrow">COMMUNITY KNOWLEDGE</div>
              <h3 id="home-research-heading">Surveys &amp; research.</h3>
            </div>
            <p>Share your perspective through community surveys, then explore reports that bring evidence and ideas
              together.</p>
          </div>
          <div class="home-v3-research-grid">
            <article class="home-v3-research-card home-v3-survey-card">
              <span class="home-v3-research-icon">
                <UiIcon name="clipboard-list" :size="19" />
              </span><span class="home-v3-research-type">COMMUNITY SURVEY</span>
              <template v-if="surveys.length">
                <h4>{{ surveys[0].title }}</h4>
                <p>{{ surveys[0].excerpt }}</p>
                <Link :href="wayfinderSurvey15.url({ slug: surveys[0].slug })">{{ surveys[0].survey_url ? 'Take part' :
                  'View survey' }}
                  <UiIcon name="arrow-up-right" :size="13" />
                </Link>
              </template>
              <template v-else>
                <h4>Make your perspective count.</h4>
                <p>Explore community surveys and share your experience when a new one is open.</p>
                <Link :href="wayfinderSurveys14().url">Explore surveys
                  <UiIcon name="arrow-up-right" :size="13" />
                </Link>
              </template>
            </article>
            <article class="home-v3-research-card home-v3-report-card">
              <span class="home-v3-research-icon">
                <UiIcon name="file-text" :size="19" />
              </span><span class="home-v3-research-type">RESEARCH &amp; REPORTS</span>
              <template v-if="reports.length">
                <h4>{{ reports[0].title }}</h4>
                <p>{{ reports[0].excerpt }}</p>
                <Link :href="wayfinderReport13.url({ slug: reports[0].slug })">Read the report
                  <UiIcon name="arrow-up-right" :size="13" />
                </Link>
              </template>
              <template v-else>
                <h4>Evidence, context, and new ideas.</h4>
                <p>Read research reports shared with the Kanram community across subjects and fields.</p>
                <Link :href="wayfinderReports12().url">Explore reports
                  <UiIcon name="arrow-up-right" :size="13" />
                </Link>
              </template>
            </article>
          </div>
        </section>
        <div class="home-v3-upcoming-events">
          <div class="home-v3-events-heading">
            <div>
              <div class="eyebrow">COME LEARN WITH US</div>
              <h3>Upcoming webinars & events.</h3>
            </div>
            <Link :href="wayfinderIndex10().url" class="refined-text-link">See all events
              <UiIcon name="arrow-up-right" :size="12" />
            </Link>
          </div>
          <div v-if="upcomingEvents.length" class="home-v3-event-list">
            <Link v-for="event in upcomingEvents" :key="event.id" :href="wayfinderShow11.url({ event: event.slug })"
              class="home-v3-event-card"><img :src="event.cover_image || '/images/learning/live-class.png'"
                :alt="event.title"><span class="home-v3-event-content"><span class="home-v3-event-date"><b>{{ new
                  Date(event.starts_at).toLocaleDateString(undefined, {
                    timeZone: event.timezone, month: 'short', day:
                    'numeric'
                    }) }}</b><small>{{ new Date(event.starts_at).toLocaleTimeString(undefined, {
                      timeZone:
                        event.timezone, hour:
                        'numeric', minute: '2-digit', timeZoneName: 'short' }) }}</small></span><span
                  class="home-v3-event-copy"><b>{{
                    event.title }}</b><small>{{ event.host_name }} · {{ event.duration_minutes }}
                    min</small></span></span>
              <UiIcon name="arrow-up-right" :size="14" />
            </Link>
          </div>
          <div v-else class="home-v3-event-placeholder">
            <UiIcon name="calendar" :size="16" /> New live conversations are being planned.
            <Link :href="wayfinderIndex10().url">Explore the events page
              <UiIcon name="arrow-up-right" :size="11" />
            </Link>
          </div>
        </div>
      </section>

      <section class="home-v3-final wrap">
        <div>
          <div class="home-v3-eyebrow">YOUR NEXT CHAPTER STARTS HERE</div>
          <h2>Come curious.<br><em>Leave more capable.</em></h2>
          <p>Find a course, meet your mentor, and see the complete curriculum before you decide.</p>
        </div>
        <Link :href="wayfinderCourses1().url" class="button button-dark">Find your program
          <UiIcon name="arrow-up-right" :size="14" />
        </Link>
      </section>
    </main>
  </PublicLayout>
</template>
