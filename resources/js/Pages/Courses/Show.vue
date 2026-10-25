<script setup>
import { checkout as wayfinderCheckout1 } from './../../actions/App/Http/Controllers/StudentBillingController';
import { courses as wayfinderCourses2, mentor as wayfinderMentor4, contact as wayfinderContact5, course as wayfinderCourse6 } from './../../actions/App/Http/Controllers/PublicController';
import { showRegistration as wayfinderShowRegistration3 } from './../../actions/App/Http/Controllers/AuthController';
import { courses as wayfinderCourses7 } from './../../actions/App/Http/Controllers/StudentLearningController';

import { onMounted, ref, watch } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import PublicLayout from '../../Layouts/PublicLayout.vue';
import ShareButton from '../../Components/ShareButton.vue';

const props = defineProps({ course: Object, related: Array, purchase: { type: Object, default: () => ({ available: false, cohorts: [] }) } });
const openModules = ref([0]);
const openFaq = ref(0);
const saved = ref(false);
const checkout = useForm({ cohort_id: props.purchase.cohorts?.[0]?.id ?? '' });
function beginCheckout() { checkout.post(wayfinderCheckout1.url({ slug: props.course.slug })); }
const sections = [
  { id: 'overview', label: 'Overview' },
  { id: 'curriculum', label: 'Curriculum' },
  { id: 'mentor', label: 'Mentor' },
  { id: 'reviews', label: 'Reviews' },
  { id: 'questions', label: 'Questions' },
];
const questions = [
  { q: 'Are the classes live?', a: 'Yes. Live workshops are the center of the program. You will meet your mentor and cohort for practice, discussion, and feedback.' },
  { q: 'What if I miss a session?', a: 'Session recordings and learning resources help you catch up. You can bring questions from a replay to the next live class.' },
  { q: 'Is this a good fit for me?', a: 'The program is designed for curious learners who want to work through practical projects with a small cohort. If you are unsure, our team can help you choose.' },
];

onMounted(() => {
  try {
    saved.value = JSON.parse(localStorage.getItem('kanram:saved-courses') ?? '[]').includes(props.course.slug);
  } catch {
    saved.value = false;
  }
});

watch(saved, (isSaved) => {
  try {
    const courses = new Set(JSON.parse(localStorage.getItem('kanram:saved-courses') ?? '[]'));
    isSaved ? courses.add(props.course.slug) : courses.delete(props.course.slug);
    localStorage.setItem('kanram:saved-courses', JSON.stringify([...courses]));
  } catch {
    // Saving is a convenience; the page remains usable if browser storage is unavailable.
  }
});

function toggleModule(index) {
  openModules.value = openModules.value.includes(index)
    ? openModules.value.filter((item) => item !== index)
    : [...openModules.value, index];
}

</script>

