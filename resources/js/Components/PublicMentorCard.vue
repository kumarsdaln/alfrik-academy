<script setup>
import { mentor as wayfinderMentor1 } from './../actions/App/Http/Controllers/PublicController';

import { Link } from '@inertiajs/vue3';

defineProps({
  mentor: { type: Object, required: true },
  variant: { type: String, default: 'featured' },
});
</script>

<template>
  <Link v-if="variant === 'featured'" :href="wayfinderMentor1.url({ slug: mentor.slug })" class="home-v3-mentor-card">
    <div class="home-v3-mentor-image"><img :src="mentor.image" :alt="mentor.name"><span>{{ mentor.field }}</span></div>
    <div class="home-v3-mentor-info"><span><b>{{ mentor.name }}</b><small>{{ mentor.role }}</small></span><UiIcon name="arrow-up-right" :size="16" /></div>
  </Link>

  <Link v-else :href="wayfinderMentor1.url({ slug: mentor.slug })" class="mentor-profile-card">
    <img class="mentor-list-photo" :src="mentor.image" :alt="mentor.name">
    <div><span class="mentor-field">{{ mentor.field }}</span><h2>{{ mentor.name }}</h2><p>{{ mentor.role }}</p><p>{{ mentor.intro }}</p><span class="text-link">Meet {{ mentor.name.split(' ')[0] }} <UiIcon name="arrow-up-right" :size="12" /></span></div>
    <span class="profile-stat">{{ mentor.learners }}<small>learners supported</small></span>
  </Link>
</template>
