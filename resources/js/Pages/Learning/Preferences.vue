<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import LearningSettingsLayout from '../../Components/LearningSettingsLayout.vue';
import { updatePreferences } from '../../actions/App/Http/Controllers/StudentProfileController';
import { course as showCourse } from '../../actions/App/Http/Controllers/StudentLearningController';

const props = defineProps({ timezone: { type: String, required: true }, courses: { type: Array, default: () => [] } });
const form = useForm({ timezone: props.timezone });
const save = () => form.put(updatePreferences().url, { preserveScroll: true });
</script>

<template>
  <LearningSettingsLayout active="learning" title="Learning preferences" description="Set the time zone used for your classes and keep your learning space organized.">
    <section class="settings-detail-grid">
      <form class="profile-settings-card settings-form-card" @submit.prevent="save">
        <div class="profile-settings-heading"><div><span class="eyebrow">CLASS SCHEDULE</span><h2>Your time zone</h2></div><UiIcon name="clock" :size="20" /></div>
        <p class="settings-card-intro">We’ll use this to show live class times in your local time.</p>
        <label for="profile-timezone">Preferred time zone<select id="profile-timezone" v-model="form.timezone" autocomplete="timezone"><option value="Asia/Kolkata">India Standard Time (IST)</option><option value="America/New_York">Eastern Time (ET)</option><option value="America/Los_Angeles">Pacific Time (PT)</option><option value="Europe/London">United Kingdom (GMT/BST)</option><option value="Australia/Sydney">Australian Eastern Time</option><option value="UTC">UTC</option></select><small v-if="form.errors.timezone" role="alert">{{ form.errors.timezone }}</small></label>
        <div class="settings-form-actions"><span>Change this whenever you travel.</span><button class="button button-dark" type="submit" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save time zone' }} <UiIcon name="arrow-up-right" :size="14" /></button></div>
      </form>
      <aside class="profile-settings-aside">
        <section class="profile-settings-card profile-courses-card"><span class="eyebrow">YOUR LEARNING SPACE</span><h2>{{ courses.length }} active {{ courses.length === 1 ? 'course' : 'courses' }}</h2><Link v-for="course in courses" :key="course.slug" :href="showCourse.url({ course: course.slug })" class="profile-course-link"><span>{{ course.title }}</span><UiIcon name="arrow-up-right" :size="13" /></Link><p v-if="!courses.length">Courses you join will appear here with lessons and live practice.</p></section>
        <section class="settings-note"><UiIcon name="calendar-plus" :size="18" /><p>Class times are shown in the time zone saved here.</p></section>
      </aside>
    </section>
  </LearningSettingsLayout>
</template>
