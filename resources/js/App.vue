<script setup>
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
</script>

<template>
    <Header />
    <div class="container my-5">
        <RouterView />
    </div>
    <Footer />
</template>

<style>
html {
    position: relative;
    min-height: 100%;
}

footer {
    position: absolute;
    bottom: 0;
    width: 100%;
}
</style>
