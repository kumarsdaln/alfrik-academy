<script setup>
  import { Link, usePage } from '@inertiajs/vue3'
  import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue'

  import { index as home } from '../actions/App/Http/Controllers/HomeController'
  import {
    courses,
    howItWorks,
    mentors,
    stories,
    about,
    faq,
    contact,
  } from '../actions/App/Http/Controllers/PublicController'

  import { index as eventsIndex } from '../actions/App/Http/Controllers/WebinarEventController'
  import { index as insightsIndex } from '../actions/App/Http/Controllers/Insights/InsightController'
  import { index as careersIndex } from '../actions/App/Http/Controllers/Careers/JobController'
  import { index as reportsIndex } from '../actions/App/Http/Controllers/Insights/ReportController'
  import { index as surveysIndex } from '../actions/App/Http/Controllers/Insights/SurveyController'

  import { showLogin } from '../actions/App/Http/Controllers/AuthController'
  import { dashboard as learningDashboard } from '../actions/App/Http/Controllers/StudentLearningController'
  import { dashboard as staffDashboard } from '../actions/App/Http/Controllers/StaffController'

  const page = usePage()

  const path = computed(() => page.url.split('?')[0])
  const mobileMenuOpen = ref(false)

  const closeMobileMenu = () => {
    mobileMenuOpen.value = false
  }

  const syncMenuToViewport = () => {
    if (window.matchMedia('(min-width: 901px)').matches) {
      closeMobileMenu()
    }
  }

  watch(path, closeMobileMenu)

  onMounted(() => {
    window.addEventListener('resize', syncMenuToViewport, { passive: true })
  })

  onBeforeUnmount(() => {
    window.removeEventListener('resize', syncMenuToViewport)
  })

  const route = (action) => action().url

  const nav = [
    ['Courses', route(courses)],
    ['How it works', route(howItWorks)],
    ['Mentors', route(mentors)],
    ['Stories', route(stories)],
    ['Events', route(eventsIndex)],
    ['Insights', route(insightsIndex)],
    ['Careers', route(careersIndex)],
  ]

  const links = {
    home: route(home),
    courses: route(courses),
    mentors: route(mentors),
    stories: route(stories),
    events: route(eventsIndex),
    insights: route(insightsIndex),
    careers: route(careersIndex),
    about: route(about),
    faq: route(faq),
    contact: route(contact),
    login: route(showLogin),
    learning: route(learningDashboard),
    staff: route(staffDashboard),
  }

  const isAuthenticated = computed(() => Boolean(page.props.auth?.user))

  const accountUrl = computed(() =>
    isAuthenticated.value ? links.learning : links.login,
  )

  const accountLabel = computed(() =>
    isAuthenticated.value ? 'My learning' : 'Log in',
  )

  const isActive = (url) =>
    path.value === url || (url !== '/' && path.value.startsWith(`${url}/`))
</script>

