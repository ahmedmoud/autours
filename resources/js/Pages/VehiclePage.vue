<template>
    <body>
    <div id="wrapper">

        <!-- header begin -->
        <header-one/>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>

            <!-- section begin -->


            <!-- section close -->
            <div v-if="isOpen" class="modal-mask">
                <div class="modal-wrapper" @click="$emit('close')">
                    <div class="modal-container" ref="target">
                        <div class="modal-header">
                            <slot name="header"> Rental Terms </slot>
                        </div>
                        <div class="modal-body overflow-y-auto" style="max-height: calc(100vh - 210px);">
                            <CAccordion>
                                <CAccordionItem v-for="(item,index) in activeRentalTerms" :item-key="index">
                                    <CAccordionHeader>
                                        <div v-html="item.title"> </div>
                                    </CAccordionHeader>
                                    <CAccordionBody>
                                        <div v-html="item.description"> </div>
                                    </CAccordionBody>
                                </CAccordionItem>
                            </CAccordion>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <div>
                                    <button class="btn btn-primary"  @click="closeModal()">Done</button>
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>

            <section id="section-car-details" v-if="!loading">
                <div class="col-md-12   mb-5 " style="margin-left: 18%; margin-top: 5%;">
                <button class="mr-2 mt-2 btn " style="width:420px; background: #f9d602; color: #000;"><span
                        class="ti ti-circle-number-1 mr-2"/>Choose Your Location
                    </button>
                    <button class="mr-2 btn mt-2 "
                            style="width:420px; background: #f9d602; color: #000;"><span
                        class="ti ti-circle-number-2 mr-2"/>Choose Your Car
                    </button>
                    <button class="btn mt-2 active" style="width:420px; background: rgb(155,147,84);color: #000;"><span
                        class="ti ti-circle-number-3 mr-2"/>Reserve Your Car
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-1" style="margin-top: 1.5%;">
                        <div class="col-md-11 pb-4" style="background: #fff;">
                            <div class="p-1" style="background: #e1e1e1; width: 111%; margin-left: -12px; margin-top: 10px;">
                                <h5 class="p-2">YOUR SEARCH DETAILS</h5>
                            </div>
                            <div class=" mt-3 row" style="background: #fff;">
                                <h5>PICK-UP - LOCATION </h5>

                                <p class="col-md-12"><span class=" col-md-1 ti ti-gps"></span>{{location}}</p>
                                <span class="col-md-6 ti ti-calendar">&nbsp;{{date[0]}}</span>
                                <span class="col-md-3 ti ti-clock">&nbsp;00:00</span>
                            </div>
                            <hr/>
                            <div class=" mt-3 row" style="background: #fff;">
                                <h5>DROP-OFF - LOCATION </h5>
                                <p class="col-12"><span class=" col-md-1 ti ti-gps"></span>{{location}}</p>

                                <span class="col-md-6 ti ti-calendar">&nbsp;{{date[1]}}</span>
                                <span class="col-md-3 ti ti-clock">&nbsp;00:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="container bg-white col-md-10 offset-md-0 p-5" style=" margin-top: 2%">
                        <div class="row g-5">
                            <div class="col-lg-6">
                                <div id="slider-carousel" class="owl-carousel">
                                    <h3>{{ vehicle.name }}</h3>
                                    <div class="row"><span>{{ vehicle.category?.name }}</span></div>
                                    <div class="item w-100">
                                        <img class="item w-150"
                                             :src="vehicle.photo ? '/img/vehicles/' + vehicle.photo : ''" alt="photo"/>
                                    </div>
                                    <div class="spacer-30"></div>

                                    <p v-html="vehicle.description"></p>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class=" row ">
                                    <h3 class="col-md-4">{{ currency + ' ' +vehicle.final_price }}</h3>
                                    <p class="col-md-6"> for {{ daysNumber }} day{{ daysNumber < 2 ? '' : 's' }} - {{ currency + ' ' + Math.round((vehicle.final_price / daysNumber))}} / per day </p>
                                </div>
                                <div class="de-spec">
                                    <div v-if="vehicle.specifications" v-for="specification in vehicle.specifications" class="row">
                                        <span class="d-title"><i :class="'fa fa-' + specification.icon"/> &nbsp;{{ specification.name }}</span>
                                        <span class="d-value">{{ specification.option }}</span>
                                    </div>
                                </div>
                                <div class="spacer-single"></div>
                            </div>

                            <div class="row bg-light-gray mt-5 item-list" >
                                <div class="row">
                                    <div class="col-lg-2">
                                        <img width="100" height="100" :src="'/img/' + vehicle?.supplier?.logo"  alt=""/>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="col-lg-2"><span style="font-size: medium; margin-left: -12px">{{ vehicle?.supplier?.company }}</span></div>
                                        <div class="col-lg-10" style="margin-left: -12px"><small><a class="cursor-pointer text-primary" href="javascript:void(0);" @click="openRentalTerms(vehicle)">Rental Terms</a></small></div>
                                    </div>
                                    <div class="row col-lg-2">
                                        <div class="col-lg-3">
                                           <button class="btn btn-primary"><span style="background-color: #f9d602;padding: 0.5em 0.4em;font-size: 1.0em;font-weight: 600;">7.1/10</span></button>
                                        </div>
                                        <div class="col-lg-12 row">
                                            <span class="be_media-body col-lg-12"><strong>Good</strong><span style="font-size: medium;">(<strong style="color: #f9d602">1000</strong> + reviews)</span></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <h5><i class="fa fa-location"/>Address: </h5><p>{{ vehicle?.supplier?.address }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <span><i class="fa fa-gas-pump"/></span>
                                            Fuel Policy: <small> Full to Full </small> </div>
                                    </div>
                                </div>

                                <div class=" row col-lg-12">
                                    <span class="primary" style="color: #5e9007;">What is Included!</span>
                                    <ul class="row col-lg-6">
                                        <li class="col-lg-6" v-for="item in vehicle.included ">
                                            <div class="row">
                                                <i class="col-lg-2 fa fa-check fa-xl mt-3" style="color: green;"/><p class="col-md-10" style="font-size: 13px;">{{item.what_is_included}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="de-box col-lg-12 mt-5 mb25   " style="width: 100%">
                                <form name="contactForm" id='contact_form' method="post">
                                    <h4 class="offset-1">Booking this car</h4>

                                    <div class="spacer-20"></div>
                                    <form class="trip-form mt-4 px-2" @submit.prevent="search">
                                        <div class="row  flex-column">
                                            <div class="w-100 mb-3 col-4">
                                                <el-select
                                                    class="w-100"
                                                    v-model="location"
                                                    size="large"
                                                    placeholder="Pickup..."
                                                    disabled>
                                                </el-select>
                                            </div>
                                            <div class="mb-3 col-4">
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
                                            <div class="mb-3 col-2 offset-1">
                                                <input
                                                    type="submit"
                                                    value="Check Availability"
                                                    class="btn-main btn-fullwidth rounded-3"
                                                    style="padding: 7px 25px"
                                                />
                                            </div>
                                        </div>
                                    </form>
                                    <div class="clearfix"></div>
                                </form>
                                <form class="trip-form mt-4 px-2 col-12" @submit.prevent="book">
                                    <input type='submit' id='send_message' value='Continue To Payment' class="btn-main btn-fullwidth offset-9 col-md-3">
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <div v-else>
            <Loader />
            </div>
        </div>
    </div>
    </body>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import {usePage, useForm} from '@inertiajs/vue3';
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import HeaderOne from '../components/HeaderOne.vue'
import Loader from '../components/Loader.vue'
import {router} from "@inertiajs/vue3";
import {CAccordion,CAccordionItem,CAccordionHeader,CAccordionBody} from '@coreui/vue';



const isOpen = ref(false)

const closeModal = () => {
    isOpen.value = false;
}


const id = ref('')
const vehicle = ref('')
const currency = ref('')
const date = ref([]);
const location = ref("");
const priceTax = ref("");
const daysNumber = ref("");
const loading = ref(false);
const form = useForm({
    pickupLoc: "",
    date: "",
    date_from: "",
    date_to: "",
    vehicle: "",
    price: "",
});
const $toast = useToast();

const activeRentalTerms = ref('');
const openRentalTerms = (vehicle) => {
    isOpen.value = true
    activeRentalTerms.value = vehicle.rental_terms
}
const setParams = async () => {
    let urlParams =  new URLSearchParams(window.location.search);
    if(urlParams.has('pickupLoc')){
        location.value =  urlParams.get('pickupLoc')
        form.pickupLoc = urlParams.get('pickupLoc')
    }
    if(urlParams.has('date_from')){
        date.value[0] =  urlParams.get('date_from')
    }
    if(urlParams.has('date_to')){
        date.value[1] =  urlParams.get('date_to')
    }
    if(urlParams.has('date')){
       form.date = urlParams.get('date')
    }
    if(urlParams.has('id')){
        id.value =  urlParams.get('id')
        form.id =  urlParams.get('id')
    }
    getVehicle()
}
const getVehicle = async () => {
    try {
        loading.value = true


        const response = await axios.post('/get/vehicle/data', {
            id: id.value,
            currency: localStorage.getItem('currency') ?? 'USD',
            date: date.value,
            location: location.value

        })
        vehicle.value = response.data.data.vehicle
        form.vehicle = vehicle.value.id
        form.price = vehicle.value.final_price
        form.date = response.data.data.date
        date.value = response.data.data.date
        location.value = response.data.data.location
        daysNumber.value = response.data.data.days
        loading.value = false

    } catch (error) {
        if(!error.response.data.status) {
            $toast.error('Please Select Date and pickup', {position: 'top'})
            router.get('/')
        }
        loading.value = false
        console.error(error)
    }
}

const fetchVehicles = async () => {
    try {
        const response = await axios.post("/filter/vehicles");
        date.value = response.data.date;
        console.log(response.data)
        priceTax.value = response.data.priceTax;
        daysNumber.value = '';
        daysNumber.value = response.data.days;
    } catch (error) {
        if(!error.response.data.status) {
            $toast.error('Please Select Date and pickup', {position: 'top'})
            router.get('/')
        }
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
    form.date_from = date.value[0];
    form.date_to = date.value[1];
    getVehicle();
};


onMounted(() => {
    currency.value = localStorage.getItem('currency') ?? 'USD'
    setParams();
    // fetchVehicles();
})

</script>

<style scoped>
li::before {
    display: none;
}
.item-list {
    display: grid;
    align-items: flex-end;
    padding: 20px;
    background: #ffffff;
    border: solid 1px #dddddd;
    box-shadow: 3px 3px 9px rgba(164,164,186,0.2);
    border-radius: 6px;
}
</style>
