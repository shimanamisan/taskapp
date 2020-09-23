<template>
    <div>
        <div class="loader__cover"></div>
        <div class="loader">
            <p class="loader__text">Loading...</p>
        </div>
    </div>
</template>

<script>
export default {};
</script>
<style scoped>
.loader__cover {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 1;
}
.loader__text {
    color: #ffffff;
    margin-left: -32px;
}
.loader {
    position: fixed;
    font-size: 25px;
    top: 50%;
    left: 50%;
    width: 1em;
    height: 1em;
    border-radius: 50%;
    -webkit-animation: load5 1.1s infinite ease;
    animation: load5 1.1s infinite ease;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    z-index: 2;
}
@-webkit-keyframes load5 {
    0%,
    100% {
        box-shadow: 0em -2.6em 0em 0em #ffffff,
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.5),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7);
    }
    12.5% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.7),
            1.8em -1.8em 0 0em #ffffff, 2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5);
    }
    25% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.5),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7), 2.5em 0em 0 0em #ffffff,
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    37.5% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.7),
            1.75em 1.75em 0 0em #ffffff,
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    50% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.5),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.7),
            0em 2.5em 0 0em #ffffff, -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    62.5% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.5),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.7), -1.8em 1.8em 0 0em #ffffff,
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    75% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.5),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.7),
            -2.6em 0em 0 0em #ffffff,
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    87.5% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.5),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.7),
            -1.8em -1.8em 0 0em #ffffff;
    }
}
@keyframes load5 {
    0%,
    100% {
        box-shadow: 0em -2.6em 0em 0em #ffffff,
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.5),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7);
    }
    12.5% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.7),
            1.8em -1.8em 0 0em #ffffff, 2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5);
    }
    25% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.5),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7), 2.5em 0em 0 0em #ffffff,
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    37.5% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.7),
            1.75em 1.75em 0 0em #ffffff,
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    50% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.5),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.7),
            0em 2.5em 0 0em #ffffff, -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    62.5% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.5),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.7), -1.8em 1.8em 0 0em #ffffff,
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    75% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.5),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.7),
            -2.6em 0em 0 0em #ffffff,
            -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
    }
    87.5% {
        box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2),
            1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2),
            2.5em 0em 0 0em rgba(255, 255, 255, 0.2),
            1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2),
            0em 2.5em 0 0em rgba(255, 255, 255, 0.2),
            -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.5),
            -2.6em 0em 0 0em rgba(255, 255, 255, 0.7),
            -1.8em -1.8em 0 0em #ffffff;
    }
}
</style>
