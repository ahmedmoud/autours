<template>
    <header-one/>

    <body>
    <!-- banner search form-->

    <div class="jumbotron jumbotron-fluid"
         style="background-image: url(img/banner-bk.jpg);background-size: cover;background-position: center; background-repeat: no-repeat; height: 600px; display:flex;  justify-content: center;">

        <div class="jumbotron-fluid" style="width: 75%;">
            <h1 class="p-fontsize" style="color: #ffffff;"><strong><span
                style="color: rgb(249, 214, 2)">Car Rentals</span> - Search, Book & Enjoy.</strong></h1>
            <FloatSearchForm/>
            <h1 class="py-3 p-fontsize" style=" color: #ffffff;">
                <strong> Looking for a vehicle? You're at the right place!<br/></strong>
            </h1>
            <div class="text-white font-weight-bold included-part">

            </div>
        </div>
    </div>

    <!-- clients -->
    <div class="my-4" style="background: #FFFFFF">
        <div class="container">
            <div class="row" style="justify-content: center;">
                <div v-for="logo in logos" class="col-md-1 py-2 ">
                    <img :src="'img/company_logos/' + logo" class="mx-auto d-block" width="100" height="40"/>
                </div>
            </div>
        </div>
    </div>

    <!-- why autours -->
    <div class="" style=" background: #f9d602; height: 167px; display: flex; align-items: center;  ">
        <img src="images/background/autours-left.png"/>
        <p style="font-size: 5vw; font-weight: 1000 !important; position: absolute; left: 32%;">Why Autours?</p>
        <img style=" position:absolute; left: 95.7%;" src="images/background/autours-right.png"/>
    </div>


    <!-- services -->
    <div class="my-5 py-2 ">
        <div class="" style="display: ruby">
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-3 text-center">
                <img src="images/icons/home-icon1.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>Variety<br> Of Cars</h5>
                <p style="font-size: 20px; color: #595555;">Choose from a wide<br> range of cars to meet all<br> your
                    needs.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-2 text-center">
                <img src="images/icons/home-icon2.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>24/7<br> Customer Service</h5>
                <p style="font-size: 20px; color: #595555;">Continuous support avail-<br> able around the clock, <br>
                    everyday of the week.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-2 text-center">
                <img src="images/icons/home-icon3.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>Present in<br>9 Arab Countries</h5>
                <p style="font-size: 20px; color: #595555;">We're present in 9 Arab countries, bringing our services
                    closer to you throughout the region.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-2 text-center">
                <img src="images/icons/home-icon4.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>Multiple and secure<br>payment options</h5>
                <p style="font-size: 20px; color: #595555;">We offer multiple and secure payment options, ensuring
                    flexibility and safety for all your transactions.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-2 text-center">
                <img src="images/icons/home-icon5.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>Instant<br>Confirmation</h5>
                <p style="font-size: 20px; color: #595555;">Receive Instant Confirmation, ensuring your booking is
                    secured immediately.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-3 text-center">
                <img src="images/icons/home-icon8.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>No visa<br>or hidden fees</h5>
                <p style="font-size: 20px; color: #595555;">No extra fees when using your<br> credit card & We offer
                    transparent<br> pricing with no undisclosed costs.</p>
            </div>

            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-2 text-center">
                <img src="images/icons/home-icon7.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>Multilingual<br>customer service</h5>
                <p style="font-size: 20px; color: #595555;">Our team available to<br> support you in multiple languages.
                </p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-2 text-center">
                <img src="images/icons/home-icon6.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>Free Booking<br>Modifications</h5>
                <p style="font-size: 20px; color: #595555;">Easily modify your booking,<br> without any charges.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-2 text-center">
                <img src="images/icons/home-icon9.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>Free<br>Cancellation</h5>
                <p style="font-size: 20px; color: #595555;">Enjoy the option of free Cancellation without any addtional
                    cahrges.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-2 text-center">
                <img src="images/icons/home-icon10.png" width="100px" alt="Phishing Detect" class="mx-auto my-1">
                <h5>Global<br>Rental Companies</h5>
                <p style="font-size: 20px; color: #595555;">We partner with the best global rental companies to ensure
                    high-quality service.</p>
            </div>


        </div>

    </div>

    <!-- WHERE WE ARE -->
    <div class="mt-5 " style="background: #f9d602; ">
        <div style="background-color: #000; height: 25px;"></div>


        <div>
            <p class="text-center " style="font-size: 5vw; font-weight: 1000 !important; margin-top: 5%; left: 32%;">WHERE WE ARE</p>
            <div class="where_we_are_section mt-5">
                <div class="card"
                     style="height: 90%; width: 15%; background: rgba(255,255,255,0); border-color: rgba(255,255,255,0);">
                    <div class="card__img">
                        <img src="images/countries/saudi.jpg" alt="Big Ben">
                        <div class="card__overlay">
                            <p style="font-size: 1vw; font-weight: 1000;" class="text-center">KINGDOM OF<br> SAUDI
                                ARABIA</p>
                        </div>
                    </div>
                </div>

                <div class="card"
                     style="width: 25%; height: 29%; background: rgba(255,255,255,0); border-color: rgba(255,255,255,0);">
                    <div class=" card__img">
                        <img
                            src="images/countries/bahrain.jpg" alt="bahrain">

                        <div class="card__overlay">
                            <p style="font-size: 1vw; font-weight: 1000;" class="text-center">B&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;H&nbsp;&nbsp;&nbsp;R&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;N</p>
                        </div>

                    </div>
                    <div class="card__img mt-3">
                        <img src="images/countries/qatar.png"
                             alt="qatar">

                        <div class="card__overlay">
                            <p style="font-size: 1vw; font-weight: 1000;" class="text-center">Q&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;&nbsp;T&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;&nbsp;R</p>
                        </div>

                    </div>

                    <div class="card__img mt-2">
                        <img
                            src="images/countries/kuwait.jpg"
                            alt="bahrain">

                        <div class="card__overlay">
                            <p style="font-size: 1.3vw; font-weight: 1000;" class="text-center">K&nbsp;&nbsp;u&nbsp;&nbsp;w&nbsp;&nbsp;a&nbsp;&nbsp;i&nbsp;&nbsp;t</p>
                        </div>

                    </div>
                </div>
                <div class="card"
                     style="width: 40%; height: 100%; background: rgba(255,255,255,0); border-color: rgba(255,255,255,0);">
                    <div class="card__img" style="height: 29%;">
                        <img
                            src="images/countries/uae.jpg"
                            alt="Eiffel Tower">

                        <div class="card__overlay">
                            <p style="font-size: 1vw; font-weight: 1000;">UNITED ARAB EMIRATES</p>
                        </div>
                    </div>
                    <div class="d-flex mt-3">
                        <div class="card__img mr-3" style="width: 100%; height: 205%">
                            <img
                                src="images/countries/egypt.jpg"
                            >

                            <div class="card__overlay">
                                <p style="font-size: 1vw; font-weight: 1000;" class="text-center">E&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;&nbsp;&nbsp;&nbsp;Y&nbsp;&nbsp;&nbsp;&nbsp;P&nbsp;&nbsp;&nbsp;&nbsp;T</p>
                            </div>
                        </div>
                        <div class="card__img " style="width: 100%; height: 205% ">
                            <img

                                src="images/countries/oman.jpg"
                                alt="Eiffel Tower"/>

                            <div class="card__overlay">
                                <p style="font-size: 1.2vw; font-weight: 1000;" class="text-center">O&nbsp;&nbsp;&nbsp;&nbsp;M&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;&nbsp;N</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card"
                     style="height: 90%; width: 15%; background: rgba(255,255,255,0); border-color: rgba(255,255,255,0);">
                    <div class="card__img">
                        <img
                            src="images/countries/jordan.jpg"
                            alt="Pisa Tower">
                        <div class="card__overlay">
                            <p style="font-size: 1vw; font-weight: 1000;" class="text-center">JORDAN</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div style="background-color: #000; height: 30px;"></div>


    <!-- OUR Fleet -->
    <div class="jumbotron" style="height: 100%; background-image: url('images/background/our_fleet.png')">
        <p style="font-size: 5vw; font-weight: 1000 !important; position: absolute; left: 32%; margin-top: 40px;">OUR
            FLEET</p>

        <swiper
            :modules="[Navigation, Pagination, Scrollbar, A11y]"
            :slides-per-view="3"
            :space-between="5"
            loop
            navigation
            style="margin-top: 10%;"
        >
            <swiper-slide v-for="item in [1,2,3,4,5,6,7]">
                <div class="text-center" style="background: url('images/background/our_fleet_card.png');">
                    <div class="">
                        <div class="">
                            <img :src="'images/swiper/swiper' + item+ '.png'" alt=""
                                 height="550">
                        </div>
                    </div>
                </div>

            </swiper-slide>
        </swiper>
    </div>

    <div style="background-color: #000; height: 30px;"></div>

    <!-- Be Supplier -->
    <div class="jumbotron jumbotron-fluid"
         style=" background-image: url(images/background/be-supplier.png);background-size: cover;background-position: center; background-repeat: no-repeat; height: 600px;   align-content: center;">


        <div class="" style="display: ruby" >
            <div class="col-md-6"></div>
            <div class="col-md-6">
            <button
                style="width: 20%; color: rgb(244, 216, 73); font-weight: 700; border-color: #000; background-color: #000000; border-width: 6px; border-radius: 20px 0px 0px 20px; " @click="sendEmail('supplier')">
                S U B M I T
            </button>
            <input v-model="supplier_email" placeholder="W R I T E   Y O U R    M A I L   H E R E" type="text"
                   style="width: 40%; border-color: #000; color: #000; background-color: rgba(0,0,0,0); border-width: 6px; border-radius: 0px 20px 20px 0px"/>
        </div>
        </div>
    </div>
    <div style="background-color: #000; height: 30px;"></div>


    <!-- Be Supplier -->
    <div class="jumbotron jumbotron-fluid"
         style=" background-image: url(images/background/offers.png);background-size: cover;background-position: center; background-repeat: no-repeat; height: 600px;   align-content: center;">


        <div class="" style="display: ruby">
            <div class="col-md-1"></div>
            <div class="col-md-6" style="margin-top: 10%;">
                <button
                    style="width: 20%; color: rgb(244, 216, 73); font-weight: 700; border-color: #000; background-color: #000000; border-width: 6px; border-radius: 20px 0px 0px 20px; " @click="sendEmail('offers')">
                    S U B M I T
                </button>
                <input v-model="offers_email"  placeholder="  W R I T E   Y O U R    M A I L   H E R E" type="text"
                       style="width: 40%; border-color: #000; color: #000; background-color: rgba(0,0,0,0); border-width: 6px; border-radius: 0px 20px 20px 0px"/>
            </div>
        </div>
    </div>
    <div style="background-color: #000; height: 30px;"></div>

    <!-- price table -->
    <div class=" " style="background: rgb(244, 216, 73);" id="price-table">
        <h2 class="text-center font-weight-bold d-block mb-3">FAQ</h2>
        <div class=" mx-5 acc d-flex">
            <div class='wrapper' style="background-color: rgba(255,255,255,0); width: 35%;">
                <input id='why_autours' type='checkbox'>
                <label for='why_autours' class="faq_label">
                    <p style="font-size: 14px;">Can I receive a specific color of the car model ?</p>
                    <div class='lil_arrow'></div>
                    <div class='content' style="color: black;">
                        <div style="position: relative; margin-left: 15px; font-size: 12px; max-width: 400px; width: 80%; font-weight: 200;">
                            The cars displayed online are just examples of the vehicles the customer may get, and unfortunately,<br>
                            we cannot guarantee the exact make or model,or aspects such as the color of the car.Autours,guarantee<br>
                            the category of the car, seating capacity,transmission and boot space.The model of vehicle the customer<br>
                            will receive will depend on availability in the rental supplier's fleet at the collection time.
                        </div>
                    </div>
                </label>
                <input id='instant_confirmation' type='checkbox'>
                <label for='instant_confirmation' class="faq_label">
                    <p style="font-size: 14px;">What is an instant confirmation?</p>
                    <div class='lil_arrow'></div>
                    <div class='content' style="color: black;">
                        <div style="display:inline-block;  font-size: .6vw; width: 400px; font-weight: 200;">
                            <p>At Autours, we value your time and strive to provide a seamless booking experience.<br>
                                With our instant confirmation feature, you can book with confidence and get on the<br> road faster.
                            </p>
                        </div>
                    </div>
                </label>
                <input id='driving_licence' type='checkbox'>
                <label for='driving_licence' class="faq_label">
                    <p style="font-size: 14px;">What are the driving license requirements?</p>
                    <div class='lil_arrow'></div>
                    <div class='content' style="color: black;">
                        <div style="display:inline-block; font-size: .6vw; width: 400px; font-weight: 200;">
                            <p>To rent a car with Autours, you need to meet the following driving license requirements:</p>
                               <strong>Minimum Age:</strong> You must be at least 21 years old.<br>
                               <strong>Valid Driving License:</strong> You must possess a valid driver's license issued from your country of residence.<br>
                                <strong>International Drivers:</strong> International customers must present a valid international driver's permit (IDP) <br> along with their original driver's license.
                        </div>
                    </div>
                </label>
            </div>
            <div class='wrapper ' style="background-color: rgba(255,255,255,0); width: 35%;">
                <input id='collect_car' type='checkbox'>
                <label for='collect_car' class="faq_label">
                    <p style="font-size: 14px;">What do I need to bring to collect the car?</p>
                    <div class='lil_arrow'></div>
                    <div class='content' style="color: black;">
                        <div style="display:inline-block; font-size: .6vw; width: 400px; font-weight: 200;">
                            When collecting your rental car from Autours, please ensure you have the following items:<br>
                            • Booking Confirmation: Make sure to have your booking confirmation details handy,<br> either in print or on your mobile device.<br>
                            • Driving License: Bring a valid driving license issued from your  country of residence.<br> International customers should also  carry a valid international driver's permit (IDP) if required.<br>
                            • Payment Method: Have a credit card in the primary driver's name for any necessary payments.<br>
