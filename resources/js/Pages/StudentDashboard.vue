<script setup>
  import { logout as wayfinderLogout1 } from './../actions/App/Http/Controllers/AuthController';
  import { schedule as wayfinderSchedule2, session as wayfinderSession3, courses as wayfinderCourses4, course as wayfinderCourse5, assignments as wayfinderAssignments7, assignment as wayfinderAssignment8, calendar as wayfinderCalendar9 } from './../actions/App/Http/Controllers/StudentLearningController';
  import { activity as wayfinderActivity10, purchases as wayfinderPurchases11 } from './../actions/App/Http/Controllers/StudentBillingController';
  import { courses as wayfinderCourses6 } from './../actions/App/Http/Controllers/PublicController';

  import { Link } from '@inertiajs/vue3';
  import { computed } from 'vue';
  import LearningSidebar from '../Components/LearningSidebar.vue';

  const props = defineProps({ student: Object, sessions: Array, courses: Array, replays: Array, assignments: Array, learningStats: Object, today: String });
  const compactToday = computed(() => {
    const date = new Date(props.today);
    return Number.isNaN(date.getTime()) ? props.today : new Intl.DateTimeFormat('en', { weekday: 'short', month: 'short', day: 'numeric' }).format(date);
  });
</script>

<template>
  <div class="dashboard-shell">
    <LearningSidebar active="overview" :student="student" :course-count="courses.length"
      :assignment-count="assignments.length" />
    <main class="dash-main">
      <header class="dash-top">
        <div class="dash-top-account">
          <div class="dash-top-date"><span>YOUR LEARNING DAY</span><time><span class="full-date">{{ today }}</span><span
                class="compact-date">{{ compactToday }}</span></time></div><span class="profile-avatar small">{{
                  student.initials }}</span><span class="dash-top-name">{{ student.firstName }}</span>
          <Link :href="wayfinderLogout1().url" method="post" as="button" class="dash-logout">Sign out</Link>
        </div>
      </header>
      <div class="dash-content">
        <div class="dash-welcome">
          <div>
            <div class="eyebrow">YOUR LEARNING SPACE</div>
            <h1>Welcome back, {{ student.firstName }}</h1>
            <p>A good week starts with one small step.</p>
          </div>
          <Link class="button button-dark" :href="wayfinderSchedule2().url">View your schedule <span>
              <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
            </span></Link>
        </div>
        <section class="learner-pulse" aria-label="Your learning at a glance">
          <Link :href="wayfinderCourses4().url"><span>ACTIVE COURSES</span><b>{{ learningStats.activeCourses
              }}</b><small>Keep your momentum
              <UiIcon name="arrow-up-right" :size="12" />
            </small></Link>
          <Link :href="wayfinderActivity10().url"><span>LESSONS COMPLETED</span><b>{{ learningStats.completedLessons
              }}</b><small>Your learning activity
              <UiIcon name="arrow-up-right" :size="12" />
            </small></Link>
          <Link :href="wayfinderAssignments7().url"><span>WORK SUBMITTED</span><b>{{ learningStats.submittedAssignments
              }}</b><small>Assignments and projects
              <UiIcon name="arrow-up-right" :size="12" />
            </small></Link>
          <Link :href="wayfinderPurchases11().url"><span>PAID ORDERS</span><b>{{ learningStats.purchases
              }}</b><small>Course and event purchases
              <UiIcon name="arrow-up-right" :size="12" />
            </small></Link>
          <Link :href="wayfinderSchedule2().url"><span>LIVE CLASSES ATTENDED</span><b>{{ learningStats.attendedSessions
              }}</b><small>Time with your cohort
              <UiIcon name="arrow-up-right" :size="12" />
            </small></Link>
        </section>
        <section id="assignments" class="dashboard-assignments" aria-labelledby="dashboard-assignments-title">
          <header class="dashboard-assignments-heading">
            <div><span class="eyebrow">YOUR NEXT STEPS</span>
              <h2 id="dashboard-assignments-title">Assignments</h2>
              <p>Projects and practice to keep your learning moving.</p>
            </div>
            <Link :href="wayfinderAssignments7().url" class="dashboard-assignments-link">All assignments
              <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
            </Link>
          </header>
          <div v-if="assignments.length" class="dashboard-assignment-list">
            <Link v-for="assignment in assignments" :key="assignment.id"
              :href="wayfinderAssignment8.url({ assignmentId: assignment.id })" class="dashboard-assignment-row">
              <div class="dashboard-assignment-main"><span class="dashboard-assignment-course">{{ assignment.course
                  }}</span>
                <h3>{{ assignment.title }}</h3>
              </div>
              <div v-if="assignment.due_at" class="dashboard-assignment-due"><span>DUE DATE</span><time>{{ new
                Date(assignment.due_at).toLocaleDateString() }}</time></div>
              <span class="dashboard-assignment-action">Open project
                <UiIcon name="arrow-up-right" class="ui-icon" :size="14" />
              </span>
            </Link>
          </div>
          <div v-else class="dashboard-assignment-empty"><b>Nothing due right now.</b><span>New assignments from your
              courses will appear here.</span></div>
        </section>
        <div class="dash-columns">
          <div class="dash-left">
            <section class="dash-section">
              <div class="dash-section-head">
                <div>
                  <h2>Coming up live</h2>
                  <p>Your cohort’s next moments together.</p>
                </div>
                <Link :href="wayfinderSchedule2().url">Full calendar
                  <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
                </Link>
              </div>
              <div v-if="sessions.length">
                <article v-for="session in sessions" :key="session.id" class="session-card session-violet">
                  <div class="session-date"><b>{{ session.day }}</b><span>{{ session.dayNumber }}</span></div>
                  <div class="session-info">
                    <div class="session-time">{{ session.date }} · {{ session.time }} · {{ session.duration }} min</div>
                    <h3>{{ session.title }}</h3>
                    <p>{{ session.course }} · with {{ session.teacher }}</p>
                  </div>
                  <Link :href="wayfinderSession3.url({ liveSession: session.id })" class="session-view-button">View
                    class
                    <UiIcon name="arrow-up-right" class="ui-icon" :size="14" />
                  </Link>
                </article>
              </div>
              <div v-else class="learning-empty"><span>
                  <UiIcon name="clock" class="ui-icon" />
                </span>
                <div><b>No live classes on the calendar yet</b>
                  <p>When your mentor schedules a class, it will appear here.</p>
                </div>
              </div>
            </section>
            <section id="my-courses" class="dash-section course-progress">
              <div class="dash-section-head">
                <div>
                  <h2>Pick up where you left off</h2>
                  <p>Small steps add up.</p>
                </div>
                <Link :href="wayfinderCourses4().url">All courses
                  <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
                </Link>
              </div>
              <article v-for="(course, index) in courses" :key="course.slug" class="progress-card">
                <span class="progress-course-number" aria-hidden="true">{{ String(index + 1).padStart(2, '0') }}</span>
                <div class="progress-info">
                  <div class="progress-title">
                    <div class="progress-course-heading"><span>{{ course.cohort || 'YOUR COURSE' }}</span>
                      <h3>{{ course.title }}</h3>
                    </div>
                    <div class="progress-meter"><strong>{{ course.progress }}%</strong><span>complete</span></div>
                  </div>
                  <div class="progress-bar" role="progressbar" :aria-valuenow="course.progress" aria-valuemin="0"
                    aria-valuemax="100" :aria-label="`${course.title} progress`"><span
                      :style="{ width: course.progress + '%' }" class="bar-violet"></span></div>
                  <div class="progress-next"><span>UP NEXT</span><b>{{ course.next }}</b></div>
                </div>
                <Link :href="wayfinderCourse5.url({ course: course.slug })" class="progress-continue">Continue
                  <UiIcon name="arrow-up-right" class="ui-icon" :size="14" />
                </Link>
              </article>
              <div v-if="!courses.length" class="learning-empty"><span>
                  <UiIcon name="sparkles" class="ui-icon" />
                </span>
                <div><b>Your learning journey starts here</b>
                  <p>Join a cohort to see your course progress and live classes.</p>
                  <Link :href="wayfinderCourses6().url">Explore courses
                    <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
                  </Link>
                </div>
              </div>
            </section>
            <section v-if="replays.length" class="dash-section">
              <div class="dash-section-head">
                <div>
                  <h2>Catch up on a replay</h2>
                  <p>Missed a session? The recording is ready.</p>
                </div>
                <Link :href="wayfinderSchedule2().url">All past classes
                  <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
                </Link>
              </div>
              <article v-for="replay in replays" :key="replay.id" class="replay-row"><span class="replay-play">
                  <UiIcon name="play" class="ui-icon" :size="12" />
                </span>
                <div><b>{{ replay.title }}</b><small>{{ replay.course }} · {{ replay.date }}</small></div>
                <Link :href="wayfinderSession3.url({ liveSession: replay.id })">Watch
                  <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
                </Link>
              </article>
            </section>
          </div>
          <aside class="dash-right">
            <section class="weekly-card">
              <div class="week-top"><span>YOUR LEARNING</span><span>{{ courses.length }} {{ courses.length === 1 ?
                  'course' : 'courses' }}</span></div>
              <h3>Keep showing up.<br>It adds up.</h3>
              <div class="week-summary"><span>
                  <UiIcon name="circle-dot" class="ui-icon" />
                </span>
                <p><b>{{ sessions.length }} upcoming live {{ sessions.length === 1 ? 'class' : 'classes' }}</b><br>in
                  your cohort schedule</p>
                <Link :href="wayfinderSchedule2().url">
                  <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
                </Link>
              </div>
            </section>

            <section class="calendar-export">
              <div><b>Keep class time close</b>
                <p>Add your cohort sessions to your calendar.</p>
              </div><a :href="wayfinderCalendar9().url">
                <UiIcon name="plus" class="ui-icon" /> Add to calendar
              </a>
            </section>
          </aside>
        </div>
      </div>
    </main>
  </div>
</template>
