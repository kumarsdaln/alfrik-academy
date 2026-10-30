<script setup>
import { destroyInsight, storeInsight, updateInsight } from '../../../actions/App/Http/Controllers/StaffPublishingController';
import { reports as manageReports, surveys as manageSurveys } from '../../../actions/App/Http/Controllers/StaffPublishingController';
import { reports as publicReports, report as showReport, surveys as publicSurveys, survey as showSurvey } from '../../../actions/App/Http/Controllers/DiscoveryController';
import { Link, router, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import StaffAdminLayout from '../../../Layouts/StaffAdminLayout.vue';
import SurveyQuestionEditor from '../../../Components/SurveyQuestionEditor.vue';

const props = defineProps({ contentType: String, entries: Object, surveyResults: Object });
const isSurvey = props.contentType === 'survey';
const title = isSurvey ? 'Surveys.' : 'Research reports.';
const blankQuestion = () => ({ id: `q_${Date.now()}_${Math.random().toString(36).slice(2, 7)}`, prompt: '', type: 'single_choice', required: true, options: ['', ''] });
const create = useForm({ title: '', type: props.contentType, category: '', excerpt: '', cover_image: '', cover_upload: null, survey_url: '', survey_questions: isSurvey ? [blankQuestion()] : [], body: '', status: 'draft' });
const drafts = reactive(Object.fromEntries(props.entries.data.map((entry) => [entry.id, {
  title: entry.title, slug: entry.slug, type: entry.type, category: entry.category || '', excerpt: entry.excerpt || '',
  cover_image: entry.cover_image || '', cover_upload: null, survey_url: entry.survey_url || '', survey_questions: JSON.parse(JSON.stringify(entry.survey_questions || [])), body: entry.body, status: entry.status,
}])));
const publicIndex = isSurvey ? publicSurveys().url : publicReports().url;
const manageIndex = isSurvey ? manageSurveys : manageReports;
const publicEntry = (entry) => isSurvey ? showSurvey.url({ slug: entry.slug }) : showReport.url({ slug: entry.slug });

function save(entry) {
  router.put(updateInsight.url({ insight: entry.id }), drafts[entry.id], { preserveScroll: true });
}

function remove(entry) {
  if (window.confirm(`Delete “${entry.title}” permanently?`)) {
    router.delete(destroyInsight.url({ insight: entry.id }), { preserveScroll: true });
  }
}

function publishedDate(entry) {
  return entry.published_at ? new Date(entry.published_at).toLocaleDateString() : 'Not published';
}
</script>

<template>
  <StaffAdminLayout>
    <div class="admin-heading editorial-admin-heading">
      <div><div class="eyebrow">PUBLIC KNOWLEDGE HUB</div><h1>{{ title }}</h1><p>{{ isSurvey ? 'Build surveys with questions people can answer right on the public page, then review response totals.' : 'Publish and maintain long-form research, findings, and evidence-led reports.' }}</p></div>
      <Link :href="publicIndex" target="_blank" class="button button-dark">View public page <UiIcon name="arrow-up-right" :size="13" /></Link>
    </div>

    <section class="admin-panel editorial-create">
      <div class="editorial-panel-title"><span class="admin-chip">NEW {{ isSurvey ? 'SURVEY' : 'REPORT' }}</span><h2>{{ isSurvey ? 'Create a survey' : 'Publish a research report' }}</h2><p>{{ isSurvey ? 'Write your questions here. Visitors can answer them without leaving the survey page.' : 'Include the findings, methodology, and source context in the report.' }}</p></div>
      <form class="admin-form" @submit.prevent="create.post(storeInsight().url)">
        <div class="admin-form-grid"><label>Title<input v-model="create.title" maxlength="180" required><small class="editorial-error">{{ create.errors.title }}</small></label><label>Subject<input v-model="create.category" maxlength="100" placeholder="Research topic"></label></div>
        <label>Short introduction<textarea v-model="create.excerpt" maxlength="500" rows="2" placeholder="What should visitors know before opening this entry?"></textarea></label>
        <div v-if="isSurvey" class="admin-form-grid"><label>External form URL <small>(optional fallback)</small><input v-model="create.survey_url" type="url" placeholder="https://…"><small>Use this only if responses are handled by another provider.</small><small class="editorial-error">{{ create.errors.survey_url }}</small></label><label>Cover image <small>(optional)</small><input type="file" accept="image/jpeg,image/png,image/webp" @input="create.cover_upload = $event.target.files[0] || null"><small class="editorial-error">{{ create.errors.cover_upload }}</small></label></div>
        <label v-else>Cover image <small>(optional)</small><input type="file" accept="image/jpeg,image/png,image/webp" @input="create.cover_upload = $event.target.files[0] || null"><small class="editorial-error">{{ create.errors.cover_upload }}</small></label>
        <SurveyQuestionEditor v-if="isSurvey" v-model="create.survey_questions" />
        <small v-if="create.errors.survey_questions" class="editorial-error">{{ create.errors.survey_questions }}</small>
        <label>{{ isSurvey ? 'Purpose & participation details' : 'Report content' }}<textarea v-model="create.body" rows="7" minlength="20" required :placeholder="isSurvey ? 'Explain who should respond, how long it takes, and how responses will be used.' : 'Present the findings, methodology, limitations, and sources.'"></textarea><small class="editorial-error">{{ create.errors.body }}</small></label>
        <div class="editorial-form-actions"><label>Publishing status<select v-model="create.status"><option value="draft">Save as draft</option><option value="published">Publish now</option></select></label><button class="button button-dark" :disabled="create.processing">{{ create.status === 'published' ? 'Publish' : 'Save draft' }} <UiIcon name="arrow-up-right" :size="13" /></button></div>
      </form>
    </section>

    <section class="admin-panel editorial-records">
      <div class="editorial-records-heading"><div><h2>{{ isSurvey ? 'Manage surveys' : 'Manage reports' }}</h2><p>{{ entries.total }} total · Edit details, control publication, or open the public page.</p></div><span class="admin-chip">{{ entries.total }} entries</span></div>
      <article v-for="entry in entries.data" :key="entry.id" class="editorial-record">
        <div class="editorial-record-summary"><div><span class="admin-chip" :class="`status-${entry.status}`">{{ entry.status }}</span><h3>{{ entry.title }}</h3><p>{{ entry.category || 'Uncategorized' }} · {{ publishedDate(entry) }}<template v-if="isSurvey"> · {{ entry.survey_responses_count || 0 }} responses</template></p></div><Link v-if="entry.status === 'published'" :href="publicEntry(entry)" target="_blank" class="admin-secondary">Preview <UiIcon name="arrow-up-right" :size="12" /></Link></div>
        <div v-if="isSurvey && entry.survey_responses_count" class="survey-results-summary"><strong>Response summary</strong><template v-for="question in entry.survey_questions || []" :key="question.id"><div v-if="surveyResults?.[entry.id]?.[question.id]" class="survey-result-question"><span>{{ question.prompt }}</span><div v-for="option in question.options" :key="option" class="survey-result-option"><span>{{ option }}</span><span>{{ surveyResults[entry.id][question.id][option] }} · {{ Math.round((surveyResults[entry.id][question.id][option] / entry.survey_responses_count) * 100) }}%</span></div></div><p v-else-if="question.type === 'text'" class="survey-private-answer-note">Written answers are stored anonymously and are not shown in this summary.</p></template></div>
        <details><summary>Edit {{ isSurvey ? 'survey' : 'report' }}</summary><form class="admin-form editorial-edit-form" @submit.prevent="save(entry)">
          <div class="admin-form-grid"><label>Title<input v-model="drafts[entry.id].title" required maxlength="180"></label><label>URL slug<input v-model="drafts[entry.id].slug" required maxlength="190"></label><label>Subject<input v-model="drafts[entry.id].category" maxlength="100"></label><label>Replace cover image<input type="file" accept="image/jpeg,image/png,image/webp" @input="drafts[entry.id].cover_upload = $event.target.files[0] || null"></label></div>
          <label>Short introduction<textarea v-model="drafts[entry.id].excerpt" rows="2" maxlength="500"></textarea></label>
          <label v-if="isSurvey">Secure survey form URL <small>(optional)</small><input v-model="drafts[entry.id].survey_url" type="url"></label>
          <SurveyQuestionEditor v-if="isSurvey" v-model="drafts[entry.id].survey_questions" />
          <label>{{ isSurvey ? 'Purpose & participation details' : 'Report content' }}<textarea v-model="drafts[entry.id].body" rows="6" minlength="20" required></textarea></label>
          <div class="editorial-form-actions"><label>Publishing status<select v-model="drafts[entry.id].status"><option value="draft">Draft</option><option value="published">Published</option></select></label><div><button class="button button-dark">Save changes</button><button type="button" class="editorial-delete" @click="remove(entry)">Delete</button></div></div>
        </form></details>
      </article>
      <div v-if="!entries.data.length" class="admin-empty">No {{ isSurvey ? 'surveys' : 'reports' }} yet. Create the first one above.</div>
      <div v-if="entries.last_page > 1" class="admin-pagination"><span>Page {{ entries.current_page }} of {{ entries.last_page }}</span><div><Link v-if="entries.prev_page_url" :href="manageIndex.url({ mergeQuery: { page: entries.current_page - 1 } })">← Newer</Link><Link v-if="entries.next_page_url" :href="manageIndex.url({ mergeQuery: { page: entries.current_page + 1 } })">Older →</Link></div></div>
    </section>
  </StaffAdminLayout>
</template>

<style scoped>
.editorial-admin-heading{align-items:flex-end}.editorial-admin-heading .button{display:inline-flex;align-items:center;gap:9px;white-space:nowrap}.editorial-create,.editorial-records{margin-bottom:18px}.editorial-panel-title,.editorial-records-heading{margin-bottom:20px}.editorial-panel-title h2,.editorial-records-heading h2{font:400 1.65rem Georgia,serif;margin:10px 0 6px}.editorial-panel-title p,.editorial-records-heading p{font-size:.84rem;line-height:1.6;color:var(--academy-muted);margin:0}.editorial-form-actions{display:flex;align-items:flex-end;justify-content:space-between;gap:15px}.editorial-form-actions>label{display:grid;gap:6px;font-size:.8rem;color:var(--academy-muted)}.editorial-form-actions select{min-width:160px;padding:10px;border:1px solid #e2e4dc;border-radius:5px;background:var(--academy-surface)}.editorial-form-actions>div{display:flex;align-items:center;gap:12px}.editorial-error{display:block;color:var(--academy-danger);font-size:.76rem}.editorial-records-heading{display:flex;align-items:center;justify-content:space-between;gap:15px}.editorial-record{border-top:1px solid #e8e9e2;padding:16px 0}.editorial-record-summary{display:flex;align-items:center;justify-content:space-between;gap:16px}.editorial-record-summary h3{font:400 1.2rem Georgia,serif;margin:8px 0 4px}.editorial-record-summary p{color:var(--academy-muted);font-size:.75rem;margin:0}.editorial-record-summary>.admin-secondary{display:inline-flex;align-items:center;gap:6px;flex:none}.editorial-record details{margin-top:14px}.editorial-record details>summary{cursor:pointer;color:var(--academy-secondary);font-size:.78rem;font-weight:600}.editorial-edit-form{margin-top:15px;padding:17px;background:var(--academy-paper);border-radius:7px}.editorial-delete{border:0;background:none;color:#9a4b44;padding:10px;cursor:pointer;font:inherit;font-size:.78rem}.editorial-records .admin-pagination{margin-top:12px}.editorial-records .admin-pagination a{color:var(--academy-primary)}@media(max-width:700px){.editorial-admin-heading{align-items:flex-start;flex-direction:column}.editorial-admin-heading .button{min-height:42px}.editorial-form-actions{align-items:stretch;flex-direction:column}.editorial-form-actions select{width:100%;min-height:42px}.editorial-form-actions>div{align-items:stretch;flex-direction:column}.editorial-form-actions>div .button{justify-content:center;min-height:42px}.editorial-record-summary{align-items:flex-start;flex-direction:column}}
.survey-results-summary{margin-top:14px;padding:14px;background:var(--academy-paper);border:1px solid #e8e9e2;border-radius:5px}.survey-results-summary>strong{display:block;margin-bottom:10px;font-size:.75rem;color:var(--academy-secondary)}.survey-result-question{display:grid;gap:7px;padding:10px 0;border-top:1px solid #e7e9e1}.survey-result-question>span{font-size:.74rem;font-weight:600;color:var(--academy-muted)}.survey-result-option{display:flex;justify-content:space-between;gap:12px;color:var(--academy-muted);font-size:.7rem}.survey-private-answer-note{margin:9px 0;color:var(--academy-muted);font-size:.68rem}
</style>
