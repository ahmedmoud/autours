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
                <h1>About us</h1>
            </div>
            <div class="row">
                <div class="ml-5 mr-5">
                    <div style="font-family: sans-serif; font-size: 20px;">
                        <h3>At Autours, we strive to empower companies to reach a wide range of customers.</h3>
                        As a partner on our platform, we provide you with the opportunity to grow your business and
                        expand
                        your reach to local and regional
                        markets. We believe that collaboration is the key to mutual growth, which is why we offer our
                        partnered companies’ comprehensive tools
                        and reports to help them enhance their services and engage better with customers.<br>
                        We are committed to providing a flexible and supportive business environment that contributes to
                        the success of our partnerships. With
                        Autours, we are dedicated to offering opportunities for continuous growth and development for
                        car
                        rental companies through our
                        long-term partnerships.<br>
                        <h3>Join us today and be part of the future of the car rental industry in the region.</h3>
                    </div>
                </div>
                <div>
                    <img width="1920" src="/assets/images/backgrounds/car.png">
                </div>

                <div style="margin-left: 25%; margin-top: 5%; margin-bottom: 5%;">
                    <p style="font-size: 100px; font-weight: 1000;"> Why Choose Us</p>
                </div>
                <div class=" row offset-2">
                    <div class="col-md-2 mr-5">
                        <img height="102" src="/assets/images/icons/car-icon.png"/>
                        <h3 class="mt-4 ml-4">ALL BRANDS</h3>
                    </div>
                    <div class="col-md-2">
                        <img width="200" height="102" src="/assets/images/icons/team-icon.png"/>
                        <h3 class="mt-4">EXPERT TEAM</h3>
                    </div>
                    <div class="col-md-2">
                        <img class="ml-4" height="102" src="/assets/images/icons/24-h-icon.png"/>
                        <h3 class="mt-4">24 H SERVICE</h3>
                    </div>
                    <div class="col-md-2">
                        <img width="140" height="102" src="/assets/images/icons/AFFORDABLE-icon.png"/>
                        <h3 class="mt-4">AFFORDABLE</h3>
                    </div>
                    <div class="col-md-2">
                        <img height="102" src="/assets/images/icons/anywhere-icon.png"/>
                        <h3 class="mt-4">ANY WHERE</h3>
                    </div>
                </div>
                <div class="row py-5 mt-3" style="background: rgb(249, 214, 2)">
                    <div class="col-md-6">
                        <div class="ml-5">
                            <h1 class="ml-4">Our Vision</h1>
                            <div class="row">
                                <div  class=" col-md-6">
                                    <img width="348" src="/assets/images/backgrounds/Our-Goals.png"/>
                                </div>
                                <div class="col-md-5">
                                    <p style="font-family: sans-serif;" class="mt-5">
                                        To be the preferred partner for car
                                        rental companies in the region by
                                        providing an innovative platform
                                        that supports their growth and
                                        expansion while enhancing their
                                        ability to deliver the best customer
                                        service.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <h1 class="ml-1">Our Goal</h1>
                        <div class="row">
                            <div class="col-md-6">
                                <img width="348" src="/assets/images/backgrounds/Our-Vision.png"/>
                            </div>
                            <div class="col-md-5">
                                <p style="font-family: sans-serif;" class="mt-3">
                                    Support companies in reaching new
                                    markets through our platform.
                                    Provide analytical tools and reports to help
                                    companies improve their performance.
                                    Strengthen collaboration between Autours
                                    and its partners to ensure a smooth and
                                    successful rental experience.
                                    Achieve sustainable growth for partnered
                                    companies through transparency and
                                    continuous development.
                                </p>

                            </div>
                        </div>
                    </div>

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
