<template>
    <div>
        <HeaderTemplate :isLogin=true />
        <div class="container mx-auto">
            <div class="text-center mt-8">
                <h1 class="text-2xl font-bold mb-4">Login</h1>
                <p class="text-gray-600 mb-8">
                    Please enter your email and password to login.
                </p>
            </div>
            <Form @submit="submitForm" class="flex flex-col items-center">
                <label for="email" class="mb-2">Email:</label>
                <Field
                    v-model="email"
                    name="email"
                    id="email"
                    as="input"
                    rules="required|email"
                    type="email"
                    class="px-4 py-2 mb-4 border border-gray-300 rounded w-full max-w-sm"
                />
                <ErrorMessage name="email" as="p" />
    
                <label for="password" class="mb-2">Password:</label>
                <Field
                    v-model="password"
                    name="password"
                    id="password"
                    as="input"
                    rules="required|password"
                    type="password"
                    class="px-4 py-2 mb-4 border border-gray-300 rounded w-full max-w-sm"
                />
                <ErrorMessage name="password" as="p" />
    
                <div class="flex items-center">
                    <label for="remember" class="mr-2">Remember me</label>
                    <input
                        v-model="remember"
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="form-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded"
                    />
                </div>
    
                <button
                    type="submit"
                    class="px-4 mt-1 py-2 bg-gray-800 text-white rounded"
                >
                    Login
                </button>
            </Form>
        </div>
        <FooterTemplate />
    </div>
</template>

<script>
import HeaderTemplate from "../templates/HeaderTemplate.vue";
import FooterTemplate from "../templates/FooterTemplate.vue";
import { Form, Field, ErrorMessage } from "vee-validate";
import axios from "axios";
import Swal from "sweetalert2";
import "../validationRules";
import { getToken } from "../getToken";

export default {
    props: {
        authenticated: {type: Boolean, required:true},
        user: {type:Object}
    },
    created() {
        console.log(this.authenticated);
        if (this.authenticated) {
            this.$router.push("/dashboard");
        }
    },
    name: "LoginView",
    components: {
        Form,
        Field,
        ErrorMessage,
        HeaderTemplate,
        FooterTemplate
    },
    data() {
        return {
            email: "",
            password: "",
            remember: false,
        };
    },
    methods: {
        async submitForm(values) {
            await getToken();
            await axios
                .post("/login", {
                    email: values.email,
                    password: values.password,
                    remember: values.remember,
                })
                .then((response) => {
                    if (response.status == 204) {
                        Swal.fire({
                            icon: "success",
                            title: "Login Successful",
                            text: "You have successfully logged in.",
                        }).then(() => {
                            this.$router.go("/dashboard");
                        });
                    }
                })
                .catch((error) => {
                    if (error.response.status == 422 && error.response) {
                        Swal.fire({
                            icon: "error",
                            title: "Ooops... Login Failed",
                            text: "These credentials do not match our records.",
                        });
                    } else {
                        axios.post("/api/error-logger", {
                            error: error.response ? error.response : error,
                            page: "Login Form",
                        });
                        Swal.fire({
                            icon: "error",
                            title: "Ooops... Login Failed",
                            text: "Something wrong has happened, please try again later",
                        });
                    }
                });
        },
    },
};
</script>
