<script setup>
  import { insights as wayfinderInsights, insight as wayfinderInsight } from './../../actions/App/Http/Controllers/DiscoveryController';
  import { reports as reportsRoute, surveys as surveysRoute } from './../../actions/App/Http/Controllers/DiscoveryController';
  import { router, Link } from '@inertiajs/vue3';
  import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
  import PublicLayout from '../../Layouts/PublicLayout.vue';

  const props = defineProps({ insights: Object, filters: Object, subjects: Array });
  const q = ref(props.filters.q || '');
  const type = ref(props.filters.type || '');
  const category = ref(props.filters.category || '');
  const subjectTrack = ref(null);
  const subjectCanScroll = ref(false);
  const subjectAtStart = ref(true);
  const subjectAtEnd = ref(true);
  const featured = computed(() => props.insights.data[0] || null);
  const latest = computed(() => props.insights.data.slice(1));
  const categories = [
    { label: 'All stories', value: '' },
    { label: 'Articles & guides', value: 'article' },
    { label: 'News & updates', value: 'news' },
    { label: 'Events', value: 'event' },
    { label: 'Surveys', value: 'survey' },
    { label: 'Reports', value: 'report' },
  ];
  let debounce;

  watch([q, type, category], () => {
    clearTimeout(debounce);
    debounce = setTimeout(() => router.get(wayfinderInsights().url, { q: q.value, type: type.value, category: category.value }, { preserveState: true, preserveScroll: true, replace: true }), 250);
  });
  function updateSubjectScroll() {
    const track = subjectTrack.value;
    if (!track) return;
    subjectCanScroll.value = track.scrollWidth > track.clientWidth + 1;
    subjectAtStart.value = track.scrollLeft <= 1;
    subjectAtEnd.value = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
  }
  function scrollSubjects(direction) {
    const track = subjectTrack.value;
    if (!track) return;
    track.scrollBy({ left: direction * Math.max(180, track.clientWidth * 0.7), behavior: 'smooth' });
  }
  function resizeSubjectTrack() { updateSubjectScroll(); }
  onMounted(async () => {
    await nextTick();
    updateSubjectScroll();
    await nextTick();
    updateSubjectScroll();
    window.addEventListener('resize', resizeSubjectTrack, { passive: true });
  });
  watch(() => props.subjects, async () => { await nextTick(); updateSubjectScroll(); }, { deep: true });
  watch(subjectCanScroll, async () => { await nextTick(); updateSubjectScroll(); });
  onBeforeUnmount(() => {
    clearTimeout(debounce);
    window.removeEventListener('resize', resizeSubjectTrack);
  });

  function dateLabel(date, options = { month: 'short', day: 'numeric', year: 'numeric' }) {
    return date ? new Date(date).toLocaleDateString(undefined, options) : 'Recently';
  }
</script>

