<template>
    <div key="modal" class="c-modal">
        <div class="c-modal__body">
            <div class="c-modal__send" v-show="passChangeFlg">
                <p>パスワードを更新しました。</p>
            </div>
            <div class="p-nav--trigger" @click="closeHandle">
                <i class="fas fa-times p-nav--close"></i>
            </div>
            <div class="c-form__item c-modal__inner">
                <label for class="c-form-lavel">現在のパスワード</label>
                <input
                    type="password"
                    class="c-input"
                    v-model="fromData.old_password"
                    :class="{ 'c-error__bg': validOldPassword }"
                />
                <!-- バリデーションエラー --->
                <div v-if="profilePasswordErrors" class="c-error">
                    <ul v-if="profilePasswordErrors.old_password">
                        <li
                            v-for="msg in profilePasswordErrors.old_password"
                            :key="msg"
                        >
                            {{ msg }}
                        </li>
                    </ul>
                </div>
                <!--- end c-error -->
            </div>
            <div class="c-form__item c-modal__inner">
                <label for class="c-form-lavel">新しいパスワード</label>
                <input
                    type="password"
                    class="c-input"
                    v-model="fromData.password"
                    :class="{ 'c-error__bg': validPassword }"
                />
                <!-- バリデーションエラー --->
                <div v-if="profilePasswordErrors" class="c-error">
                    <ul v-if="profilePasswordErrors.password">
                        <li
                            v-for="msg in profilePasswordErrors.password"
                            :key="msg"
                        >
                            {{ msg }}
                        </li>
                    </ul>
                </div>
                <!--- end c-error -->
            </div>
            <!-- c-form__item -->
            <div class="c-form__item">
                <label for class="c-form-lavel">新しいパスワード再入力</label>
                <input
                    type="password"
                    class="c-input"
                    v-model="fromData.password_confirmation"
                />
            </div>
            <div
                class="u-btn__wrapp u-btn__password c-modal__btn__passwordEdit"
            >
                <button
                    class="c-btn c-btn__common"
                    @click="profilPasswordeEdit"
                >
                    変更
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
    props: ["userId"],
    data() {
        return {
            fromData: {
                old_password: null,
                password: null,
                password_confirmation: null
            },
            passChangeFlg: false
        };
    },
    computed: {
        ...mapState({
            profilePasswordErrors: state => state.profile.profileErrorMessages
        }),
        ...mapGetters({
            getCode: "error/getCode",
            validOldPassword: "profile/validProfileOldPasswodError",
            validPassword: "profile/validProfilePasswodError"
        })
    },
    methods: {
        async profilPasswordeEdit() {
            this.clearError();
            // アクションへファイル情報を渡す
            await this.$store.dispatch("profile/profilPasswordeEdit", {
                // これでkey:valueの形でデータをコントローラーへ渡せる
                user_id: this.userId,
                old_password: this.fromData.old_password,
                password: this.fromData.password,
                password_confirmation: this.fromData.password_confirmation
            });

            if (this.getCode === 200) {
                // 送信後入力フォームを空にする
                this.fromData.old_password = null;
                this.fromData.password = null;
                this.fromData.password_confirmation = null;
                this.passChangeFlg = !this.passChangeFlg;
                this.clearError();
            }
        },

        // モーダルを閉じるイベントを親コンポーネントに渡す
        closeHandle() {
            this.$emit("closeEvent");
            // パスワード変更メッセージが出力されていたら消去する
            this.passChangeFlg = false;
            // モーダル表示を固定するクラスを削除する
            const elment = document.getElementById("js-modal-lock");
            elment.classList.remove("c-modal__lock");
            // バリデーションエラーが表示されていたら閉じる際に消去する
            setTimeout(() => {
                this.clearError();
                this.fromData.old_password = null;
                this.fromData.password = null;
                this.fromData.password_confirmation = null;
            }, 200);
        },
        /*************************************************
         * バリデーションメッセージを消すアクションを呼ぶ
         **************************************************/
        clearError() {
            this.$store.commit("profile/setProfileErrorMessages", null);
        }
    }
};
</script>

<style></style>
