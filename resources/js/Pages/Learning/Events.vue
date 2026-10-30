<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import LearningSidebar from '../../Components/LearningSidebar.vue';
import { dashboard } from '../../actions/App/Http/Controllers/StudentLearningController';
import { index as publicEvents, show as eventShow } from '../../actions/App/Http/Controllers/WebinarEventController';

const props = defineProps({ events: { type: Array, default: () => [] } });
const upcoming = computed(() => props.events.filter((event) => !event.isPast));
const past = computed(() => props.events.filter((event) => event.isPast).reverse());

function dateLabel(event, options) {
  return new Intl.DateTimeFormat(undefined, { ...options, timeZone: event.timezone }).format(new Date(event.startsAt));
}

function price(event) {
  if (!event.amount) return 'Free';
  return new Intl.NumberFormat(undefined, { style: 'currency', currency: event.currency }).format(event.amount / 100);
}

function statusLabel(event) {
  if (event.registrationStatus === 'waitlisted') return 'Waitlisted';
  if (event.registrationStatus === 'cancelled') return 'Cancelled';
  if (event.paymentStatus === 'pending') return 'Payment pending';
  if (event.paymentStatus === 'expired') return 'Payment expired';
  if (event.paymentStatus === 'failed') return 'Payment failed';
  if (event.paymentStatus === 'refunded') return 'Refunded';
  if (event.paymentStatus === 'bypassed') return 'Development pass';
  if (event.registrationStatus === 'attended') return 'Attended';
  return 'Seat reserved';
}
</script>

<template>
  <div class="dashboard-shell">
    <LearningSidebar active="events" />
    <main class="dash-main">
      <header class="dash-top">
        <Link :href="dashboard().url"><UiIcon name="arrow-left" :size="13" /> Learning home</Link>
        <span>Your Alfrik account</span>
      </header>
      <div class="dash-content learner-events-content">
        <div class="learner-index-heading">
          <div>
            <div class="eyebrow">YOUR LIVE LEARNING</div>
            <h1>Events & webinars</h1>
            <p>Your reserved seats, upcoming live rooms, and event replays.</p>
          </div>
          <Link class="button button-dark" :href="publicEvents().url">Discover events <UiIcon name="arrow-up-right" :size="13" /></Link>
        </div>

        <section class="learner-events-section" aria-labelledby="upcoming-events-title">
          <div class="learner-events-section-heading">
            <div><span class="eyebrow">ON YOUR CALENDAR</span><h2 id="upcoming-events-title">Coming up</h2></div>
            <span class="learner-event-count">{{ upcoming.length }} {{ upcoming.length === 1 ? 'event' : 'events' }}</span>
          </div>
          <div v-if="upcoming.length" class="learner-event-grid">
            <article v-for="event in upcoming" :key="event.id" class="learner-event-card">
              <Link class="learner-event-image" :href="eventShow.url({ event: event.slug })">
                <img :src="event.cover || '/images/learning/live-class.png'" :alt="event.title" loading="lazy">
                <span>{{ event.type }}</span>
              </Link>
              <div class="learner-event-copy">
                <div class="learner-event-meta">
                  <span class="learner-event-date">{{ dateLabel(event, { weekday: 'short', month: 'short', day: 'numeric' }) }}</span><span class="learner-event-time">{{ dateLabel(event, { hour: 'numeric', minute: '2-digit' }) }}</span>
                  <span class="learner-event-status" :class="`status-${event.paymentStatus}`">{{ statusLabel(event) }}</span>
                </div>
                <h3><Link :href="eventShow.url({ event: event.slug })">{{ event.title }}</Link></h3>
                <p>{{ event.summary }}</p>
                <div class="learner-event-foot">
                  <span>{{ event.host }}</span>
                  <span>{{ event.duration }} min</span><span>{{ price(event) }}</span>
                </div>
                <div class="learner-event-actions">
                  <a v-if="event.meetingUrl" :href="event.meetingUrl" target="_blank" rel="noopener noreferrer" class="button button-dark">Join live <UiIcon name="arrow-up-right" :size="13" /></a>
                  <a v-else-if="event.checkoutUrl" :href="event.checkoutUrl" target="_blank" rel="noopener noreferrer" class="button button-dark">Finish payment <UiIcon name="arrow-up-right" :size="13" /></a>
                  <Link v-else :href="eventShow.url({ event: event.slug })" class="learner-event-detail">Event details <UiIcon name="arrow-up-right" :size="13" /></Link>
                  <span>{{ event.timezone }}</span>
                </div>
              </div>
            </article>
          </div>
          <div v-else class="learner-events-empty">
            <div class="learner-events-empty-copy"><span class="eyebrow">NO EVENTS RESERVED YET</span><h3>Make your next live moment count.</h3><p>Explore upcoming webinars, workshops, and community events. Once you register, your schedule, joining details, and replays will appear here.</p></div>
            <div class="learner-events-empty-action"><Link class="button button-dark" :href="publicEvents().url">Discover events <UiIcon name="arrow-up-right" :size="14" /></Link><span>Choose a session that fits your interests and schedule.</span></div>
          </div>
        </section>

        <section v-if="past.length" class="learner-events-section learner-past-events" aria-labelledby="past-events-title">
          <div class="learner-events-section-heading">
            <div><span class="eyebrow">KEEP THE IDEAS GOING</span><h2 id="past-events-title">Past events</h2></div>
            <span class="learner-event-count">{{ past.length }} {{ past.length === 1 ? 'record' : 'records' }}</span>
          </div>
          <article v-for="event in past" :key="event.id" class="learner-past-event">
            <span class="learner-past-label">PAST</span>
            <div><h3>{{ event.title }}</h3><p><span>{{ dateLabel(event, { month: 'short', day: 'numeric', year: 'numeric' }) }}</span><span>{{ event.host }}</span><span>{{ statusLabel(event) }}</span></p></div>
            <a v-if="event.replayUrl" :href="event.replayUrl" target="_blank" rel="noopener noreferrer">Watch replay <UiIcon name="arrow-up-right" :size="13" /></a>
            <Link v-else :href="eventShow.url({ event: event.slug })">Event details <UiIcon name="arrow-up-right" :size="13" /></Link>
          </article>
        </section>
      </div>
    </main>
  </div>
