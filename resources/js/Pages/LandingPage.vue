<template>
    <header-one/>

    <body>
    <!-- banner -->

    <div class="jumbotron jumbotron-fluid" id=""
         style="background-image: url(img/banner-bk.jpg);background-size: cover;background-position: center; background-repeat: no-repeat; height: 75%; display:flex; align-items: flex-end; justify-content: center;">

        <div class="jumbotron-fluid  " style="width: 70%">
            <h1 style="color: #ffffff">
                <span style="color: rgb(249, 214, 2)">Car Rentals</span> - Search, Book & Enjoy .
            </h1>
            <FloatSearchForm/>
            <h1 data-aos="fade" data-aos-easing="linear" data-aos-duration="1000" data-aos-once="true"
                class=" text-white font-weight-bold my-5 ml-4 " style="  ">
                Looking for a vehicle? You're at the right place.<br/>
            </h1>
            <div class="row text-white font-weight-bold">
                <i class="col-1 fa fa-check-square fa-xl mt-2"  style="color: #7fff1f; margin-right: -6%;"/><p class="col-md-2">Free Cancellation</p>
                <i class="col-1 fa fa-check-square fa-xl mt-2"   style="color: #7fff1f; margin-right: -6%;"/><p class="col-md-2">Damage Collision Waiver</p>
                <i class="col-1 fa fa-check-square fa-xl mt-2"   style="color: #7fff1f; margin-right: -6%;"/><p class="col-md-2">Theft Protection</p>
                <i class="col-1 fa fa-check-square fa-xl mt-2"   style="color: #7fff1f; margin-right: -6%;"/><p class="col-md-2">Unlimited Mileage</p>
                <i class="col-1 fa fa-check-square fa-xl mt-2"   style="color: #7fff1f; margin-right: -6%;"/><p class="col-md-2">Third Party Liability</p>
            </div>
        </div>
    </div>

    <!--    <search-form/>-->
    <!-- client -->
    <div class="jumbotron jumbotron-fluid" style="background: #FFFFFF">
        <div class="container">
            <div class="row" style="justify-content: center;">
                <div v-for="logo in logos" class="ml-5 col-sm-4 col-md-2 py-2 align-self-center">
                    <img :src="'img/' + logo" class="mx-auto d-block" width="300" height="200"/>
                </div>
            </div>
        </div>
    </div>
    <!-- three-blcok -->
    <div class=""
         style=" background: #f9d602; height: 150px; display: flex; align-items: flex-end; justify-content: center; ">
        <h2 class="font-weight-bold">Why book a car rental <br/> with Autours?</h2>
    </div>

    <div class="container my-5 py-2">
        <div class="row">
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-4 text-center">
                <img src="img/feature-1.png" width="250px" alt="Phishing Detect" class="mx-auto my-4">
                <h4>Pas de frais cachés</h4>
                <p>Une fois que vous avez payé, vous êtes tranquilles. Pas de surprise de dernière minute.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-4 text-center">
                <img src="img/feature-1.png" width="250px" alt="Phishing Detect" class="mx-auto my-4">
                <h4>Anti-spam</h4>
                <p>Lorem ipsum dolor sit amet porro his no his deleniti</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" data-aos-once="true"
                 class="col-md-4 text-center">
                <img src="img/feature-1.png" width="250px" alt="Phishing Detect" class="mx-auto my-4">
                <h4>Phishing Detect</h4>
                <p>Ne error antiopam usu. Sed vocen concludaturque ea</p>
            </div>

        </div>
    </div>
    <!-- images -->
    <div class="my-5 py-2" style="background: #f9d602">
        <div class="container  ">
            <h2 class="text-center font-weight-bold my-5">Popular car rental locations worldwide</h2>
            <section>
                <div class="card">
                    <div class="card__img">
                        <img
                            src="https://images.unsplash.com/photo-1486299267070-83823f5448dd?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80"
                            alt="Big Ben">
                        <!-- <span><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>4.5</span> -->
                        <div class="card__overlay">
                            <h2>London</h2>
                            <p>Big Ben</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card__img">
                        <img
                            src="https://images.unsplash.com/photo-1581010864468-c972b8705439?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80"
                            alt="Eiffel Tower">

                        <div class="card__overlay">
                            <h2>Paris</h2>
                            <p>Eiffel Tower</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card__img">
                        <img
                            src="https://images.unsplash.com/photo-1552832230-c0197dd311b5?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1096&q=80"
                            alt="Colosseum">

                        <div class="card__overlay">
                            <h2>Rome</h2>
                            <p>Colosseum</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card__img">
                        <img
                            src="https://images.unsplash.com/photo-1581473483413-313a5afffb08?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=714&q=80"
                            alt="Pisa Tower">
                        <div class="card__overlay">
                            <h2>Pisa</h2>
                            <p>Pisa Tower</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card__img">
                        <img
                            src="https://images.unsplash.com/photo-1585155967849-91c736589c84?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=627&q=80"
                            alt="">
                        <div class="card__overlay">
                            <h2>New York</h2>
                            <p>Statue of Liberty</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card__img">
                        <img
                            src="https://images.unsplash.com/photo-1527915676329-fd5ec8a12d4b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80"
                            alt="Sydney Opera House">
                        <div class="card__overlay">
                            <h2>Sydney</h2>
                            <p>Sydney Opera House</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- feature (skew background) -->
    <div class="jumbotron jumbotron-fluid feature" id="feature-first">
        <div class="container my-5">
            <div class="row justify-content-between text-center text-md-left">
                <div data-aos="fade-right" data-aos-duration="1000" data-aos-once="true" class="col-md-6">
                    <h2 class="font-weight-bold">Take a look inside</h2>
                    <p class="my-4">Te iisque labitur eos, nec sale argumentum scribentur no,
                        <br> augue disputando in vim. Erat fugit sit at, ius lorem deserunt deterruisset no.</p>
                    <a href="#" class="btn my-4 font-weight-bold atlas-cta cta-blue">Learn More</a>
                </div>
                <div data-aos="fade-left" data-aos-duration="1000" data-aos-once="true"
                     class="col-md-6 align-self-center">
                    <img src="img/feature-1.png" alt="Take a look inside" class="mx-auto d-block">
                </div>
            </div>
        </div>
    </div>
    <!-- feature (green background) -->
    <div class="jumbotron jumbotron-fluid feature" id="feature-last">
        <div class="container">
            <div class="row justify-content-between text-center text-md-left">
                <div data-aos="fade-left" data-aos-duration="1000" data-aos-once="true" class="col-md-6 flex-md-last">
                    <h2 class="font-weight-bold">Safe and reliable</h2>
                    <p class="my-4">
                        Duo suas detracto maiestatis ad, commodo lucilius invenire nec ad,
                        <br> eum et oratio disputationi. Falli lobortis his ad
                    </p>
                    <a href="#" class="btn my-4 font-weight-bold atlas-cta cta-blue">Learn More</a>
                </div>
                <div data-aos="fade-right" data-aos-duration="1000" data-aos-once="true"
                     class="col-md-6 align-self-center flex-md-first">
                    <img src="img/feature-2.png" alt="Safe and reliable" class="mx-auto d-block">
                </div>
            </div>
        </div>
    </div>

    <!-- price table -->
    <div class="container my-5 py-2" id="price-table">
        <h2 class="text-center font-weight-bold d-block mb-3">FAQ</h2>
        <div class="acc d-flex">
            <div class='wrapper w-50'>
                <input id='pictures' type='checkbox'>
                <label for='pictures'>
                    <p>Why book a car rental with Autours?</p>
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
            <div class='wrapper w-50 mx-4'>
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


