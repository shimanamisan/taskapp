<template>
  <div class="l-wrapper p-callback">
    <div class="p-callback__wrapp">
      <div class="p-callback__wrapp--innner">
        <p v-if="authentication">Twitterでログインを行っています。。。</p>
        <p v-else>認証に失敗しました。</p>
        <p>{{ failMessages }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapMutations } from "vuex";
export default {
  data() {
    return {
      failMessages: null
    };
  },
  computed: {
    authentication() {
      return !this.failMessages;
    }
  },
  methods: {
    callbackTwitterLogin() {
      axios
        .get("api/callback", {
          params: this.$route.query
        })
        .then(response => {
          this.setApiStatus(response.status);
          this.setEmail(response.data.email);
          this.setUser(response.data.name);
          this.setPic(response.data.pic);
          this.setId(response.data.id);
          // Uncaught (in promise) undefined が発生。vue-router 3.1.xxから rjectされてPromisが返ってきたのに、
          // だれもキャッチしてくれなかったときに発生するエラー
          // https://qiita.com/Sa2Knight/items/4d4c6b7b14be340cf583
          // this.$router.push('/tasklist')
          // 以下の記述で解決
          this.$router.push("/tasklist").catch(e => {});
        })
        .catch(error => {
          this.failMessages = error.message;
        });
    },
    ...mapMutations({
      // this.$store.auth.commit('setId')
      // this.setId(引数)で利用することが可能になる
      setApiStatus: "auth/setApiStatus",
      setUser: "auth/setUser",
      setEmail: "auth/setEmail",
      setPic: "auth/setPic",
      setId: "auth/setId"
    })
  },
  mounted() {
    this.callbackTwitterLogin();
  }
};
</script>

<style>
</style>