<template>
  <div class="site-shell">
    <header class="topbar wrap public-topbar">
      <!-- Header brand -->
      <Link class="brand" :href="links.home" aria-label="Alfrik Academy home">
        <img src="/public/images/brand/logo.png" alt="" class="brand-logo" width="44" height="44" />
        <span class="brand-name">Alfrik Academy</span>
      </Link>

      <!-- Main navigation -->
      <nav id="public-navigation" class="main-nav" :class="{ 'is-open': mobileMenuOpen }" aria-label="Main navigation"
        :aria-hidden="mobileMenuOpen ? undefined : undefined" @keydown.esc.stop.prevent="closeMobileMenu">
        <Link v-for="item in nav" :key="item[1]" :href="item[1]" :class="{ active: isActive(item[1]) }"
          :aria-current="path === item[1] ? 'page' : undefined" @click="closeMobileMenu">
          {{ item[0] }}
        </Link>

        <div class="mobile-menu-actions">
          <Link :href="accountUrl" @click="closeMobileMenu">
            {{ accountLabel }}
          </Link>

          <Link :href="links.courses" class="button button-dark" @click="closeMobileMenu">
            Find your course
            <UiIcon name="arrow-up-right" :size="13" />
          </Link>
        </div>
      </nav>

      <!-- Desktop actions -->
      <div class="top-actions">
        <Link :href="accountUrl" class="sign-in">
          {{ accountLabel }}
        </Link>

        <Link :href="links.courses" class="button button-dark button-small">
          Find your course
          <span>
            <UiIcon name="arrow-up-right" class="ui-icon" :size="13" />
          </span>
        </Link>
      </div>

      <!-- Mobile navigation toggle -->
      <button class="mobile-nav-toggle" type="button" :aria-expanded="mobileMenuOpen" aria-controls="public-navigation"
        :aria-label="mobileMenuOpen ? 'Close navigation menu' : 'Open navigation menu'
          " @keydown.esc.stop.prevent="closeMobileMenu" @click="mobileMenuOpen = !mobileMenuOpen">
        <UiIcon :name="mobileMenuOpen ? 'close' : 'menu'" :size="19" />
      </button>
    </header>

    <div v-if="page.props.flash?.success" class="flash wrap" role="status">
      {{ page.props.flash.success }}
    </div>

    <slot />

    <!-- Footer -->
    <footer class="footer wrap public-footer">
      <Link class="brand" :href="links.home" aria-label="Alfrik Academy home">
        <img src="/public/images/brand/logo.png" alt="" class="brand-logo" width="36" height="36" />
        <span class="brand-name">Alfrik Academy</span>
      </Link>

      <span class="copyright">© 2026 Alfrik Academy</span>

      <nav class="footer-links" aria-label="Footer navigation">
        <Link :href="links.courses">Courses</Link>
        <Link :href="links.mentors">Mentors</Link>
        <Link :href="links.stories">Stories</Link>
        <Link :href="links.events">Webinars &amp; events</Link>
        <Link :href="links.insights">Insights</Link>
        <Link :href="surveysIndex().url">Surveys</Link>
        <Link :href="reportsIndex().url">Research reports</Link>
        <Link :href="links.careers">Careers</Link>
        <Link :href="links.about">About</Link>
        <Link :href="links.faq">FAQ</Link>
        <Link :href="links.contact">Contact</Link>
        <Link :href="links.staff">For our team</Link>
      </nav>

      <span class="footer-tagline">Made for curious minds</span>
    </footer>
  </div>
</template>

