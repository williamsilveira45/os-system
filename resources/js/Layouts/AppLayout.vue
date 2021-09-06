<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <Link href="/home">
                                Dashboard
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <Link href="/home">
                                Dashboard
                            </Link>
                            <Link href="/test1">
                                Test1
                            </Link>
                            <Link href="/test2">
                                Test2
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <p>AAASDASDASDAS</p>
        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header"></slot>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue'

    export default {
        components: {
            Link
        },
        data() {
            return {
                showingNavigationDropdown: false,
            }
        },
        methods: {

        }
    }
</script>
