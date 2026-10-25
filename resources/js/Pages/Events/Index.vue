<script setup>
import { courses as wayfinderCourses1 } from './../../actions/App/Http/Controllers/PublicController';
import { show as wayfinderShow2 } from './../../actions/App/Http/Controllers/WebinarEventController';
import { insights as wayfinderInsights3 } from './../../actions/App/Http/Controllers/DiscoveryController';

import { InfiniteScroll, Link } from '@inertiajs/vue3';
import PublicLayout from '../../Layouts/PublicLayout.vue';

defineProps({ upcoming: Object, upcomingCount: Number, past: Array });
const dateParts = (value, timezone) => new Intl.DateTimeFormat(undefined, { timeZone: timezone, weekday: 'short', month: 'short', day: 'numeric' }).format(new Date(value));
const timeParts = (value, timezone) => new Intl.DateTimeFormat(undefined, { timeZone: timezone, hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }).format(new Date(value));
</script>

<template>
  <PublicLayout>
    <main class="events-page">
      <section class="events-hero wrap"><div><span class="eyebrow">LEARN TOGETHER, LIVE</span><h1>Good questions.<br><em>Good company.</em></h1><p>Join a Kanram webinar, meet generous practitioners, and leave with ideas you can put to work right away.</p><Link :href="wayfinderCourses1().url" class="events-hero-link">Explore live cohort programs <UiIcon name="arrow-up-right" :size="14"/></Link></div><div class="events-hero-art"><img :src="'/images/learning/live-class.png'" alt="A mentor leading an online class"><span><UiIcon name="calendar" :size="15"/> OPEN ROOMS FOR CURIOUS MINDS</span></div></section>

      <section class="events-section wrap"><header class="events-section-heading"><div><span class="eyebrow">SAVE YOUR SEAT</span><h2>Coming up live</h2></div><span>{{ upcomingCount }} upcoming {{ upcomingCount === 1 ? 'event' : 'events' }}</span></header>
        <div v-if="upcoming.data.length"><InfiniteScroll data="upcoming" :buffer="450" :manual-after="4" class="event-card-grid"><article v-for="event in upcoming.data" :key="event.id" class="event-card"><Link :href="wayfinderShow2.url({ event: event.slug })" class="event-card-image"><img :src="event.cover_image || '/images/learning/live-class.png'" :alt="event.title"><span>{{ event.event_type.replace('_', ' ') }}</span><span class="event-price">{{ event.price_minor > 0 ? new Intl.NumberFormat(undefined,{style:'currency',currency:event.currency.toUpperCase()}).format(event.price_minor/100) : 'Free' }}</span></Link><div class="event-card-copy"><div class="event-meta"><span>{{ dateParts(event.starts_at, event.timezone) }} <i aria-hidden="true">·</i> {{ timeParts(event.starts_at, event.timezone) }}</span><span>{{ event.duration_minutes }} min</span></div><h3><Link :href="wayfinderShow2.url({ event: event.slug })">{{ event.title }}</Link></h3><p>{{ event.summary }}</p><div class="event-host"><span class="event-host-mark">{{ event.host_name.split(' ').map(part => part[0]).slice(0,2).join('') }}</span><span><small>HOSTED BY</small><b>{{ event.host_name }}</b></span><Link :href="wayfinderShow2.url({ event: event.slug })">Details <UiIcon name="arrow-up-right" :size="12"/></Link></div></div></article>
          <template #next="{ loading, manualMode, hasMore, fetch }">
            <div v-if="loading || (manualMode && hasMore)" class="event-load-more" aria-live="polite">
              <button v-if="manualMode && hasMore" type="button" :disabled="loading" @click="fetch">{{ loading ? 'Loading events…' : 'Load more events' }}</button>
              <span v-else-if="loading">Loading more events…</span>
            </div>
          </template>
        </InfiniteScroll></div>
        <div v-else class="events-empty"><UiIcon name="calendar" :size="22"/><h3>We’re planning the next one.</h3><p>Check back soon for live conversations, workshops, and open classes.</p><Link :href="wayfinderInsights3().url">Read the latest from Kanram <UiIcon name="arrow-up-right" :size="13"/></Link></div>
      </section>

      <section v-if="past.length" class="events-past"><div class="wrap"><header class="events-section-heading"><div><span class="eyebrow">FROM THE ARCHIVE</span><h2>Good conversations live on.</h2></div></header><div class="past-event-list"><Link v-for="event in past" :key="event.id" :href="wayfinderShow2.url({ event: event.slug })" class="past-event-row"><span>{{ dateParts(event.starts_at, event.timezone) }}</span><b>{{ event.title }}</b><small>{{ event.host_name }} · {{ event.duration_minutes }} minutes</small><UiIcon name="arrow-up-right" :size="14"/></Link></div></div></section>
      <section class="events-cta wrap"><div><span class="eyebrow">A SMALLER ROOM, A BIGGER NEXT STEP</span><h2>Keep learning<br><em>with people.</em></h2></div><Link class="button button-dark" :href="wayfinderCourses1().url">Explore live courses <UiIcon name="arrow-up-right" :size="13"/></Link></section>
    </main>
  </PublicLayout>
