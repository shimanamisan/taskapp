<template>
    <img :src="this.logo" alt="no_image"/>
</template>

<script>
import logo from "../../../img/no_img.png";
export default {
    data(){
        return{
            logo: logo,
        }
    }
};
</script>

<style></style>
