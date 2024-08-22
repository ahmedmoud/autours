<template>
    <header-one/>

    <body>
    <!-- banner -->

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

    <!--    <search-form/>-->
    <!-- client -->
    <div class="my-4" style="background: #FFFFFF">
        <div class="container">
            <div class="row" style="justify-content: center;">
                <div v-for="logo in logos" class="col-md-1 py-2 ">
                    <img :src="'img/company_logos/' + logo" class="mx-auto d-block" width="100" height="40"/>
                </div>
            </div>
        </div>
    </div>
    <!-- three-blcok -->
    <div class="" style=" background: #f9d602; height: 167px; display: flex; align-items: center;  ">
        <img src="images/background/autours-left.png"/>
        <p style="font-size: 5vw; font-weight: 1000 !important; position: absolute; left: 32%;">Why Autours?</p>
        <img style=" position:absolute; left: 95.7%;" src="images/background/autours-right.png"/>
    </div>

    <div class=" my-5 py-2">
        <div class="row">
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
    <!-- images -->

    <div class="my-5 " style="background: #f9d602; ">
        <div style="background-color: #000; height: 25px;"></div>
        <div>
            <p class="text-center " style="font-size: 5vw; font-weight: 1000 !important; margin-top: 5%; left: 32%;">WHERE WE ARE</p>
            <div class="where_we_are_section my-5">
                <div class="card" style="height: 90%; width: 15%; background: rgba(255,255,255,0); border-color: rgba(255,255,255,0);">
                    <div class="card__img">
                        <img src="images/countries/saudi.jpg" alt="Big Ben">
                        <div class="card__overlay">
                            <p style="font-size: 1vw; font-weight: 1000;" class="text-center">KINGDOM OF<br> SAUDI ARABIA</p>
                        </div>
                    </div>
                </div>

                <div class="card" style="width: 25%; height: 29%; background: rgba(255,255,255,0); border-color: rgba(255,255,255,0);" >
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
                <div class="card" style="width: 40%; height: 31%; background: rgba(255,255,255,0); border-color: rgba(255,255,255,0);" >
                    <div class="card__img">
                        <img
                            src="images/countries/uae.jpg"
                            alt="Eiffel Tower">

                        <div class="card__overlay">
                            <p style="font-size: 1vw; font-weight: 1000;">UNITED ARAB EMIRATES</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 2%">
                        <div class="card__img mt-2" style="height: 195%; width: 50%;">
                            <img
                                src="images/countries/egypt.jpg"
                                alt="Eiffel Tower">

                            <div class="card__overlay">
                                <p style="font-size: 1vw; font-weight: 1000;" class="text-center">E&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;&nbsp;&nbsp;&nbsp;Y&nbsp;&nbsp;&nbsp;&nbsp;P&nbsp;&nbsp;&nbsp;&nbsp;T</p>
                            </div>
                        </div>
                        <div class="card__img mt-2" style="height: 195%; width: 50%;">
                            <img
                                src="images/countries/oman.jpg"
                                alt="Eiffel Tower">

                            <div class="card__overlay">
                                <p style="font-size: 1.2vw; font-weight: 1000;" class="text-center">O&nbsp;&nbsp;&nbsp;&nbsp;M&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;&nbsp;&nbsp;&nbsp;N</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="height: 90%; width: 15%; background: rgba(255,255,255,0); border-color: rgba(255,255,255,0);">
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
        <div style="background-color: #000; height: 25px;"></div>

    </div>
    <!-- feature (skew background) -->
    <div class="jumbotron  " style="height: 70%;">
        <p  style="font-size: 5vw; font-weight: 1000 !important; position: absolute; left: 32%;">OUR FLEET</p>

            <swiper
                :modules="[Navigation, Pagination, Scrollbar, A11y]"
                :slides-per-view="2"
                :space-between="10"
                loop
                navigation
                class="mt-5"
            >
                <swiper-slide v-for="item in [1,2,3]">
                    <div class="text-center">
                            <div class="">
                                <h4 class="mt-3 ml-3">F&nbsp;&nbsp;&nbsp;&nbsp;U&nbsp;&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; S&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;Z&nbsp;&nbsp;&nbsp;&nbsp;E </h4>
                                <div class="">
                                    <img :src="'images/swiper/swiper' + item+ '.png'" alt=""
                                         height="350" >
                                </div>
                                <p style="font-size: 20px;">EASY-GOING & PUNCHY MOVE<br> AROUNDS</p>
                            </div>
                    </div>

                </swiper-slide>


            </swiper>

    </div>

    <div style="background-color: #000; height: 25px;"></div>

    <!-- price table -->
        <div class=" " style="background: rgb(244, 216, 73);" id="price-table">
        <h2 class="text-center font-weight-bold d-block mb-3">FAQ</h2>
        <div class="container acc d-flex">
            <div class='wrapper w-25 '>
                <input id='pictures' type='checkbox'>
                <label for='pictures'>
                    <p>Why book a car with Autours?</p>
                    <div class='lil_arrow'></div>
                    <div class='content'>
                        <ul>
                            <li>
                                <a href='#'>Design briefs</a>
                            </li>
                            <li>
                                <a href='#'>Non Disclosure</a>
                            </li>
                            <li>
                                <a href='#'>Company Brochure</a>
                            </li>
                        </ul>
                    </div>
                    <span></span>
                </label>
                <input id='jobs' type='checkbox'>
                <label for='jobs'>
                    <p>Upcoming Jobs</p>
                    <div class='lil_arrow'></div>
                    <div class='content'>
                        <ul>
                            <li>
                                <a href='#'>Weekly Forecast</a>
                            </li>
                            <li>
                                <a href='#'>Timescales</a>
                            </li>
                            <li>
                                <a href='#'>Quotes</a>
                            </li>
                        </ul>
                    </div>
                    <span></span>
                </label>
                <input id='events' type='checkbox'>
                <label for='events'>
                    <p>Events & Task Management</p>
                    <div class='lil_arrow'></div>
                    <div class='content'>
                        <ul>
                            <li>
                                <a href='#'>Calendar</a>
                            </li>
                            <li>
                                <a href='#'>Important Dates</a>
                            </li>
                            <li>
                                <a href='#'>Someting Event related</a>
                            </li>
                        </ul>
                    </div>
                    <span></span>
                </label>

            </div>
            <div class='wrapper w-25 '>
                <input id='financial' type='checkbox'>
                <label for='financial'>
                    <p>Invoicing & financial</p>
                    <div class='lil_arrow'></div>
                    <div class='content'>
                        <ul>
                            <li>
                                <a href='#'>Invoicing Templates</a>
                            </li>
                            <li>
                                <a href='#'>Invoice Archives</a>
                            </li>
                            <li>
                                <a href='#'>Send Invoice</a>
                            </li>
                        </ul>
                    </div>
                    <span></span>
                </label>
                <input id='settings' type='checkbox'>
                <label for='settings'>
                    <p>System Settings</p>
                    <div class='lil_arrow'></div>
                    <div class='content'>
                        <ul>
                            <li>
                                <a href='#'>User Settings</a>
                            </li>
                            <li>
                                <a href='#'>Edit Profile</a>
                            </li>
                            <li>
                                <a href='#'>Do something cool</a>
                            </li>
                        </ul>
                    </div>
                    <span></span>
                </label>
            </div>
            <div class='wrapper w-25 '>
                <input id='financial' type='checkbox'>
                <label for='financial'>
                    <p>Invoicing & financial</p>
                    <div class='lil_arrow'></div>
                    <div class='content'>
                        <ul>
                            <li>
                                <a href='#'>Invoicing Templates</a>
                            </li>
                            <li>
                                <a href='#'>Invoice Archives</a>
                            </li>
                            <li>
                                <a href='#'>Send Invoice</a>
                            </li>
                        </ul>
                    </div>
                    <span></span>
                </label>
                <input id='settings' type='checkbox'>
                <label for='settings'>
                    <p>System Settings</p>
                    <div class='lil_arrow'></div>
                    <div class='content'>
                        <ul>
                            <li>
                                <a href='#'>User Settings</a>
                            </li>
                            <li>
                                <a href='#'>Edit Profile</a>
                            </li>
                            <li>
                                <a href='#'>Do something cool</a>
                            </li>
                        </ul>
                    </div>
                    <span></span>
                </label>
            </div>
        </div>
    </div>
    <div style="background-color: #000; height: 25px;"></div>

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
onMounted(() => {
    getLocations();
    getVehicles();
    getLogos();
    getUser();

})
</script>

<style lang="scss" scoped>
@import '../../css/custom.css';

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
        width: 400px;
        margin: 0 auto;
        background: white;
        border-radius: 4px;
        position: relative;
        box-shadow: 0px 2px rgba(0, 0, 0, 0.12);

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
            border-top: 2px solid rgba(0, 0, 0, 0.33);
            border-right: 2px solid rgba(0, 0, 0, 0.33);
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

.search-form {
    background: #1c1b1bd4;

}

</style>
