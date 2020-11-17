<template>
    <img :src="this.logo" alt="logo" class="c-logo" />
</template>

<script>
import logo from "@/../img/logo.png";
export default {
    data() {
        return {
            logo: logo,
        };
    },
};
</script>

<style></style>
