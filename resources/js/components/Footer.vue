<script setup>
import { ref } from 'vue';

const copyrightYear = ref(new Date().getFullYear());
</script>

<template>
    <footer class="bg-light py-3">
        <div class="container">
            Copyright &copy; {{ copyrightYear }}, COMP3385 Web Dev Superstars ✨
        </div>
    </footer>
</template>

<style scoped>

</style>
