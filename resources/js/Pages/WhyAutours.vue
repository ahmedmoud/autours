<template>
    <body>
    <div id="wrapper">

        <!-- header begin -->
        <header-one/>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>
            <div style="margin-left: 40%; width: 15%; ">
                <div style="background:#ffd100; height: 1%; margin-bottom: -15%;"></div>
                <h1 class="text-nowrap">Why &nbsp; Autours</h1>
            </div>
            <p  style="font-size: 1.3vw;" class="mx-5"> Whether you are a supplier looking fto expand your reach or a renter of a vehicle, Autours is your trusted partner in the car rental market. Join us today and experience the Autours difference! </p>
            <img class="ml-ح1" width="1900" src="/images/why_autours_customer.jpg"/>
            <div class="row">
                <div class="offset-1">
                    <div class="col-md-3" style="background:#ffd100; height: 3%; margin-bottom: -3%;"></div>
                    <h2>Customers</h2>
                    <p>At Autours, we strive to provide an exceptional car rental experience tailored to your needs. Here’s why choosing us is the right decision:</p>
                </div>
                <div class="offset-4">
                    <ul>
                        <li><strong>Diverse Fleet:</strong> A wide range of vehicles tailored to your needs, from economy cars to SUVs.</li>
                        <li><strong>Competitive Pricing:</strong> Transparent pricing model with no hidden fees for added value.</li>
                        <li><strong>Seamless Booking Experience:</strong> Secure and user-friendly online reservations.</li>
                        <li><strong>Flexible Rental Periods:</strong> Choose from hourly to monthly rentals.</li>
                        <li><strong>Quality Assurance:</strong> High standards of safety and maintenance for all vehicles.</li>
                        <li><strong>Exceptional Customer Service:</strong> 24/7 assistance for all your queries and concerns.</li>
                    </ul>
                </div>

            </div>

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
#top {
    margin-top: 7%;
}
</style>
