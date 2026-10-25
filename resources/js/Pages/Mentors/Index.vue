<script setup>
import PublicLayout from '../../Layouts/PublicLayout.vue';
import PublicMentorCard from '../../Components/PublicMentorCard.vue';
defineProps({ mentors: Array });
</script>

<template>
  <PublicLayout>
    <main class="public-page">
      <section class="page-hero wrap"><div class="eyebrow">PEOPLE WHO MAKE ROOM FOR YOU</div><h1>Meet the mentors<br><em>in your corner.</em></h1><p>Practitioners who love their craft, make space for questions, and bring real experience into every live class.</p></section>
      <section class="wrap page-content mentor-list mentor-photo-grid"><PublicMentorCard v-for="mentor in mentors" :key="mentor.slug" :mentor="mentor" variant="directory" /></section>
    </main>
  </PublicLayout>
</template>
