<script setup>
import { dashboard as wayfinderDashboard1, course as wayfinderCourse3 } from './../../actions/App/Http/Controllers/StudentLearningController';
import { courses as wayfinderCourses2, course as wayfinderCourse4 } from './../../actions/App/Http/Controllers/PublicController';
import { show as wayfinderShow5 } from './../../actions/App/Http/Controllers/WebinarEventController';

import { Link } from '@inertiajs/vue3';
import LearningSidebar from '../../Components/LearningSidebar.vue';

defineProps({ payments: Object, eventTickets: Array });
function money(payment) {
  return new Intl.NumberFormat(undefined, { style: 'currency', currency: payment.currency }).format(payment.amount / 100);
}
</script>

<template>
  <div class="dashboard-shell"><LearningSidebar active="purchases" />
    <main class="dash-main"><header class="dash-top"><Link :href="wayfinderDashboard1().url"><UiIcon name="arrow-left" /> Learning home</Link><span>Your Alfrik account</span></header>
      <div class="dash-content account-page-content"><div class="learner-index-heading"><div><div class="eyebrow">YOUR ACCOUNT</div><h1>Purchases & receipts</h1><p>Course orders, paid event tickets, and payment confirmations, all in one place.</p></div><Link class="button button-dark" :href="wayfinderCourses2().url">Explore courses <UiIcon name="arrow-up-right" /></Link></div>
        <div v-if="payments.data.length" class="account-list">
          <article v-for="payment in payments.data" :key="`course-${payment.id}`" class="account-list-item"><span class="account-item-icon"><UiIcon name="credit-card" /></span><div class="account-list-main"><small>COURSE ENROLLMENT · {{ payment.currency }}</small><h2>{{ payment.course }}</h2><p>{{ payment.cohort || 'Course access' }}<span v-if="payment.paidAt"> · Paid {{ new Date(payment.paidAt).toLocaleDateString(undefined, { dateStyle: 'medium' }) }}</span><span v-else-if="payment.expiresAt && payment.status === 'pending'"> · Checkout expires {{ new Date(payment.expiresAt).toLocaleString(undefined, { dateStyle: 'short' }) }}</span></p></div><div class="account-list-total"><b>{{ money(payment) }}</b><span class="payment-status" :class="`status-${payment.status}`">{{ payment.status }}</span><a v-if="payment.receiptUrl" :href="payment.receiptUrl" target="_blank" rel="noopener noreferrer">Stripe receipt <UiIcon name="external-link" /></a><a v-else-if="payment.checkoutUrl" :href="payment.checkoutUrl" target="_blank" rel="noopener noreferrer">Continue checkout <UiIcon name="external-link" /></a></div><Link v-if="payment.status === 'paid'" :href="wayfinderCourse3.url({ course: payment.slug })" class="account-list-link">Open course <UiIcon name="arrow-up-right" /></Link><Link v-else :href="wayfinderCourse4.url({ slug: payment.slug })" class="account-list-link">View course <UiIcon name="arrow-up-right" /></Link></article>
        </div>
        <section v-if="eventTickets.length" class="event-purchases"><div class="eyebrow">WEBINARS & EVENTS</div><h2>Event tickets</h2><article v-for="ticket in eventTickets" :key="`event-${ticket.id}`" class="account-list-item"><span class="account-item-icon"><UiIcon name="ticket" /></span><div class="account-list-main"><small>EVENT TICKET · {{ ticket.currency }}</small><h2>{{ ticket.title }}</h2><p v-if="ticket.status === 'bypassed'">Development preview · gateway payment skipped; no charge was made.</p><p v-else><span v-if="ticket.paidAt">Paid {{ new Date(ticket.paidAt).toLocaleDateString(undefined, { dateStyle: 'medium' }) }}</span><span v-else-if="ticket.expiresAt && ticket.status === 'pending'"> · Checkout expires {{ new Date(ticket.expiresAt).toLocaleString(undefined, { dateStyle: 'short' }) }}</span></p></div><div class="account-list-total"><b>{{ money(ticket) }}</b><span class="payment-status" :class="`status-${ticket.status}`">{{ ticket.status === 'bypassed' ? 'dev preview' : ticket.status }}</span><a v-if="ticket.receiptUrl" :href="ticket.receiptUrl" target="_blank" rel="noopener noreferrer">Stripe receipt <UiIcon name="external-link" /></a><a v-else-if="ticket.checkoutUrl" :href="ticket.checkoutUrl" target="_blank" rel="noopener noreferrer">Continue checkout <UiIcon name="external-link" /></a></div><Link v-if="ticket.slug" :href="wayfinderShow5.url({ event: ticket.slug })" class="account-list-link">View event <UiIcon name="arrow-up-right" /></Link></article></section>
        <div v-if="!payments.data.length && !eventTickets.length" class="schedule-empty learner-index-empty"><span><UiIcon name="credit-card" /></span><h2>Your purchases will appear here.</h2><p>Course purchases and paid event tickets will include payment status and Stripe receipts.</p><Link :href="wayfinderCourses2().url">Explore courses <UiIcon name="arrow-up-right" /></Link></div>
        <nav v-if="payments.links.length > 3" class="account-pagination"><Link v-for="(link, index) in payments.links" :key="index" :href="link.url || '#'"><span v-html="link.label" /></Link></nav>
      </div>
    </main>
  </div>
</template>
<style scoped>.event-purchases{margin-top:34px}.event-purchases>h2{font:400 24px var(--serif);margin:8px 0 14px}.event-purchases .account-list-item{margin-bottom:9px}</style>
