<template>
    <header class="bg-gray-800 py-4">
        <div
            class="container mx-auto flex flex-col sm:flex-row justify-between items-center px-4"
        >
            <h1 class="text-white text-lg font-bold mb-4 sm:mb-0 sm:w-auto">
                <router-link to="/dashboard" v-if="authenticated">Vin Checker Gabriel</router-link>
                <router-link to="/" v-else>Vin Checker Gabriel</router-link>
            </h1>
            <div
                class="flex flex-row sm:items-center w-auto space-x-4"
                v-if="!authenticated && (!isLogin || !isRegister)"
            >
                <router-link
                    active-class="active"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 sm:mr-4 rounded sm:hidden"
                    to="/login"
                    v-if="!isLogin"
                    >Login</router-link
                >
                <router-link
                    active-class="active"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded sm:hidden"
                    to="/register"
                    v-if="!isRegister"
                    >Register</router-link
                >
                <div class="hidden sm:flex flex-row space-x-4">
                    <router-link
                        active-class="active"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
                        to="/login"
                        v-if="!isLogin"
                        >Login</router-link
                    >
                    <router-link
                        active-class="active"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded"
                        to="/register"
                        v-if="!isRegister"
                        >Register</router-link
                    >
                </div>
            </div>
            <div class="flex flex-row sm:items-center w-auto space-x-4" v-else-if="authenticated && (!isLogin || !isRegister)">
                <a
                        href="#"
                        class="bg-green-500 hover:bg-red-600 text-white px-4 py-2 rounded sm:hidden"
                        @click="confirmLogout"
                        v-if="authenticated"
                        >Disconnect</a
                    >
                <div class="hidden sm:flex flex-row space-x-4">
                    <a
                        href="#"
                        class="bg-green-500 hover:bg-red-600 text-white px-4 py-2 rounded"
                        @click="confirmLogout"
                        v-if="authenticated"
                        >Disconnect</a
                    >
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";
import { getToken } from "../getToken";

export default {
    name: "HeaderTemplate",
    props: ["authenticated", "user", "isLogin", "isRegister"],
    methods: {
        confirmLogout() {
            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, log out",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.logout();
                }
            });
        },
        async logout() {
            await getToken();
            await axios
                .post("/logout")
                .then(() => {
                    Swal.fire({
                        icon: "success",
                        title: "Login Successful",
                        text: "You have successfully logged out.",
                    }).then(() => {
                        this.$router.go("/login");
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
