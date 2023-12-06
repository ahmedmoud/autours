<template>
<body>
    <div id="wrapper">

        <!-- header begin -->
        <header-one />
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <img src="/images/background/2.jpg" class="jarallax-img" alt=""
                    style="object-fit: cover;
                    object-position: 50% 50%;
                    max-width: none;
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    overflow: hidden;
                    pointer-events: none;
                    transform-style: preserve-3d;
                    backface-visibility: hidden;
                    will-change: transform, opacity;
                    margin-top: 161.5px;
                    transform: translate3d(0px, -161.5px, 0px);">
                    <div class="center-y relative text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center">
									<h1>Vehicle Fleet</h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->

            <section id="section-car-details">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-6">
                            <div id="slider-carousel" class="owl-carousel">
                                <div class="item w-100">
                                    <img class="item w-100" :src="vehicle.photo ? '/img/vehicles/' + vehicle.photo : ''" alt="photo" />
                                </div>
                                <div class="spacer-30"></div>
                                <h3>{{ vehicle.name }}</h3>
                                <p>
                                  {{ vehicle.description }}  
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <h4>Category</h4>
                            <ul class="ul-style-2">
                                {{ vehicle.category?.name }}
                                <!-- <li>Multimedia Player</li>
                                <li>Central Lock</li>
                                <li>Sunroof</li> -->
                            </ul>

                            <h4>Specifications</h4>
                            <div class="de-spec">
                                <!-- <div class="d-row">
                                    <span class="d-title">Category</span>
                                    <span class="d-value">{{ vehicle.category?.name }}</span>
                                </div> -->
                                <div v-if="vehicle.specifications" v-for="specification in vehicle.specifications" class="d-row">
                                    <span class="d-title">{{specification.name}}</span>
                                    <span class="d-value">{{specification.option}}</span>
                                </div>
                            </div>
                            <div class="spacer-single"></div>
                        </div>

                        <div class="col-lg-3">
                            <div class="de-price text-center">
                                for {{ daysNumber }} day{{ daysNumber < 2  ? '' : 's' }}
                                <h3>{{ calculatedPrice(vehicle, daysNumber) }}$</h3>
                            </div>
                            <div class="spacer-30"></div>
                            <div class="de-box mb25">
                                <form name="contactForm" id='contact_form' method="post">
                                    <h4>Booking this car</h4>

                                    <div class="spacer-20"></div>

                                    <div class="row">
                                    </div>
                                    <form class="trip-form mt-4 px-2" @submit.prevent="search">
                                        <div class="row align-items-center flex-column">
                                            <div class="w-100 mb-3">
                                                <el-select
                                                    class="w-100"
                                                    v-model="location"
                                                    size="large"
                                                    placeholder="Pickup..."
                                                    disabled>
                                                </el-select>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-control-wrap">
                                                    <el-date-picker
                                                        v-model="date"
                                                        type="daterange"
                                                        range-separator="To"
                                                        start-placeholder="Start date"
                                                        end-placeholder="End date"
                                                        size="large"
                                                        format="YYYY/MM/DD"
                                                        value-format="YYYY-MM-DD"
                                                    />
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input
                                                    type="submit"
                                                    value="Check Availability"
                                                    class="btn-main btn-fullwidth rounded-3"
                                                    style="padding: 7px 25px"
                                                />
                                            </div>
                                        </div>                                        
                                    </form>
                                    <form class="trip-form mt-4 px-2" @submit.prevent="book">
                                        <input type='submit' id='send_message' value='Book Now' class="btn-main btn-fullwidth">
                                    </form>
                                    
                                    <div class="clearfix"></div>
                                    
                                </form>
                            </div>

                            <!-- <div class="de-box">
                                <h4>Share</h4>
                                <div class="de-color-icons">
                                    <span><i class="fa fa-twitter fa-lg"></i></span>
                                    <span><i class="fa fa-facebook fa-lg"></i></span>
                                    <span><i class="fa fa-reddit fa-lg"></i></span>
                                    <span><i class="fa fa-linkedin fa-lg"></i></span>
                                    <span><i class="fa fa-pinterest fa-lg"></i></span>
                                    <span><i class="fa fa-stumbleupon fa-lg"></i></span>
                                    <span><i class="fa fa-delicious fa-lg"></i></span>
                                    <span><i class="fa fa-envelope fa-lg"></i></span>
                                </div>
                            </div> -->
                        </div>                
                    </div>
                </div>
            </section>
			
			
        </div>
        <!-- content close -->        
        <!-- footer begin -->
        <!-- footer close -->
        
    </div>
</body> 
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePage, useForm } from '@inertiajs/vue3';

import HeaderOne from '../components/HeaderOne.vue'

const id = ref('')
const vehicle = ref('')
const date = ref(null);
const location = ref("");
const priceTax = ref("");
const daysNumber = ref("");
const form = useForm({
    pickupLoc: "",
    date: "",
    vehicle: "",
    price: "",
});

const extractVetementIdFromUrl = () => {
    const page = usePage();
    const urlSegments = page.url.split('/');
    const vetementIdIndex = urlSegments.indexOf('vehicles') + 1;

    if (vetementIdIndex > 0 && vetementIdIndex < urlSegments.length) {
       id.value = urlSegments[vetementIdIndex];
    } else {
        id.value = null;
    }

}

const getVehicle = async () => {
    try {
        const response = await axios.post('/get/vehicle/data', { id: id.value })
        vehicle.value = response.data
        form.vehicle = vehicle.value.id
        form.price = vehicle.value.price
        location.value = vehicle.value.branch.location
    } catch (error) {
        console.error(error)
    }
}

const fetchVehicles = async () => {
    try {
        const response = await axios.post("/filter/vehicles");
        date.value = response.data.date;
        priceTax.value = response.data.priceTax;
        daysNumber.value = '';
        daysNumber.value = response.data.daysNumber;
    } catch (error) {
        console.error(error);
    }
};

const book = () => {
    form.pickupLoc = location.value;
    form.date = date.value;
    form.post("/book/vehicles");
};

const search = () => {
    form.pickupLoc = location.value;
    form.date = date.value;
    axios.post("/search/vehicles", form);
    fetchVehicles();
};

const calculatedPrice = (vehicle, days) => {
    const basePrice =
    days >= 1 && days < 7 ? vehicle.price :
    days >= 7 && days < 30 ? vehicle.week_price :
    days >= 30 && days < 365 ? vehicle.month_price :
    days >= 365 ? vehicle.year_price : vehicle.price;

    return ((basePrice + ((priceTax.value * basePrice) / 100)) * days).toFixed(2);

}

onMounted(() => {
    extractVetementIdFromUrl();
    getVehicle();
    fetchVehicles();
})

</script>

<style scoped>
    li::before{
        display: none;
    }
</style>