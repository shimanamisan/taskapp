<template>
    <div>
        <Header />
        <div class="l-wrapper l-wrapper__profile">
            <transition name="c-transition__flash">
                <Message v-show="success" />
            </transition>
            <div class="l-main__auth l-main__auth--profile">
                <div class="l-card__container">
                    <div class="p-card__container">
                        <p class="p-card__title">プロフィール編集</p>
                    </div>
                    <hr class="u-form__line" />
                    <div class="c-form__container--profile">
                        <div class="c-form__item">
                            <label
                                for
                                class="c-form-lavel c-form-lavel__profile"
                                >プロフィール画像</label
                            >
                            <!-- バリデーションエラー --->
                            <div
                                v-if="profileUploadErrors"
                                class="errors errors--profile"
                            >
                                <ul v-if="profileUploadErrors.profilePhoto">
                                    <li
                                        v-for="msg in profileUploadErrors.profilePhoto"
                                        :key="msg"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>
                            <!--- end errors -->
                            <label class="c-input--profile">
                                <input
                                    type="file"
                                    class="c-input--profile__drop"
                                    @change="fileSelected"
                                    @focus="imagefocus"
                                />
                                <output v-if="preview">
                                    <img
                                        v-bind:src="preview"
                                        alt="プロフィール画像"
                                        class="c-form__outputImg"
                                    />
                                    <p v-show="previewProfileImage">
                                        <img
                                            v-bind:src="profileData.pic"
                                            alt="プロフィール画像"
                                            class="c-form__output"
                                        />
                                    </p>
                                </output>
                                <output v-else>
                                    <NoImage class="c-form__outputImg" />
                                </output>
                            </label>
                            <div
                                class="l-flex l-flex--center u-btn__wrapp"
                                v-show="showProfileImage"
                            >
                                <div class="u-btn__common__margin">
                                    <button
                                        class="c-btn c-btn__common c-btn__common__cancel"
                                        @click="reset"
                                    >
                                        キャンセル
                                    </button>
                                </div>
                                <div class="u-btn__common__margin">
                                    <button
                                        class="c-btn c-btn__common"
                                        @click="profileImageEdit"
                                    >
                                        変更
                                    </button>
                                </div>
                            </div>
                            <!-- l-flex -->
                        </div>
                        <!-- end c-form__item -->
                        <div>
                            <div class="c-form__item">
                                <label for class="c-form-lavel"
                                    >ニックネーム</label
                                >
                                <!-- バリデーションエラー --->
                                <div v-if="profileUploadErrors" class="errors">
                                    <ul v-if="profileUploadErrors.name">
                                        <li
                                            v-for="msg in profileUploadErrors.name"
                                            :key="msg"
                                        >
                                            {{ msg }}
                                        </li>
                                    </ul>
                                </div>
                                <!--- end errors -->
                                <input
                                    type="text"
                                    class="c-input"
                                    v-model="profileData.name"
                                    @focus="namefocus"
                                />
                                <!-- 変更用ボタン -->
                                <div
                                    class="l-flex u-btn__wrapp"
                                    v-show="showName"
                                >
                                    <div class="u-btn__common__margin">
                                        <button
                                            class="c-btn c-btn__common c-btn__common__cancel"
                                            @click="cancelName"
                                        >
                                            キャンセル
                                        </button>
                                    </div>
                                    <div class="u-btn__common__margin">
                                        <button
                                            class="c-btn c-btn__common"
                                            @click="profileNameEdit"
                                        >
                                            変更
                                        </button>
                                    </div>
                                </div>
                                <!-- l-flex -->
                            </div>
                            <div class="c-form__item">
                                <label for class="c-form-lavel"
                                    >メールアドレス</label
                                >
                                <!-- バリデーションエラー --->
                                <div v-if="profileUploadErrors" class="errors">
                                    <ul v-if="profileUploadErrors.email">
                                        <li
                                            v-for="msg in profileUploadErrors.email"
                                            :key="msg"
                                        >
                                            {{ msg }}
                                        </li>
                                    </ul>
                                </div>
                                <!--- end errors -->
                                <input
                                    type="text"
                                    class="c-input"
                                    v-model="profileData.email"
                                    @focus="emailfocus"
                                />
                            </div>
                            <!-- 変更用ボタン -->
                            <div class="l-flex u-btn__wrapp" v-show="showEmail">
                                <div class="u-btn__common__margin">
                                    <button
                                        class="c-btn c-btn__common c-btn__common__cancel"
                                        @click="canselEmail"
                                    >
                                        キャンセル
                                    </button>
                                </div>
                                <div class="u-btn__common__margin">
                                    <button
                                        class="c-btn c-btn__common"
                                        @click="profileEmailEdit"
                                    >
                                        変更
                                    </button>
                                </div>
                            </div>
                            <!-- l-flex -->
                            <div class="u-btn__wrapp u-btn__password">
                                <button
                                    class="c-btn c-btn__common"
                                    @click="openPasswordModal"
                                >
                                    パスワードの変更
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- c-form__container--profile -->
                    <transition name="c-transition__modal">
                        <ChangePassword
                            v-show="showPassword"
                            @closeEvent="closeModal"
                            :user-id="this.profileData.user_id"
                        />
                        <!-- end c-modal -->
                    </transition>
                </div>
                <!-- l-card__container -->
                <div class="l-card__container">
                    <div class="p-card__container">
                        <p class="p-card__title">アカウントの削除</p>
                    </div>
                    <hr class="u-form__line" />
                    <div class="c-form__container">
                        <p>
                            退会処理を行います。現在登録されているタスクは全て削除され復旧はできません。
                        </p>
                    </div>
                    <div class="c-form__action c-form__action__item">
                        <button
                            type="submit"
                            class="c-btn c-btn__danger"
                            @click="userSoftDelete"
                        >
                            削除する
                        </button>
                    </div>
                </div>
                <!-- l-card__container -->
            </div>
            <!-- l-main__auth -->
        </div>
        <!-- l-wrapper__profile -->
    </div>
