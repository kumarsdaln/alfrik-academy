<script setup>
import { dashboard as wayfinderDashboard1, schedule as wayfinderSchedule2, course as wayfinderCourse3 } from './../../actions/App/Http/Controllers/StudentLearningController';
import { courses as wayfinderCourses4 } from './../../actions/App/Http/Controllers/PublicController';

import { Link } from '@inertiajs/vue3';
import LearningSidebar from '../../Components/LearningSidebar.vue';
defineProps({ courses: Object });
</script>

<template>
  <div class="dashboard-shell"><LearningSidebar active="courses" :course-count="courses.total" />
    <main class="dash-main"><header class="dash-top"><Link :href="wayfinderDashboard1().url"><UiIcon name="arrow-left" class="ui-icon" :size="13" /> Learning home</Link><span>Your active enrollments</span></header><div class="dash-content learner-index-content"><div class="learner-index-heading"><div><div class="eyebrow">YOUR LEARNING SPACE</div><h1>My courses</h1><p>Pick up where you left off, or revisit a lesson from your cohort.</p></div><Link class="button button-dark schedule-cta" :href="wayfinderSchedule2().url">See live schedule <span><UiIcon name="arrow-up-right" class="ui-icon" :size="15" /></span></Link></div>
      <template v-if="courses.data.length">
      <div class="learner-course-grid">
        <article v-for="course in courses.data" :key="course.slug" class="learner-course-card">
          <Link :href="wayfinderCourse3.url({ course: course.slug })" class="learner-course-cover">
            <img :src="course.image || '/images/learning/live-class.png'" :alt="course.title">
            <span class="course-cohort-label">{{ course.cohort || 'Active cohort' }}</span>
          </Link>
          <div class="learner-course-copy">
            <div class="course-mentor-label"><span>YOUR MENTOR</span><b>{{ course.mentor }}</b></div>
            <h2><Link :href="wayfinderCourse3.url({ course: course.slug })">{{ course.title }}</Link></h2>
            <p class="course-card-description">{{ course.subtitle }}</p>
            <div class="course-progress-panel">
              <div class="course-progress-heading"><span>YOUR PROGRESS</span><b>{{ course.progress }}%</b></div>
              <div class="progress-bar"><span :style="{ width: course.progress + '%' }" class="bar-violet"></span></div>
              <small>{{ course.completedLessons }} of {{ course.totalLessons }} lessons completed</small>
            </div>
            <div class="course-next-lesson"><span>NEXT LESSON</span><b>{{ course.nextLesson || 'Every lesson is complete' }}</b></div>
            <Link :href="wayfinderCourse3.url({ course: course.slug })" class="learner-course-action">
              <span>{{ course.progress ? 'Continue learning' : 'Open course' }}</span>
              <UiIcon name="arrow-up-right" class="ui-icon" :size="15" />
            </Link>
          </div>
        </article>
      </div>
      <nav v-if="courses.last_page > 1" class="learning-pagination" aria-label="Course pages">
        <Link v-for="(link, index) in courses.links" :key="index" :href="link.url || '#'"><span v-html="link.label" /></Link>
      </nav>
      </template>
      <div v-if="!courses.data.length" class="schedule-empty learner-index-empty"><span><UiIcon name="sparkles" class="ui-icon" /></span><h2>Your courses will show up here.</h2><p>When you join a cohort, you’ll find its syllabus, lessons, and progress in this space.</p><Link :href="wayfinderCourses4().url">Explore courses <UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></Link></div>
    </div></main>
  </div>
</template>