<!--                            • Additional Driver's Information: If you plan to add an additional driver,<br> ensure they meet all required criteria and have their driving license ready.-->
<!--                            These items are essential to facilitate a smooth and efficient car collection process. If you have any specific inquiries about what to bring when collecting your car, please don't hesitate to contact us.-->
                        </div>
                    </div>
                    <span></span>
                </label>
                <input id='canellation_policy' type='checkbox'>
                <label for='canellation_policy' class="faq_label">
                    <p style="font-size: 14px;">What is the cancellation policy?</p>
                    <div class='lil_arrow'></div>
                    <div class='content' style="color: black;">
                        <div style="display:inline-block;  font-size: .6vw; width: 400px; font-weight: 200;">
                            Our cancellation policy at Autours is designed to  provide flexibility and convenience:<br>
                            • Free Cancellation: You can cancel your booking free of charge up to 24 hours.<br>
                            • Late Cancellation: Cancellations made less than 24 hours before pick-up may incur a cancellation fee.<br>
                            • No-shows: If you do not collect your rental car and do not cancel the booking in advance,<br> a no-show fee may apply.
                            Please review the specific terms and conditions related to cancellations<br> during the booking process. For further assistance or to cancel a booking, please contact our customer<br>
                            support team.


                        </div>
                    </div>
                    <span></span>
                </label>
                <input id='how_to_cancel' type='checkbox'>
                <label for='how_to_cancel' class="faq_label">
                    <p style="font-size: 14px;">How do I cancel my booking?</p>
                    <div class='lil_arrow'></div>
                    <div class='content'>
                        <div style="display:inline-block;  font-size: .6vw; width: 400px; font-weight: 200;">
                        To cancel your booking with Autours, follow these simple steps:<br>
                        1. Visit Our Website: Log in to your account on our website.<br>
                        2. Find Your Booking: Navigate to the bookings section where your reservation is listed.<br>
                        3. Initiate Cancellation: Select the booking to cancel and follow the prompts to initiate the process.<br>
                        4. Contact Customer Support: If you encounter any issues, please contact our customer support team.<br>
                        Please note:<br>
                        - Cancellations made at least 24 hours before your scheduled pick-up time are typically free of charge.<br>
                        - Late cancellations may incur fees as per our cancellation policy.<br>
