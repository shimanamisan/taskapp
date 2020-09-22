<template>
    <div>
        <Header />
        <div class="p-500">
            <div class="p-500__wrapp">
                <p>500</p><br>
                <p>｜</p>
                <p>
                    内部サーバーエラーが発生しました。しばらくお待ち下さい
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import Header from "@/components/Include/Header";
export default {
    components: {
        Header
    }
};
</script>
<style></style>
