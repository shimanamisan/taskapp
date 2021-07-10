<template>
    <img :src="imgPath" alt="no_image" />
</template>

<script>
import path from '@img/no_img.png';
export default {
    data() {
        return {
            imgPath: path
        };
    },
};
</script>

<style></style>
