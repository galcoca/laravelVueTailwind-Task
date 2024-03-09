<template>
    <router-view :authenticated="authenticated" :user="user" />
</template>

<script>
export default {
    name: "App",
    data() {
      return {
        authenticated: window.authUser ? true : false,
        user: window.authUser,
      }
    }
};
</script>
