<template>
    <body>
    <div id="wrapper">

        <!-- header begin -->
        <header-one/>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>


        </div>
    </div>
    <Footer/>

    </body>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import 'vue-toast-notification/dist/theme-sugar.css';
import HeaderOne from '../components/HeaderOne.vue'
import Footer from "../components/Footer.vue";
import 'primevue/resources/themes/aura-light-amber/theme.css'





onMounted(() => {

})

</script>

<style scoped>

</style>
