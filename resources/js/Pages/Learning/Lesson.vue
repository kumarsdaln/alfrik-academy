<script setup>
import { completeLesson as wayfinderCompleteLesson1, course as wayfinderCourse2, lesson as wayfinderLesson3 } from './../../actions/App/Http/Controllers/StudentLearningController';

import LearningSidebar from '../../Components/LearningSidebar.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ course: Object, module: Object, lesson: Object });
const form = useForm({});
function complete() {
  form.post(wayfinderCompleteLesson1.url({ lesson: props.lesson.id }), { preserveScroll: true });
}
</script>

<template>
  <div class="dashboard-shell"><LearningSidebar active="courses" />
    <main class="dash-main"><header class="dash-top"><nav class="lesson-top-nav" aria-label="Lesson location"><Link :href="wayfinderCourse2.url({ course: course.slug })"><UiIcon name="arrow-left" class="ui-icon" :size="13" />Back to course</Link></nav></header><div class="dash-content lesson-content"><nav class="lesson-breadcrumb" aria-label="Breadcrumb"><Link :href="wayfinderCourse2.url({ course: course.slug })">{{ course.title }}</Link><span aria-hidden="true">/</span><span>{{ module.title }}</span><span aria-hidden="true">/</span><span aria-current="page">{{ lesson.title }}</span></nav><article class="lesson-panel"><div class="eyebrow">{{ lesson.type }}<span v-if="lesson.duration"> · {{ Math.max(1, Math.round(lesson.duration / 60)) }} MIN</span></div><h1>{{ lesson.title }}</h1><p v-if="lesson.summary" class="lesson-summary">{{ lesson.summary }}</p><div v-if="lesson.videoUrl" class="lesson-video-card"><span><UiIcon name="play" class="ui-icon" :size="12" /></span><div><b>Lesson video</b><p>Watch the lesson, then mark it complete to track your progress.</p></div><a :href="lesson.videoUrl" target="_blank" rel="noopener noreferrer">Open video <UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></a></div><div v-if="lesson.body && lesson.body.trim() !== lesson.summary?.trim()" class="lesson-body">{{ lesson.body }}</div><a v-if="lesson.resourcePath" class="lesson-resource" :href="`/storage/${lesson.resourcePath}`" target="_blank" rel="noopener noreferrer">Download lesson resource <UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></a><div v-if="!lesson.body && !lesson.videoUrl && !lesson.resourcePath" class="lesson-placeholder"><b>Lesson materials are being prepared</b><p>Your mentor is still adding resources. You can return to this lesson from the course syllabus anytime.</p></div><button v-if="!lesson.completed" class="button button-dark" :disabled="form.processing" @click="complete">{{ form.processing ? 'Saving…' : 'Mark lesson complete' }} <span><UiIcon name="check" class="ui-icon" :size="13" /></span></button><div v-else class="lesson-done"><UiIcon name="check" class="ui-icon" :size="13" /> Lesson complete — nice work.</div></article><nav class="lesson-nav" aria-label="Lesson navigation"><Link v-if="lesson.previousId" :href="wayfinderLesson3.url({ lesson: lesson.previousId })"><UiIcon name="arrow-left" class="ui-icon" :size="13" /> Previous lesson</Link><span v-else></span><Link v-if="lesson.nextId" :href="wayfinderLesson3.url({ lesson: lesson.nextId })">Next lesson <UiIcon name="arrow-right" class="ui-icon" :size="13" /></Link><Link v-else :href="wayfinderCourse2.url({ course: course.slug })">Back to syllabus <UiIcon name="arrow-right" class="ui-icon" :size="13" /></Link></nav></div></main>
  </div>
</template>