<template>
  <PublicLayout>
    <main class="journal-page">
      <header class="journal-masthead wrap">
        <div class="journal-kicker">THE KANRAM JOURNAL <span class="journal-kicker-divider">/</span> IDEAS, KNOWLEDGE &
          UPDATES</div>
        <div class="journal-title-row">
          <div>
            <h1>Curiosity has <em>no boundaries.</em></h1>
            <p>A place for useful knowledge, thoughtful perspectives, and the latest updates from across the worlds we
              live and work in.</p>
          </div>
          <div class="journal-note"><span>Learn something<br>worth sharing.</span></div>
        </div>
        <div class="journal-toolbar">
          <nav class="journal-topics" aria-label="Filter journal stories">
            <button v-for="category in categories" :key="category.value" type="button"
              :class="{ active: type === category.value }" @click="type = category.value">{{ category.label }}</button>
          </nav>
          <label class="journal-search">
            <UiIcon name="search" :size="16" /><input v-model="q" type="search" placeholder="Search the journal"
              aria-label="Search journal stories"><kbd>⌕</kbd>
          </label>
        </div>
        <nav class="journal-collection-links" aria-label="Browse special collections"><span>EXPLORE</span>
          <Link :href="surveysRoute().url">Community surveys
            <UiIcon name="arrow-up-right" :size="12" />
          </Link>
          <Link :href="reportsRoute().url">Research reports
            <UiIcon name="arrow-up-right" :size="12" />
          </Link>
        </nav>
        <nav v-if="subjects?.length" class="journal-subjects" aria-label="Explore stories by subject">
          <span>EXPLORE SUBJECTS</span>
          <button v-if="subjectCanScroll" class="journal-subject-arrow" type="button" aria-label="Scroll subjects left"
            :disabled="subjectAtStart" @click="scrollSubjects(-1)">
            <UiIcon name="chevron-left" :size="15" />
          </button>
          <div ref="subjectTrack" class="journal-subject-track" role="group" aria-label="Choose a subject" tabindex="0"
            @scroll.passive="updateSubjectScroll">
            <button type="button" :class="{ active: !category }" @click="category = ''">All subjects</button>
            <button v-for="subject in subjects" :key="subject" type="button" :class="{ active: category === subject }"
              @click="category = subject">{{ subject }}</button>
          </div>
          <button v-if="subjectCanScroll" class="journal-subject-arrow" type="button" aria-label="Scroll subjects right"
            :disabled="subjectAtEnd" @click="scrollSubjects(1)">
            <UiIcon name="chevron-right" :size="15" />
          </button>
        </nav>
      </header>

      <section class="journal-content wrap" aria-live="polite">
        <template v-if="featured">
          <div class="journal-section-heading">
            <div><span class="journal-section-label">WHAT’S HAPPENING & WHAT’S WORTH KNOWING</span><span
                class="journal-rule"></span></div><span>{{ insights.total }} stories</span>
          </div>

          <article class="journal-feature">
            <Link class="journal-feature-image" :href="wayfinderInsight.url({ slug: featured.slug })">
              <img v-if="featured.cover_image" :src="featured.cover_image" :alt="featured.title">
              <div v-else class="journal-image-placeholder">
                <UiIcon name="book-open" :size="36" />
              </div>
              <span class="journal-image-label">{{ featured.category || featured.type }}</span>
            </Link>
            <div class="journal-feature-copy">
              <div class="journal-story-meta"><span>{{ featured.type }}</span><i></i><span>{{
                dateLabel(featured.published_at) }}</span></div>
              <h2>
                <Link :href="wayfinderInsight.url({ slug: featured.slug })">{{ featured.title }}</Link>
              </h2>
              <p>{{ featured.excerpt }}</p>
              <div class="journal-feature-footer">
                <div class="journal-author-mark">{{ (featured.author?.name || 'K').slice(0, 1) }}</div>
                <div class="journal-author"><b>{{ featured.author?.name || 'Kanram Academy' }}</b><span>{{
                  featured.reading_minutes }} min read</span></div>
                <Link class="journal-read-link" :href="wayfinderInsight.url({ slug: featured.slug })">Read story
                  <UiIcon name="arrow-up-right" :size="15" />
                </Link>
              </div>
            </div>
          </article>

          <section v-if="latest.length" class="journal-latest">
            <div class="journal-latest-heading">
              <div><span class="journal-section-label">MORE TO EXPLORE</span><span class="journal-rule"></span></div>
              <span>Ideas from every field.</span>
            </div>
            <div class="journal-grid">
              <article v-for="item in latest" :key="item.id" class="journal-card">
                <Link class="journal-card-image" :href="wayfinderInsight.url({ slug: item.slug })">
                  <img v-if="item.cover_image" :src="item.cover_image" :alt="item.title" loading="lazy">
                  <div v-else class="journal-image-placeholder">
                    <UiIcon name="book-open" :size="24" />
                  </div>
                  <span class="journal-card-category">{{ item.category || item.type }}</span>
                </Link>
                <div class="journal-card-copy">
                  <div class="journal-story-meta"><span>{{ dateLabel(item.published_at, {
                    month: 'short', day: 'numeric'
                      }) }}</span><i></i><span>{{ item.reading_minutes }} min</span></div>
                  <h3>
                    <Link :href="wayfinderInsight.url({ slug: item.slug })">{{ item.title }}</Link>
                  </h3>
                  <p>{{ item.excerpt }}</p>
                  <Link class="journal-card-link" :href="wayfinderInsight.url({ slug: item.slug })">Read more
                    <UiIcon name="arrow-right" :size="14" />
                  </Link>
                </div>
              </article>
            </div>
          </section>

          <nav v-if="insights.last_page > 1" class="journal-pagination" aria-label="Journal pagination">
            <span>Page {{ insights.current_page }} of {{ insights.last_page }}</span>
            <div>
              <Link v-if="insights.prev_page_url"
                :href="wayfinderInsights.url({ mergeQuery: { page: insights.current_page - 1 } })">← Newer stories
              </Link>
              <Link v-if="insights.next_page_url"
                :href="wayfinderInsights.url({ mergeQuery: { page: insights.current_page + 1 } })">More stories →</Link>
            </div>
          </nav>
        </template>

        <div v-else class="journal-empty"><span class="journal-empty-icon">
            <UiIcon name="search" :size="22" />
          </span><span class="journal-section-label">NOTHING HERE JUST YET</span>
          <h2>No stories found.</h2>
          <p>Try another search or topic. There’s always more to learn about the world around us.</p><button
            type="button" @click="q = ''; type = ''; category = ''">Clear filters</button>
        </div>
      </section>
      <section class="journal-signoff">
        <div class="wrap"><span>KNOWLEDGE GROWS WHEN IT’S SHARED.</span>
          <p>Explore ideas, discoveries, and perspectives from across the community.</p>
          <Link :href="wayfinderInsights().url">Explore all stories
            <UiIcon name="arrow-up-right" :size="14" />
          </Link>
        </div>
      </section>
    </main>
  </PublicLayout>
