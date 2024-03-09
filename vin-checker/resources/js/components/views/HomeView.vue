<template>
  <div>
      <HeaderTemplate />
      <div class="flex items-center justify-center h-60">
        <div class="max-w-md mx-auto p-8 bg-white shadow-lg rounded-lg">
          <h1 class="text-3xl font-bold mb-4">Welcome to VIN Checker</h1>
          <p class="text-gray-600 mb-6">Please login or register to access the VIN checker.</p>
        </div>
      </div>
      <FooterTemplate />
  </div>
</template>

<script>
import HeaderTemplate from "../templates/HeaderTemplate.vue";
import FooterTemplate from "../templates/FooterTemplate.vue";

export default {
    name: "HomeView",
    components: {
        HeaderTemplate,
        FooterTemplate,
    }
};
</script>