const user = ref('')

const form = useForm({
    pickupLoc: '',
    date: '',
});
const logos = ref({})
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
        logos.value = response.data
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
            height: 0;
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

section {
    display: grid;
    grid-template-columns:25% 30% 15% 25%;
    gap: 15px;
    place-content: center;
    grid-template-rows: 50% 50%;
    height: 80vh;
    min-height: 460px;
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
        border-radius: 25px;
        box-shadow: -2px 4px 15px rgb(0 0 0 / 26%);

        @include mQ(470px) {
            grid-column: span 1;
        }

        &:nth-child(2) {
            grid-column: 2/3;
            grid-row: span 2;

            @include mQ(690px) {
                grid-column: span 1;
                grid-row: span 1;
            }
        }

        &:nth-child(3) {
            grid-column: span 2;

            @include mQ(690px) {
                grid-column: 2/4;
                grid-row: 1/2;
            }
        }

        @include mQ(690px) {
            &:nth-child(6) {
                grid-column: 2/4;
                grid-row: 2/3;
            }
        }

        @include mQ(470px) {

            &:nth-child(5) {
                grid-column: span 2;
            }
        }

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
                content: "";
                color: #fff;
                padding: clamp(0.938rem, 5vw, 1.563rem);
                background: rgb(2, 2, 46);
                background: linear-gradient(0deg, rgb(0 0 0 / 57%) 0%, rgb(255 255 255 / 0%) 100%);
                width: 100%;
                height: 100%;
                border-radius: 25px;
                display: flex;
                justify-content: flex-end;
                flex-direction: column;
            }

            span {
                position: absolute;
                top: 25px;
                left: min(2vmax, 1.563rem);
                color: #ff7b29;
                background: #fff;
                border-radius: 50px;
                padding: 2px 8px 2px 6px;
                display: flex;
                box-shadow: 0px 1px 20px #0000002b;

                @include mQ(690px) {
                    top: 20px;
                }

                @include mQ(470px) {
                    top: 15px;
                }

                svg {
                    fill: #ff7b29;
                    width: 20px;
                    margin-right: 2px;
                }
            }
        }
    }
}

.search-form {
    background: #1c1b1bd4;

}

</style>
