<script setup>
import { Link } from '@inertiajs/vue3';
import { session as sessionRoute } from '../../actions/App/Http/Controllers/StudentLearningController';

defineProps({
  item: { type: Object, required: true },
  past: { type: Boolean, default: false },
});
</script>

<template>
  <article class="schedule-event">
    <div class="schedule-date" :class="{ 'past-date': past }">
      <small>{{ item.day }}</small>
      <b>{{ item.dayNumber }}</b>
      <span class="schedule-date-time">{{ item.time }}</span>
    </div>
    <div class="schedule-event-main">
      <span class="eyebrow">{{ item.course }}</span>
      <h2 class="truncate">{{ item.title }}</h2>
      <p><span>{{ item.date }}</span><span>{{ item.duration }} minutes</span><span>With {{ item.teacher }}</span></p>
    </div>
    <Link class="schedule-open" :href="sessionRoute(item.id).url">
      {{ past ? (item.hasReplay ? 'Watch replay' : 'Details') : 'Class details' }}
      <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
    </Link>
  </article>
</template>
