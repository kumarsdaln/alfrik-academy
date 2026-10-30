<script setup>
import { insights as wayfinderInsights, insight as wayfinderInsight, reports as reportsRoute, report as reportRoute, surveys as surveysRoute, survey as surveyRoute, submitSurvey } from './../../actions/App/Http/Controllers/DiscoveryController';
import { Link, useForm } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import PublicLayout from '../../Layouts/PublicLayout.vue';
import ShareButton from '../../Components/ShareButton.vue';

const props = defineProps({ insight: Object, related: Array, collectionType: String, hasResponded: Boolean });
const readingProgress = ref(0);
const paragraphs = computed(() => (props.insight.body || '').split(/\n\s*\n/).map((paragraph) => paragraph.trim()).filter(Boolean));
const collectionHref = computed(() => props.collectionType === 'survey' ? surveysRoute().url : props.collectionType === 'report' ? reportsRoute().url : wayfinderInsights().url);
const collectionLabel = computed(() => props.collectionType === 'survey' ? 'Surveys' : props.collectionType === 'report' ? 'Research reports' : 'The journal');
const surveyQuestions = computed(() => props.insight.type === 'survey' ? (props.insight.survey_questions || []) : []);
const requiredQuestions = computed(() => surveyQuestions.value.filter((question) => question.required));
const requiredAnswered = computed(() => requiredQuestions.value.filter((question) => {
  const answer = surveyForm.answers[question.id];
  return Array.isArray(answer) ? answer.length > 0 : String(answer || '').trim().length > 0;
}).length);
const requiredProgress = computed(() => requiredQuestions.value.length ? Math.round((requiredAnswered.value / requiredQuestions.value.length) * 100) : 100);
const surveySubmitted = ref(props.hasResponded);
const surveyForm = useForm({ answers: Object.fromEntries(surveyQuestions.value.map((question) => [question.id, question.type === 'multiple_choice' ? [] : ''])) });

function sendSurveyResponse() {
  surveyForm.post(submitSurvey.url({ slug: props.insight.slug }), {
    preserveScroll: true,
    onSuccess: () => { surveySubmitted.value = true; },
  });
}

function detailUrl(item) {
  if (item.type === 'survey') return surveyRoute.url({ slug: item.slug });
  if (item.type === 'report') return reportRoute.url({ slug: item.slug });
  return wayfinderInsight.url({ slug: item.slug });
}

function updateReadingProgress() {
  const page = document.documentElement;
  const scrollable = page.scrollHeight - window.innerHeight;
  readingProgress.value = scrollable > 0 ? Math.min(100, Math.max(0, (window.scrollY / scrollable) * 100)) : 0;
}

function dateLabel(date) {
  return date ? new Date(date).toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' }) : 'Recently';
}

onMounted(() => {
  updateReadingProgress();
  window.addEventListener('scroll', updateReadingProgress, { passive: true });
  window.addEventListener('resize', updateReadingProgress);
});
onBeforeUnmount(() => {
  window.removeEventListener('scroll', updateReadingProgress);
  window.removeEventListener('resize', updateReadingProgress);
});
</script>

