<script setup>
import { schedule as wayfinderSchedule1 } from './../../actions/App/Http/Controllers/StudentLearningController';

import LearningSidebar from '../../Components/LearningSidebar.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ session: Object });
</script>

<template>
  <div class="dashboard-shell"><LearningSidebar active="schedule" />
    <main class="dash-main"><header class="dash-top"><nav class="session-breadcrumbs" aria-label="Breadcrumb"><Link :href="wayfinderSchedule1().url"><UiIcon name="arrow-left" class="ui-icon" :size="13" />Class schedule</Link><span aria-hidden="true">/</span><span>{{ session.course }}</span></nav></header><div class="dash-content session-detail-content"><div class="session-detail-card"><div class="session-detail-art"><span class="session-duration-number">{{ session.duration }}</span><small>{{ session.duration === 1 ? 'MINUTE' : 'MINUTES' }} COHORT SESSION</small></div><div class="session-detail-copy"><div class="eyebrow">{{ session.course }}</div><h1>{{ session.title }}</h1><div class="session-detail-meta"><span>{{ session.date }} · {{ session.time }}</span><span>With <b>{{ session.teacher }}</b></span></div><p v-if="session.description" class="session-description">{{ session.description }}</p><p v-else class="session-description">A focused session with your cohort. Bring your questions, ideas, and work in progress.</p>
      <a v-if="session.joinUrl" class="button button-dark" :href="session.joinUrl" target="_blank" rel="noopener noreferrer">Join live class <span><UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></span></a>
      <a v-else-if="session.recordingUrl" class="button button-dark" :href="session.recordingUrl" target="_blank" rel="noopener noreferrer">Watch class replay <span><UiIcon name="play" class="ui-icon" :size="12" /></span></a>
      <div v-else class="session-status"><span><UiIcon name="clock" class="ui-icon" /></span><p>{{ session.startsAt && new Date(session.startsAt) > new Date() ? 'Your mentor has not added a meeting link yet. Check back before class.' : 'A recording has not been shared for this class yet.' }}</p></div>
      <div class="session-detail-footer"><span>Facilitated by <b>{{ session.teacher }}</b></span><span v-if="session.provider">Hosted on {{ session.provider }}</span></div>
    </div></div><section class="prep-note"><div><span class="eyebrow">BEFORE CLASS</span><b>Make the most of your live time</b><p>Bring a question, share your work in progress, and leave with one clear next step to try.</p></div></section></div></main>
  </div>
</template>
