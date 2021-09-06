<template>
    <div class="flex h-screen">
        <div class="w-4/12 ml-auto mr-auto mt-36">
            <h1 class="text-center mb-4 font-bold text-xl">{{ appName }}</h1>
            <div class="p-5 border-gray-100 login-container">
                <form @submit.prevent="login()">
                    <div class="vt-input mb-3" :class="{'vt-input-error': form.errors.email}">
                        <label for="email">Email</label>
                        <input id="email" type="email" placeholder="" v-model="form.email">
                        <span>{{ form.errors.email }}</span>
                    </div>
                    <div class="vt-input mb-3" :class="{'vt-input-error': form.errors.password}">
                        <label for="password">Password</label>
                        <input id="password" type="password" placeholder="" v-model="form.password">
                        <span>{{ form.errors.password }}</span>
                    </div>
                    <div class="flex justify-between">
                        <a class="mt-1" href="/recovery">Forgot your password?</a>
                        <button type="submit" :disabled="form.processing" class="vt-main-btn">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Auth',
    props: ['appName', 'errors'],
    data() {
        return {
            form: this.$inertia.form({
                email: null,
                password: null,
            }),
        }
    },
    methods: {
        login() {
            this.form.clearErrors();
            this.form.post('/login')
        }
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