<style scoped>
  .public-topbar {
    position: relative;
    gap: clamp(14px, 2vw, 28px);
  }

  .public-topbar .brand {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    flex: none;
    color: var(--academy-ink);
    text-decoration: none;
  }

  .brand-logo {
    display: block;
    width: 44px;
    height: 44px;
    flex: none;
    object-fit: contain;
  }

  .brand-name {
    color: var(--academy-ink);
    font-size: 1.05rem;
    font-weight: 700;
    letter-spacing: -0.025em;
    line-height: 1.2;
    white-space: nowrap;
  }

  .brand:hover .brand-name {
    color: var(--academy-primary);
  }

  .public-topbar .main-nav {
    display: flex;
    flex: 1;
    justify-content: center;
    gap: clamp(12px, 1.8vw, 26px);
    margin: 0;
    white-space: nowrap;
  }

  .public-topbar .main-nav>a {
    color: var(--academy-muted);
    text-decoration: none;
    transition: color 150ms ease;
  }

  .public-topbar .main-nav>a:hover,
  .public-topbar .main-nav>a.active {
    color: var(--academy-primary);
  }

  .public-topbar .top-actions {
    display: flex;
    align-items: center;
    gap: 18px;
  }

  .sign-in {
    color: var(--academy-ink);
    text-decoration: none;
  }

  .sign-in:hover {
    color: var(--academy-primary);
  }

  .mobile-nav-toggle,
  .mobile-menu-actions {
    display: none;
  }

  .mobile-nav-toggle {
    place-items: center;
    width: 42px;
    height: 42px;
    flex: none;
    border: 1px solid var(--academy-border);
    border-radius: 4px;
    background: var(--academy-surface);
    color: var(--academy-ink);
    cursor: pointer;
  }

  .mobile-nav-toggle:focus-visible {
    outline: 3px solid var(--academy-focus);
    outline-offset: 2px;
  }

  @media (max-width: 1020px) {
    .public-topbar .main-nav {
      gap: 14px;
      font-size: 12px;
    }

    .public-topbar .top-actions {
      gap: 14px;
    }

    .public-topbar .top-actions .button {
      gap: 8px;
      padding: 10px 11px;
    }
  }

  @media (max-width: 900px) {
    .public-topbar {
      height: auto;
      min-height: 68px;
      flex-wrap: nowrap;
      padding-top: 9px;
      padding-bottom: 9px;
    }

    .public-topbar .main-nav:not(.is-open) {
      display: none;
    }

    .public-topbar .main-nav.is-open {
      position: absolute;
      z-index: 60;
      top: calc(100% - 1px);
      left: 16px;
      right: 16px;
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 4px;
      width: auto;
      padding: 12px;
      background: var(--academy-surface);
      border: 1px solid var(--academy-border);
      box-shadow: 0 16px 34px rgb(23 27 46 / 8%);
      white-space: normal;
    }

    .public-topbar .main-nav>a {
      display: flex;
      align-items: center;
      min-height: 42px;
      padding: 9px 11px;
      border-radius: 3px;
      color: var(--academy-muted);
      font-size: 13px;
    }

    .public-topbar .main-nav>a:hover,
    .public-topbar .main-nav>a.active {
      background: var(--academy-primary-soft);
      color: var(--academy-primary);
    }

    .mobile-nav-toggle {
      display: grid;
    }
  }

  @media (max-width: 600px) {
    .public-topbar {
      min-height: 64px;
    }

    .public-topbar .brand {
      gap: 7px;
    }

    .public-topbar .brand-logo {
      width: 36px;
      height: 36px;
    }

    .public-topbar .brand-name {
      font-size: 0.95rem;
    }

    .public-topbar .top-actions {
      display: none;
    }

    .public-topbar .mobile-nav-toggle {
      margin-left: auto;
    }

    .public-topbar .main-nav.is-open {
      left: 12px;
      right: 12px;
      grid-template-columns: 1fr;
      max-height: min(75vh, 560px);
      overflow-y: auto;
    }

    .mobile-menu-actions {
      display: grid;
      gap: 8px;
      padding: 10px 3px 2px;
      margin-top: 4px;
      border-top: 1px solid var(--academy-border);
    }

    .mobile-menu-actions>a:first-child {
      padding: 10px;
      color: var(--academy-primary);
      font-size: 13px;
      text-decoration: none;
    }

    .mobile-menu-actions .button {
      display: flex;
      align-items: center;
      justify-content: space-between;
      min-height: 44px;
      padding: 11px 14px;
    }
  }

  @media (prefers-reduced-motion: reduce) {
    .public-topbar .main-nav>a {
      transition: none;
    }
  }


  /* Alfrik Academy — Public Footer */

  .public-footer {
    display: grid;
    grid-template-columns: auto 1fr;
    align-items: center;
    gap: 24px 32px;
    padding-top: 32px;
    padding-bottom: 28px;
    border-top: 1px solid var(--academy-border, #E7E2E5);
  }

  .public-footer .brand {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    width: fit-content;
    color: var(--academy-ink, #171B2E);
    text-decoration: none;
  }

  .public-footer .brand-logo {
    display: block;
    width: 36px;
    height: 36px;
    flex: 0 0 36px;
    object-fit: contain;
  }

  .public-footer .brand-name {
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -0.3px;
  }

  .public-footer .copyright {
    justify-self: end;
    color: var(--academy-muted, #687080);
    font-size: 13px;
  }

  .public-footer .footer-links {
    grid-column: 1 / -1;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px 22px;
  }

  .public-footer .footer-links a {
    color: var(--academy-muted, #687080);
    font-size: 13px;
    line-height: 1.7;
    text-decoration: none;
    transition: color 160ms ease;
  }

  .public-footer .footer-links a:hover {
    color: var(--academy-primary, #B00050);
  }

  .public-footer .footer-links a:focus-visible,
  .public-footer .brand:focus-visible {
    outline: 2px solid var(--academy-primary, #B00050);
    outline-offset: 4px;
    border-radius: 3px;
  }

  .public-footer .footer-tagline {
    grid-column: 1 / -1;
    padding-top: 18px;
    border-top: 1px solid var(--academy-border, #E7E2E5);
    color: var(--academy-muted, #687080);
    font-size: 12px;
    letter-spacing: 0.2px;
  }

  /* Tablet */
  @media (max-width: 768px) {
    .public-footer {
      gap: 20px;
    }

    .public-footer .footer-links {
      gap: 10px 18px;
    }
  }

  /* Mobile */
  @media (max-width: 480px) {
    .public-footer {
      grid-template-columns: 1fr;
      gap: 18px;
      padding-top: 24px;
      padding-bottom: 22px;
    }

    .public-footer .brand {
      justify-self: start;
    }

    .public-footer .copyright {
      justify-self: start;
      font-size: 12px;
    }

    .public-footer .footer-links {
      gap: 10px 16px;
    }

    .public-footer .footer-links a {
      font-size: 13px;
    }

    .public-footer .footer-tagline {
      padding-top: 14px;
    }
  }
</style>