<template>
    <img :src="imgPath" alt="logo" class="c-logo" />
</template>

<script>
import path from '@img/logo.png'
export default {
    data() {
        return {
            imgPath: path
        };
    },
};
</script>

<style></style>
