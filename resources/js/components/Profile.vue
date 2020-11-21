<template>
    <div>
        <Header />
        <transition>
            <Loading v-show="this.showLoading" />
        </transition>
        <div class="l-wrapper l-wrapper__profile">
            <transition name="c-transition__flash">
                <Message
                    v-show="success"
                    :message-data="this.success_message"
                />
            </transition>
            <div class="l-main__auth l-main__auth__profile">
                <div class="l-card__container">
                    <div class="p-card__container">
                        <p class="p-card__title">プロフィール編集</p>
                    </div>
                    <hr class="u-form__line" />
                    <div class="c-form__container__profile">
                        <div class="c-form__item">
                            <label
                                for
                                class="c-form-lavel c-form-lavel__profile"
                                >プロフィール画像</label
                            >
                            <label class="c-input__profile">
                                <input
                                    type="file"
                                    class="c-input__profile__drop"
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
                            <!-- バリデーションエラー --->
                            <div
                                v-if="profileErrorMessages"
                                class="c-error errors__profile"
                            >
                                <ul v-if="profileErrorMessages.profilePhoto">
                                    <li
                                        v-for="msg in profileErrorMessages.profilePhoto"
                                        :key="msg"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>
                            <!--- end c-error -->
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
                        <div class="u-profile__form">
                            <div class="c-form__item">
                                <label for class="c-form-lavel"
                                    >ニックネーム</label
                                >
                                <!--- end c-error -->
                                <input
                                    type="text"
                                    class="c-input"
                                    v-model="profileData.name"
                                    @focus="namefocus"
                                    :class="{ 'c-error__bg': validName }"
                                />
                                <!-- バリデーションエラー --->
                                <div v-if="profileErrorMessages" class="c-error">
                                    <ul v-if="profileErrorMessages.name">
                                        <li
                                            v-for="msg in profileErrorMessages.name"
                                            :key="msg"
                                        >
                                            {{ msg }}
                                        </li>
                                    </ul>
                                </div>
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
                                <!--- end c-error -->
                                <input
                                    type="text"
                                    class="c-input"
                                    v-model="profileData.email"
                                    @focus="emailfocus"
                                    :class="{ 'c-error__bg': validEmail }"
                                />
                                <!-- バリデーションエラー --->
                                <div v-if="profileErrorMessages" class="c-error">
                                    <ul v-if="profileErrorMessages.email">
                                        <li
                                            v-for="msg in profileErrorMessages.email"
                                            :key="msg"
                                        >
                                            {{ msg }}
                                        </li>
                                    </ul>
                                </div>
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
                    <!-- c-form__container__profile -->
                    <transition name="c-transition__modal">
                        <ChangePassword
                            v-show="showPassword"
                            @closeEvent="closePasswordModal"
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
import { mapMutations, mapState, mapGetters } from "vuex";
import NoImage from "./common/NoImage";
import ChangePassword from "./modal/ChangePassword";
import Header from "@/components/Include/Header";
import Loading from "@/components/Loading/Loading";
import Message from "@/components/Include/Message";
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
            success_message: null,

            // ローディング画面の表示フラグ
            showLoading: false,

            // プロフィールのフォームデータ
            profileData: {
                user_id: null,
                name: null,
                email: null,
                profileImage: null,
            },
        };
    },
    components: {
        Header,
        Message,
        NoImage,
        ChangePassword,
        Loading,
    },
    computed: {
        ...mapState({
            profileErrorMessages: (state) => state.profile.profileErrorMessages,
        }),
        ...mapGetters({
            getCode: "error/getCode",
            validEmail: "profile/validProfileEmailError",
            validName: "profile/validProfileNameError"
        }),
    },
    methods: {
        ...mapMutations({
            setSuccessResponseMessage: "profile/setSuccessResponseMessage",
        }),
        // フォームでファイルが選択されたら実行
        fileSelected(event) {
            if (event.target.files.length === 0) {
                this.reset();
                return false;
            }
            // ファイルが画像でなかったら処理を中断
            console.log(event.target.files[0]);
            if (!event.target.files[0].type.match("image.*")) {
                this.$store.commit("profile/setProfileErrorMessages", {
                    profilePhoto: ["画像を選択してください"],
                });
                this.$el.querySelector('input[type="file"]').value = null;
                return false;
            }
            // ファイル情報をdataプロパティに保存
            // Eventオブジェクトのtargetプロパティ内のfilesに選択したファイル情報が入っている
            this.profileData.profileImage = event.target.files[0];
            // FileReaderクラスのインスタンスを取得
            const reader = new FileReader();
            // ファイルを読み込み終わったタイミングで実行する処理
            reader.onload = (event) => {
                this.preview = event.target.result;
            };
            // ファイルを読み込む
            // 読み込まれたファイルはデータURL形式で受け取れる
            reader.readAsDataURL(event.target.files[0]);
            this.profileData.profileImage = event.target.files[0];
            console.log("正常に画像が格納されています。");
        },
        reset() {
            // エラーメッセージが出ていたら消す
            this.clearError();
            // this.$el.querySelectorでinput要素のDOMを取得して内部の値を消している
            this.$el.querySelector('input[type="file"]').value = null;
            this.preview = null;
            this.profileData.profileImage = null;
            this.showProfileImage = !this.showProfileImage;
        },
        // プロフィール写真変更
        async profileImageEdit() {
            this.clearError();
            this.isActiveLoading();
            this.setSuccessResponseMessage(null);
            // プロフィール画像保存の処理
            // FormDataオブジェクトをインスタンス化
            const formData = new FormData();
            // appendメソッドでフィールドに追加（第1引数：キーを指定、第2引数：valueを指定（ファイル情報））
            // ここのキーとフォームリクエストクラスのバリデーションで指定したキーを同じにしてないと、
            // 常にリクエストが空とみなされてバリデーションに引っかかる
            // formdataオブジェクトの中身を見る https://qiita.com/_Keitaro_/items/6a3342735d3429175300
            formData.append("profilePhoto", this.profileData.profileImage);
            // アクションへファイル情報を渡す
            await this.$store.dispatch("profile/profileImageEdit", {
                user_id: this.profileData.user_id,
                img: formData,
            });
            if (this.getCode === 200) {
                this.showSuccess();
                setTimeout(this.showSuccess, 5000);
            }
            this.isActiveLoading();
            this.showProfileImage = !this.showProfileImage;
        },
        async userSoftDelete() {
            // ゲストユーザーは退会できなようにメッセージ表示
            if (this.profileData.user_id === 1) {
                window.alert("ゲストユーザーは退会できません。");
                return false;
            }
            if (
                window.confirm(
                    "退会処理を行うと、現在作成しているタスクも削除されます。\n退会しますか？"
                )
            ) {
                // アクションを呼びに行く
                await this.$store.dispatch("profile/userSoftDelete" , {
                    user_id: this.profileData.user_id,
                });
                if (this.getCode === 200) {
                    // 画面遷移時にコンポーネントにメッセージを渡す
                    this.$router.push({
                        name: "Index",
                        params: {
                            message:
                                "退会しました。ご利用ありがとうございました。",
                        },
                    });
                }
            }
        },
        async profileNameEdit() {
            this.clearError();
            this.isActiveLoading();
            this.setSuccessResponseMessage(null);
            // アクションへファイル情報を渡す
            await this.$store.dispatch("profile/profileNameEdit", {
                name: this.profileData.name,
            });
            if (this.getCode === 200) {
                this.showName = !this.showName;
                this.isActiveLoading();
                this.showSuccess();
                setTimeout(this.showSuccess, 5000);
                return;
            }
            this.isActiveLoading();
        },
        async profileEmailEdit() {
            this.clearError();
            this.isActiveLoading();
            this.setSuccessResponseMessage(null);
            // アクションへファイル情報を渡す
            await this.$store.dispatch("profile/profileEmailEdit", {
                user_id: this.profileData.user_id,
                email: this.profileData.email,
            });
            if (this.getCode === 200) {
                this.isActiveLoading();
                this.showEmail = !this.showEmail;
                this.showSuccess();
                setTimeout(() => {
                    this.showSuccess();
                }, 5000);
                return;
            }
            this.isActiveLoading();
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
            const elment = document.getElementById("js-modal-lock");
            elment.classList.add("c-modal__lock");
        },
        closePasswordModal() {
            this.showPassword = !this.showPassword;
        },
        isActiveLoading() {
            this.showLoading = !this.showLoading;
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
            this.isActiveLoading();
            axios
                .get("/api/user")
                .then((response) => {
                    console.log(response);
                    this.isActiveLoading();
                    this.profileData.user_id = response.data.id;
                    this.profileData.name = response.data.name;
                    this.profileData.email = response.data.email;
                    this.preview = response.data.pic;
                    this.setSuccessResponseMessage(null);
                })
                .catch((error) => {
                    alert(
                        "エラーが発生しました。改善しない場合はお問い合わせページよりご連絡下さい。"
                    );
                    this.isActiveLoading();
                    console.log(error);
                });
        },
    },
    created() {
        // createdライフサイクルフックで、表示が残っていたバリデーションメッセージを消す
        this.clearError();
        this.getProfile();
    },
};
</script>
<style></style>