</template>

<style scoped>
  .journal-kicker-divider {
    color: #c3c5bb
  }

  .journal-page {
    --ink: #24281f;
    --muted: #777b72;
    --line: #e6e3da;
    --paper: #faf9f6;
    --green: #354532;
    background: var(--paper);
    min-height: 80vh;
    color: var(--ink);
    padding-bottom: 0
  }

  .journal-masthead {
    padding-top: 48px
  }

  .journal-kicker,
  .journal-section-label {
    font-size: .68rem;
    letter-spacing: .16em;
    font-weight: 700;
    color: #687463
  }

  .journal-kicker {
    display: flex;
    align-items: center;
    gap: 9px
  }

  .journal-kicker-dot {
    width: 7px;
    height: 7px;
    background: #879d78;
    border-radius: 50%
  }

  .journal-title-row {
    display: flex;
    justify-content: space-between;
    align-items: end;
    padding: 23px 0 32px;
    border-bottom: 1px solid var(--line)
  }

  .journal-title-row h1 {
    font-family: Georgia, serif;
    font-weight: 400;
    font-size: clamp(2.7rem, 6vw, 5rem);
    letter-spacing: -.055em;
    line-height: 1.03;
    margin: 0
  }

  .journal-title-row h1 em {
    color: #6b7d60;
    font-weight: 400
  }

  .journal-title-row p {
    color: var(--muted);
    line-height: 1.65;
    margin: 14px 0 0;
    max-width: 580px;
    font-size: .96rem
  }

  .journal-note {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 13px 17px;
    border: 1px solid var(--line);
    border-radius: 4px;
    color: #687463;
    font-size: .78rem;
    line-height: 1.5;
    margin-bottom: 3px
  }

  .journal-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 17px 0 24px
  }

  .journal-topics {
    display: flex;
    gap: 7px;
    flex-wrap: wrap
  }

  .journal-topics button {
    border: 1px solid transparent;
    background: transparent;
    color: #656b61;
    padding: 9px 13px;
    border-radius: 99px;
    font: inherit;
    font-size: .8rem;
    cursor: pointer;
    transition: all .18s
  }

  .journal-topics button:hover {
    border-color: var(--line);
    color: var(--ink)
  }

  .journal-topics button.active {
    background: var(--green);
    color: white
  }

  .journal-search {
    height: 40px;
    width: min(280px, 100%);
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 0 11px;
    border: 1px solid var(--line);
    background: #fff;
    border-radius: 4px;
    color: #7a8075
  }

  .journal-search input {
    border: 0;
    outline: 0;
    background: transparent;
    min-width: 0;
    flex: 1;
    font: inherit;
    font-size: .8rem;
    color: var(--ink)
  }

  .journal-search kbd {
    font-size: .7rem;
    color: #92958e;
    border: 1px solid var(--line);
    border-radius: 3px;
    padding: 1px 5px
  }

  .journal-content {
    padding-bottom: 58px
  }

  .journal-section-heading,
  .journal-latest-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 0 0 17px;
    color: #898b83;
    font-size: .75rem
  }

  .journal-section-heading>div,
  .journal-latest-heading>div {
    display: flex;
    align-items: center;
    gap: 12px
  }

  .journal-rule {
    height: 1px;
    width: 50px;
    background: #bbbeb4
  }

  .journal-feature {
    display: grid;
    grid-template-columns: 1.18fr .82fr;
    min-height: 370px;
    background: #fff;
    border: 1px solid var(--line)
  }

  .journal-feature-image {
    position: relative;
    display: block;
    overflow: hidden;
    min-height: 370px;
    background: #e9e8df
  }

  .journal-feature-image img,
  .journal-card-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    transition: transform .5s
  }

  .journal-feature-image:hover img,
  .journal-card-image:hover img {
    transform: scale(1.035)
  }

  .journal-image-label,
  .journal-card-category {
    position: absolute;
    left: 18px;
    top: 17px;
    background: rgba(250, 249, 246, .94);
    color: #495744;
    padding: 7px 10px;
    font-size: .62rem;
    letter-spacing: .1em;
    text-transform: uppercase
  }

  .journal-feature-copy {
    padding: clamp(25px, 4vw, 48px);
    display: flex;
    flex-direction: column;
    justify-content: center
  }

  .journal-story-meta {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #83877f;
    font-size: .7rem;
    text-transform: capitalize
  }

  .journal-story-meta i {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background: #aeb2a8
  }

  .journal-feature-copy h2 {
    font-family: Georgia, serif;
    font-size: clamp(1.8rem, 3vw, 2.7rem);
    font-weight: 400;
    letter-spacing: -.03em;
    line-height: 1.13;
    margin: 18px 0 13px
  }

  .journal-feature-copy h2 a,
  .journal-card h3 a {
    color: inherit;
    text-decoration: none
  }

  .journal-feature-copy h2 a:hover,
  .journal-card h3 a:hover {
    color: #617657
  }

  .journal-feature-copy>p,
  .journal-card-copy>p {
    font-size: .88rem;
    color: #73786f;
    line-height: 1.7;
    margin: 0
  }

  .journal-feature-footer {
    border-top: 1px solid var(--line);
    display: flex;
    align-items: center;
    gap: 11px;
    margin-top: 27px;
    padding-top: 17px
  }

  .journal-author-mark {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    background: #e8ebdf;
    color: #4b6044;
    font: 1rem Georgia, serif
  }

  .journal-author {
    display: flex;
    flex-direction: column;
    gap: 3px;
    flex: 1;
    font-size: .7rem
  }

  .journal-author b {
    font-weight: 600;
    color: #363b32
  }

  .journal-author span {
    color: #898d83
  }

  .journal-read-link,
  .journal-card-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #40523b;
    text-decoration: none;
    font-size: .76rem;
    font-weight: 600
  }

  .journal-latest {
    padding-top: 46px
  }

  .journal-latest-heading {
    margin-bottom: 17px
  }

  .journal-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px
  }

  .journal-card {
    border: 1px solid var(--line);
    background: white;
    min-width: 0
  }

  .journal-card-image {
    position: relative;
    height: 180px;
    display: block;
    overflow: hidden;
    background: #e9e8df
  }

  .journal-card-category {
    left: 13px;
    top: 13px;
    font-size: .58rem;
    padding: 6px 8px
  }

  .journal-card-copy {
    padding: 18px 19px 19px
  }

  .journal-card-copy .journal-story-meta {
    font-size: .66rem
  }

  .journal-card h3 {
    font-family: Georgia, serif;
    font-size: 1.35rem;
    letter-spacing: -.02em;
    font-weight: 400;
    line-height: 1.22;
    margin: 11px 0 8px
  }

  .journal-card-copy>p {
    font-size: .79rem;
    line-height: 1.6;
    min-height: 51px
  }

  .journal-card-link {
    margin-top: 17px;
    font-size: .7rem
  }

  .journal-pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--line);
    margin-top: 35px;
    padding-top: 18px;
    color: #858980;
    font-size: .76rem
  }

  .journal-pagination div {
    display: flex;
    gap: 23px
  }

  .journal-pagination a {
    color: #40523b;
    text-decoration: none
  }

  .journal-empty {
    text-align: center;
    padding: 74px 20px 88px;
    border: 1px solid var(--line);
    background: #fff
  }

  .journal-empty-icon {
    display: grid;
    place-items: center;
    margin: 0 auto 18px;
    width: 46px;
    height: 46px;
    background: #eff0e9;
    border-radius: 50%;
    color: #607356
  }

  .journal-empty h2 {
    font: 400 2rem Georgia, serif;
    margin: 13px 0 7px
  }

  .journal-empty p {
    max-width: 430px;
    margin: 0 auto 20px;
    color: var(--muted);
    font-size: .88rem;
    line-height: 1.65
  }

  .journal-empty button {
    border: 0;
    background: var(--green);
    color: #fff;
    padding: 10px 16px;
    border-radius: 3px;
    font: inherit;
    font-size: .78rem;
    cursor: pointer
  }

  .journal-signoff {
    background: #efeee8;
    border-top: 1px solid var(--line);
    padding: 23px 0
  }

  .journal-signoff .wrap {
    display: flex;
    align-items: center;
    gap: 18px
  }

  .journal-signoff span {
    color: #697763;
    font-size: .63rem;
    font-weight: 700;
    letter-spacing: .13em
  }

  .journal-signoff p {
    flex: 1;
    color: #6f746b;
    font-size: .78rem;
    margin: 0
  }

  .journal-signoff a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #3f5139;
    font-size: .75rem;
    text-decoration: none;
    font-weight: 600
  }

  @media(max-width:760px) {
    .journal-masthead {
      padding-top: 34px
    }

    .journal-title-row {
      padding: 19px 0 23px
    }

    .journal-note {
      display: none
    }

    .journal-toolbar {
      align-items: stretch;
      flex-direction: column
    }

    .journal-search {
      width: auto
    }

    .journal-feature {
      grid-template-columns: 1fr
    }

    .journal-feature-image {
      min-height: 260px;
      height: 45vw;
      max-height: 360px
    }

    .journal-feature-copy {
      padding: 26px
    }

    .journal-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr))
    }

    .journal-card-image {
      height: 160px
    }

    .journal-signoff .wrap {
      align-items: flex-start;
      flex-direction: column;
      gap: 9px
    }
  }

  @media(max-width:520px) {
    .journal-title-row h1 {
      font-size: 2.75rem
    }

    .journal-topics {
      gap: 3px
    }

    .journal-topics button {
      padding: 8px 10px;
      font-size: .72rem
    }

    .journal-grid {
      grid-template-columns: 1fr
    }

    .journal-card-image {
      height: 210px
    }

    .journal-card-copy>p {
      min-height: 0
    }

    .journal-pagination {
      align-items: flex-start;
      gap: 15px;
      flex-direction: column
    }

    .journal-pagination div {
      width: 100%;
      justify-content: space-between
    }
  }

  .journal-subjects {
    display: flex;
    align-items: center;
    gap: 7px;
    flex-wrap: wrap;
    padding: 0 0 22px
  }

  .journal-subjects>span {
    font-size: .61rem;
    letter-spacing: .13em;
    font-weight: 700;
    color: #82877e;
    margin-right: 4px
  }

  .journal-subjects button {
    border: 1px solid var(--line);
    background: #fff;
    color: #62695e;
    padding: 7px 10px;
    border-radius: 99px;
    font: inherit;
    font-size: .72rem;
    cursor: pointer
  }

  .journal-subjects button:hover,
  .journal-subjects button.active {
    border-color: #607356;
    background: #eff1eb;
    color: #40523b
  }

  .journal-collection-links {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    padding: 0 0 21px
  }

  .journal-collection-links>span {
    font-size: .61rem;
    letter-spacing: .13em;
    font-weight: 700;
    color: #82877e
  }

  .journal-collection-links>a {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 10px;
    border: 1px solid var(--line);
    background: #fff;
    color: #52634a;
    text-decoration: none;
    border-radius: 99px;
    font-size: .72rem
  }

  .journal-collection-links>a:hover {
    border-color: #607356;
    background: #eff1eb
  }

  .journal-image-label,
  .journal-card-category {
    display: inline-flex;
    align-items: center;
    min-height: 36px;
    padding: 9px 11px;
    font-size: .68rem;
    font-weight: 650;
    letter-spacing: .1em
  }

  /* Journal filters follow the academy’s square-corner visual language. */
  .journal-topics button,
  .journal-search,
  .journal-search kbd,
  .journal-collection-links>a,
  .journal-subject-track button {
    border-radius: 0
  }

  .journal-subjects {
    flex-wrap: nowrap;
    gap: 14px;
    min-width: 0;
    overflow: hidden
  }

  .journal-subjects>span {
    flex: 0 0 auto
  }

  .journal-subject-track {
    display: flex;
    flex: 1 1 auto;
    gap: 7px;
    min-width: 0;
    overflow-x: auto;
    overscroll-behavior-x: contain;
    padding: 1px 0 9px;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch
  }

  .journal-subject-track::-webkit-scrollbar {
    display: none
  }

  .journal-subject-arrow {
        align-self: center;
    display: grid;
    place-items: center;
    flex: 0 0 34px;
    width: 34px;
    height: 34px;
    padding: 0;
    border: 1px solid var(--line);
    border-radius: 0;
    background: transparent;
    color: #52634a;
    cursor: pointer
  }

  .journal-subject-arrow:hover:not(:disabled) {
    background: #eff1eb;
    border-color: #607356
  }

  .journal-subject-arrow:disabled {
    opacity: .35;
    cursor: default
  }

  .journal-subject-track button {
    flex: 0 0 auto;
    white-space: nowrap
  }

  .journal-subject-track:focus-visible {
    outline: 2px solid #718065;
    outline-offset: 2px
  }

  @media(max-width:760px) {
    .journal-subjects {
      align-items: flex-start
    }

    .journal-subjects>span {
      padding-top: 9px
    }
  }

  @media(max-width:520px) {
    .journal-subjects {
      gap: 10px
    }

    .journal-subject-track {
      gap: 6px
    }
  }

  .journal-subjects .journal-subject-arrow {
    align-self: center;
    display: grid;
    place-items: center;
    flex: 0 0 38px;
    width: 38px;
    height: 38px;
    min-height: 38px;
    padding: 0;
    border: 1px solid #d9ded5;
    border-radius: 0;
    background: #f2f4ef;
    color: #354532;
    cursor: pointer;
    transition: background-color .16s ease, border-color .16s ease, color .16s ease;
  }
  .journal-subjects .journal-subject-arrow:hover:not(:disabled) {
    border-color: #354532;
    background: #354532;
    color: #fff;
  }
  .journal-subjects .journal-subject-arrow:disabled {
    border-color: #e5e6e0;
    background: transparent;
    color: #9da197;
    opacity: 1;
    cursor: default;
  }
  .journal-subjects .journal-subject-arrow:focus-visible {
    outline: 2px solid #718065;
    outline-offset: 2px;
  }</style>