<!--                        • Ensure to review the cancellation terms and conditions applicable to your booking.<br>-->
<!--                           For further assistance or to cancel your booking, please don't hesitate to reach out to us.<br>-->
                        </div>
                    </div>
                    <span></span>
                </label>
            </div>
            <div class='wrapper ' style="background-color: rgba(255,255,255,0); width: 35%;">
                <input id='update_booking' type='checkbox'>
                <label for='update_booking' class="faq_label">
                    <p style="font-size: 14px;">Can I change the booking to different date & time? </p>
                    <div class='lil_arrow'></div>
                    <div class='content' style="color: black;">
                        <div style="display:inline-block; font-size: .6vw; width: 400px; font-weight: 200;">
                            Yes, many car rental companies allow customers to change their<br> booking to a different date and time, although this may depend <br> on the company's policies and the terms and conditions of the <br> rental agreement. Here’s how you can present this option<br> on your website:
                            Change Your Booking Date & Time<br>
                            We understand that plans can change. <br> At Autours, you have the flexibility to modify <br> your booking to a different date and time. Here’s how it works:
                            • Easy Modifications: Log into your account and navigate to your bookings. Select the reservation you wish to modify and choose your new preferred date and time.
                            • No Hidden Fees: Enjoy the convenience of changing your booking without worrying about hidden fees. Please note that changes are subject to availability and any difference in rental rates.
                            • Customer Support: If you need assistance, our customer support team is here to help. Contact us via email or phone, and we’ll guide you through the process.
                        </div>
                    </div>
                    <span></span>
                </label>
                <input id='insurance_excess' type='checkbox'>
                <label for='insurance_excess' class="faq_label">
                    <p style="font-size: 14px;">What is an insurance excess?</p>
                    <div class='lil_arrow'></div>
                    <div class='content' style="color: black;">
                        <div style="display:inline-block;  font-size: .6vw; width: 400px; font-weight: 200;">
                            Insurance excess, also known as a deductible,<br> is the amount you are liable to pay towards <br> the cost of any damage or loss to the rental<br> vehicle during the rental period.<br>
                            • How it Works: If there is damage to the car,<br> the insurance excess is the maximum amount you would<br> have to pay out of pocket before the insurance<br> coverage kicks in.
                            • Example: If the insurance excess is $500 and there is $1,000 worth of damage to the vehicle, you would pay $500 and the insurance would cover the remaining $500.
                            • Coverage Options: <br>Some rental agreements offer options to reduce<br> the excess through additional insurance or<br> waivers, which can be purchased for added peace of mind.<br>
                            It's important to review your rental <br>agreement to understand the specific<br> terms and conditions related to insurance excess<br>. If you have any questions regarding insurance<br> coverage or excess, feel free <br>to contact us for clarification.<br>
                            This explanation provides clarity on what <br>insurance excess entails and helps customers <br>understand their financial responsibility in<br> case of any damage to the rental vehicle.
                        </div>
                    </div>
                    <span></span>
                </label>
                <input id='collision_damage' type='checkbox'>
                <label for='collision_damage' class="faq_label">
                    <p style="font-size: 14px;">What is Collision Damage Waiver (CDW)?</p>
                    <div class='lil_arrow'></div>
                    <div class='content' style="color: black;">
                        <div style="display:inline-block; font-size: .6vw; width: 400px; font-weight: 200;">
                            Collision Damage Waiver (CDW) is an optional insurance <br> coverage that reduces the renter's financial responsibility <br>(excess) in case of damage to the rental vehicle.<br>
                            • Coverage: CDW typically covers damage<br> to the rental vehicle due to collision,<br> theft, and vandalism.
                            • Financial Protection: By purchasing CDW,<br> the renter can often reduce their liability to pay the full<br> cost of damages down to a <br>lower amount or eliminate it altogether, depending <br>on the terms of the waiver.<br>
                            • Exclusions: CDW may not cover certain damages,<br> such as those resulting from negligent use of <br>the vehicle or driving under the influence.<br>
                            It's important to carefully review the <br>terms and conditions of the CDW offered by Autours to <br>understand the coverage limits, exclusions, and<br> any additional fees associated with this option.<br>
                            For more information or to add CDW to your<br> rental, please contact our customer support team.<br>
                            This explanation provides a clear understanding of<br> what Collision Damage Waiver (CDW) is and its benefits for<br> renters considering additional insurance coverage<br> for their rental vehicle.
                        </div>
                    </div>
                    <span></span>
                </label>
            </div>
        </div>
    </div>


    <div style="background-color: #000; height: 30px;"></div>
    <!-- contact -->
    <Contactus/>
    <!-- copyright -->
    <Footer/>
    </body>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import {useForm, Link} from '@inertiajs/vue3';
