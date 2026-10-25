<script setup>
import StaffAdminLayout from '../../../Layouts/StaffAdminLayout.vue';

defineProps({ events: { type: Object, required: true } });

function formatDate(value) {
  return new Intl.DateTimeFormat(undefined, { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(value));
}

function readableAction(action) {
  return action.replace(/^staff\./, '').replaceAll('.', ' · ').replaceAll('_', ' ');
}
</script>

<template>
  <StaffAdminLayout>
    <div class="admin-heading"><div><div class="eyebrow">SECURITY & GOVERNANCE</div><h1>Audit history.</h1><p>Review successful changes made by staff. Form values and sensitive credentials are never stored here.</p></div></div>
    <section class="admin-panel audit-panel">
      <div class="audit-list-head"><div><h2>Staff activity</h2><span>{{ events.total }} recorded changes</span></div><small>Newest first</small></div>
      <div v-if="events.data.length" class="audit-list">
        <article v-for="event in events.data" :key="event.id" class="audit-entry">
          <span class="audit-entry-mark"><UiIcon name="activity" :size="15" /></span>
          <div class="audit-entry-copy"><b>{{ readableAction(event.action) }}</b><small>{{ event.actor?.name || 'Former staff account' }} · {{ event.actor?.email || 'account removed' }}</small><span v-if="event.context?.route_parameters && Object.keys(event.context.route_parameters).length" class="audit-params">Records: {{ Object.entries(event.context.route_parameters).map(([key, value]) => `${key} ${value}`).join(' · ') }}</span><span v-if="event.context?.changed_fields?.length" class="audit-fields">Fields: {{ event.context.changed_fields.join(', ') }}</span></div>
          <time :datetime="event.created_at">{{ formatDate(event.created_at) }}</time>
        </article>
      </div>
      <div v-else class="admin-empty">Staff changes will appear here as they happen.</div>
      <div v-if="events.last_page > 1" class="admin-pagination"><span>Page {{ events.current_page }} of {{ events.last_page }}</span><div><a v-if="events.prev_page_url" :href="events.prev_page_url">Newer</a><a v-if="events.next_page_url" :href="events.next_page_url">Older</a></div></div>
    </section>
  </StaffAdminLayout>
</template>

<style scoped>
.audit-panel{padding:22px}.audit-list-head{display:flex;align-items:flex-end;justify-content:space-between;padding-bottom:15px;border-bottom:1px solid #ebe9e2}.audit-list-head h2{margin:0 0 5px;font:500 22px var(--serif)}.audit-list-head span,.audit-list-head>small{font-size:10px;color:#85847d}.audit-list{display:grid}.audit-entry{display:flex;align-items:flex-start;gap:13px;padding:15px 0;border-bottom:1px solid #f0eee9}.audit-entry-mark{display:grid;place-items:center;flex:none;width:32px;height:32px;border-radius:50%;background:#f4f6f1;color:#52664f}.audit-entry-copy{display:grid;gap:4px;flex:1;min-width:0}.audit-entry-copy>b{font-size:12px;text-transform:capitalize;color:#383831}.audit-entry-copy>small,.audit-params,.audit-fields{font-size:9px;color:#85847d;overflow-wrap:anywhere}.audit-entry time{font-size:9px;color:#85847d;white-space:nowrap}.audit-fields{color:#637656}.admin-pagination{display:flex;justify-content:space-between;padding-top:16px;font-size:10px}.admin-pagination div{display:flex;gap:15px;color:#52664f}.theme-dark .audit-list-head,.theme-dark .audit-entry{border-color:#383c35}.theme-dark .audit-entry-copy>b{color:#f0f0ea}
@media(max-width:600px){.audit-panel{padding:15px}.audit-entry{display:grid;grid-template-columns:32px minmax(0,1fr)}.audit-entry time{grid-column:2}.audit-list-head h2{font-size:19px}}
</style>
