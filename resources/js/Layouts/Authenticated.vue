<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('salons.index')">
                                    <breeze-application-logo class="block h-9 w-auto" />
                                </inertia-link>
                            </div>

                            <!-- Navigation Links -->
                            <can permission="salons.index">
                                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <breeze-nav-link :href="route('salons.index')" :active="route().current('salons.index') || route().current('salons.show') || route().current('salons.create')">
                                        Салоны
                                    </breeze-nav-link>
                                </div>
                            </can>
                            <can permission="users.index">
                                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <breeze-nav-link :href="route('users.index')" :active="route().current('users.index') || route().current('users.show') || route().current('users.create')">
                                        Пользователи
                                    </breeze-nav-link>
                                </div>
                            </can>
                           <can permission="reports.index">
                               <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                   <breeze-nav-link :href="route('reports.index')" :active="route().current('reports.index') || route().current('reports.show') || route().current('reports.create')">
                                       Отчеты
                                   </breeze-nav-link>
                               </div>
                           </can>
                            <can permission="sources.index">
                                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <breeze-nav-link :href="route('sources.index')" :active="route().current('sources.index') || route().current('sources.show') || route().current('sources.create')">
                                        Источники
                                    </breeze-nav-link>
                                </div>
                            </can>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <breeze-dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <breeze-dropdown-link :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </breeze-dropdown-link>
                                    </template>
                                </breeze-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <breeze-responsive-nav-link :href="route('salons.index')" :active="route().current('salons.index')">
                            Салоны
                        </breeze-responsive-nav-link>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <breeze-responsive-nav-link :href="route('users.index')" :active="route().current('users.index')">
                            Пользователи
                        </breeze-responsive-nav-link>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <breeze-responsive-nav-link :href="route('reports.index')" :active="route().current('reports.index')">
                            Отчеты
                        </breeze-responsive-nav-link>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <breeze-responsive-nav-link :href="route('sources.index')" :active="route().current('sources.index')">
                            Источники
                        </breeze-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <breeze-responsive-nav-link :href="route('logout')" method="post" as="button">
                                Log Out
                            </breeze-responsive-nav-link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white  shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
            <main>
                <slot />
            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BreezeApplicationLogo from '@/Components/ApplicationLogo'
    import BreezeDropdown from '@/Components/Dropdown'
    import BreezeDropdownLink from '@/Components/DropdownLink'
    import BreezeNavLink from '@/Components/NavLink'
    import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink'
    import Can from "@/Components/Can";

    export default {
        components: {
            Can,
            BreezeApplicationLogo,
            BreezeDropdown,
            BreezeDropdownLink,
            BreezeNavLink,
            BreezeResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },
    }
</script>
