<template>
  <div class="c-task__sidebar__user__wrapp">
    <div class="c-task__sidebar__user">
      <output>
        <div class="c-task__avater" v-if="imgPath">
          <img :src="imgPath" alt />
        </div>
        <div class="c-task__avater" v-else>
          <NoImage />
        </div>
      </output>
      <h1 class="c-task__sidebar__usertitle">{{ username }}</h1>
    </div>
  </div>
  <!-- c-task__sidebar__user__wrapp -->
</template>

<script>
import NoImage from "@js/components/common/NoImage";
import { mapState, mapGetters } from "vuex";
export default {
  data() {
    return {
      imgPath: "",
    };
  },
  components: {
    NoImage,
  },
  computed: {
    ...mapGetters({
      username: "auth/getUserName",
    }),
  },
  methods: {
    profileimage() {
      axios
        .get("/api/user")
        .then((response) => {
          this.imgPath = response.data.pic;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.profileimage();
  },
};
</script>

<style></style>
