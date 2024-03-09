<template>
    <div>
        <HeaderTemplate :isRegister=true />
        <div class="container mx-auto">
            <div class="text-center mt-8">
                <h1 class="text-2xl font-bold mb-4">Registration</h1>
                <p class="text-gray-600 mb-8">
                    Please enter your name, username or email, password, and phone
                    number to register.
                </p>
            </div>
            <Form
                @submit="submitRegistrationForm"
                class="flex flex-col items-center"
            >
                <label for="name" class="mb-2">Name:</label>
                <Field
                    v-model="form.name"
                    name="name"
                    id="name"
                    as="input"
                    rules="required"
                    type="text"
                    class="px-4 py-2 mb-4 border border-gray-300 rounded w-full max-w-sm"
                />
                <ErrorMessage name="name" as="p" />
        
                <label for="username" class="mb-2">Username:</label>
                <Field
                    v-model="form.username"
                    name="username"
                    id="username"
                    as="input"
                    rules="required|username"
                    type="text"
                    class="px-4 py-2 mb-4 border border-gray-300 rounded w-full max-w-sm"
                />
                <ErrorMessage name="username" as="p" />
        
                <label for="email" class="mb-2">Email:</label>
                <Field
                    v-model="form.email"
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
                    v-model="form.password"
                    name="password"
                    id="password"
                    as="input"
                    rules="required|password"
                    type="password"
                    class="px-4 py-2 mb-4 border border-gray-300 rounded w-full max-w-sm"
                />
                <ErrorMessage name="password" as="p" />
        
                <label for="passwordConfirmation" class="mb-2"
                    >Confirm Password:</label
                >
                <Field
                    v-model="form.passwordConfirmation"
                    name="passwordConfirmation"
                    id="passwordConfirmation"
                    as="input"
                    rules="required"
                    type="password"
                    class="px-4 py-2 mb-4 border border-gray-300 rounded w-full max-w-sm"
                />
                <ErrorMessage name="passwordConfirmation" as="p" />
        
                <label for="phone" class="mb-2">Phone Number:</label>
                <Field
                    v-model="form.phone"
                    name="phone"
                    id="phone"
                    as="input"
                    rules="required|phoneFormat"
                    type="text"
                    class="px-4 py-2 mb-4 border border-gray-300 rounded w-full max-w-sm"
                />
                <ErrorMessage name="phone" as="p" />
        
                <button
                    type="submit"
                    class="px-4 mt-1 py-2 bg-gray-800 text-white rounded"
                >
                    Register
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
    name: "RegisterView",
    components: {
        Form,
        Field,
        ErrorMessage,
        HeaderTemplate,
        FooterTemplate
    },
    data() {
        return {
            isRegister: true,
            form: {
                name: "",
                username: "",
                email: "",
                password: "",
                passwordConfirmation: "",
                phone: "",
            },
        };
    },
    methods: {
        async submitRegistrationForm(values) {
            await getToken();
            await axios
                .post("/register", {
                    name: values.name,
                    username: values.username,
                    email: values.email,
                    password: values.password,
                    password_confirmation: values.passwordConfirmation,
                    phone: values.phone,
                })
                .then((response) => {
                    if (response.status == 204) {
                        Swal.fire({
                            icon: "success",
                            title: "Registration Successful",
                            text: "You have successfully registered. Now you will be redirected to the login page",
                        }).then(() => {
                            this.$router.go("/login");
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
