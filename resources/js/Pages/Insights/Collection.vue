<script setup>
import { reports as reportsRoute, report as reportRoute, surveys as surveysRoute, survey as surveyRoute } from './../../actions/App/Http/Controllers/DiscoveryController';
import { Link } from '@inertiajs/vue3';
import PublicLayout from '../../Layouts/PublicLayout.vue';

const props = defineProps({ contentType: String, title: String, description: String, insights: Object });
const routeForCollection = () => props.contentType === 'survey' ? surveysRoute : reportsRoute;
const detailUrl = (item) => props.contentType === 'survey' ? surveyRoute.url({ slug: item.slug }) : reportRoute.url({ slug: item.slug });
</script>

<template>
  <PublicLayout>
    <main class="editorial-collection wrap">
      <header class="collection-heading">
        <span class="collection-eyebrow"><UiIcon :name="contentType === 'survey' ? 'clipboard-list' : 'file-text'" :size="15" /> ALFRIK KNOWLEDGE HUB</span>
        <h1>{{ title }}<em>.</em></h1>
        <p>{{ description }}</p>
        <div class="collection-actions"><Link :href="routeForCollection().url" class="collection-current">{{ title }}</Link><Link :href="routeForCollection() === surveysRoute ? reportsRoute().url : surveysRoute().url">{{ contentType === 'survey' ? 'Browse research reports' : 'Browse surveys' }} <UiIcon name="arrow-up-right" :size="13" /></Link></div>
      </header>

      <section class="collection-results" aria-live="polite">
        <div class="collection-count"><span>{{ insights.total }} {{ insights.total === 1 ? 'entry' : 'entries' }}</span><span>Recently published</span></div>
        <div v-if="insights.data.length" class="collection-grid">
          <article v-for="item in insights.data" :key="item.id" class="collection-card">
            <Link :href="detailUrl(item)" class="collection-card-image">
              <img v-if="item.cover_image" :src="item.cover_image" :alt="item.title" loading="lazy">
              <div v-else class="collection-image-placeholder"><UiIcon :name="contentType === 'survey' ? 'clipboard-list' : 'file-text'" :size="25" /></div>
              <span>{{ contentType === 'survey' ? 'SURVEY' : 'REPORT' }}</span>
            </Link>
            <div class="collection-card-copy">
              <div class="collection-meta"><span>{{ item.category || 'General' }}</span><span>{{ item.reading_minutes }} min read</span></div>
              <h2><Link :href="detailUrl(item)">{{ item.title }}</Link></h2>
              <p>{{ item.excerpt }}</p>
              <Link :href="detailUrl(item)" class="collection-card-link">{{ contentType === 'survey' ? 'View survey' : 'Read report' }} <UiIcon name="arrow-up-right" :size="14" /></Link>
            </div>
          </article>
        </div>
        <div v-else class="collection-empty">
          <UiIcon :name="contentType === 'survey' ? 'clipboard-list' : 'file-text'" :size="22" />
          <h2>{{ contentType === 'survey' ? 'No surveys published yet.' : 'No reports published yet.' }}</h2>
          <p>Check back soon for new work from the community.</p>
          <Link :href="routeForCollection().url">Refresh this page <UiIcon name="arrow-right" :size="13" /></Link>
        </div>
        <nav v-if="insights.last_page > 1" class="collection-pagination" aria-label="Pages">
          <span>Page {{ insights.current_page }} of {{ insights.last_page }}</span>
          <div><Link v-if="insights.prev_page_url" :href="routeForCollection().url({ mergeQuery: { page: insights.current_page - 1 } })">← Newer</Link><Link v-if="insights.next_page_url" :href="routeForCollection().url({ mergeQuery: { page: insights.current_page + 1 } })">Older →</Link></div>
        </nav>
      </section>
    </main>
  </PublicLayout>
</template>

