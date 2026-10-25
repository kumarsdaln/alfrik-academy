<script setup>
import { Link } from '@inertiajs/vue3';
import { index as notificationIndex, read as markRead, readAll, open as openNotification } from '../actions/App/Http/Controllers/NotificationController';

defineProps({
  notifications: { type: Object, required: true },
  unreadCount: { type: Number, default: 0 },
  counts: { type: Object, required: true },
  activeFilter: { type: String, default: 'all' },
});

function iconFor(category) {
  return ({ assignment: 'clipboard-list', session: 'calendar', event: 'ticket', payment: 'credit-card' })[category] || 'bell';
}

function when(date) {
  return date ? new Intl.DateTimeFormat(undefined, { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(date)) : '';
}
</script>

<template>
  <section class="notification-inbox">
    <header class="notification-inbox-heading">
      <div class="notification-heading-copy">
        <div class="notification-heading-kicker"><span class="eyebrow">YOUR UPDATES</span><span>{{ counts.all }} total</span></div>
        <div class="notification-heading-title"><h1>Notifications</h1><span v-if="unreadCount" class="notification-unread-summary"><i></i>{{ unreadCount }} unread</span><span v-else class="notification-unread-summary is-current"><UiIcon name="check-circle" :size="13" /> All caught up</span></div>
        <p>Class changes, assignment feedback, and important account updates.</p>
      </div>
      <Link v-if="unreadCount" :href="readAll().url" method="post" as="button" class="notification-read-all"><UiIcon name="check" :size="14" /> Mark all as read</Link>
    </header>
    <div class="notification-toolbar">
      <nav class="notification-filters" aria-label="Filter notifications">
        <Link v-for="tab in [{ key: 'all', label: 'All' }, { key: 'unread', label: 'Unread' }, { key: 'read', label: 'Read' }]" :key="tab.key" :href="notificationIndex({ query: { filter: tab.key } }).url" :class="{ active: activeFilter === tab.key }" :aria-current="activeFilter === tab.key ? 'page' : undefined">{{ tab.label }} <span>{{ counts[tab.key] }}</span></Link>
      </nav>
      <span class="notification-page-summary">{{ notifications.from || 0 }}–{{ notifications.to || 0 }} of {{ notifications.total }} shown <template v-if="notifications.last_page > 1">· page {{ notifications.current_page }} of {{ notifications.last_page }}</template></span>
    </div>
    <div v-if="notifications.data.length" class="notification-list">
      <article v-for="item in notifications.data" :key="item.id" class="notification-row" :class="{ 'is-unread': !item.readAt }">
        <span class="notification-icon"><UiIcon :name="iconFor(item.category)" :size="17" /></span>
        <div class="notification-copy">
          <div class="notification-title-line"><h2>{{ item.title }}</h2><span v-if="!item.readAt" class="notification-new">NEW</span></div>
          <p>{{ item.body }}</p>
          <time :datetime="item.createdAt">{{ when(item.createdAt) }}</time>
        </div>
        <div class="notification-actions">
          <Link v-if="item.url" :href="openNotification.url({ notification: item.id })" method="post" as="button" class="notification-open">Open <UiIcon name="arrow-up-right" :size="13" /></Link>
          <Link v-if="!item.readAt" :href="markRead.url({ notification: item.id })" method="post" as="button" class="notification-mark">Mark read</Link>
        </div>
      </article>
    </div>
    <div v-else class="notification-empty"><span><UiIcon :name="activeFilter === 'all' ? 'bell' : 'check-circle'" :size="21" /></span><h2>{{ activeFilter === 'unread' ? 'You’re all caught up.' : activeFilter === 'read' ? 'Nothing read yet.' : 'You’re all caught up.' }}</h2><p>{{ activeFilter === 'unread' ? 'There are no unread notifications right now.' : activeFilter === 'read' ? 'Notifications you’ve read will appear here.' : 'When something needs your attention, you’ll find it here.' }}</p></div>
    <nav v-if="notifications.links.length > 3" class="notification-pagination" aria-label="Notification pages">
      <Link v-for="(link, index) in notifications.links" :key="index" :href="link.url || '#'"><span v-html="link.label" /></Link>
    </nav>
  </section>
</template>

<style scoped>
.notification-inbox { width:100%; max-width:980px; margin:0 auto; color:#252a23; }
.notification-inbox-heading { display:flex; align-items:flex-end; justify-content:space-between; gap:24px; padding:0 0 25px; margin:0 0 20px; border-bottom:1px solid #e6e4dc; }
.notification-heading-copy { min-width:0; }
.notification-heading-kicker { display:flex; align-items:center; gap:12px; }
.notification-heading-kicker>span:last-child { color:#858a80; font-size:11px; }
.notification-heading-title { display:flex; align-items:center; gap:13px; flex-wrap:wrap; }
.notification-inbox-heading h1 { margin:10px 0 7px; color:#20251f; font:400 clamp(2.45rem,5vw,3.75rem)/1.04 var(--serif); letter-spacing:-.05em; }
.notification-unread-summary { display:inline-flex; align-items:center; gap:7px; padding:7px 10px; background:#edf2e9; color:#40583d; font-size:11px; font-weight:650; }
.notification-unread-summary i { width:7px; height:7px; background:#617b59; }
.notification-unread-summary.is-current { background:#f0f1ed; color:#6c7468; }
.notification-inbox-heading p { max-width:560px; margin:0; color:#747970; font-size:13px; line-height:1.6; }
.notification-read-all { display:inline-flex; min-height:42px; align-items:center; justify-content:center; gap:8px; padding:0 14px; border:1px solid #dfe2d8; background:#fff; color:#40583d; font-size:11px; font-weight:650; cursor:pointer; white-space:nowrap; transition:background .16s,border-color .16s; }
.notification-read-all:hover { border-color:#9da995; background:#f4f6f1; }
.notification-toolbar { display:flex; align-items:center; justify-content:space-between; gap:14px; margin:0 0 13px; }
.notification-filters { display:flex; align-items:center; gap:5px; }
.notification-filters a { display:inline-flex; min-height:38px; align-items:center; gap:8px; padding:0 12px; border:0; border-bottom:2px solid transparent; background:transparent; color:#73796f; font-size:12px; text-decoration:none; cursor:pointer; }
.notification-filters a.active { border-bottom-color:#40583d; color:#30452e; font-weight:650; }
.notification-filters a>span { color:#898f84; font-size:10px; }
.notification-page-summary { color:#858a80; font-size:11px; white-space:nowrap; }
.notification-list { display:grid; gap:10px; }
.notification-row { display:grid; grid-template-columns:42px minmax(0,1fr) auto; align-items:start; gap:15px; padding:19px 20px; border:1px solid #e5e3dc; background:#fff; transition:border-color .16s,background .16s; }
.notification-row.is-unread { border-left:3px solid #6c815f; padding-left:18px; background:#fbfcf9; }
.notification-icon { display:grid; width:40px; height:40px; flex:none; place-items:center; background:#f1f3ed; color:#52664f; }
.is-unread .notification-icon { background:#e8eee3; }
.notification-copy { min-width:0; }
.notification-title-line { display:flex; align-items:center; gap:9px; }
.notification-copy h2 { margin:0; color:#30382f; font:600 15px/1.4 var(--sans); letter-spacing:-.015em; }
.notification-new { padding:3px 6px; background:#edf2e9; color:#506448; font-size:9px; font-weight:700; letter-spacing:.06em; }
.notification-copy p { margin:6px 0 9px; color:#70776d; font-size:13px; line-height:1.55; }
.notification-copy time { color:#858a80; font-size:11px; }
.notification-actions { display:flex; align-items:flex-end; flex-direction:column; gap:10px; padding-top:2px; }
.notification-open,.notification-mark { display:inline-flex; min-height:30px; align-items:center; gap:5px; border:0; background:none; color:#40583d; font-size:11px; font-weight:650; cursor:pointer; white-space:nowrap; }
.notification-mark { min-height:24px; color:#73796f; font-size:10px; }
.notification-open:hover,.notification-mark:hover { color:#263a26; text-decoration:underline; text-underline-offset:3px; }
.notification-empty { display:grid; justify-items:center; padding:64px 20px; border:1px solid #e5e3dc; background:#fff; text-align:center; }
.notification-empty>span { display:grid; width:48px; height:48px; place-items:center; background:#f1f3ed; color:#52664f; }
.notification-empty h2 { margin:16px 0 5px; color:#30382f; font:400 26px/1.2 var(--serif); }
.notification-empty p { max-width:390px; margin:0; color:#747970; font-size:13px; line-height:1.55; }
.notification-pagination { display:flex; justify-content:center; gap:6px; margin:24px 0; }
.notification-pagination :deep(a) { padding:9px 12px; border:1px solid #e5e3dc; background:#fff; color:#465840; font-size:11px; }
.notification-pagination :deep(a[disabled]) { opacity:.5; }
:global(html.theme-dark) .notification-inbox { color:#e8ebe4; }
:global(html.theme-dark) .notification-inbox-heading { border-color:#383c35; }
:global(html.theme-dark) .notification-heading-kicker>span:last-child,
:global(html.theme-dark) .notification-inbox-heading p,
:global(html.theme-dark) .notification-page-summary,
:global(html.theme-dark) .notification-copy time { color:#a9afa4; }
:global(html.theme-dark) .notification-inbox-heading h1,
:global(html.theme-dark) .notification-copy h2,
:global(html.theme-dark) .notification-empty h2 { color:#f0f1eb; }
:global(html.theme-dark) .notification-unread-summary { background:#2f3a2d; color:#d7e3d0; }
:global(html.theme-dark) .notification-unread-summary.is-current { background:#30352e; color:#c2c8bd; }
:global(html.theme-dark) .notification-read-all,
:global(html.theme-dark) .notification-row,
:global(html.theme-dark) .notification-empty,
:global(html.theme-dark) .notification-pagination :deep(a) { border-color:#3b4339; background:#20251f; color:#d7e3d0; }
:global(html.theme-dark) .notification-read-all:hover { background:#2b3429; border-color:#586653; }
:global(html.theme-dark) .notification-filters a { color:#b9c0b4; }
:global(html.theme-dark) .notification-filters a.active { border-bottom-color:#a3b594; color:#e0e8d9; }
:global(html.theme-dark) .notification-filters a>span { color:#9da597; }
:global(html.theme-dark) .notification-row.is-unread { border-color:#485441; border-left-color:#9caf8b; background:#252c24; }
:global(html.theme-dark) .notification-icon,
:global(html.theme-dark) .notification-empty>span { background:#30392e; color:#cbd9c3; }
:global(html.theme-dark) .is-unread .notification-icon { background:#3a4735; }
:global(html.theme-dark) .notification-new { background:#35422f; color:#d7e3d0; }
:global(html.theme-dark) .notification-copy p,
:global(html.theme-dark) .notification-empty p { color:#b1b8ac; }
:global(html.theme-dark) .notification-open { color:#c6d7bd; }
:global(html.theme-dark) .notification-mark { color:#aeb6a9; }
:global(html.theme-dark) .notification-open:hover,
:global(html.theme-dark) .notification-mark:hover { color:#f0f1eb; }
@media(max-width:680px) {
  .notification-inbox-heading { align-items:flex-start; flex-direction:column; gap:15px; padding-bottom:19px; margin-bottom:15px; }
  .notification-inbox-heading h1 { font-size:2.55rem; }
  .notification-inbox-heading p { font-size:12px; }
  .notification-read-all { width:100%; }
  .notification-toolbar { align-items:flex-start; flex-direction:column; gap:7px; }
  .notification-filters { width:100%; overflow-x:auto; scrollbar-width:none; }
  .notification-filters::-webkit-scrollbar { display:none; }
  .notification-filters a { flex:none; padding:0 10px; }
  .notification-page-summary { align-self:flex-end; }
  .notification-row { grid-template-columns:36px minmax(0,1fr); gap:10px 12px; padding:14px; }
  .notification-row.is-unread { padding-left:12px; }
  .notification-icon { width:36px; height:36px; }
  .notification-copy h2 { font-size:14px; }
  .notification-copy p { font-size:12px; }
  .notification-actions { grid-column:2; align-items:center; flex-direction:row; gap:14px; padding:0; }
  .notification-open,.notification-mark { min-height:32px; }
  .notification-empty { padding:48px 18px; }
}
</style>
