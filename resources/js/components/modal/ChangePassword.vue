<template>
    <div key="modal" class="c-modal">
        <div class="c-modal__body">
            <div class="p-nav--trigger" @click="closeHandle">
                <i class="fas fa-times p-nav--close"></i>
            </div>
            <div class="c-form__item c-modal__inner">
                <label for class="c-form-lavel">現在のパスワード</label>
                <input
                    type="password"
                    class="c-input"
                    v-model="fromData.password"
                />
                <!-- バリデーションエラー --->
                <div v-if="profileUploadErrors" class="errors">
                    <ul v-if="profileUploadErrors.password">
                        <li
                            v-for="msg in profileUploadErrors.password"
                            :key="msg"
                        >
                            {{ msg }}
                        </li>
                    </ul>
                </div>
                <!--- end errors -->
            </div>
            <div class="c-form__item c-modal__inner">
                <label for class="c-form-lavel">新しいパスワード</label>
                <input
                    type="password"
                    class="c-input"
                    v-model="fromData.password"
                />
                <!-- バリデーションエラー --->
                <div v-if="profileUploadErrors" class="errors">
                    <ul v-if="profileUploadErrors.password">
                        <li
                            v-for="msg in profileUploadErrors.password"
                            :key="msg"
                        >
                            {{ msg }}
                        </li>
                    </ul>
                </div>
                <!--- end errors -->
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
    data() {
        return {
            fromData: {
                password: "",
                password_confirmation: ""
            }
        };
    },
    computed: {
        ...mapState({
            profileUploadErrors: state => state.auth.profileErrorMessages
        }),
        ...mapGetters({
            getCode: "error/getCode"
        })
    },
    methods: {
        async profilPasswordeEdit() {
            this.clearError();
            // アクションへファイル情報を渡す
            await this.$store.dispatch("auth/profilPasswordeEdit", {
                // これでkey:valueの形でデータをコントローラーへ渡せる
                password: this.profileData.password,
                password_confirmation: this.profileData.password_confirmation
            });

            if (this.getCode === 200) {
                // 送信後入力フォームを空にする
                this.profileData.password = "";
                this.profileData.password_confirmation = "";
                this.showPassword = !this.showPassword;
                this.clearError();
                this.showSuccess();
                setTimeout(this.showSuccess, 3000);
            }
        },
        ShowPasswordTrigger() {
            this.profileData.password = "";
            this.profileData.password_confirmation = "";
            this.clearError();
            this.showPassword = !this.showPassword;
        },
        // モーダルを閉じるイベントを親コンポーネントに渡す
        closeHandle(){
            this.$emit('closeEvent')
        },
        /*************************************************
         * バリデーションメッセージを消すアクションを呼ぶ
         **************************************************/
        clearError() {
            this.$store.commit("auth/setProfileErrorMessages", null);
        }
    }
};
</script>

<style></style>