</template>

<style scoped>
.learner-events-content{max-width:1120px}
.learner-events-content .learner-index-heading{align-items:flex-end;margin-bottom:34px}
.learner-events-content .learner-index-heading h1{font:400 clamp(2.5rem,5vw,4rem)/1.04 var(--serif);letter-spacing:-.055em;margin:9px 0}
.learner-events-content .learner-index-heading p{font-size:13px;color:var(--academy-muted);line-height:1.6;margin:0}
.learner-events-content .button{min-height:43px;white-space:nowrap}
.learner-events-section{margin:28px 0 42px}
.learner-events-section-heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:15px}
.learner-events-section-heading h2{font:400 27px/1.15 var(--serif);letter-spacing:-.025em;margin:7px 0 0}
.learner-event-count{font-size:10px;color:var(--academy-muted);padding-bottom:3px}
.learner-event-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:15px}
.learner-event-card{min-width:0;overflow:hidden;background:var(--academy-surface);border:1px solid #e7e6df;border-radius:7px}
.learner-event-image{height:185px;display:block;position:relative;background:var(--academy-paper);overflow:hidden}
.learner-event-image img{width:100%;height:100%;object-fit:cover;transition:transform .25s ease}
.learner-event-image:hover img{transform:scale(1.025)}
.learner-event-image>span{position:absolute;left:12px;bottom:12px;background:var(--academy-surface);padding:7px 9px;border-radius:3px;color:var(--academy-secondary);font-size:9px;text-transform:capitalize}
.learner-event-copy{padding:16px}
.learner-event-meta{display:flex;align-items:center;justify-content:space-between;gap:9px;color:var(--academy-muted);font-size:9px;line-height:1.4}
.learner-event-status{flex:none;border-radius:20px;padding:5px 8px;background:var(--academy-success-surface);color:var(--academy-success);font-size:8px}
.learner-event-status.status-pending,.learner-event-status.status-expired,.learner-event-status.status-failed{background:var(--academy-warning-surface);color:var(--academy-warning)}
.learner-event-status.status-refunded,.learner-event-status.status-cancelled{background:var(--academy-danger-surface);color:var(--academy-danger)}
.learner-event-status.status-bypassed{background:var(--academy-paper);color:var(--academy-secondary)}
.learner-event-copy h3{font:400 22px/1.22 var(--serif);letter-spacing:-.02em;margin:12px 0 6px}
.learner-event-copy>p{min-height:36px;color:var(--academy-muted);font-size:11px;line-height:1.55;margin:0}
.learner-event-foot{display:flex;justify-content:space-between;gap:10px;margin-top:13px;padding-top:11px;border-top:1px solid #eeede8;color:var(--academy-muted);font-size:9px}
.learner-event-foot span{display:inline-flex;align-items:center;gap:5px;min-width:0}
.learner-event-actions{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:14px}
.learner-event-actions .button{min-height:38px;padding:9px 12px;font-size:10px}
.learner-event-actions>span{font-size:8px;color:var(--academy-muted)}
.learner-event-detail,.learner-past-event>a{display:inline-flex;align-items:center;gap:5px;color:var(--academy-primary);font-size:10px;font-weight:650}
.learner-events-empty{display:flex;align-items:center;gap:15px;padding:21px;background:var(--academy-surface);border:1px dashed #dcded5;border-radius:6px}
.learner-events-empty>span,.learner-past-icon{display:grid;place-items:center;width:40px;height:40px;flex:none;border-radius:50%;background:var(--academy-paper);color:var(--academy-secondary)}
.learner-events-empty>div{flex:1;min-width:0}
.learner-events-empty h3{font:400 20px var(--serif);margin:0 0 4px}
.learner-events-empty p{font-size:10px;line-height:1.5;color:var(--academy-muted);margin:0}
.learner-events-empty>a{display:inline-flex;align-items:center;gap:5px;flex:none;color:var(--academy-primary);font-size:10px;font-weight:650}
.learner-past-events{border-top:1px solid #e8e7df;padding-top:25px}
.learner-past-event{display:flex;align-items:center;gap:12px;padding:13px 0;border-bottom:1px solid #e9e8e1}
.learner-past-event>div{flex:1;min-width:0}
.learner-past-event h3{font:400 16px/1.3 var(--serif);margin:0 0 4px}
.learner-past-event p{font-size:9px;color:var(--academy-muted);margin:0}
@media(max-width:760px){.learner-event-grid{grid-template-columns:1fr}.learner-event-image{height:205px}}
@media(max-width:560px){.learner-events-content .learner-index-heading{align-items:flex-start;flex-direction:column;gap:15px;margin-bottom:25px}.learner-events-content .learner-index-heading h1{font-size:2.6rem}.learner-events-section{margin:24px 0 32px}.learner-events-section-heading h2{font-size:24px}.learner-event-copy{padding:14px}.learner-event-meta{align-items:flex-start;flex-direction:column}.learner-event-copy h3{font-size:20px}.learner-events-empty{align-items:flex-start;flex-wrap:wrap;padding:16px}.learner-events-empty>div{width:calc(100% - 55px)}.learner-events-empty>a{margin-left:55px}.learner-past-event{align-items:flex-start;flex-wrap:wrap}.learner-past-event>a{margin-left:52px}.learner-event-foot{flex-wrap:wrap}}

.learner-events-content { max-width:1120px; padding-top:42px; }
.learner-events-content .learner-index-heading { align-items:flex-end; margin-bottom:38px; }
.learner-events-content .learner-index-heading h1 { font-size:clamp(2.7rem,5.2vw,4.25rem); letter-spacing:-.055em; }
.learner-events-content .learner-index-heading p { max-width:600px; font-size:14px; }
.learner-events-content .learner-index-heading>.button { display:inline-flex; align-items:center; gap:14px; min-height:48px; padding:0 17px; border-radius:0; font-size:11px; }
.learner-events-section { margin:30px 0 42px; }
.learner-events-section-heading { align-items:end; margin-bottom:16px; }
.learner-events-section-heading h2 { font-size:30px; }
.learner-event-count { font-size:11px; }
.learner-event-grid { gap:18px; }
.learner-event-card { border:1px solid #e1dfd7; border-radius:0; }
.learner-event-image { height:auto; aspect-ratio:16/8.7; }
.learner-event-image>span { left:14px; bottom:14px; padding:8px 10px; border-radius:0; color:var(--academy-contrast); font-size:9px; font-weight:600; }
.learner-event-copy { padding:18px 19px 17px; }
.learner-event-meta { justify-content:flex-start; flex-wrap:wrap; gap:7px 14px; font-size:11px; }
.learner-event-date { color:var(--academy-primary); font-weight:600; }
.learner-event-status { margin-left:auto; padding:5px 8px; border-radius:0; font-size:9px; font-weight:600; }
.learner-event-copy h3 { margin:12px 0 7px; font-size:25px; line-height:1.18; }
.learner-event-copy>p { min-height:44px; font-size:13px; line-height:1.55; }
.learner-event-foot { justify-content:flex-start; flex-wrap:wrap; gap:7px 16px; margin-top:15px; padding-top:13px; font-size:11px; }
.learner-event-foot span { gap:0; }
.learner-event-actions { margin-top:15px; padding-top:13px; border-top:1px solid #eeede8; }
.learner-event-actions .button { display:inline-flex; align-items:center; gap:12px; min-height:42px; padding:0 14px; border-radius:0; font-size:11px; }
.learner-event-actions>span { font-size:10px; }
.learner-event-detail,.learner-past-event>a { font-size:11px; }
.learner-events-empty { display:grid; grid-template-columns:minmax(0,1fr) minmax(250px,.64fr); align-items:center; gap:38px; padding:28px 30px; border:0; border-left:3px solid var(--academy-primary); border-radius:0; background:var(--academy-paper); }
.learner-events-empty-copy .eyebrow { color:var(--academy-secondary); font-size:9px; letter-spacing:.8px; }
.learner-events-empty h3 { margin:9px 0 7px; font-size:28px; line-height:1.18; }
.learner-events-empty p { max-width:620px; color:var(--academy-muted); font-size:13px; line-height:1.65; }
.learner-events-empty-action { display:grid; justify-items:end; gap:10px; text-align:right; }
.learner-events-empty-action .button { display:inline-flex; align-items:center; gap:12px; min-height:44px; padding:0 15px; border-radius:0; font-size:11px; }
.learner-events-empty-action>span { color:var(--academy-muted); font-size:10px; line-height:1.5; }
.learner-past-events { padding-top:27px; }
.learner-past-event { gap:15px; padding:15px 0; }
.learner-past-label { width:40px; flex:none; color:var(--academy-muted); font-size:8px; font-weight:700; letter-spacing:.7px; }
.learner-past-event h3 { font-size:19px; }
.learner-past-event p { display:flex; flex-wrap:wrap; gap:5px 14px; font-size:10px; }
.learner-past-event>a { min-height:36px; padding:0 10px; border:1px solid #dce2d7; color:var(--academy-primary); text-decoration:none; }
.learner-past-event>a:hover { background:var(--academy-primary-soft); border-color:var(--academy-primary); color:var(--academy-primary); }
html.theme-dark .learner-event-card { border-color:var(--academy-border); background:var(--academy-surface); }
html.theme-dark .learner-event-copy h3,html.theme-dark .learner-events-empty h3,html.theme-dark .learner-past-event h3 { color:var(--academy-ink); }
html.theme-dark .learner-event-copy>p,html.theme-dark .learner-event-foot,html.theme-dark .learner-event-meta,html.theme-dark .learner-event-actions>span,html.theme-dark .learner-past-event p { color:var(--academy-muted); }
html.theme-dark .learner-event-date { color:var(--academy-contrast); }
html.theme-dark .learner-events-empty { background:var(--academy-paper); border-color:var(--academy-secondary); }
html.theme-dark .learner-events-empty p,html.theme-dark .learner-events-empty-action>span { color:var(--academy-muted); }
html.theme-dark .learner-events-empty-copy .eyebrow { color:var(--academy-muted); }
html.theme-dark .learner-past-events,html.theme-dark .learner-event-foot,html.theme-dark .learner-event-actions,html.theme-dark .learner-past-event { border-color:var(--academy-border); }
html.theme-dark .learner-past-event>a { border-color:var(--academy-primary); color:var(--academy-contrast); }
@media(max-width:760px) { .learner-event-grid { grid-template-columns:1fr; } .learner-event-image { aspect-ratio:16/8.5; } }
@media(max-width:560px) {
  .learner-events-content { padding-top:27px; }
  .learner-events-content .learner-index-heading { gap:16px; margin-bottom:28px; }
  .learner-events-content .learner-index-heading h1 { font-size:2.55rem; }
  .learner-events-content .learner-index-heading p { font-size:12px; }
  .learner-events-section { margin:25px 0 32px; }
  .learner-events-section-heading h2 { font-size:25px; }
  .learner-event-image { aspect-ratio:16/9; }
  .learner-event-copy { padding:15px; }
  .learner-event-meta { align-items:center; font-size:10px; }
  .learner-event-copy h3 { font-size:22px; }
  .learner-event-copy>p { min-height:0; font-size:12px; }
  .learner-events-empty { grid-template-columns:1fr; gap:18px; padding:20px; }
  .learner-events-empty-action { justify-items:start; text-align:left; }
  .learner-events-empty h3 { font-size:24px; }
  .learner-events-empty p { font-size:12px; }
  .learner-past-event { align-items:flex-start; flex-wrap:wrap; }
  .learner-past-label { padding-top:4px; }
  .learner-past-event>div { flex:1 1 calc(100% - 60px); }
  .learner-past-event>a { margin-left:55px; }
}
</style>