import HeaderOne from '../components/HeaderOne.vue'
import SearchForm from "./SearchForm.vue";
import FloatSearchForm from "./FloatSearchForm.vue";
import Footer from "../components/Footer.vue"
import Contactus from "../components/Contactus.vue"
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Navigation, Pagination, Scrollbar, A11y} from 'swiper/modules';
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
const $toast = useToast();

const user = ref('')

const form = useForm({
    pickupLoc: '',
    date: '',
});
const logos = ref(["europcar.png", "avis.png", "alamo.png", "sixt.png", "national.jpg", "dollar.png", "hertz.png", "thrifty.jpeg", "budget.jpg", "enterprise.svg.png"])
const date = ref('')
const countries = ref('')
const location = ref('')
const locations = {
    all: ref([]),
    options: ref([]),
    loading: ref(false),
}

const vehicles = ref([])
const offers_email = ref("")
const supplier_email = ref("")

const getLogos = async () => {
    try {
        const response = await axios.get('get/logos')
        // logos.value = response.data
    } catch (error) {
        console.error(error)
    }
}
const fetchCountries = async () => {
    countries.loading.value = true;
    try {
        const response = await axios.get('https://api.countrystatecity.in/v1/countries', {
            headers: {
                'X-CSCAPI-KEY': 'NVZhakViaFdtOXBJZ0xoQW1lWkJGTmlGUW1Kb05XaElGbXhocnNNOA=='
            }
        })
        countries.all.value = response.data
        countries.list.value = countries.all.value.map((item) => ({
            id: `${item.id}`,
            label: `${item.name}`,
            iso: `${item.iso2}`
        }))
        console.log(countries.list.value)
    } catch (error) {
        console.error(error)
    } finally {
        countries.loading.value = false;
    }
}
const getVehicles = async () => {
    try {
        const response = await axios.get('get/vehicles')
        vehicles.value = response.data
    } catch (error) {
        console.error(error)
    }
}

