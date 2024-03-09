<template>
    <div>
        <HeaderTemplate :authenticated="authenticated" />
        <div class="flex items-center justify-center h-screen">
            <div
                class="max-w-md w-full mx-auto p-8 bg-white mt-0 shadow-lg rounded-lg"
            >
                <h1 class="text-3xl font-bold mb-8 text-center">Dashboard</h1>
                <Form @submit="searchVIN" class="flex flex-col items-center">
                    <label for="vin" class="mb-2">Enter Vin Number:</label>
                    <Field
                        v-model="vin"
                        name="vin"
                        id="vin"
                        as="input"
                        rules="required|vinRuler"
                        type="vin"
                        class="px-4 py-2 mb-4 border border-gray-300 rounded w-full max-w-sm"
                    />
                    <ErrorMessage name="vin" as="p" />
                    <button
                        type="submit"
                        class="bg-blue-500 ml-2 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Search
                    </button>
                </Form>
                {{ searchResults }}
                <div v-if="Object.keys(searchResults).length > 0" class="mt-8">
                    <h2 class="text-xl font-bold">Search Results</h2>
                    <div v-if="searchResults" class="mt-4">
                        <h2 class="text-xl font-bold">
                            VIN: {{ searchResults.vin }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <p>
                                    <strong>Make:</strong>
                                    {{ searchResults.vinData.make }}
                                </p>
                                <p>
                                    <strong>Model:</strong>
                                    {{ searchResults.vinData.model }}
                                </p>
                                <p>
                                    <strong>Year:</strong>
                                    {{ searchResults.vinData.year }}
                                </p>
                            </div>
                            <div>
                                <p><strong>Salvage Data:</strong></p>
                                <pre class="bg-gray-100 p-4">{{
                                    searchResults.salvageData
                                }}</pre>
                            </div>
                        </div>
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
import { Form, Field, ErrorMessage } from "vee-validate";
import "../validationRules";

import axios from "axios";
import Swal from "sweetalert2";
import { Global } from "../../Global";

export default {
    props: ["authenticated", "user"],
    name: "DashboardView",
    data() {
        return {
            vin: "",
            searchResults: {},
        };
    },
    components: {
        Form,
        Field,
        ErrorMessage,
        HeaderTemplate,
        FooterTemplate,
    },
    methods: {
        async searchVIN() {
            if (this.vin) {
                await axios
                    .get("https://vindecoder.p.rapidapi.com/decode_vin", {
                        headers: {
                            "X-RapidAPI-Key": Global.key,
                            "X-RapidAPI-Host": "vindecoder.p.rapidapi.com",
                        },
                        params: {
                            vin: this.vin,
                        },
                    })
                    .then((response) => {
                        this.searchResults.vin = this.vin;
                        this.searchResults.vinData = response.data.specification;
                        this.salvageChecks();
                    })
                    .catch((error) => {
                        this.logError(error);
                    });
            } else {
                this.logError(false);
            }
        },
        async salvageChecks() {
            await axios
                .get("https://vindecoder.p.rapidapi.com/salvage_check", {
                    headers: {
                        "X-RapidAPI-Key": Global.key,
                        "X-RapidAPI-Host": "vindecoder.p.rapidapi.com",
                    },
                    params: {
                        vin: this.vin,
                    },
                })
                .then((response) => {
                    this.searchResults.isSalvage = response.data.is_salvage;
                    this.searchResults.salvageInfo = response.data.info;
                })
                .catch((error) => {
                    this.logError(error);
                });
        },
        async logError(error) {
            if (error) {
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
        },
    },
};
</script>
