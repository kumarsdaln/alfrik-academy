<script setup>
import { course as wayfinderCourse1, mentor as wayfinderMentor2 } from './../actions/App/Http/Controllers/PublicController';

import { Link } from '@inertiajs/vue3';

defineProps({
  course: { type: Object, required: true },
  variant: { type: String, default: 'featured' },
  position: { type: Number, default: 1 },
});
</script>

<template>
  <article v-if="variant === 'featured'" class="home-v3-course-card">
    <Link :href="wayfinderCourse1.url({ slug: course.slug })" class="home-v3-course-image">
      <img :src="course.image" :alt="`${course.category} live learning program`">
      <span>{{ String(position).padStart(2, '0') }} <i>·</i> {{ course.category }}</span>
    </Link>
    <div class="home-v3-course-content">
      <div class="home-v3-course-meta">
        <span>{{ course.weeks }} weeks</span>
        <span v-if="course.rating !== 'New'"><UiIcon name="star" :size="12" /> {{ course.rating }}</span>
        <span v-else>New program</span>
      </div>
      <h3><Link :href="wayfinderCourse1.url({ slug: course.slug })">{{ course.title }}</Link></h3>
      <p>{{ course.summary }}</p>
      <div class="home-v3-course-footer">
        <span class="home-v3-mentor-mini">
          <img :src="`/images/learning/${course.mentor_slug}.png`" :alt="course.mentor">
          <span><small>{{ course.mentor_title }}</small><b>{{ course.mentor }}</b></span>
        </span>
        <Link :href="wayfinderCourse1.url({ slug: course.slug })" :aria-label="`Explore ${course.title}`"><UiIcon name="arrow-up-right" :size="16" /></Link>
      </div>
    </div>
  </article>

  <article v-else class="refined-course-card">
    <Link :href="wayfinderCourse1.url({ slug: course.slug })" class="refined-course-image"><img :src="course.image" :alt="`${course.category} course`"></Link>
    <div class="refined-course-top"><span>{{ course.category }}</span><span><UiIcon name="star" class="ui-icon ui-rating-icon" :size="12" /> {{ course.rating }} <small>({{ course.reviews_count }})</small></span></div>
    <h2>{{ course.title }}</h2>
    <p>{{ course.summary }}</p>
    <div class="refined-course-mentor">
      <span class="refined-initials">{{ course.mentor.split(' ').map((name) => name[0]).join('') }}</span>
      <span><small>{{ course.mentor_title }}</small><b>{{ course.mentor }}</b></span>
      <Link :href="wayfinderMentor2.url({ slug: course.mentor_slug })" class="mentor-profile-link">Profile <UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></Link>
    </div>
    <div class="refined-course-meta"><span>{{ course.duration }}</span><span>{{ course.class_size }}</span><span>Starts {{ course.next_start }}</span></div>
    <div class="refined-course-bottom"><b>${{ course.price }} <small>USD</small></b><Link :href="wayfinderCourse1.url({ slug: course.slug })" class="refined-text-link">View course <span><UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></span></Link></div>
  </article>
</template>