<template>
  <PublicLayout>
    <main class="journal-article-page">
      <div class="reading-progress-track" aria-hidden="true"><span :style="{ width: `${readingProgress}%` }"></span></div>
      <article class="journal-article wrap">
        <nav class="article-breadcrumbs" aria-label="Breadcrumb">
          <Link :href="collectionHref">{{ collectionLabel }}</Link><span>/</span><span>{{ insight.category || insight.type }}</span>
        </nav>

        <header class="article-header">
          <div class="article-topic"><span>{{ insight.category || insight.type }}</span><i></i><span>{{ insight.type }}</span></div>
          <h1>{{ insight.title }}</h1>
          <p class="article-deck">{{ insight.excerpt }}</p>
          <div class="article-meta-row">
            <div class="article-byline"><div class="article-avatar">{{ (insight.author?.name || 'K').slice(0, 1) }}</div><div><b>{{ insight.author?.name || 'Alfrik Journal' }}</b><span>Published {{ dateLabel(insight.published_at) }}</span></div></div>
            <div class="article-reading"><UiIcon name="clock" :size="15" /> {{ insight.reading_minutes }} min read</div><ShareButton class="article-share-inline" :title="insight.title" :text="insight.excerpt" label="Share" />
          </div>
        </header>

        <figure v-if="insight.cover_image" class="article-cover-wrap">
          <img class="article-cover" :src="insight.cover_image" :alt="insight.title">
          <figcaption>From the Alfrik Journal · {{ insight.category || 'Ideas & knowledge' }}</figcaption>
        </figure>

        <aside v-if="insight.type === 'survey' && !surveyQuestions.length && insight.survey_url" class="survey-invitation">
          <div><span class="article-rail-label">COMMUNITY SURVEY</span><h2>Your perspective is part of the picture.</h2><p>Take part using the secure survey form linked below. Response collection is handled by the survey provider.</p></div>
          <a :href="insight.survey_url" target="_blank" rel="noopener noreferrer">Take the survey <UiIcon name="arrow-up-right" :size="15" /></a>
        </aside>
        <aside v-else-if="insight.type === 'survey' && !surveyQuestions.length" class="survey-invitation survey-not-open"><div><span class="article-rail-label">COMMUNITY SURVEY</span><h2>This survey is not accepting responses yet.</h2><p>Check back later to take part.</p></div></aside>

        <aside v-if="insight.type === 'report'" class="report-note"><UiIcon name="file-text" :size="18" /><span><b>Research report</b><small>Review the findings and methodology described in this report.</small></span></aside>

        <div class="article-reading-layout">
          <aside class="article-rail" aria-label="Article tools and details">
            <div class="article-rail-inner">
              <span class="article-rail-label">{{ insight.type === 'survey' ? 'ABOUT THIS SURVEY' : 'IN THIS STORY' }}</span>
              <div class="article-rail-stat"><UiIcon name="clock" :size="15" /><span>{{ insight.reading_minutes }} min {{ insight.type === 'survey' ? 'to respond' : 'read' }}</span></div>
              <div class="article-rail-stat"><UiIcon name="book-open" :size="15" /><span>{{ insight.type === 'survey' ? `${surveyQuestions.length} questions` : `${paragraphs.length} paragraphs` }}</span></div>
              <div class="article-rail-divider"></div>
              
            </div>
          </aside>

          <div class="article-prose">
            <p v-for="(paragraph, index) in paragraphs" :key="index" :class="{ 'article-lead-paragraph': index === 0 }">{{ paragraph }}</p>
            <div class="article-endnote"><div><b>Keep exploring.</b><p>Ideas connect across subjects. Follow your curiosity to another story.</p></div><Link :href="collectionHref">Browse {{ collectionLabel.toLowerCase() }} <UiIcon name="arrow-up-right" :size="14" /></Link></div>
          </div>
        </div>

        <section v-if="insight.type === 'survey' && surveyQuestions.length" class="survey-response-panel" aria-labelledby="survey-form-title">
          <div v-if="surveySubmitted" class="survey-thank-you"><span class="survey-success-mark"><UiIcon name="check" :size="18" /></span><div><span class="article-rail-label">RESPONSE RECORDED</span><h2 id="survey-form-title">Thank you for sharing your perspective.</h2><p>Your response is saved anonymously. You can close this page whenever you’re ready.</p></div></div>
          <template v-else>
            <div class="survey-form-heading"><div><span class="article-rail-label">YOUR RESPONSE</span><h2 id="survey-form-title">Share your perspective.</h2><p>Your answers are anonymous. Please avoid including personal details in written responses.</p></div><span class="survey-time-estimate"><UiIcon name="clock" :size="13" /> About {{ insight.reading_minutes }} min <i></i> {{ surveyQuestions.length }} questions</span></div>
            <div class="survey-progress"><div><span>Required questions</span><span>{{ requiredAnswered }} of {{ requiredQuestions.length }} answered</span></div><div class="survey-progress-track" role="progressbar" :aria-valuenow="requiredProgress" aria-valuemin="0" aria-valuemax="100" aria-label="Required questions answered"><span :style="{ width: `${requiredProgress}%` }"></span></div></div>
            <form class="survey-response-form" @submit.prevent="sendSurveyResponse">
              <fieldset v-for="(question, index) in surveyQuestions" :key="question.id" class="survey-response-question">
                <legend><span class="survey-question-number">{{ String(index + 1).padStart(2, '0') }}</span><span class="survey-question-copy">{{ question.prompt }}<i v-if="question.required">Required</i><i v-else>Optional</i></span></legend>
                <textarea v-if="question.type === 'text'" v-model="surveyForm.answers[question.id]" rows="3" maxlength="2000" :required="question.required" :placeholder="'Share a little context…'"></textarea>
                <div v-else class="survey-response-options">
                  <label v-for="option in question.options" :key="option" class="survey-response-option"><input v-if="question.type === 'multiple_choice'" v-model="surveyForm.answers[question.id]" type="checkbox" :value="option"><input v-else v-model="surveyForm.answers[question.id]" type="radio" :name="question.id" :value="option" :required="question.required"><span>{{ option }}</span><UiIcon name="check" :size="15" /></label>
                </div>
                <small v-if="surveyForm.errors[`answers.${question.id}`]" class="survey-field-error">{{ surveyForm.errors[`answers.${question.id}`] }}</small>
              </fieldset>
              <div class="survey-submit-row"><div><span>One response per browser or account.</span><small>Your answers help inform future community resources.</small></div><button type="submit" :disabled="surveyForm.processing">{{ surveyForm.processing ? 'Sending response…' : 'Submit my response' }} <UiIcon name="arrow-up-right" :size="14" /></button></div>
              <p v-if="surveyForm.errors.answers" class="survey-field-error">{{ surveyForm.errors.answers }}</p>
            </form>
          </template>
        </section>

        <section v-if="related.length" class="related-journal">
          <header class="related-heading"><div><span class="article-rail-label">MORE TO EXPLORE</span><h2>Keep following the thread.</h2></div><Link :href="collectionHref">More {{ collectionLabel.toLowerCase() }} <UiIcon name="arrow-up-right" :size="14" /></Link></header>
          <div class="related-grid">
            <article v-for="item in related" :key="item.id" class="related-card">
              <Link class="related-image" :href="detailUrl(item)">
                <img v-if="item.cover_image" :src="item.cover_image" :alt="item.title" loading="lazy">
                <div v-else class="related-placeholder"><UiIcon name="book-open" :size="22" /></div>
              </Link>
              <div class="related-card-copy"><div class="related-meta"><span>{{ item.category || item.type }}</span><span>{{ dateLabel(item.published_at) }}</span></div><h3><Link :href="detailUrl(item)">{{ item.title }}</Link></h3><p>{{ item.excerpt }}</p></div>
            </article>
          </div>
        </section>
      </article>
    </main>
  </PublicLayout>
