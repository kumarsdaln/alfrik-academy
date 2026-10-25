<script setup>
import { courses as wayfinderCourses1 } from './../../actions/App/Http/Controllers/PublicController';

import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import PublicLayout from '../../Layouts/PublicLayout.vue';
import PublicCourseCard from '../../Components/PublicCourseCard.vue';
const props = defineProps({ courses: Array, categories: Array, filters: Object });
const q = ref(props.filters.q || '');
const category = ref(props.filters.category || 'all');
let timer;
watch([q, category], () => { clearTimeout(timer); timer = setTimeout(() => router.get(wayfinderCourses1().url, { q: q.value, category: category.value }, { preserveState: true, replace: true, preserveScroll: true }), 180); });
</script>

<template><PublicLayout><main class="refined-main"><section class="refined-page-heading wrap"><div class="eyebrow">SMALL COHORTS · LIVE CLASSES · REAL PRACTICE</div><h1>Courses for your<br><em>next chapter.</em></h1><p>Find a focused program led by a mentor who makes time for you. Review the schedule and full curriculum before you decide.</p></section><section class="wrap refined-catalog"><div class="refined-catalog-tools"><label><span class="sr-only">Search courses</span><input v-model="q" type="search" placeholder="Search by skill, course, or mentor"></label><select v-model="category" aria-label="Filter by subject"><option value="all">All subjects</option><option v-for="cat in categories" :key="cat.slug" :value="cat.slug">{{ cat.label }}</option></select><span class="course-count">{{ courses.length }} programs</span></div><div class="refined-course-grid"><PublicCourseCard v-for="course in courses" :key="course.slug" :course="course" variant="catalog" /></div><div v-if="!courses.length" class="refined-empty">No courses match that search. Try another topic.</div></section></main></PublicLayout></template>
