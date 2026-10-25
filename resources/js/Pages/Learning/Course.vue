<script setup>
import { dashboard as wayfinderDashboard1, quiz as wayfinderQuiz2, lesson as wayfinderLesson3 } from './../../actions/App/Http/Controllers/StudentLearningController';

import LearningSidebar from '../../Components/LearningSidebar.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ course: Object });
</script>

<template>
  <div class="dashboard-shell">
    <LearningSidebar active="courses" />
    <main class="dash-main">
      <header class="dash-top"><Link :href="wayfinderDashboard1().url"><UiIcon name="arrow-left" :size="13" /> Learning home</Link><span>Mentored by {{ course.mentor }}</span></header>
      <div class="dash-content enrolled-course-content">
        <div class="enrolled-course-hero"><div><div class="eyebrow">YOUR COHORT COURSE</div><h1>{{ course.title }}</h1><p>{{ course.subtitle }}</p><div class="course-progress-large"><span :style="{ width: course.progress + '%' }"></span></div><small>{{ course.progress }}% complete</small></div><div class="course-progress-stamp"><b>{{ course.modules.length }}</b><span>learning<br>modules</span></div></div>
        <section v-if="course.quizzes.length" class="course-quizzes"><div class="dash-section-head"><div><h2>Knowledge checks</h2><p>Short practice between live classes helps reinforce what you are learning.</p></div></div><Link v-for="quiz in course.quizzes" :key="quiz.id" :href="wayfinderQuiz2.url({ quizId: quiz.id })" class="course-quiz-row"><span class="quiz-row-icon"><UiIcon name="clipboard-list" /></span><span class="course-quiz-copy"><b>{{ quiz.title }}</b><small>{{ quiz.questionCount }} questions · {{ quiz.attemptLimit !== null ? `${quiz.attemptsUsed}/${quiz.attemptLimit} attempts used` : 'Practice at your pace' }}<template v-if="quiz.latestScore !== null"> · Latest {{ Math.round(quiz.latestScore) }}%</template></small></span><span class="course-quiz-action">{{ quiz.attemptLimit !== null && quiz.attemptsUsed >= quiz.attemptLimit ? 'Review result' : quiz.attemptsUsed ? 'Continue practice' : 'Start quiz' }} <UiIcon name="arrow-up-right" :size="13" /></span></Link></section>
        <section id="syllabus" class="enrolled-syllabus"><div class="dash-section-head"><div><h2>Your syllabus</h2><p>Lessons and live practice, organized by module.</p></div></div><article v-for="(module, index) in course.modules" :key="module.id" class="enrolled-module"><div class="enrolled-module-heading"><span>{{ String(index + 1).padStart(2, '0') }}</span><div><h3>{{ module.title }}</h3><p v-if="module.description">{{ module.description }}</p></div><small>{{ module.lessons.filter(lesson => lesson.completed).length }}/{{ module.lessons.length }} done</small></div><Link v-for="lesson in module.lessons" :key="lesson.id" :href="wayfinderLesson3.url({ lesson: lesson.id })" class="enrolled-lesson"><span class="lesson-complete-icon" :class="{ complete: lesson.completed }"><UiIcon v-if="lesson.completed" name="check" :size="12" /><UiIcon v-else name="play" :size="10" /></span><span class="enrolled-lesson-copy"><b>{{ lesson.title }}</b><small>{{ lesson.type }}<span v-if="lesson.duration"> · {{ Math.max(1, Math.round(lesson.duration / 60)) }} min</span></small></span><span class="enrolled-lesson-action">{{ lesson.completed ? 'Review' : 'Start' }} <UiIcon name="arrow-up-right" :size="13" /></span></Link><div v-if="!module.lessons.length" class="module-empty">Your mentor is preparing this module.</div></article><div v-if="!course.modules.length" class="schedule-empty"><span><UiIcon name="sparkles" /></span><h2>Your syllabus is taking shape.</h2><p>Your mentor will add modules and lessons here soon.</p></div></section>
      </div>
    </main>
  </div>
</template>