</template>

<style scoped>
.journal-article-page{--ink:var(--academy-ink,var(--academy-ink));--muted:var(--academy-muted,var(--academy-muted));--line:#e5e3dc;--paper:var(--academy-paper,var(--academy-paper));--green:var(--academy-primary,var(--academy-primary));min-height:80vh;padding:0 0 88px;background:var(--paper);color:var(--ink)}
.reading-progress-track{position:sticky;top:0;z-index:20;height:3px;background:transparent}
.reading-progress-track span{display:block;height:100%;background:var(--academy-primary);transition:width .08s linear}
.journal-article{max-width:1160px}
.article-breadcrumbs{display:flex;align-items:center;gap:10px;padding:25px 0;color:var(--academy-muted);font-size:.74rem;text-transform:capitalize}
.article-breadcrumbs a{color:var(--academy-primary);text-decoration:none}
.article-breadcrumbs a:hover{text-decoration:underline;text-underline-offset:4px}
.article-header{max-width:900px;margin:42px auto 36px;text-align:left}
.article-topic{display:flex;align-items:center;gap:9px;color:var(--academy-secondary);font-size:.7rem;font-weight:700;letter-spacing:.11em;text-transform:uppercase}
.article-topic i{display:none}
.article-header h1{max-width:870px;margin:17px 0 17px;color:var(--academy-ink);font:450 clamp(2.8rem,6vw,5.25rem)/1.01 var(--serif);letter-spacing:-.05em}
.article-deck{max-width:760px;margin:0;color:var(--academy-muted);font-size:clamp(1.04rem,1.8vw,1.28rem);line-height:1.72}
.article-meta-row{display:flex;justify-content:flex-start;align-items:center;gap:22px;margin-top:27px}
.article-byline{display:flex;align-items:center;gap:11px;text-align:left}
.article-avatar{display:grid;place-items:center;width:40px;height:40px;background:var(--academy-primary-soft);color:var(--academy-secondary);font:500 1.1rem var(--serif)}
.article-byline>div:last-child{display:flex;flex-direction:column;gap:4px}
.article-byline b{color:var(--academy-ink);font-size:.78rem;font-weight:600}
.article-byline span{color:var(--academy-muted);font-size:.7rem}
.article-reading{display:flex;align-items:center;gap:7px;padding-left:20px;border-left:1px solid var(--line);color:var(--academy-muted);font-size:.75rem}
.article-meta-row :deep(.article-share-inline){display:inline-flex;align-items:center;margin-left:2px}
.article-meta-row :deep(.share-button){min-height:38px;padding:7px 10px;border:1px solid #dfe2d9;border-radius:0;background:transparent;color:var(--academy-primary);font-size:.74rem}
.article-meta-row :deep(.share-button:hover){border-color:var(--academy-muted);background:var(--academy-paper)}
.article-cover-wrap{max-width:1000px;margin:0 auto 48px}
.article-cover{display:block;width:100%;height:clamp(280px,48vw,540px);object-fit:cover;background:var(--academy-paper)}
.article-cover-wrap figcaption{padding:11px 0;border-bottom:1px solid var(--line);color:var(--academy-muted);font-size:.69rem}
.article-reading-layout{display:grid;grid-template-columns:160px minmax(0,720px);gap:clamp(35px,6vw,72px);justify-content:center;align-items:start}
.article-rail-inner{position:sticky;top:26px;padding-top:16px;border-top:1px solid var(--line)}
.article-rail-label{display:block;color:var(--academy-muted);font-size:.65rem;letter-spacing:.12em;font-weight:700}
.article-rail-stat{display:flex;align-items:center;gap:9px;margin-top:16px;color:var(--academy-muted);font-size:.75rem}
.article-rail-divider{height:1px;margin:18px 0 14px;background:var(--line)}
.article-share-button{display:inline-flex;align-items:center;gap:8px;padding:8px 0;border:0;background:transparent;color:var(--academy-primary);font:inherit;font-size:.76rem;font-weight:600;cursor:pointer}
.article-share-button:hover{text-decoration:underline;text-underline-offset:4px}
.article-rail-note{display:block;margin-top:4px;color:var(--academy-muted);font-size:.68rem}
.article-prose{min-width:0}
.article-prose>p{margin:0 0 25px;color:var(--academy-ink);font:400 1.12rem/1.9 var(--serif)}
.article-prose>p.article-lead-paragraph{color:var(--academy-ink);font-size:1.28rem;line-height:1.75}
.article-endnote{display:flex;align-items:center;gap:14px;margin-top:42px;padding:20px 0;border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
.article-endnote>div{flex:1;min-width:0}
.article-endnote b{color:var(--academy-ink);font:500 1.08rem var(--serif)}
.article-endnote p{margin:4px 0 0;color:var(--academy-muted);font-size:.75rem;line-height:1.55}
.article-endnote>a,.related-heading>a{display:inline-flex;align-items:center;gap:7px;color:var(--academy-primary);text-decoration:none;font-size:.74rem;font-weight:600;white-space:nowrap}
.article-endnote>a:hover,.related-heading>a:hover{text-decoration:underline;text-underline-offset:4px}
.related-journal{max-width:1000px;margin:76px auto 0}
.related-heading{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-bottom:21px;padding-bottom:17px;border-bottom:1px solid var(--line)}
.related-heading h2{margin:8px 0 0;color:var(--academy-ink);font:450 clamp(1.7rem,3vw,2.35rem)/1.15 var(--serif);letter-spacing:-.035em}
.related-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}
.related-card{min-width:0;background:var(--academy-surface);border:1px solid var(--line)}
.related-image{display:block;height:175px;overflow:hidden;background:var(--academy-paper)}
.related-image img{display:block;width:100%;height:100%;object-fit:cover;transition:transform .35s}
.related-image:hover img{transform:scale(1.035)}
.related-placeholder{display:grid;place-items:center;height:100%;color:var(--academy-secondary)}
.related-card-copy{padding:17px}
.related-meta{display:flex;justify-content:space-between;gap:8px;color:var(--academy-muted);font-size:.66rem}
.related-meta span:first-child{color:var(--academy-secondary);text-transform:capitalize}
.related-card h3{margin:10px 0 7px;color:var(--academy-ink);font:450 1.3rem/1.25 var(--serif);letter-spacing:-.02em}
.related-card h3 a{color:inherit;text-decoration:none}
.related-card h3 a:hover{color:var(--academy-secondary)}
.related-card p{margin:0;color:var(--academy-muted);font-size:.76rem;line-height:1.65}
.survey-invitation{display:flex;align-items:center;justify-content:space-between;gap:24px;max-width:850px;margin:0 auto 38px;padding:23px 25px;border:1px solid var(--line);background:var(--academy-primary-soft)}
.survey-invitation h2{margin:9px 0 6px;color:var(--academy-ink);font:450 clamp(1.35rem,3vw,1.85rem)/1.2 var(--serif)}
.survey-invitation p{margin:0;color:var(--academy-muted);font-size:.84rem;line-height:1.65}
.survey-invitation>a{display:inline-flex;flex:none;align-items:center;justify-content:center;gap:9px;min-height:44px;padding:11px 15px;background:var(--academy-primary);color:var(--academy-contrast);text-decoration:none;font-size:.77rem;font-weight:600}
.survey-invitation>a:hover{background:var(--academy-primary-hover)}
.report-note{display:flex;align-items:center;gap:13px;max-width:850px;margin:0 auto 34px;padding:16px 18px;border-left:3px solid #657a5d;background:var(--academy-paper);color:var(--academy-secondary)}
.report-note>span{display:grid;gap:4px}
.report-note b{color:var(--academy-ink);font:500 1.05rem var(--serif)}
.report-note small{color:var(--academy-muted);font-size:.75rem;line-height:1.5}
.survey-response-panel{max-width:850px;margin:58px auto 38px;padding:clamp(22px,4vw,36px);border:1px solid #e2e3db;background:var(--academy-paper)}
.survey-form-heading{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;padding-bottom:22px;border-bottom:1px solid #dfe2d8}
.survey-form-heading h2,.survey-thank-you h2{margin:8px 0;color:var(--academy-ink);font:450 clamp(1.7rem,3.5vw,2.45rem)/1.15 var(--serif);letter-spacing:-.035em}
.survey-form-heading p,.survey-thank-you p{margin:0;color:var(--academy-muted);font-size:.84rem;line-height:1.65}
.survey-time-estimate{display:inline-flex;flex:none;align-items:center;gap:7px;padding:8px 0;color:var(--academy-secondary);font-size:.7rem}
.survey-time-estimate i{display:none}
.survey-progress{padding:18px 0 5px}
.survey-progress>div:first-child{display:flex;justify-content:space-between;gap:12px;color:var(--academy-muted);font-size:.7rem}
.survey-progress>div:first-child span:last-child{color:var(--academy-secondary);font-weight:600}
.survey-progress-track{height:4px;margin-top:9px;background:#e0e4db;overflow:hidden}
.survey-progress-track span{display:block;height:100%;background:var(--academy-primary);transition:width .2s ease}
.survey-response-form{display:grid;gap:0}
.survey-response-question{min-width:0;margin:0;padding:22px 0;border:0;border-bottom:1px solid #dfe2d8}
.survey-response-question legend{display:flex;align-items:flex-start;gap:12px;width:100%;padding:0;margin:0 0 14px}
.survey-question-number{display:grid;place-items:center;flex:none;width:31px;height:31px;background:var(--academy-paper);color:var(--academy-secondary);font:.85rem var(--serif)}
.survey-question-copy{display:grid;gap:5px;padding-top:3px;color:var(--academy-ink);font-size:.96rem;font-weight:600;line-height:1.5}
.survey-question-copy i{color:var(--academy-muted);font-size:.65rem;font-style:normal;font-weight:500;letter-spacing:.03em;text-transform:uppercase}
.survey-response-question textarea{width:100%;max-width:100%;min-height:92px;padding:13px 14px;border:1px solid #d8ddd2;background:var(--academy-surface);color:var(--academy-ink);font:400 .86rem/1.6 var(--sans);resize:vertical}
.survey-response-question textarea:focus{outline:2px solid var(--academy-secondary-light);outline-offset:1px;border-color:var(--academy-primary)}
.survey-response-options{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}
.survey-response-option{position:relative;display:flex;align-items:center;gap:10px;min-height:49px;padding:10px 13px;border:1px solid #dfe2d8;background:var(--academy-surface);color:var(--academy-muted);font-size:.8rem;line-height:1.4;cursor:pointer;transition:border-color .15s,background .15s}
.survey-response-option:hover{border-color:var(--academy-muted)}
.survey-response-option:has(input:checked){border-color:var(--academy-secondary);background:var(--academy-paper);color:var(--academy-primary)}
.survey-response-option:has(input:focus-visible){outline:3px solid #8a9b7f55;outline-offset:2px}
.survey-response-option input{width:17px;height:17px;flex:none;margin:0;accent-color:var(--academy-secondary)}
.survey-response-option>span{flex:1}
.survey-response-option>.ui-icon{color:var(--academy-secondary);opacity:0}
.survey-response-option:has(input:checked)>.ui-icon{opacity:1}
.survey-field-error{display:block;margin-top:9px;color:var(--academy-danger);font-size:.74rem}
.survey-submit-row{display:flex;align-items:center;justify-content:space-between;gap:18px;padding-top:21px}
.survey-submit-row>div{display:grid;gap:5px;color:var(--academy-muted);font-size:.7rem}
.survey-submit-row>div small{color:var(--academy-muted);font-size:.68rem}
.survey-submit-row button{display:inline-flex;align-items:center;gap:9px;min-height:45px;padding:12px 17px;border:0;background:var(--academy-primary);color:var(--academy-contrast);font:600 .78rem var(--sans);cursor:pointer;transition:background .15s}
.survey-submit-row button:hover:not(:disabled){background:var(--academy-secondary)}
.survey-submit-row button:disabled{opacity:.65;cursor:wait}
.survey-thank-you{display:flex;align-items:flex-start;gap:15px;padding:10px 0}
.survey-success-mark{display:grid;place-items:center;flex:none;width:42px;height:42px;background:var(--academy-success-surface);color:var(--academy-success)}
@media(max-width:760px){.article-breadcrumbs{padding:20px 0}.article-header{margin:28px auto 27px}.article-header h1{font-size:clamp(2.5rem,8vw,4rem)}.article-cover-wrap{margin-bottom:30px}.article-reading-layout{grid-template-columns:1fr;gap:22px}.article-rail-inner{position:static;display:flex;align-items:center;gap:15px;flex-wrap:wrap;padding:0 0 13px;border-top:0;border-bottom:1px solid var(--line)}.article-rail-label{width:100%}.article-rail-stat{margin:0}.article-rail-divider{width:1px;height:18px;margin:0}.article-rail-note{display:none}.article-prose>p{font-size:1.08rem;line-height:1.82}.article-prose>p.article-lead-paragraph{font-size:1.2rem}.related-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.survey-invitation{align-items:flex-start;flex-direction:column;padding:20px}.survey-invitation>a{width:100%}}
@media(max-width:600px){.journal-article-page{padding-bottom:56px}.article-breadcrumbs{font-size:.7rem}.article-header{margin-top:22px}.article-header h1{font-size:clamp(2.35rem,10vw,3.4rem)}.article-meta-row{gap:15px;flex-wrap:wrap}.article-reading{padding-left:14px}.article-byline b{font-size:.72rem}.article-byline span{font-size:.65rem}.article-avatar{width:35px;height:35px}.article-cover{height:64vw;min-height:220px}.article-endnote{align-items:flex-start;flex-wrap:wrap}.article-endnote>div{min-width:0}.article-endnote>a{margin-left:0}.related-journal{margin-top:52px}.related-heading{align-items:flex-start;gap:16px;flex-direction:column}.related-grid{grid-template-columns:1fr}.related-image{height:210px}.survey-response-panel{margin-top:38px;padding:19px}.survey-form-heading{flex-direction:column}.survey-response-options{grid-template-columns:1fr}.survey-submit-row{align-items:stretch;flex-direction:column}.survey-submit-row button{justify-content:center}.survey-thank-you{align-items:flex-start}}
</style>