const getLocations = async () => {
    locations.loading.value = true;
    try {
        const response = await axios.get('/get/locations')
        locations.all.value = Object.values(response.data)
    } catch (error) {
        console.error(error)
    } finally {
        locations.loading.value = false;
    }
}

const remoteLocations = (query) => {
    if (query) {
        locations.loading.value = true
        setTimeout(() => {
            locations.loading.value = false
            locations.options.value = locations.all.value.filter((item) =>
                item.toLowerCase().includes(query.toLowerCase())
            )
        }, 200)


    } else {
        locations.options.value = [];
    }
}

const search = () => {
    form.pickupLoc = location.value
    form.date = date.value
    form.post('search/vehicles');
}
const getUser = async () => {
    try {
        const response = await axios.get('/get/user/data');
        user.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

const sendEmail = async (type) => {
    try {
        if (type === 'offers' && (offers_email.value === '' || offers_email.value === undefined || offers_email.value === null || offers_email.value === []) ){
            alert("please type your email first");
            return;
        }
        if (type === 'supplier' && (supplier_email.value === '' || supplier_email.value === undefined || supplier_email.value === null || supplier_email.value === []) ){
            alert("please type your email first");
            return;
        }
        const body = {
            type: type,
            email: type === 'supplier' ? supplier_email.value : offers_email.value
        }
        const response = await axios.post('/send-email', body);
        if (response.status) {
            $toast.success("email sent successfully !" , {position: 'top'})
        }

    } catch (error) {
        $toast.error("cannot send email now !" , {position: 'top'})
        console.error(error);
    }
}
onMounted(() => {
    getLocations();
    getVehicles();
    getLogos();
    getUser();
    var el = document.getElementsByClassName("swiper-button-next")
    if (el.length) {
        el[0].style.color = '#00000000'
        var image = 'images/icons/next.svg'
        el[0].style.backgroundImage = 'url("' + image + '")'
        el[0].style.backgroundRepeat = 'no-repeat'
        el[0].style.width = 150
        el[0].style.height = 150
        el[0].style.marginTop = '-10%'
    }
    var el = document.getElementsByClassName("swiper-button-prev")
    if (el.length) {
        el[0].style.color = '#00000000'
        var image = 'images/icons/prev.svg'
        el[0].style.backgroundImage = 'url("' + image + '")'
        el[0].style.backgroundRepeat = 'no-repeat'
        el[0].style.width = 150
        el[0].style.height = 150
        el[0].style.marginTop = '-10%'
    }

})


</script>

<style lang="scss" scoped>
@import '../../css/custom.css';


//. {
//    color: rgba(244, 214, 64, 0) !important;
//}

.swiper-button-prev {
    color: #f4d640 !important;
}


@media screen and (max-width: 800px) {
    .p-fontsize {
        font-size: 5vw;
    }
    .included-part {
        display: none;
    }
    .jumbotron-fluid {
        width: 100%;
    }
}


#banner {
    position: relative;

    &::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba($color: #000000, $alpha: .5);
    }
}

header {
    width: 100%;
    position: static;
    background: transparent;
    margin: 0;
    border-bottom: none;
}

.trip-form {
    border-radius: 7px;
    padding: 40px;
    background: #fff;
    position: relative;
    z-index: 3;
    -webkit-box-shadow: 0 15px 30px 0px rgba(0, 0, 0, 0.1);
    box-shadow: 0 15px 30px 0px rgba(0, 0, 0, 0.1);
}

$easing: cubic-bezier(0.680, -0.550, 0.265, 1.550);
$color: white;

.acc {
    .wrapper {
        margin: 0 auto;
        background: white;
        border-radius: 4px;
        position: relative;

        p {
            display: block;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            transition: all .3s ease;
        }

        label {
            display: block;
            position: relative;
            color: #b5abab;
            overflow: hidden;
            cursor: pointer;
            height: 56px;
            -webkit-transition: text-indent 0.2s;
            text-indent: 20px;
            padding-top: 1px;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            color: white;
            list-style-type: none;

            a {
                display: block;
                width: 100%;
                padding: 15px 0px;
                text-decoration: none;
                color: #434447;
                border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            }

            a:hover {
                background-color: rgba(0, 0, 0, 0.06);
            }
        }

        label:hover {
            background: rgba(244, 216, 73, 0.5) !important;
            color: #434447;

            p {
                transform: translateX(20px);
            }
        }

        input[type="checkbox"] {
            display: none;
        }

        span {
            height: 3px;
            position: absolute;
            width: 0px;
            display: block;
            top: 58px;
            background: #f4d849;
        }

        .content {
            background: rgba(244, 216, 73, 0.7);
            height: 300px;
            position: relative;
            border-top: 2px solid rgba(0, 0, 0, 0.12);
            top: 4px;
        }

        .lil_arrow {
            width: 5px;
            height: 5px;
            -webkit-transition: transform 0.8s;
            transition: transform 0.8s;
            -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border-top: 2px solid rgb(0, 0, 0);
            border-right: 2px solid rgb(0, 0, 0);
            float: right;
            position: relative;
            top: -30px;
            right: 27px;
            transform: rotate(45deg)
        }

        input[type="checkbox"]:checked + label > .content {
            display: block;
        }

        input[type="checkbox"]:checked + label > span {
            display: none;
        }

        input[type="checkbox"]:checked + label > .lil_arrow {
            -webkit-transition: transform 0.8s;
            transition: transform 0.8s;
            -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform: rotate(135deg)
        }

        input[type="checkbox"]:checked + label {
            display: block;
            background: rgba(244, 216, 73, 0.5) !important;
            color: #434447;
            text-indent: 30px;
            height: 275px;
            -webkit-transition: height 0.8s;
            transition: height 0.8s;
            -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        label:hover > span {
            width: 100%;
            -webkit-transition-timing-function: $easing;
            transition: width 0.4s;
        }

        input[type='checkbox']:not(:checked) + label {
            display: block;
            -webkit-transition: height 0.8s;
            -moz-transition: height 0.8s;
            transition: height 0.8s;
            height: 60px;
            -webkit-transition-timing-function: $easing;
        }
    }
}

::-webkit-scrollbar {
    display: none;
}

// images

@mixin mQ($px) {
    @media screen and (max-width: $px) {
        @content;
    }
}

.where_we_are_section {
    display: flex;
    gap: 8px;
    height: 80vh;
    padding: max(2vh, 1.5rem);

    img {
        width: 100%;
        display: block;
        height: 100%;
        object-fit: cover;
    }

    h2 {
        color: white;
        font-size: clamp(1rem, 0.8750rem + 0.6250vw, 1.5rem);
        line-height: 1.3;
        font-weight: 700;
    }

    @include mQ(690px) {
        height: 65vh;
    }

    @include mQ(470px) {
        grid-template-columns:repeat(2, 1fr);
        grid-template-rows: repeat(3, 35%);
    }

    .card {
        border-radius: 25%;

        p {
            font-size: clamp(0.9rem, 0.8750rem + 0.1250vw, 1rem);
            line-height: 1.4;
        }


        img {
            border-radius: 25px;
        }

        .card__img {
            position: relative;
            height: 100%;

            .card__overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                color: #fff;
                padding: clamp(0.938rem, 5vw, 1.563rem);
                width: 100%;
                height: 100%;
                background: rgb(2, 2, 46);
                background: linear-gradient(0deg, rgb(0 0 0 / 60%) 0%, rgba(207, 12, 12, 0) 100%);
                border-radius: 25px;
                display: flex;
                justify-content: flex-end;
                flex-direction: column;
            }
        }
    }
}

.card_img {
    position: absolute;
    bottom: 0;
    left: 0;
    color: #fff;
    padding: clamp(0.938rem, 5vw, 1.563rem);
    width: 100%;
    height: 100%;
    background: rgb(2, 2, 46);
    background: linear-gradient(0deg, rgb(0 0 0 / 60%) 0%, rgba(207, 12, 12, 0) 100%);
    border-radius: 15%;
    display: flex;
    justify-content: flex-end;
    flex-direction: column;
}

.search-form {
    background: #1c1b1bd4;

}

.faq_label{
    border-color: black;
    border-radius: 25px;
    border-width: 3px;
    border-style: solid;
    color: #000 !important;
    font-weight: 800;
    width: 90%;
}


</style>
