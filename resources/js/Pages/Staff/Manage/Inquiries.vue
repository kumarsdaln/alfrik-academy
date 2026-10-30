<script setup>
import { updateInquiry as wayfinderUpdateInquiry1 } from './../../../actions/App/Http/Controllers/Staff/AdminOperationsController';

import { inquiries as inquiriesRoute } from '../../../actions/App/Http/Controllers/Staff/AdminOperationsController';
import { router } from '@inertiajs/vue3';
import StaffAdminLayout from '../../../Layouts/StaffAdminLayout.vue';

defineProps({ inquiries: Object });
function setStatus(item, status) { router.patch(wayfinderUpdateInquiry1.url({ inquiryId: item.id }), { status }, { preserveScroll: true }); }
</script>

<template><StaffAdminLayout><div class="admin-heading"><div><div class="eyebrow">PUBLIC WEBSITE</div><h1>Contact inbox.</h1><p>Keep public inquiries visible, assign a follow-up state, and close the loop with prospective learners and partners.</p></div></div><section class="admin-panel"><article v-for="item in inquiries.data" :key="item.id" class="inquiry-card"><div class="inquiry-meta"><span class="admin-chip">{{ item.topic }}</span><small>{{ new Date(item.created_at).toLocaleString() }}</small><select :value="item.status" aria-label="Inquiry status" @change="setStatus(item, $event.target.value)"><option value="new">New</option><option value="in_progress">In progress</option><option value="resolved">Resolved</option></select></div><h2>{{ item.name }}</h2><a :href="`mailto:${item.email}`">{{ item.email }}</a><p>{{ item.message }}</p></article><div v-if="!inquiries.data.length" class="admin-empty">No public contact requests yet.</div><div class="admin-pagination"><span>Page {{ inquiries.current_page }} of {{ inquiries.last_page }}</span><div><a v-if="inquiries.prev_page_url"  :href="inquiriesRoute.url({mergeQuery: {page: inquiries.current_page - 1}})">← Newer</a><a v-if="inquiries.next_page_url"  :href="inquiriesRoute.url({mergeQuery: {page: inquiries.current_page + 1}})">Older →</a></div></div></section></StaffAdminLayout></template>

<style scoped>.inquiry-card{border-bottom:1px solid #efeee9;padding:18px 2px}.inquiry-meta{display:flex;align-items:center;gap:12px}.inquiry-meta small{color:var(--academy-muted);flex:1}.inquiry-meta select{padding:7px 9px;border:1px solid #e2e1da;border-radius:6px;background:white;font-size:11px}.inquiry-card h2{font:400 1.25rem var(--serif,Georgia,serif);margin:12px 0 3px}.inquiry-card>a{color:var(--academy-secondary);font-size:12px}.inquiry-card p{color:var(--academy-muted);white-space:pre-line;line-height:1.7;margin-bottom:0}.admin-pagination{display:flex;justify-content:space-between;font-size:11px;color:var(--academy-muted);padding-top:15px}.admin-pagination div{display:flex;gap:14px}.admin-pagination a{color:var(--academy-secondary)}</style>
