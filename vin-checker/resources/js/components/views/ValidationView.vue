<template>
    <div>
        <HeaderTemplate :authenticated="authenticated" />
        <div class="clear-both">
            <div class="flex flex-col items-center h-screen">
                <div
                    class="max-w-3xl w-full mx-auto p-8 bg-white mt-0 shadow-lg rounded-lg"
                >
                    <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
                    <p class="text-gray-600 mb-6">Welcome!</p>
                    <div v-if="!user.phone_validated">
                        <p class="text-red-500 mb-4">Your phone number has not been validated yet.</p>
                        <p>Please start the validation process and enter the code when asked.</p>
                        <template v-if="!showInput">
                            <button @click="startValidation" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Start Validation</button>
                        </template>
                        <template v-else>
                            <input type="text" v-model="verificationCode" class="border border-gray-300 rounded px-3 py-2 mt-4" placeholder="Enter verification code">
                            <button @click="submitVerificationCode" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Submit</button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <FooterTemplate />
    </div>
</template>

<script>
import HeaderTemplate from "../templates/HeaderTemplate.vue";
import FooterTemplate from "../templates/FooterTemplate.vue";
import axios from 'axios';
import Swal from "sweetalert2";
import { getToken } from "../getToken";

export default {
    props: ['authenticated', 'user'],
    name: "ValidationView",
    components: {
        HeaderTemplate,
        FooterTemplate,
    },
    data() {
        return {
            showInput: false,
            verificationCode: '',
            verificationCodeSent: Math.floor(Math.random() * 99999).toString()
        };
    },
    methods: {
        async startValidation() {
            /* IS SETUP BUT THE API ENDPOINT IS RETURNING AN ERROR, USED AN ALTERNATIVE WITH MY ACC OF TELESIGN */

            const phoneNumber = this.user.phone;
            const verifyCode = this.verificationCodeSent;
            const url = `/api/send-otp`;
            await getToken();
            await axios
                .post(url, {
                    phoneNumber: phoneNumber,
                    verifyCode: verifyCode,
                })
                .then(response => {
                    if(response.status == 200)
                    {
                        this.showInput = true
                    }
                })
                .catch(error => {
                    this.logError(error);
                });
        },
        async submitVerificationCode() {
            if(this.verificationCodeSent == this.verificationCode) {
                await getToken();
                await axios
                    .post('/api/verifyPhone', {
                        userId: this.user.id
                    })
                    .then(response => {
                        console.log(response);
                        console.log(response.status);
                        if(response.status == 200)
                        {
                            Swal.fire({
                                icon: "success",
                                title: "Phone Validated",
                                text: "You have successfully validated your phone.",
                            }).then(() => {
                                this.$router.go("/login");
                            });
                        }
                    })
                    .catch(error => {
                        this.logError(error);
                    });
            } else {
                this.logError(false);
            }
        },
        async logError(error) {
            if(error){
                await getToken();
                axios.post("/api/error-logger", {
                    error: error.response ? error.response : error,
                    page: "Validating Phone",
                });
            }
            Swal.fire({
                icon: "error",
                title: "Ooops... Something went wrong",
                text: "Please try again later",
            });
        }
    }
};
</script>