</template>
<script>
import { mapState, mapGetters } from "vuex";
import NoImage from "./common/NoImage";
import ChangePassword from "./modal/ChangePassword";
import Header from "./Header";
import Message from "./Message";
export default {
    data() {
        return {
            // ボタン表示フラグ
            showProfileImage: false,
            showName: false,
            showEmail: false,
            showPassword: false,

            // 画像プレビューフラグ
            preview: null,
            previewProfileImage: null,

            // 登録後のメッセージ表示フラグ
            success: false,

            // プロフィールのフォームデータ
            profileData: {
                user_id: null,
                name: null,
                email: null,
                profileImage: null
            }
        };
    },
    components: {
        Header,
        Message,
        NoImage,
        ChangePassword
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
        // フォームでファイルが選択されたら実行
        fileSelected(event) {
            // ファイルが画像でなかったら処理を中断
            if (!event.target.files[0].type.match("image.*")) {
                this.$store.commit("auth/setProfileErrorMessages", {
                    profilePhoto: ["画像を選択してください"]
                });
                this.$el.querySelector('input[type="file"]').value = null;
                return false;
            }
            // ファイル情報をdataプロパティに保存
            // Eventオブジェクトのtargetプロパティ内のfilesに選択したファイル情報が入っている
            this.profileImage = event.target.files[0];
            // FileReaderクラスのインスタンスを取得
            const reader = new FileReader();
            // ファイルを読み込み終わったタイミングで実行する処理
            reader.onload = event => {
                this.preview = event.target.result;
            };
            // ファイルを読み込む
            // 読み込まれたファイルはデータURL形式で受け取れる
            reader.readAsDataURL(event.target.files[0]);
            this.profileData.profileImage = event.target.files[0];
        },
        reset() {
            // エラーメッセージが出ていたら消す
            this.clearError();
            // this.$el.querySelectorでinput要素のDOMを取得して内部の値を消している
            this.$el.querySelector('input[type="file"]').value = null;
            this.showProfileImage = !this.showProfileImage;
        },
        // プロフィール写真変更
        async profileImageEdit() {
            this.clearError();
            // プロフィール画像保存の処理
            // FormDataオブジェクトをインスタンス化
            const formData = new FormData();
            // appendメソッドでフィールドに追加（第1引数：キーを指定、第2引数：valueを指定（ファイル情報））
            // ここのキーとフォームリクエストクラスのバリデーションで指定したキーを同じにしてないと、
            // 常にリクエストが空とみなされてバリデーションに引っかかる
            // formdataオブジェクトの中身を見る https://qiita.com/_Keitaro_/items/6a3342735d3429175300
            formData.append("profilePhoto", this.profileData.profileImage);
            // アクションへファイル情報を渡す
            await this.$store.dispatch("auth/profileImageEdit", formData);
            if (this.getCode === 200) {
                this.showSuccess();
                setTimeout(this.showSuccess, 3000);
            }
            this.showProfileImage = !this.showProfileImage;
        },
        async userSoftDelete() {
            if (
                window.confirm(
                    "退会処理を行うと、現在作成しているタスクも削除されます。\n退会しますか？"
                )
            ) {
                // アクションを呼びに行く
                await this.$store.dispatch("auth/userSoftDelete");
                if (this.getCode === 200) {
                    this.$router.push({
                        name: "Index",
                        params: {
                            message:
                                "退会しました。ご利用ありがとうございました。"
                        }
                    });
                }
            }
        },
        async profileNameEdit() {
            this.clearError();
            // アクションへファイル情報を渡す
            await this.$store.dispatch("profile/profileNameEdit", {
                name: this.profileData.name
            });
            if (this.getCode === 200) {
                this.showName = !this.showName;
                this.showSuccess();
                setTimeout(this.showSuccess, 3000);
            }
        },
        async profileEmailEdit() {
            this.clearError();
            // アクションへファイル情報を渡す
            await this.$store.dispatch("profile/profileEmailEdit", {
                email: this.profileData.email
            });
            if (this.getCode === 200) {
                this.showEmail = !this.showEmail;
                this.showSuccess();
                setTimeout(this.showSuccess, 3000);
            }
        },

        cancelName() {
            this.clearError();
            this.showName = !this.showName;
        },
        canselEmail() {
            this.clearError();
            this.showEmail = !this.showEmail;
        },
        openPasswordModal() {
            this.showPassword = !this.showPassword;
            // モーダル表示を固定するクラスを付与する
            const elment = document.getElementById('js-modal-lock')
            elment.classList.add('c-modal__lock')
        },
        closeModal() {
            this.showPassword = !this.showPassword;
        },
        /****************************************
         * focus処理のメソッド
         *****************************************/
        namefocus() {
            if (this.showName === true) {
                return;
            }
            this.showName = !this.showName;
        },
        emailfocus() {
            if (this.showEmail === true) {
                return;
            }
            this.showEmail = !this.showEmail;
        },
        imagefocus() {
            if (this.showProfileImage === true) {
                return;
            }
            this.showProfileImage = !this.showProfileImage;
        },
        /*************************************************
         * バリデーションメッセージを消すアクションを呼ぶ
         **************************************************/
        clearError() {
            this.$store.commit("profile/setProfileErrorMessages", null);
        },
        /*************************************************
         * データ更新時のモーダルを表示
         **************************************************/
        showSuccess() {
            this.success = !this.success;
        },
        /*************************************************
         * プロフィールアクセス時にユーザー情報を取得
         **************************************************/
        getProfile() {
            axios
                .get("/api/user")
                .then(response => {
                    this.profileData.user_id = response.data.id;
                    this.profileData.name = response.data.name;
                    this.profileData.email = response.data.email;
                    this.preview = response.data.pic;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    created() {
        // createdライフサイクルフックで、表示が残っていたバリデーションメッセージを消す
        this.clearError();
        this.getProfile();
    }
};
</script>
<style></style>
