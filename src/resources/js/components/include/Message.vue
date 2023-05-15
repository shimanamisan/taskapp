<template>
    <div
        class="msg__cover msg__hide msg__appear msg__response"
        v-if="successResponseMessage"
    >
        <ul v-if="successResponseMessage.message">
            <li v-for="msg in successResponseMessage.message" :key="msg">
                {{ msg }}
            </li>
        </ul>
    </div>
    <div class="msg__cover msg__hide msg__appear" v-else>
        <p>更新されました</p>
    </div>
</template>
<script>
import { mapState } from "vuex";
export default {
    data() {
        return {};
    },
    computed: {
        ...mapState({
            successResponseMessage: (state) =>
                state.profile.successResponseMessage,
        }),
    },
};
</script>
>
<style></style>
