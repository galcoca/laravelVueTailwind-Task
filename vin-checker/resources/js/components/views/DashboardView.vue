<template>
    <div>
        <HeaderTemplate :authenticated="authenticated" />
        <div class="clear-both">
            <div class="flex flex-col items-center h-screen">
                <div
                    class="max-w-3xl w-full mx-auto p-8 bg-white mt-0 shadow-lg rounded-lg"
                >
                    <h1 class="text-3xl font-bold mb-8 text-center">Dashboard</h1>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-8">
                        <div class="flex flex-col items-center">
                            <Form @submit="searchVIN" class="w-full max-w-md">
                                <label for="vin" class="mb-2"
                                    >Enter Vin Number:</label
                                >
                                <Field
                                    v-model="vin"
                                    name="vin"
                                    id="vin"
                                    as="input"
                                    rules="required|vinRuler"
                                    type="vin"
                                    class="px-4 py-2 mb-4 border border-gray-300 rounded w-full"
                                />
                                <ErrorMessage name="vin" as="p" />
                                <button
                                    type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full"
                                >
                                    Search
                                </button>
                            </Form>
                        </div>
                        <div class="clear-both">
                            <div
                                v-if="Object.keys(searchResults).length > 0 && searchResults.vinData != false"
                                class="mt-8"
                            >
                                <h2 class="text-xl font-bold text-center">
                                    Search Results
                                </h2>
                                <div v-if="searchResults" class="mt-4">
                                    <div class="bg-white rounded-lg shadow-md p-6">
                                        <h2 class="text-xl font-bold">
                                            Vehicle Information
                                        </h2>
                                        <div
                                            class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4"
                                        >
                                            <div>
                                                <p>
                                                    <strong>Make:</strong>
                                                    {{ searchResults.vinData.make }}
                                                </p>
                                                <p>
                                                    <strong>Model:</strong>
                                                    {{
                                                        searchResults.vinData.model
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Year:</strong>
                                                    {{ searchResults.vinData.year }}
                                                </p>
                                                <p>
                                                    <strong>Trim Level:</strong>
                                                    {{
                                                        searchResults.vinData
                                                            .trim_level
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Engine:</strong>
                                                    {{
                                                        searchResults.vinData.engine
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Style:</strong>
                                                    {{
                                                        searchResults.vinData.style
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Made In:</strong>
                                                    {{
                                                        searchResults.vinData
                                                            .made_in
                                                    }}
                                                </p>
                                            </div>
                                            <div>
                                                <p><strong>Dimensions:</strong></p>
                                                <p>
                                                    <strong>Height:</strong>
                                                    {{
                                                        searchResults.vinData
                                                            .overall_height
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Length:</strong>
                                                    {{
                                                        searchResults.vinData
                                                            .overall_length
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Width:</strong>
                                                    {{
                                                        searchResults.vinData
                                                            .overall_width
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Seating:</strong>
                                                    {{
                                                        searchResults.vinData
                                                            .standard_seating
                                                    }}
                                                </p>
                                                <p>
                                                    <strong
                                                        >Highway Mileage:</strong
                                                    >
                                                    {{
                                                        searchResults.vinData
                                                            .highway_mileage
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>City Mileage:</strong>
                                                    {{
                                                        searchResults.vinData
                                                            .city_mileage
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        v-if="searchResults.isSalvage"
                                        class="bg-white rounded-lg shadow-md p-6 mt-6"
                                    >
                                        <h2 class="text-xl font-bold">
                                            Salvage Information
                                        </h2>
                                        <div
                                            class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4"
                                        >
                                            <div>
                                                <p>
                                                    <strong>Vehicle Title:</strong>
                                                    {{
                                                        searchResults.salvageData
                                                            .vehicle_title
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Mileage:</strong>
                                                    {{
                                                        searchResults.salvageData
                                                            .mileage
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Primary Damage:</strong>
                                                    {{
                                                        searchResults.salvageData
                                                            .primary_damage
                                                    }}
                                                </p>
                                                <p>
                                                    <strong
                                                        >Secondary Damage:</strong
                                                    >
                                                    {{
                                                        searchResults.salvageData
                                                            .secondary_damage
                                                    }}
                                                </p>
                                                <p>
                                                    <strong>Loss Type:</strong>
                                                    {{
                                                        searchResults.salvageData
                                                            .loss_type
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8"
                            v-if="searchResults.vinData == false">
                                <h2 class="text-xl font-bold text-center">
                                    Unable to find data, make sure the vin is correct
                                </h2>
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
            searchResults: {
                vinData: false
            },
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
                        if (response.success != false) {
                            this.searchResults.vin = this.vin;
                            this.searchResults.vinData = response.data.specification;
                            this.salvageChecks();
                        } else {
                            this.searchResults = {
                                vinData: false
                            }
                        }
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