<style scoped>
.editorial-collection{--ink:#293127;--muted:#72786e;--line:#e5e3da;min-height:72vh;padding-top:44px;padding-bottom:80px;color:var(--ink)}
.collection-heading{padding:18px 0 27px;border-bottom:1px solid var(--line)}.collection-eyebrow{display:inline-flex;align-items:center;gap:8px;color:var(--academy-secondary-light);font-size:.66rem;letter-spacing:.14em;font-weight:700}.collection-heading h1{font:400 clamp(3rem,7vw,5.7rem)/1 Georgia,serif;letter-spacing:-.06em;margin:22px 0 12px}.collection-heading h1 em{color:var(--academy-secondary-light);font-weight:400}.collection-heading>p{max-width:650px;color:var(--muted);font-size:1rem;line-height:1.7;margin:0}.collection-actions{display:flex;align-items:center;gap:10px;margin-top:23px}.collection-actions>a{display:inline-flex;align-items:center;gap:7px;padding:9px 13px;border:1px solid var(--line);color:var(--academy-secondary);text-decoration:none;font-size:.76rem}.collection-actions>a.collection-current{background:var(--academy-primary);border-color:var(--academy-primary);color:white}.collection-results{padding-top:22px}.collection-count{display:flex;justify-content:space-between;color:var(--academy-muted);font-size:.73rem;margin-bottom:15px}.collection-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}.collection-card{background:var(--academy-surface);border:1px solid var(--line);min-width:0}.collection-card-image{position:relative;height:205px;display:block;overflow:hidden;background:var(--academy-paper)}.collection-card-image img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .35s}.collection-card-image:hover img{transform:scale(1.035)}.collection-card-image>span{position:absolute;top:12px;left:12px;background:color-mix(in srgb, var(--academy-paper) 92.9%, transparent);color:var(--academy-secondary);padding:7px 9px;font-size:.59rem;letter-spacing:.11em}.collection-image-placeholder{height:100%;display:grid;place-items:center;color:var(--academy-secondary)}.collection-card-copy{padding:17px 18px 19px}.collection-meta{display:flex;justify-content:space-between;gap:8px;color:var(--academy-muted);font-size:.64rem}.collection-card h2{font:400 1.4rem/1.23 Georgia,serif;letter-spacing:-.025em;margin:11px 0 8px}.collection-card h2 a{color:inherit;text-decoration:none}.collection-card h2 a:hover{color:var(--academy-secondary)}.collection-card-copy>p{min-height:55px;color:var(--academy-muted);font-size:.78rem;line-height:1.6;margin:0}.collection-card-link{display:inline-flex;align-items:center;gap:8px;margin-top:16px;color:var(--academy-secondary);text-decoration:none;font-size:.72rem;font-weight:600}.collection-empty{min-height:280px;border:1px dashed var(--line);display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;color:var(--academy-secondary)}.collection-empty h2{font:400 1.8rem Georgia,serif;color:var(--ink);margin:15px 0 7px}.collection-empty p{color:var(--muted);font-size:.85rem}.collection-empty>a{display:inline-flex;align-items:center;gap:7px;color:var(--academy-secondary);text-decoration:none;font-size:.75rem}.collection-pagination{display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--line);margin-top:28px;padding-top:16px;color:var(--academy-muted);font-size:.75rem}.collection-pagination div{display:flex;gap:20px}.collection-pagination a{color:var(--academy-secondary);text-decoration:none}
@media(max-width:800px){.collection-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.collection-card-image{height:180px}}
@media(max-width:540px){.editorial-collection{padding-top:24px;padding-bottom:52px}.collection-heading h1{font-size:3.1rem}.collection-heading>p{font-size:.9rem}.collection-actions{flex-wrap:wrap}.collection-grid{grid-template-columns:1fr}.collection-card-image{height:220px}.collection-card-copy>p{min-height:0}.collection-pagination{align-items:flex-start;gap:12px;flex-direction:column}.collection-pagination div{width:100%;justify-content:space-between}}
</style>
