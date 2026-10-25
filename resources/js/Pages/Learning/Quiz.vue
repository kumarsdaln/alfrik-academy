<script setup>
import { submitQuiz as wayfinderSubmitQuiz1, course as wayfinderCourse2 } from './../../actions/App/Http/Controllers/StudentLearningController';

import LearningSidebar from '../../Components/LearningSidebar.vue';
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ quiz: Object });
const form = useForm({ answers: {} });
const answered = computed(() => Object.keys(form.answers).filter((id) => form.answers[id]).length);
const complete = computed(() => answered.value === props.quiz.questions.length);
const reviewByQuestion = computed(() => new Map((props.quiz.latestAttempt?.answers ?? []).map((answer) => [answer.questionId, answer])));

function submit() {
  form.post(wayfinderSubmitQuiz1.url({ quizId: props.quiz.id }), { preserveScroll: true });
}
</script>

<template>
  <div class="dashboard-shell">
    <LearningSidebar active="courses" />
    <main class="dash-main">
      <header class="dash-top"><Link :href="wayfinderCourse2.url({ course: quiz.courseSlug })"><UiIcon name="arrow-left" :size="13" /> {{ quiz.courseTitle }}</Link><span>Knowledge check</span></header>
      <div class="dash-content quiz-content">
        <div class="eyebrow">PRACTICE & REFLECT</div>
        <h1>{{ quiz.title }}</h1>
        <p class="quiz-intro">A quick check-in to help you see what you understand before the next live session.</p>
        <div class="quiz-meta"><span><UiIcon name="clipboard-list" :size="14" /> {{ quiz.questions.length }} questions</span><span><UiIcon name="check-circle" :size="14" /> Pass mark {{ quiz.passPercent }}%</span><span><UiIcon name="circle-dot" :size="14" /> {{ quiz.attemptLimit !== null ? `${quiz.remainingAttempts} attempt${quiz.remainingAttempts === 1 ? '' : 's'} left` : 'Unlimited attempts' }}</span></div>

        <section v-if="quiz.latestAttempt" class="quiz-result" :class="quiz.latestAttempt.passed ? 'quiz-result-pass' : 'quiz-result-review'">
          <span class="quiz-result-icon"><UiIcon :name="quiz.latestAttempt.passed ? 'check-circle' : 'circle-help'" :size="18" /></span>
          <div><div class="eyebrow">{{ quiz.latestAttempt.passed ? 'NICE WORK — YOU PASSED' : 'A USEFUL PLACE TO START AGAIN' }}</div><h2>{{ Math.round(quiz.latestAttempt.score) }}%</h2><p>You got {{ quiz.latestAttempt.answers.filter(answer => answer.isCorrect).length }} of {{ quiz.questions.length }} questions right. Correct answers are shown below.</p></div>
        </section>

        <form v-if="quiz.canAttempt && quiz.questions.length" class="quiz-form" @submit.prevent="submit">
          <fieldset v-for="(question, index) in quiz.questions" :key="question.id" class="quiz-question">
            <legend><span>{{ String(index + 1).padStart(2, '0') }}</span>{{ question.prompt }}<small>{{ question.points }} {{ question.points === 1 ? 'point' : 'points' }}</small></legend>
            <label v-for="option in question.options" :key="option.id" class="quiz-option" :class="{ 'quiz-option-selected': form.answers[question.id] === option.id }">
              <input v-model="form.answers[question.id]" type="radio" :name="`question-${question.id}`" :value="option.id">
              <span class="quiz-radio"></span><span>{{ option.body }}</span>
            </label>
            <small v-if="form.errors[`answers.${question.id}`]" class="quiz-error">{{ form.errors[`answers.${question.id}`] }}</small>
          </fieldset>
          <div class="quiz-submit-row"><span>{{ answered }} of {{ quiz.questions.length }} answered</span><button class="button button-dark" type="submit" :disabled="form.processing || !complete">{{ form.processing ? 'Submitting…' : 'Submit answers' }} <UiIcon name="arrow-up-right" :size="13" /></button></div>
          <p v-if="form.errors.answers || form.errors.quiz" class="quiz-error">{{ form.errors.answers || form.errors.quiz }}</p>
        </form>
        <section v-else-if="!quiz.questions.length" class="learning-empty"><span><UiIcon name="clipboard-list" /></span><div><b>This quiz is being prepared</b><p>Your mentor has not added questions yet.</p></div></section>
        <section v-else class="quiz-locked"><div class="eyebrow">ALL ATTEMPTS USED</div><h2>Take a look at what you learned.</h2><p>Your latest result and answer review are above. Bring any questions to your next live class.</p></section>

        <section v-if="quiz.latestAttempt" class="quiz-review"><div class="dash-section-head"><div><h2>Answer review</h2><p>Use the explanations as a guide for what to revisit.</p></div></div><article v-for="(question, index) in quiz.questions" :key="question.id" class="quiz-review-question"><div class="quiz-review-prompt"><span>{{ String(index + 1).padStart(2, '0') }}</span><b>{{ question.prompt }}</b></div><div v-for="option in question.options" :key="option.id" class="quiz-review-option" :class="{ 'is-correct': reviewByQuestion.get(question.id)?.correctOptionId === option.id, 'is-wrong': reviewByQuestion.get(question.id)?.selectedOptionId === option.id && !reviewByQuestion.get(question.id)?.isCorrect }"><UiIcon :name="reviewByQuestion.get(question.id)?.correctOptionId === option.id ? 'check-circle' : reviewByQuestion.get(question.id)?.selectedOptionId === option.id ? 'close' : 'circle-dot'" :size="14" /><span>{{ option.body }}</span><small v-if="reviewByQuestion.get(question.id)?.correctOptionId === option.id">Correct answer</small><small v-else-if="reviewByQuestion.get(question.id)?.selectedOptionId === option.id">Your answer</small></div></article></section>
      </div>
    </main>
  </div>
</template>
