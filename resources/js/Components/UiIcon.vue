<script setup>
import {
  Activity,
  ArrowLeft,
  ArrowRight,
  ArrowUp,
  ArrowUpRight,
  BarChart3,
  Bell,
  Briefcase,
  BookOpen,
  CalendarDays,
  CalendarPlus,
  Check,
  CheckCircle2,
  CircleDot,
  CircleHelp,
  ClipboardList,
  ChevronLeft,
  ChevronRight,
  Clock,
  Command,
  Copy,
  CreditCard,
  Ellipsis,
  ExternalLink,
  FileText,
  Flame,
  Heart,
  LayoutDashboard,
  LockKeyhole,
  Mail,
  Megaphone,
  MessageCircle,
  Menu,
  Moon,
  Play,
  Plus,
  Search,
  Share2,
  Settings,
  Sparkles,
  Star,
  Sun,
  Users,
  X,
} from '@lucide/vue';

const props = defineProps({
  name: { type: String, required: true },
  size: { type: [Number, String], default: 14 },
  strokeWidth: { type: [Number, String], default: 1.8 },
});

const icons = {
  'arrow-left': ArrowLeft,
  'arrow-right': ArrowRight,
  'arrow-up': ArrowUp,
  'arrow-up-right': ArrowUpRight,
  activity: Activity,
  'bar-chart': BarChart3,
  bell: Bell,
  'book-open': BookOpen,
  briefcase: Briefcase,
  calendar: CalendarDays,
  'calendar-plus': CalendarPlus,
  check: Check,
  'check-circle': CheckCircle2,
  'chevron-left': ChevronLeft,
  'chevron-right': ChevronRight,
  'circle-dot': CircleDot,
  help: CircleHelp,
  'clipboard-list': ClipboardList,
  clock: Clock,
  command: Command,
  copy: Copy,
  'credit-card': CreditCard,
  ellipsis: Ellipsis,
  'external-link': ExternalLink,
  'file-text': FileText,
  flame: Flame,
  heart: Heart,
  dashboard: LayoutDashboard,
  layout: LayoutDashboard,
  'lock-keyhole': LockKeyhole,
  mail: Mail,
  'message-circle': MessageCircle,
  megaphone: Megaphone,
  menu: Menu,
  moon: Moon,
  play: Play,
  plus: Plus,
  search: Search,
  share: Share2,
  settings: Settings,
  sparkles: Sparkles,
  star: Star,
  sun: Sun,
  users: Users,
  close: X,
};
</script>

<template>
  <component
    :is="icons[props.name]"
    v-if="icons[props.name]"
    class="ui-icon"
    :size="props.size"
    :stroke-width="props.strokeWidth"
    aria-hidden="true"
    focusable="false"
  />
</template>
