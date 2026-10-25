<script setup>
import { submitAssignment as wayfinderSubmitAssignment1, assignments as wayfinderAssignments2, course as wayfinderCourse3 } from './../../actions/App/Http/Controllers/StudentLearningController';

import LearningSidebar from '../../Components/LearningSidebar.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ assignment: Object });
const form = useForm({ response: props.assignment.submission?.response ?? '' });
function submit() {
  form.post(wayfinderSubmitAssignment1.url({ assignmentId: props.assignment.id }), { preserveScroll: true });
}
</script>

<template>
  <div class="dashboard-shell"><LearningSidebar active="assignments" />
    <main class="dash-main"><header class="dash-top"><Link :href="wayfinderAssignments2().url"><UiIcon name="arrow-left" class="ui-icon" :size="13" /> Your assignments</Link><span>{{ assignment.course }}</span></header><div class="dash-content assignment-content"><div class="eyebrow">COHORT PROJECT · {{ assignment.course }}</div><h1>{{ assignment.title }}</h1><p v-if="assignment.dueAt" class="assignment-due">Due {{ new Date(assignment.dueAt).toLocaleString(undefined, { dateStyle: 'medium', timeStyle: 'short' }) }}</p><article class="assignment-instructions"><div class="eyebrow">THE PROMPT</div><p>{{ assignment.instructions }}</p></article>
      <section v-if="assignment.submission" class="submission-received"><div class="submission-check"><UiIcon name="check" class="ui-icon" :size="13" /></div><div><div class="eyebrow">{{ assignment.submission.status === 'graded' ? 'FEEDBACK FROM YOUR MENTOR' : 'SUBMISSION RECEIVED' }}</div><h2>{{ assignment.submission.status === 'graded' ? 'Your mentor has reviewed this.' : 'You’ve put your work out there.' }}</h2><p v-if="assignment.submission.score !== null && assignment.submission.score !== undefined" class="submission-score">Score · {{ assignment.submission.score }}</p><p class="submission-response">{{ assignment.submission.response }}</p><div v-if="assignment.submission.feedback" class="mentor-feedback"><b>Mentor feedback</b><p>{{ assignment.submission.feedback }}</p></div><small v-if="assignment.submission.submittedAt">Submitted {{ new Date(assignment.submission.submittedAt).toLocaleString() }}</small></div></section>
      <form v-else class="assignment-form" @submit.prevent="submit"><label for="assignment-response">Your work</label><p>Share your response with your mentor. You can include a draft, a reflection, or a link in the text below.</p><textarea id="assignment-response" v-model="form.response" rows="10" maxlength="20000" placeholder="Start with what you noticed, tried, or want feedback on…"></textarea><small v-if="form.errors.response" class="form-error">{{ form.errors.response }}</small><div class="assignment-submit-row"><span>{{ form.response.length }} / 20,000 characters</span><button class="button button-dark" :disabled="form.processing">{{ form.processing ? 'Submitting…' : 'Submit your work' }} <span><UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></span></button></div></form>
      <div class="assignment-back"><Link :href="wayfinderCourse3.url({ course: assignment.courseSlug })">Back to course syllabus <UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></Link></div>
    </div></main>
  </div>
</template>
