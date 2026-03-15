<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { IconLogout, IconSearch, IconSettings } from '@tabler/icons-vue';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import BreadcrumbsBar from '@/Components/BreadcrumbsBar.vue';
import FlashNotifications from '@/Components/FlashNotifications.vue';
import LocaleSwitcher from '@/Components/LocaleSwitcher.vue';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import UserAvatar from '@/Components/UserAvatar.vue';
import { useAppName } from '@/Composables/useAppName';
import { useSidebarState } from '@/Composables/useSidebarState';
import { useTranslations } from '@/Composables/useTranslations';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    activeModule: {
        type: String,
        default: null,
    },
    moduleNavigation: {
        type: Array,
        default: () => [],
    },
});

const { t } = useTranslations();
const appName = useAppName();
const { sidebarCollapsed, toggleSidebarCollapsed } = useSidebarState();
const mobileSidebarOpen = ref(false);
const userMenuOpen = ref(false);
const currentYear = new Date().getFullYear();
const hasProfileRoute = computed(() => route().has('profile.show'));

const moduleNavigationItems = computed(() =>
    [
        {
            key: 'debtors',
            label: t('nav.debtors'),
            href: route('debtors.view'),
            icon: IconSearch,
            active: props.activeModule === 'debtors' || route().current('debtors.view'),
            visible: true,
        },
    ].filter((item) => item.visible)
);

const topNavigation = computed(() =>
    props.moduleNavigation.map((item) => ({
        ...item,
        active: Boolean(item.active),
    }))
);

const sideNavigation = computed(() => moduleNavigationItems.value);

const toggleSidebar = () => {
    if (typeof window !== 'undefined' && window.matchMedia('(min-width: 1024px)').matches) {
        toggleSidebarCollapsed();

        return;
    }

    mobileSidebarOpen.value = !mobileSidebarOpen.value;
};

const closeMobileSidebar = () => {
    mobileSidebarOpen.value = false;
};

const toggleUserMenu = () => {
    userMenuOpen.value = !userMenuOpen.value;
};

const closeUserMenu = () => {
    userMenuOpen.value = false;
};

const handleDocumentClick = (event) => {
    if (!(event.target instanceof HTMLElement)) {
        return;
    }

    if (!event.target.closest('[data-user-menu]')) {
        closeUserMenu();
    }
};

const logout = () => {
    closeUserMenu();
    router.post(route('logout'));
};

onMounted(() => {
    document.addEventListener('click', handleDocumentClick);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleDocumentClick);
});
</script>

