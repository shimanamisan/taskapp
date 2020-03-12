<template>
    <div class="column is-6 is-offset-3 is-centered" style="margin-top: 5em;">
        <div class="card">
            <div class="card-content has-text-centered">
                <p class="title is-6">
                    ソーシャルアカウントでログインする
                </p>
                <p v-if="attempting">Twitterでログインを行っています。。。</p>
                <p v-else>Twitterでのログインに失敗しました！</p>
                <p>{{ failedMessage }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            failedMessage: null
        };
    },

    computed: {
        attempting() {
            return !this.failedMessage;
        }
    },
      methods: {
        
      },

    mounted() {
        this.$axios
            .$get("/login/twitter/callback", {
                params: this.$route.query
            })
            .then(response => {
                this.setUser(response.user);
                this.setLoggedIn(true);

                this.$router.push("/tasklist");
            })
            .catch(error => {
                this.failedMessage = error.message;
            });
    },


};
</script>