<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div class="flex h-screen">
            <div class="w-4/12 ml-auto mr-auto mt-36">
                <h1 class="text-center mb-4 font-bold text-xl">HOME</h1>
                <div class="p-5 border-gray-100 login-container">
                    HOME!
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
export default {
    name: 'Home',
    components: {AppLayout},
    component: {
        AppLayout
    }
}
</script>
<style scoped>
    .login-container {
        background-color: var(--vt-grey-10);
        box-shadow: var(--vt-shadow-low);
        border-radius: var(--vt-radius-deafult);
    }
</style>