<template>
    <Head :title="props.title" />

    <div class="min-h-screen bg-[color:var(--ui-app-bg)] text-[color:var(--ui-text)]">
        <FlashNotifications />

        <div class="flex min-h-screen">
            <aside
                class="hidden overflow-x-hidden border-r border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] transition-[width] duration-300 ease-out lg:flex lg:flex-col"
                :class="sidebarCollapsed ? 'lg:w-20' : 'lg:w-72'"
            >
                <div class="border-b border-[color:var(--ui-border)] px-3 py-4">
                    <button
                        type="button"
                        class="flex w-full items-center rounded-xl px-2 py-2 text-left transition hover:bg-[color:var(--ui-surface-muted)]"
                        :title="sidebarCollapsed ? appName : undefined"
                        @click="toggleSidebar"
                    >
                        <div
                            class="flex shrink-0 items-center justify-center transition-[width] duration-300 ease-out"
                            :class="sidebarCollapsed ? 'w-full' : 'w-10'"
                        >
                            <ApplicationMark
                                class="h-10 w-10 shrink-0 transition-transform duration-300 ease-out"
                            />
                        </div>

                        <div
                            class="min-w-0 overflow-hidden transition-[max-width,opacity,margin] duration-200 ease-out"
                            :class="
                                sidebarCollapsed
                                    ? 'ml-0 max-w-0 opacity-0'
                                    : 'ml-3 max-w-40 opacity-100'
                            "
                        >
                            <p class="truncate font-semibold text-[color:var(--ui-text)]">
                                {{ appName }}
                            </p>
                        </div>
                    </button>
                </div>

                <div class="flex-1 px-3 py-4">
                    <nav class="space-y-2">
                        <Link
                            v-for="item in sideNavigation"
                            :key="item.key"
                            :href="item.href"
                            :title="sidebarCollapsed ? item.label : undefined"
                            class="group relative flex items-center rounded-xl px-3 py-3 text-sm font-medium transition"
                            :class="[
                                item.active
                                    ? 'bg-[color:var(--ui-accent)] text-[color:var(--ui-accent-contrast)]'
                                    : 'text-[color:var(--ui-text-soft)] hover:bg-[color:var(--ui-surface-muted)] hover:text-[color:var(--ui-text)]',
                            ]"
                        >
                            <div
                                class="flex shrink-0 items-center justify-center transition-[width] duration-300 ease-out"
                                :class="sidebarCollapsed ? 'w-full' : 'w-5'"
                            >
                                <component
                                    :is="item.icon"
                                    class="h-5 w-5 shrink-0 transition-transform duration-200 ease-out group-hover:scale-105"
                                />
                            </div>

                            <span
                                class="overflow-hidden whitespace-nowrap transition-[max-width,opacity,margin] duration-200 ease-out"
                                :class="
                                    sidebarCollapsed
                                        ? 'ml-0 max-w-0 opacity-0'
                                        : 'ml-3 max-w-40 opacity-100'
                                "
                            >
                                {{ item.label }}
                            </span>

                            <span
                                v-if="sidebarCollapsed"
                                class="pointer-events-none absolute left-full top-1/2 z-20 ml-3 -translate-y-1/2 whitespace-nowrap rounded-lg border border-[color:var(--ui-border-strong)] bg-[color:var(--ui-surface)] px-2 py-1 text-xs text-[color:var(--ui-text)] opacity-0 shadow-lg transition duration-150 ease-out group-hover:opacity-100"
                            >
                                {{ item.label }}
                            </span>
                        </Link>
                    </nav>
                </div>
            </aside>

            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="mobileSidebarOpen"
                    class="fixed inset-0 z-40 bg-black/60 lg:hidden"
                    @click="closeMobileSidebar"
                />
            </Transition>

            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="-translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="translate-x-0"
                leave-to-class="-translate-x-full"
            >
                <aside
                    v-if="mobileSidebarOpen"
                    class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] lg:hidden"
                >
                    <div class="border-b border-[color:var(--ui-border)] px-4 py-4">
                        <button
                            type="button"
                            class="inline-flex items-center gap-3 rounded-xl px-2 py-2 text-left"
                            @click="closeMobileSidebar"
                        >
                            <ApplicationMark class="h-9 w-9 shrink-0" />
                            <div>
                                <p class="font-semibold text-[color:var(--ui-text)]">
                                    {{ appName }}
                                </p>
                            </div>
                        </button>
                    </div>

                    <nav class="flex-1 space-y-2 px-3 py-4">
                        <Link
                            v-for="item in sideNavigation"
                            :key="item.key"
                            :href="item.href"
                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium transition"
                            :class="
                                item.active
                                    ? 'bg-[color:var(--ui-accent)] text-[color:var(--ui-accent-contrast)]'
                                    : 'text-[color:var(--ui-text-soft)] hover:bg-[color:var(--ui-surface-muted)] hover:text-[color:var(--ui-text)]'
                            "
                            @click="closeMobileSidebar"
                        >
                            <component :is="item.icon" class="h-5 w-5 shrink-0" />
                            <span>{{ item.label }}</span>
                        </Link>
                    </nav>
                </aside>
            </Transition>

            <div class="flex min-h-screen min-w-0 flex-1 flex-col">
                <header
                    class="border-b border-[color:var(--ui-border)] bg-[color:var(--ui-surface)]"
                >
                    <div
                        class="flex min-h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8"
                    >
                        <div class="flex min-w-0 items-center gap-4">
                            <button
                                type="button"
                                class="inline-flex items-center gap-3 rounded-xl px-2 py-2 text-left transition hover:bg-[color:var(--ui-surface-muted)] lg:hidden"
                                @click="toggleSidebar"
                            >
                                <ApplicationMark class="h-9 w-9 shrink-0" />
                            </button>

                            <nav class="hidden items-center gap-1 md:flex">
                                <Link
                                    v-for="item in topNavigation"
                                    :key="item.key"
                                    :href="item.href"
                                    class="rounded-lg px-3 py-2 text-sm font-medium transition"
                                    :class="
                                        item.active
                                            ? 'bg-[color:var(--ui-surface-muted)] text-[color:var(--ui-text)]'
                                            : 'text-[color:var(--ui-text-soft)] hover:bg-[color:var(--ui-surface-muted)] hover:text-[color:var(--ui-text)]'
                                    "
                                >
                                    {{ item.label }}
                                </Link>
                            </nav>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="hidden items-center gap-3 sm:flex">
                                <LocaleSwitcher />
                                <ThemeSwitcher />
                            </div>

                            <div class="relative" data-user-menu>
                                <button
                                    type="button"
                                    class="group inline-flex items-center justify-center rounded-2xl text-sm text-[color:var(--ui-text)] transition"
                                    @click.stop="toggleUserMenu"
                                >
                                    <UserAvatar
                                        :user="$page.props.auth.user"
                                        size="nav"
                                        interactive
                                    />
                                </button>

                                <Transition name="shell-dropdown">
                                    <div
                                        v-if="userMenuOpen"
                                        class="absolute right-0 z-30 mt-2 w-56 rounded-xl border border-[color:var(--ui-border-strong)] bg-[color:var(--ui-surface)] p-2 shadow-xl"
                                    >
                                        <div class="rounded-lg px-3 py-2">
                                            <p
                                                class="truncate text-sm font-semibold text-[color:var(--ui-text)]"
                                            >
                                                {{ $page.props.auth.user.name }}
                                            </p>
                                            <p
                                                class="truncate text-xs text-[color:var(--ui-text-muted)]"
                                            >
                                                {{ $page.props.auth.user.email }}
                                            </p>
                                        </div>

                                        <div
                                            class="my-2 border-t border-[color:var(--ui-border)]"
                                        />

                                        <Link
                                            v-if="hasProfileRoute"
                                            :href="route('profile.show')"
                                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-[color:var(--ui-text-soft)] transition hover:bg-[color:var(--ui-surface-muted)] hover:text-[color:var(--ui-text)]"
                                            @click="closeUserMenu"
                                        >
                                            <IconSettings class="h-4 w-4" />
                                            <span>{{ $t('nav.profile') }}</span>
                                        </Link>

                                        <button
                                            type="button"
                                            class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-left text-sm text-red-300 transition hover:bg-red-500/10"
                                            @click="logout"
                                        >
                                            <IconLogout class="h-4 w-4" />
                                            <span>{{ $t('nav.logout') }}</span>
                                        </button>
                                    </div>
                                </Transition>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-[color:var(--ui-border)] px-4 py-3 sm:hidden">
                        <div class="flex flex-wrap gap-3">
                            <LocaleSwitcher />
                            <ThemeSwitcher />
                        </div>
                    </div>
                </header>

                <main class="min-h-0 flex-1 px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
                    <BreadcrumbsBar />

                    <div
                        class="flex flex-col rounded-xl border border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] p-4 sm:p-6"
                    >
                        <slot name="header" />
                        <slot />
                    </div>
                </main>

                <footer
                    class="border-t border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] px-4 py-3 text-xs text-[color:var(--ui-text-muted)] sm:px-6 lg:px-8"
                >
                    <div class="flex justify-end">
                        <p>{{ $t('app.footer.copyright', { year: currentYear }) }}</p>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>
