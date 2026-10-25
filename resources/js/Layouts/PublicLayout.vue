<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { home, courses, howItWorks, mentors, stories, about, faq, contact } from '../actions/App/Http/Controllers/PublicController';
import { index as eventsIndex } from '../actions/App/Http/Controllers/WebinarEventController';
import { insights as insightsIndex, jobs as careersIndex } from '../actions/App/Http/Controllers/DiscoveryController';
import { reports as reportsIndex, surveys as surveysIndex } from '../actions/App/Http/Controllers/DiscoveryController';
import { showLogin } from '../actions/App/Http/Controllers/AuthController';
import { dashboard as learningDashboard } from '../actions/App/Http/Controllers/StudentLearningController';
import { dashboard as staffDashboard } from '../actions/App/Http/Controllers/StaffController';
const page = usePage();
const path = computed(() => page.url.split('?')[0]);
const mobileMenuOpen = ref(false);
const closeMobileMenu = () => { mobileMenuOpen.value = false; };
const syncMenuToViewport = () => { if (window.matchMedia('(min-width: 901px)').matches) closeMobileMenu(); };
watch(path, closeMobileMenu);
onMounted(() => window.addEventListener('resize', syncMenuToViewport, { passive: true }));
onBeforeUnmount(() => window.removeEventListener('resize', syncMenuToViewport));
const route = (action) => action().url;
const nav = [
  ['Courses', route(courses)], ['How it works', route(howItWorks)], ['Mentors', route(mentors)],
  ['Stories', route(stories)], ['Events', route(eventsIndex)], ['Insights', route(insightsIndex)], ['Careers', route(careersIndex)],
];
const links = { home: route(home), courses: route(courses), mentors: route(mentors), stories: route(stories), events: route(eventsIndex), insights: route(insightsIndex), careers: route(careersIndex), about: route(about), faq: route(faq), contact: route(contact), login: route(showLogin), learning: route(learningDashboard), staff: route(staffDashboard) };
</script>
<template>
  <div class="site-shell">
    <header class="topbar wrap public-topbar">
      <Link class="brand" :href="links.home"><BrandMark class="brand-mark" /><span>Kanram Academy</span></Link>
      <nav id="public-navigation" class="main-nav" :class="{ 'is-open': mobileMenuOpen }" aria-label="Main navigation" @keydown.esc.stop.prevent="closeMobileMenu">
        <Link v-for="item in nav" :key="item[1]" :href="item[1]" :class="{active:path===item[1] || path.startsWith(item[1] + '/')}" @click="closeMobileMenu">{{ item[0] }}</Link>
        <div class="mobile-menu-actions">
          <Link :href="page.props.auth?.user ? links.learning : links.login" @click="closeMobileMenu">{{ page.props.auth?.user ? 'My learning' : 'Log in' }}</Link>
          <Link :href="links.courses" class="button button-dark" @click="closeMobileMenu">Find your course <UiIcon name="arrow-up-right" :size="13" /></Link>
        </div>
      </nav>
      <div class="top-actions"><Link v-if="!page.props.auth?.user" :href="links.login" class="sign-in">Log in</Link><Link v-else :href="links.learning" class="sign-in">My learning</Link><Link :href="links.courses" class="button button-dark button-small">Find your course <span><UiIcon name="arrow-up-right" class="ui-icon" :size="13" /></span></Link></div>
      <button class="mobile-nav-toggle" type="button" :aria-expanded="mobileMenuOpen" aria-controls="public-navigation" :aria-label="mobileMenuOpen ? 'Close navigation menu' : 'Open navigation menu'" @keydown.esc.stop.prevent="closeMobileMenu" @click="mobileMenuOpen = !mobileMenuOpen"><UiIcon :name="mobileMenuOpen ? 'close' : 'menu'" :size="19" /></button>
    </header>
    <div v-if="page.props.flash?.success" class="flash wrap" role="status">{{ page.props.flash.success }}</div>
    <slot />
    <footer class="footer wrap public-footer"><Link class="brand" :href="links.home"><BrandMark class="brand-mark" /><span>Kanram Academy</span></Link><span>© 2026 Kanram Academy</span><div><Link :href="links.courses">Courses</Link><Link :href="links.mentors">Mentors</Link><Link :href="links.stories">Stories</Link><Link :href="links.events">Webinars & events</Link><Link :href="links.insights">Insights</Link><Link :href="surveysIndex().url">Surveys</Link><Link :href="reportsIndex().url">Research reports</Link><Link :href="links.careers">Careers</Link><Link :href="links.about">About</Link><Link :href="links.faq">FAQ</Link><Link :href="links.contact">Contact</Link><Link :href="links.staff">For our team</Link></div><span>Made for curious minds <b><UiIcon name="sparkles" class="ui-icon" /></b></span></footer>
  </div>
</template>

<style scoped>
.public-topbar{position:relative;gap:clamp(14px,2vw,28px)}
.public-topbar .brand{flex:none}
.public-topbar .main-nav{flex:1;justify-content:center;gap:clamp(12px,1.8vw,26px);margin:0;white-space:nowrap}
.mobile-nav-toggle,.mobile-menu-actions{display:none}
@media(max-width:1020px){.public-topbar .main-nav{gap:14px;font-size:12px}.public-topbar .top-actions{gap:14px}.public-topbar .top-actions .button{padding:10px 11px;gap:8px}}
@media(max-width:900px){.public-topbar{height:auto;min-height:68px;flex-wrap:nowrap;padding-top:9px;padding-bottom:9px}.public-topbar .main-nav:not(.is-open){display:none}.public-topbar .main-nav.is-open{position:absolute;z-index:60;top:calc(100% - 1px);left:16px;right:16px;width:auto;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:4px;padding:12px;background:#fbfaf7;border:1px solid #e5e5dd;box-shadow:0 16px 34px #22251d18;white-space:normal}.public-topbar .main-nav>a{display:flex;align-items:center;min-height:42px;padding:9px 11px;border-radius:3px;color:#586052;font-size:13px}.public-topbar .main-nav>a:hover,.public-topbar .main-nav>a.active{background:#eef0e9;color:#35442f}.mobile-nav-toggle{display:grid;place-items:center;width:42px;height:42px;flex:none;border:1px solid #e2e3db;border-radius:4px;background:#fff;color:#35442f;cursor:pointer}.mobile-nav-toggle:focus-visible{outline:3px solid #73856b66;outline-offset:2px}}
@media(max-width:600px){.public-topbar{min-height:64px}.public-topbar .brand{font-size:15px;gap:7px}.public-topbar .brand-mark{width:29px;height:29px}.public-topbar .top-actions{display:none}.public-topbar .mobile-nav-toggle{margin-left:auto}.public-topbar .main-nav.is-open{left:12px;right:12px;grid-template-columns:1fr;max-height:min(75vh,560px);overflow-y:auto}.mobile-menu-actions{display:grid;gap:8px;padding:10px 3px 2px;border-top:1px solid #e5e5dd;margin-top:4px}.mobile-menu-actions>a:first-child{padding:10px;color:#465440;font-size:13px}.mobile-menu-actions .button{min-height:44px;justify-content:space-between;padding:11px 14px}}
@media(prefers-reduced-motion:reduce){.mobile-nav-toggle{transition:none}}
</style>
