<template>
    <div>
        <div v-if="errors.length" class="alert alert-danger">
            <ul>
                <li v-for="error in errors" :key="error">{{ error }}</li>
            </ul>
        </div>

        <form @submit.prevent="login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" v-model="form.email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" v-model="form.password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            errors: [],
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/login', this.form);
            } catch (error) {
                this.errors = error.response.data.errors;
            }
        },
    },
};
</script>