<template>
  <PublicLayout>
    <main class="public-page course-v4-page">
      <section class="course-detail-hero course-v4-hero">
        <div class="wrap detail-hero-inner">
          <div class="course-v4-copy">
            <div class="course-breadcrumb"><Link :href="wayfinderCourses2().url">Courses</Link><UiIcon name="arrow-right" :size="12" /><span>{{ course.category }}</span></div>
            <div class="course-v4-label"><span class="live-dot"></span>LIVE COHORT · {{ course.level }}</div>
            <h1>{{ course.title }}</h1>
            <p>{{ course.description }}</p>
            <div class="course-v4-stats"><span><b>{{ course.duration }}</b><small>guided program</small></span><span><b>{{ course.live_classes }} live classes</b><small>with mentor feedback</small></span><span><b>{{ course.class_size }}</b><small>small cohort</small></span></div>
            <div class="course-v4-hero-actions"><Link class="button button-dark" :href="wayfinderShowRegistration3.url({ query: { course: course.slug } })">Join the next cohort <UiIcon name="arrow-up-right" :size="14" /></Link><button class="course-utility-button" type="button" :aria-pressed="saved" @click="saved = !saved"><UiIcon name="heart" :size="16" /> {{ saved ? 'Saved' : 'Save course' }}</button><ShareButton class="course-utility-button" :title="course.title" :text="course.description" /></div>
            <p class="course-v4-trust"><UiIcon name="check-circle" :size="14" /> Full curriculum visible before you join <span>·</span> No experience required to explore</p>
          </div>
          <div class="course-v4-image-wrap"><img class="course-detail-image" :src="course.image" :alt="`${course.title} live workshop`"><div class="course-image-caption"><span class="course-image-play"><UiIcon name="play" :size="13" /></span><span><b>Learn together, live</b><small>{{ course.mentor }} · {{ course.mentor_title }}</small></span></div><div class="course-rating-float"><UiIcon name="star" class="ui-rating-icon" :size="13" /><b>{{ course.rating }}</b><span>({{ course.reviews_count }} learner reviews)</span></div></div>
        </div>
      </section>

      <nav class="course-section-nav" aria-label="Course sections"><div class="wrap"><a v-for="section in sections" :key="section.id" :href="`#${section.id}`">{{ section.label }}</a><Link class="course-nav-cta" :href="wayfinderShowRegistration3.url({ query: { course: course.slug } })">Join next cohort <UiIcon name="arrow-up-right" :size="13" /></Link></div></nav>

      <div class="wrap course-v4-layout">
        <div class="course-v4-main">
          <section id="overview" class="course-v4-section course-fit-section"><div class="course-section-kicker"><span>01</span><span>THE LEARNING EXPERIENCE</span></div><div class="course-section-title"><div><h2>Build skills you can put to work.</h2><p>Real practice, a thoughtful mentor, and a small group moving forward together.</p></div></div><div class="course-outcome-grid"><article v-for="(outcome, index) in course.outcomes" :key="outcome"><span>{{ String(index + 1).padStart(2, '0') }}</span><p>{{ outcome }}</p></article></div><div class="course-format-strip"><article><span class="format-icon"><UiIcon name="users" /></span><span><b>Small cohort</b><small>{{ course.class_size }}</small></span></article><article><span class="format-icon"><UiIcon name="calendar" /></span><span><b>Live by design</b><small>{{ course.schedule }}</small></span></article><article><span class="format-icon"><UiIcon name="play" /></span><span><b>Catch up anytime</b><small>{{ course.recorded_lessons }} recordings and resources</small></span></article></div></section>

          <section id="curriculum" class="course-v4-section course-curriculum-section"><div class="course-section-kicker"><span>02</span><span>THE COURSE MAP</span></div><div class="course-section-title"><div><h2>A clear path, week by week.</h2><p>Open any module to explore its focus and live studio sessions.</p></div><span class="curriculum-total">{{ course.curriculum.length }} modules · {{ course.duration }}</span></div><article v-for="(module, index) in course.curriculum" :key="module.title" class="course-v4-module" :class="{ expanded: openModules.includes(index) }"><button class="course-v4-module-heading" type="button" :aria-expanded="openModules.includes(index)" @click="toggleModule(index)"><span class="module-number">{{ String(index + 1).padStart(2, '0') }}</span><span class="module-heading-copy"><small>{{ module.weeks }} · {{ module.lessons.length }} learning moments</small><b>{{ module.title }}</b><span>{{ module.summary }}</span></span><span class="module-live-chip"><UiIcon name="circle-dot" :size="12" /> LIVE</span><UiIcon :name="openModules.includes(index) ? 'arrow-up' : 'arrow-right'" class="module-toggle-icon" :size="16" /></button><ol v-if="openModules.includes(index)" class="course-v4-lesson-list"><li v-for="(lesson, lessonIndex) in module.lessons" :key="lesson"><span class="lesson-order">{{ String(lessonIndex + 1).padStart(2, '0') }}</span><span class="lesson-type-icon"><UiIcon :name="lessonIndex === module.lessons.length - 1 ? 'users' : 'book-open'" :size="14" /></span><span>{{ lesson }}</span><small>{{ lessonIndex === module.lessons.length - 1 ? 'LIVE STUDIO' : 'GUIDED PRACTICE' }}</small></li></ol></article></section>

          <section id="mentor" class="course-v4-section course-mentor-section"><div class="course-section-kicker"><span>03</span><span>YOUR MENTOR</span></div><div class="course-mentor-feature"><img :src="`/images/learning/${course.mentor_slug}.png`" :alt="course.mentor"><div><small>{{ course.mentor_title }}</small><h2>Learn with {{ course.mentor.split(' ')[0] }}.</h2><p>Get thoughtful, personal guidance from a practitioner who understands the work and knows how to help you make progress.</p><Link :href="wayfinderMentor4.url({ slug: course.mentor_slug })">Meet {{ course.mentor.split(' ')[0] }} <UiIcon name="arrow-up-right" :size="14" /></Link></div><div class="mentor-detail-quote">“Good questions make better work.”</div></div></section>

          <section id="reviews" class="course-v4-section course-reviews-section"><div class="course-section-kicker"><span>04</span><span>FROM THE COHORT</span></div><div class="course-section-title"><div><h2>Made better by learning together.</h2><p>What learners took away from the room.</p></div><div class="course-review-average"><UiIcon name="star" class="ui-rating-icon" :size="17" /><b>{{ course.rating }}</b><small>{{ course.reviews_count }} reviews</small></div></div><div class="course-v4-review-grid"><article v-for="review in course.reviews" :key="review.author" class="course-v4-review"><div class="quote-stars"><UiIcon v-for="star in 5" :key="star" name="star" class="ui-rating-icon" :size="12" /></div><blockquote>“{{ review.quote }}”</blockquote><div class="course-review-author"><span>{{ review.author.split(' ').map(part => part[0]).join('') }}</span><span><b>{{ review.author }}</b><small>{{ review.role }}</small></span><UiIcon name="check-circle" :size="13" /></div></article></div></section>

          <section id="questions" class="course-v4-section course-questions-section"><div class="course-section-kicker"><span>05</span><span>GOOD TO KNOW</span></div><div class="course-section-title"><div><h2>A few things you might be wondering.</h2><p>Still have a question? Our team can help you choose.</p></div><Link :href="wayfinderContact5().url">Talk to us <UiIcon name="arrow-up-right" :size="13" /></Link></div><article v-for="(item, index) in questions" :key="item.q" class="course-faq-row"><button type="button" :aria-expanded="openFaq === index" @click="openFaq = openFaq === index ? -1 : index"><span>{{ item.q }}</span><UiIcon :name="openFaq === index ? 'arrow-up' : 'plus'" :size="15" /></button><p v-if="openFaq === index">{{ item.a }}</p></article></section>

          <section class="related-courses-section"><div class="course-section-title"><div><div class="course-section-kicker"><span>KEEP EXPLORING</span></div><h2>Another good place to begin.</h2></div><Link :href="wayfinderCourses2().url">All courses <UiIcon name="arrow-up-right" :size="13" /></Link></div><div class="related-course-grid"><Link v-for="item in related" :key="item.slug" :href="wayfinderCourse6.url({ slug: item.slug })" class="related-course-card"><img :src="item.image" :alt="`${item.title} workshop`"><span><small>{{ item.category }} · {{ item.duration }}</small><b>{{ item.title }}</b><span>{{ item.mentor }} <UiIcon name="arrow-up-right" :size="12" /></span></span></Link></div></section>
        </div>

        <aside class="course-v4-sidebar"><div class="cohort-card-v4"><div class="cohort-card-top"><span><i></i> NEXT COHORT</span><span>{{ course.class_size }}</span></div><div class="cohort-start-date"><small>STARTS</small><b>{{ course.next_start }}</b></div><p class="cohort-schedule"><UiIcon name="calendar" :size="15" /> {{ course.schedule }}</p><div class="cohort-card-divider"></div><div class="cohort-includes"><span><UiIcon name="check" :size="13" /> {{ course.live_classes }} mentor-led live classes</span><span><UiIcon name="check" :size="13" /> {{ course.recorded_lessons }} class replays and resources</span><span><UiIcon name="check" :size="13" /> Feedback on your project work</span><span><UiIcon name="check" :size="13" /> Final cohort showcase</span></div><div class="cohort-price"><span>Program tuition</span><b>{{ purchase.currency || 'USD' }} {{ course.price }} <small>{{ purchase.currency || 'USD' }}</small></b></div>
          <form v-if="purchase.student && purchase.available && !purchase.alreadyEnrolled" class="course-checkout-form" @submit.prevent="beginCheckout"><label v-if="purchase.cohorts?.length">Choose your live cohort<select v-model="checkout.cohort_id"><option v-for="cohort in purchase.cohorts" :key="cohort.id" :value="cohort.id">{{ cohort.name }}<template v-if="cohort.startsOn"> · starts {{ new Date(cohort.startsOn).toLocaleDateString(undefined, { dateStyle: 'medium' }) }}</template></option></select></label><p v-if="checkout.errors.cohort_id" class="form-error">{{ checkout.errors.cohort_id }}</p><button class="button button-dark cohort-join-button" :disabled="checkout.processing || !purchase.paymentsConfigured">{{ checkout.processing ? 'Opening secure checkout…' : 'Continue to secure checkout' }} <UiIcon name="lock-keyhole" :size="14" /></button><p v-if="!purchase.paymentsConfigured" class="form-error">Online checkout is being set up. Please contact the academy to enroll.</p><p v-if="checkout.errors.payment" class="form-error">{{ checkout.errors.payment }}</p><small class="checkout-trust-note">Secure payment handled by Stripe. Your card details are never stored here.</small></form>
          <div v-else-if="purchase.alreadyEnrolled" class="course-enrolled-note">You already have course access. <Link :href="wayfinderCourses7().url">Go to my courses <UiIcon name="arrow-up-right" :size="12" /></Link></div><Link v-else class="button button-dark cohort-join-button" :href="wayfinderShowRegistration3.url({ query: { course: course.slug } })">Create your learner account <UiIcon name="arrow-up-right" :size="14" /></Link><p class="cohort-note">{{ purchase.student ? 'Choose an available cohort before payment.' : 'Create your learner account to get started.' }} <Link :href="wayfinderContact5().url">Questions? Talk to us.</Link></p></div><div class="cohort-mentor-card"><div class="course-section-kicker"><span>YOUR MENTOR</span></div><div><img :src="`/images/learning/${course.mentor_slug}.png`" :alt="course.mentor"><span><b>{{ course.mentor }}</b><small>{{ course.mentor_title }}</small></span></div><Link :href="wayfinderMentor4.url({ slug: course.mentor_slug })">See mentor profile <UiIcon name="arrow-up-right" :size="12" /></Link></div><div class="course-side-help"><UiIcon name="sparkles" :size="17" /><p><b>Choosing between courses?</b><br>We’ll help you find a program and live schedule that fit.</p><Link :href="wayfinderContact5().url">Ask our team <UiIcon name="arrow-up-right" :size="12" /></Link></div></aside>
      </div>
      <div class="course-mobile-cta"><span><small>Starts {{ course.next_start }}</small><b>{{ purchase.currency || 'USD' }} {{ course.price }}</b></span><button v-if="purchase.student && purchase.available && !purchase.alreadyEnrolled" class="button button-dark" :disabled="checkout.processing || !purchase.paymentsConfigured" @click="beginCheckout">{{ checkout.processing ? 'Opening checkout…' : 'Secure checkout' }} <UiIcon name="lock-keyhole" :size="13" /></button><Link v-else-if="purchase.alreadyEnrolled" class="button button-dark" :href="wayfinderCourses7().url">Open my course <UiIcon name="arrow-up-right" :size="13" /></Link><Link v-else class="button button-dark" :href="wayfinderShowRegistration3.url({ query: { course: course.slug } })">Join next cohort <UiIcon name="arrow-up-right" :size="13" /></Link></div>
    </main>
  </PublicLayout>
</template>