</template>

<style scoped>
.events-page{background:#fbfaf7;min-height:75vh;color:#30382f}.events-hero{padding-top:66px;padding-bottom:60px;display:grid;grid-template-columns:1fr .9fr;gap:70px;align-items:center}.events-hero h1{font:400 clamp(3.5rem,7vw,6rem)/.96 var(--serif);letter-spacing:-.065em;margin:18px 0}.events-hero h1 em,.events-cta h2 em{color:#718065}.events-hero p{max-width:520px;color:#70776d;line-height:1.8;font-size:15px}.events-hero-link{display:inline-flex;align-items:center;gap:8px;color:#4f6348;font-size:12px;font-weight:650;margin-top:15px}.events-hero-art{height:350px;position:relative;overflow:hidden;background:#e4e7df}.events-hero-art img{width:100%;height:100%;object-fit:cover}.events-hero-art>span{position:absolute;bottom:15px;left:15px;background:#fbfaf7;padding:10px 12px;display:flex;align-items:center;gap:8px;font-size:9px;letter-spacing:.1em;color:#50614a}.events-section{padding-top:28px;padding-bottom:82px}.events-section-heading{display:flex;justify-content:space-between;align-items:end;margin-bottom:24px}.events-section-heading h2{font:400 clamp(2rem,4vw,3rem)/1.1 var(--serif);letter-spacing:-.04em;margin:10px 0 0}.events-section-heading>span{font-size:11px;color:#7b8177}:deep(.event-card-grid){display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:17px}.event-card{border:1px solid #e6e5dd;background:white;min-width:0}.event-card-image{display:block;position:relative;aspect-ratio:1.55/1;overflow:hidden;background:#e5e8e0}.event-card-image img{width:100%;height:100%;object-fit:cover;transition:transform .35s}.event-card:hover .event-card-image img{transform:scale(1.035)}.event-card-image>span{position:absolute;left:12px;top:12px;padding:7px 9px;background:#fff;font-size:8px;letter-spacing:.12em;color:#506048}.event-card-copy{padding:17px 17px 14px}.event-meta{display:flex;justify-content:space-between;gap:12px;color:#70786c;font-size:10px}.event-meta span{display:flex;align-items:center;gap:5px}.event-card h3{font:400 22px/1.16 var(--serif);letter-spacing:-.025em;margin:14px 0 8px}.event-card p{min-height:48px;color:#727970;font-size:11px;line-height:1.65;margin:0}.event-host{display:flex;align-items:center;gap:9px;border-top:1px solid #eeede8;padding-top:12px;margin-top:14px}.event-host-mark{width:32px;height:32px;border-radius:50%;display:grid;place-items:center;background:#ebeee7;color:#56644f;font-size:9px}.event-host>span:nth-child(2){display:grid;gap:3px;flex:1}.event-host small{font-size:7px;color:#858b80;letter-spacing:.1em}.event-host b{font-size:10px}.event-host>a{display:flex;align-items:center;gap:4px;color:#53644a;font-size:9px}.events-empty{border:1px dashed #d9ddd4;padding:50px 20px;text-align:center;color:#687460}.events-empty h3{font:400 25px var(--serif);margin:12px 0 6px;color:#344033}.events-empty p{font-size:12px;color:#777d73}.events-empty>a{display:inline-flex;align-items:center;gap:7px;font-size:11px;color:#53644a;margin-top:10px}.events-past{padding:58px 0 65px;background:#f0f1eb}.past-event-list{border-top:1px solid #dce0d7}.past-event-row{display:grid;grid-template-columns:130px 1fr 240px 18px;align-items:center;gap:20px;padding:16px 4px;border-bottom:1px solid #dce0d7}.past-event-row>span,.past-event-row small{font-size:10px;color:#73796f}.past-event-row>b{font:400 18px var(--serif)}.past-event-row>svg{color:#65745d}.events-cta{display:flex;align-items:center;justify-content:space-between;padding-top:70px;padding-bottom:75px}.events-cta h2{font:400 clamp(2.6rem,5vw,4.5rem)/.98 var(--serif);letter-spacing:-.05em;margin:14px 0 0}
.event-card-image>span:not(.event-price){min-height:38px;display:inline-flex;align-items:center;padding:9px 11px;font-size:10px;font-weight:650;letter-spacing:.08em;text-transform:capitalize}.event-card-image>.event-price{left:auto;right:12px;min-height:38px;display:inline-flex;align-items:center;justify-content:center;padding:9px 12px;background:#fff;color:#344331;font-size:14px;font-weight:750;letter-spacing:-.02em;box-shadow:0 3px 14px #2028201c}
@media(max-width:800px){.events-hero{grid-template-columns:1fr;gap:28px;padding-top:48px}.events-hero-art{height:300px}:deep(.event-card-grid){grid-template-columns:repeat(2,minmax(0,1fr))}.past-event-row{grid-template-columns:100px 1fr 18px}.past-event-row small{display:none}}
@media(max-width:560px){.events-hero{padding-top:36px}.events-hero h1{font-size:3.6rem}:deep(.event-card-grid){grid-template-columns:1fr}.event-card-image{aspect-ratio:1.8/1}.events-section{padding-bottom:58px}.events-section-heading{align-items:flex-start;gap:12px;flex-direction:column}.past-event-row{grid-template-columns:82px 1fr 16px;gap:10px}.past-event-row>b{font-size:15px}.events-cta{align-items:flex-start;flex-direction:column;gap:20px;padding-top:55px;padding-bottom:60px}}
/* Event discovery cards: surface start time and keep card actions aligned. */
:deep(.event-card-grid) { grid-auto-rows:1fr; align-items:stretch; }
.event-card { display:flex; flex-direction:column; }
.event-card-copy { display:flex; flex:1; flex-direction:column; min-width:0; }
.event-meta { display:grid; grid-template-columns:minmax(0,1fr) auto; align-items:start; gap:10px; color:#687267; font-size:10px; line-height:1.45; }
.event-meta span:first-child { min-width:0; }
.event-meta i { color:#a4aa9e; font-style:normal; padding-inline:3px; }
.event-meta span:last-child { white-space:nowrap; }
.event-card h3 { display:-webkit-box; min-height:2.32em; overflow:hidden; -webkit-box-orient:vertical; -webkit-line-clamp:2; }
.event-card p { display:-webkit-box; min-height:4.95em; overflow:hidden; -webkit-box-orient:vertical; -webkit-line-clamp:3; }
.event-host { margin-top:auto; }
.event-host > a { min-height:34px; justify-content:space-between; gap:12px; padding:0 9px; border:1px solid #dfe3da; font-size:10px; font-weight:650; white-space:nowrap; }
.event-host > a:hover { border-color:#9baa91; background:#f5f7f2; }
.event-card:focus-within { outline:2px solid #74866c; outline-offset:3px; }
@media(max-width:800px) {
  :deep(.event-card-grid) { grid-auto-rows:auto; }
  .event-card h3 { min-height:0; }
}
@media(max-width:560px) {
  .events-section { padding-top:20px; }
  .events-section-heading { flex-direction:row; align-items:flex-end; justify-content:space-between; }
  .events-section-heading h2 { font-size:30px; }
  .events-section-heading > span { flex:none; padding-bottom:3px; font-size:10px; }
  .event-card-image { aspect-ratio:1.95/1; }
  .event-card-copy { padding:15px 15px 13px; }
  .event-meta { font-size:10px; }
  .event-card h3 { margin:11px 0 7px; font-size:21px; }
  .event-card p { min-height:0; }
}
</style>
