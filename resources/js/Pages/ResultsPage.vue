<template>
    <body>
    <div id="wrapper">
        <!-- header begin -->
        <header-one/>
        <!-- header close -->
        <!-- content begin -->
        <div class="mt-3" style="background: #ececec" id="content">
            <div id="top"></div>
            <!--            <ProgressBar class="col-12" mode="indeterminate" style="height: 6px"></ProgressBar>-->

            <div v-if="isOpen" class="modal-mask">
                <div class="modal-wrapper" @click="$emit('close')">
                    <div class="modal-container" ref="target">
                        <div class="modal-header">
                            <slot name="header"> Rental Terms</slot>
                        </div>
                        <div class="modal-body overflow-y-auto" style="max-height: calc(100vh - 210px);">
                            <CAccordion>
                                <CAccordionItem v-for="(item,index) in activeRentalTerms" :item-key="index">
                                    <CAccordionHeader>
                                        <div v-html="item.title"></div>
                                    </CAccordionHeader>
                                    <CAccordionBody>
                                        <div v-html="item.description"></div>
                                    </CAccordionBody>
                                </CAccordionItem>
                            </CAccordion>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <div>
                                    <button class="btn btn-primary" @click="closeModal()">Done</button>
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>

            <div id="section-cars">
                <div class="col-md-12  steps-buttons mb-5 position-relative" style="left: 15%;">
                    <button class="mr-1 mt-2 btn steps-button "
                            style="width:420px; background: #f9d602; color: #000;"><span
                        class="ti ti-circle-number-1 mr-1"/>Choose Your Location
                    </button>
                    <button class="mr-1 btn mt-2 steps-button active"
                            style="width:420px; background: rgb(155,147,84);color: #000;"><span
                        class="ti ti-circle-number-2 mr-2"/>Choose Your Car
                    </button>
                    <button class="btn mt-2 steps-button" style="width:420px; background: #f9d602; color: #000; "><span
                        class="ti ti-circle-number-3 mr-2"/>Reserve Your Car
                    </button>
                </div>


                <div class="" style="width: 90%; padding-left: 10%;">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="col-md-12 pb-4" style="background: #fff;">
                                <div class="p-1"
                                     style="background: #e1e1e1; width: 107.5%; margin-left: -12px; margin-top: 10px;">
                                    <h5 class="p-2">YOUR SEARCH DETAILS</h5>
                                </div>
                                <div class=" mt-3 row" style="background: #fff;">
                                    <h5>PICK-UP - LOCATION </h5>
                                    <p class="col-11"><span class="  ti ti-gps"></span>&nbsp;{{ form.pickupLoc }}</p>

                                    <span class="col-md-6 ti ti-calendar">&nbsp;{{ form.date_from }}</span>
                                    <span class="col-md-3 ti ti-clock">&nbsp;{{ form.time_from }}</span>
                                </div>
                                <hr/>
                                <div class=" mt-3 row" style="background: #fff;">
                                    <h5>DROP-OFF - LOCATION </h5>

                                    <p class="col-11"><span class="  ti ti-gps"></span>&nbsp;{{ form.pickupLoc }}</p>

                                    <span class="col-md-6 ti ti-calendar">&nbsp;{{ form.date_to }}</span>
                                    <span class="col-md-3 ti ti-clock">&nbsp;{{ form.time_to }}</span>
                                </div>
                            </div>
                            <div class="col-md-12 pb-4"></div>

                            <div class="col-md-12 pb-4" style="background: #fff;">
                                <div class="p-2 pt-3"
                                     style="overflow: hidden; background: #e1e1e1; width: 107.5%; margin-left: -12px;">
                                    <h5>FILTER BY</h5>
                                </div>
                                <div class="mt-3">
                                    <form class="trip-form mt-4 px-2" @submit.prevent="search">
                                        <div class="row align-items-center flex-column">
                                            <div class="mb-3 col-md-11">
                                                <el-select class="w-100" v-model="form.pickupLoc" size="large"
                                                           filterable
                                                           remote
                                                           reserve-keyword placeholder="PICKUP..."
                                                           remote-show-suffix
                                                           :remote-method="remoteLocations"
                                                           :loading="locations.loading.value">
                                                    <el-option v-for="item in locations.all.value" :label="item"
                                                               :value="item"/>
                                                </el-select>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="form-control-wrap col-md-7">
                                                    <el-date-picker v-model="form.date_from"
                                                                    start-placeholder="Start date"
                                                                    end-placeholder="End date"
                                                                    size="large" format="YYYY/MM/DD"
                                                                    value-format="YYYY-MM-DD"/>
                                                </div>
                                                <div class="col-md-5">
                                                    <el-time-picker
                                                        v-model="form.time_from"
                                                        type="range"
                                                        size="large"
                                                        required="true"
                                                        value-format="HH:mm"
                                                        format="HH:mm"
                                                        placeholder="10:00"

                                                    />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="form-control-wrap col-md-7">
                                                    <el-date-picker v-model="form.date_to" range-separator="To"
                                                                    start-placeholder="Start date"
                                                                    end-placeholder="End date"
                                                                    size="large" format="YYYY/MM/DD"
                                                                    value-format="YYYY-MM-DD"/>
                                                </div>
                                                <div class="col-md-5">
                                                    <el-time-picker
                                                        v-model="form.time_to"
                                                        type="range"
                                                        range-separator="TO"
                                                        size="large"
                                                        required="true"
                                                        value-format="HH:mm"
                                                        format="HH:mm"
                                                        placeholder="10:00"

                                                    />
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="submit" value="Search"
                                                       class="btn-main btn-fullwidth "
                                                       style="padding: 7px 25px"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12 mt-2" style="background: #fff;">
                                    <h5 style="margin-bottom: -30px">PRICE RANGE <span class="col-md-1"
                                                                                       style="font-size: small;">&nbsp;{{
                                            priceRange
                                        }}&nbsp;-&nbsp;{{ max }}</span></h5>
                                    <hr/>
                                    <div class="row" style="margin-top: -20px">
                                        <el-slider class="col-md-12" v-model="priceRange" :min="min" :max="max"/>
                                    </div>
                                </div>

                                <div class="col-md-12 my-2" style="background: #fff;">
                                    <div class="row" @click="collapse('ms')">
                                        <h4 class="col-md-10" style="margin-bottom: -30px">
                                            Suppliers</h4> <i
                                        :class="'col-md-2 fa fa-arrow-down cursor-pointer  pointer-arrow-ms' "/></div>
                                    <hr/>
                                    <div style="margin-top: -45px" id="ms">
                                        <div class="row" v-for="supplier in filteredSuppliers">
                                            <div class="row" v-if="supplier?.vehicle_count">
                                                <strong class="col-md-10 mt-2">{{
                                                        supplier.company + ' (' + supplier?.vehicle_count + ')'
                                                    }}&nbsp;</strong>
                                                <el-checkbox
                                                    class="col-md-1"
                                                    size="large"
                                                    :model="supplier"
                                                    @click="selectSupplier(supplier.id)"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div v-for="(item, i) in filteredSpecifications" :key="i" style="background: #fff;">
                                    <div class="col-md-12 my-2  ">
                                        <div @click="collapse(item.id)" class="row"><h4 class="col-md-10"
                                                                                        style="margin-bottom: -30px">
                                            {{ item.name }}</h4>
                                            <i :class="'col-md-2 fa fa-arrow-down cursor-pointer ' +  'pointer-arrow-' + item.id"/>
                                        </div>
                                        <hr style="margin-top: 20px"/>
                                        <div style="margin-top: -35px" :id="item.id">
                                            <div class="row" v-for="option in item.options">
                                                <div class="row col-md-12" v-if="option.vehicle_count">
                                                    <strong class="col-md-10 ">{{
                                                            option.value + ` (${option.vehicle_count})`
                                                        }} </strong>
                                                    <el-checkbox
                                                        class="col-md-1 "
                                                        size="large"
                                                        :model="specification[i]"
                                                        @click="selectSpecification(item, option)"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="loading" class="col-lg-5" style=" margin-top: 10%; margin-left: 10%;">
                            <Loader style=" margin-top: 40%; margin-left: 25%;" />
                        </div>
                        <div v-else  class="col-lg-9">
                            <div class="row filter_top_group">
                                <div style="height: 115px; margin-top: 75px; margin-right: 3%; "
                                     class="col-md-1 category" :id="'category' + item.id"
                                     v-for="item in filteredCategories">
                                    <el-radio v-model="category" :label="item.id" size="large" border
                                              @click="SelectCategory(item.id)">
                                        <div class="item_filter_group filter_top " style="background: #fff;">
                                            <h4>{{ item.name }}</h4>
                                            <img :src="'img/categories/'+item.photo" width="40" height="80"/>
                                        </div>
                                    </el-radio>
                                </div>
                            </div>

                            <h3>SEARCH RESULT <strong style="color: #bdaa2f;">{{ count }} CARS FOUND</strong></h3>
                            <div v-for="(vehicle, index) in priceFiltered" :key="index" class="row col-md-12">
                                <div :style="getDisplayStyle(vehicle)" >
                                    <div class="de-item-list mb-3 p-4 ">
                                        <div class="close" style="position: absolute; top: 10px;right: 35px; cursor: pointer;" @click="hideItem(index)">
                                            <svg width="25" height="25" fill="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M19.505 4.975a.6.6 0 0 1 0 .85l-13.2 13.2a.6.6 0 0 1-.85-.85l13.2-13.2a.598.598 0 0 1 .85 0Z"
                                                      clip-rule="evenodd"></path>
                                                <path fill-rule="evenodd"
                                                      d="M5.456 4.975a.6.6 0 0 0 0 .85l13.2 13.2a.6.6 0 1 0 .85-.85l-13.2-13.2a.6.6 0 0 0-.85 0Z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="col-md-12">
                                                <div class="col-md-2 d-img">
                                                    <img :src="'img/vehicles/' + vehicle.photo" class="img-fluid"
                                                         width="300" height="100"
                                                         alt=""/>
                                                </div>
                                                <div class="d-info">
                                                    <div class="d-text">
                                                        <h4 class="text-nowrap">
                                                            {{ vehicle.name }}
                                                            <span
                                                                style="font-weight: 600;color: #727272;font-size: 16px;">or&nbsp;Similar</span>
                                                        </h4>
                                                        <span>{{ vehicle?.category?.name }}</span>
                                                        <div class="d-atr-group row">
                                                            <ul class="d-atr col-md-8">
                                                                <li v-for="specification in vehicle.specifications">
                                                                    <img  style="width:15%; margin-right: 5px;" :src="'assets/images/icons/' + specification.icon + '.svg'"/>
                                                                    <span > {{
                                                                            specification.option
                                                                        }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class=" rounded-2  mb-3 mt-3 py-1   justify-content-between align-items-center col-md-9"
                                                style="background: #edecec; ">
                                                <div class="d-supplier">
                                                    <div class="col-md-3 d-img w-100" style="height: 50px; margin-left: -15px;">
                                                        <img :src="'img/' + vehicle.supplier.logo" height="50"
                                                             width="80" alt=""/>
                                                    </div>
                                                    <div class="col-md-2 row">
                                                        <div>
                                                            <span style="font-size: 1rm; margin-left: -40px;"
                                                                  class="text-nowrap">{{
                                                                    vehicle.supplier.company
                                                                }}</span>
                                                        </div>
                                                        <div style="margin-left: -50px">
                                                            <small><a class="cursor-pointer text-primary"
                                                                      href="javascript:void(0);"
                                                                      @click="openRentalTerms(vehicle)">Rental&nbsp;Terms</a></small>
                                                        </div>
                                                    </div>
                                                    <div >
                                                        <span class="py-2 px-1 rounded-1"
                                                              style=" background-color: #f9d602; font-size: 1.0em;font-weight: 600;">7.1/10</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="be_media-body"><h5>Good</h5><span
                                                            style="font-size: medium;">(&nbsp;<strong
                                                            style="color: #f9d602">1000&nbsp;</strong>+&nbsp;reviews)</span></span>
                                                    </div>
                                                    <div v-if="vehicle.instant_confirmation" class="col-md-2">
                                                            <button class="scv-badge badge-white be_media" tabindex="0">
                                                            <i style="color: gold;" class="mt-1 px-2 fa fa-check fa-xl be_media-left be_media-middle"/>
                                                            <span class="scv-inst-text text-nowrap" style="color: #000;">Instant Confirmation</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="de-item-list col-md-9 justify-content-between align-items-center bg-light-gray">
                                                    <div class="row col-md-8">
                                                        <p class="primary bold mb-0"  style="color: #5e9007;">What is Included!</p>
                                                        <ul class="row" >
                                                            <li class="col-md-6" style="height: 20px"
                                                                v-for="(item, index) in vehicle.included ">
                                                                <div class="row" v-if="index < 4">
                                                                    <i class="col-md-1 fa fa-check fa-l mt-2 text-nowrap"
                                                                       style="color: green;"/>
                                                                    <p class="col-md-10 text-nowrap" style="font-size: 80%;">
                                                                        {{ item.what_is_included }}</p>
                                                                </div>
                                                                <div :class="'row text-nowrap vehicle-'+vehicle.id"
                                                                     style="display: none;" v-else>
                                                                    <i class="col-md-1 fa fa-check fa-l mt-2 text-nowrap"
                                                                       style="color: green;"/>
                                                                    <p class="col-md-10 text-nowrap" style="font-size: 13px;">
                                                                        {{ item.what_is_included }}</p>
                                                                </div>
                                                            </li>
                                                            <span @click="showMoreIncluded(vehicle.id)"
                                                                  class="col-md-6 cursor-pointer"
                                                                  :id="'show-more'+ vehicle.id"
                                                                  v-if="vehicle.included.length > 4 ">Show more ...</span>
                                                        </ul>
                                                    </div>
                                                    <div class="row mb-5">
                                                        <div class="col-md-12">
                                                            <p class="text-nowrap"><i class="fa fa-location"/>Address:&nbsp;<small>{{vehicle.supplier.address }}</small></p>
                                                        </div>
                                                        <div class="col-md-12" style="margin-top: -20px">
                                                            <span class="text-nowrap"><i class="fa fa-gas-pump"/></span>
                                                            Fuel Policy: <small> Full to Full </small></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-price d-total offset-1">
                                                     <span class="d-days">for {{ daysNumber }} day{{daysNumber < 2 ? '' : 's'}}</span>
                                                        <span class="text-nowrap">{{ vehicle.final_price }} {{selectedCurrency }}</span>
                                                    <a class="btn-main select-btn cursor-pointer text-white" @click="goToBookingPage(vehicle.id)">Select
                                                        <svg width="25" height="25" fill="currentColor"
                                                             viewBox="0 2 20 20"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="m8.295 16.59 4.58-4.59-4.58-4.59L9.705 6l6 6-6 6-1.41-1.41Z"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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
import {onMounted, ref, watchEffect, computed} from "vue";
import {useForm, Link, router} from "@inertiajs/vue3";
import HeaderOne from "../components/HeaderOne.vue";
import {CAccordion, CAccordionItem, CAccordionHeader, CAccordionBody} from '@coreui/vue';
import Footer from "../components/Footer.vue";
import Loader from "../components/Loader.vue"
const isOpen = ref(false)

const closeModal = () => {
    isOpen.value = false;
}
const form = {
    pickupLoc: '',
    id: '',
    currency: '',
    date_from: '',
    date_to: '',
    time_from: '',
    time_to: '',
    category: '',
    supplier: '',
    booking_id: '',
    specifications: []
}

const locations = {
    all: ref([]),
    options: ref([]),
    loading: ref(false),
};
let vehicleIds = [];

const loading = ref(false);
const category = ref("");
const supplier = ref([]);
const filteredVehicles = ref("");
const filteredCategories = ref("");
const filteredSuppliers = ref("");
const filteredSpecifications = ref([]);
const count = ref("");
const price = ref(0);
const max = ref(0)
const min = ref(0)
const priceTax = ref("");
const priceRange = ref(10000);
const daysNumber = ref("");
const specification = ref([]);
const getLocations = async () => {
    locations.loading.value = true;
    try {
        const response = await axios.get("/get/locations");
        locations.all.value = Object.values(response.data);

    } catch (error) {
        console.error(error);
    } finally {
        locations.loading.value = false;
    }
};

const showMoreIncluded = (vehicle_id) => {
    var elements = document.querySelectorAll('.vehicle-' + vehicle_id);
    const showMoreElement = document.getElementById('show-more' + vehicle_id);
// Loop through each element to apply the display toggle logic
    elements.forEach(function (element) {
        const display = element.style.display;

        if (display === 'none') {
            element.style.display = '';
            showMoreElement.textContent = 'Show less ...';
        } else {
            element.style.display = 'none';
            showMoreElement.textContent = 'Show more ...';
        }
    });
}
const remoteLocations = (query) => {
    if (query) {
        locations.loading.value = true;
        setTimeout(() => {
            locations.loading.value = false;
            locations.options.value = locations.all.value.filter((item) =>
                item.toLowerCase().includes(query.toLowerCase())
            );
        }, 200);
    } else {
        locations.options.value = [];
    }
};
const collapse = (menu) => {
    if ($("#" + menu).css('display') === 'block') {
        $('.pointer-arrow-' + menu).removeClass('fa-arrow-down')
        $('.pointer-arrow-' + menu).addClass('fa-arrow-right')
    } else if ($("#" + menu).css('display') === 'none') {
        $('.pointer-arrow-' + menu).removeClass('fa-arrow-right')
        $('.pointer-arrow-' + menu).addClass('fa-arrow-down')
    }

    $("#" + menu).toggle('slide')

}
const getSpecifications = async () => {

    console.log(filteredVehicles.value)
    if (vehicleIds.length <= 0) {
        vehicleIds = filteredVehicles.value.map(a => a.id)
    }
    const response = await axios.post('get/filtered/specifications', {vehicle_ids: vehicleIds})
    filteredSpecifications.value = response.data
}
const search = () => {
    form.category = category.value
    form.currency = localStorage.getItem('currency') ?? 'USD';
    let urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('booking_id')) {
        form.booking_id = urlParams.get('booking_id')
    }
    router.get('/results', form)
};
const SelectCategory = (category_id) => {
    $(".category").removeClass('col-md-2')
    $(".category").addClass('col-md-1')
    $(".category").addClass('category')

    $("#category" + category_id).addClass('col-md-2')
    category.value = category_id;
    form.category = category_id
    getVehicles()
}
const selectSupplier = (supplier_id) => {
    if (supplier.value.indexOf(supplier_id) >= 0) {
        supplier.value.splice(supplier.value.indexOf(supplier_id), 1);
    } else {
        supplier.value.push(supplier_id);
    }
    form.supplier = supplier.value
    getVehicles()
}

const selectSpecification = (item, option) => {
    let found = 0;
    for (let i = 0; i < form.specifications.length; i++) {
        if (form.specifications[i].name === item.name) {
            found = 1
            form.specifications[i].option = option
        }
    }
    if (found === 0) {
        form.specifications.push({name: item.name, option: option})
    }
    getVehicles()
}
const getVehicles = async () => {
    try {
        form.currency = localStorage.getItem('currency') ?? 'USD';
        loading.value = true;
        const response = await axios.post("filter/vehicles", form);
        filteredVehicles.value = response.data.filteredVehicles;
        form.pickupLoc = response.data.location;
        form.date_from = response.data.date_from
        form.date_to = response.data.date_to
        filteredCategories.value = response.data.filteredCategories;
        if (filteredSuppliers.value.length <= 0) {
            filteredSuppliers.value = response.data.filteredSuppliers;
        }
        count.value = response.data.count;

        max.value = response.data.max;
        priceRange.value = response.data.max;
        min.value = response.data.min;
        priceTax.value = response.data.priceTax;
        daysNumber.value = '';
        daysNumber.value = response.data.daysNumber;
        const specificationMap = new Map();
        filteredVehicles.value.forEach(vehicle => {
            const specifications = vehicle.specifications;
            for (const key in specifications) {
                if (specifications.hasOwnProperty(key)) {
                    const {name, option} = specifications[key];
                    if (specificationMap.has(name)) {
                        const specItem = specificationMap.get(name);
                        if (!specItem.options.includes(option)) {
                            specItem.options.push(option);
                        }
                    } else {
                        specificationMap.set(name, {name, options: [option]});
                    }
                }
            }
        });


        getSpecifications()
        // filteredSpecifications.value = Array.from(specificationMap.values());
        // specification.value = [];
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

const getFilters = async () => {
    try {
        loading.value = true;
        const formData = new FormData();
        formData.append("category", category.value);
        formData.append("date", date.value);
        formData.append("priceRange", price.value);
        formData.append("supplier", supplier.value);
        formData.append("specification", specification.value);
        formData.append("currency", localStorage.getItem('currency') ?? 'EGP');
        const response = await axios.post("filter/vehicles", formData);
        filteredVehicles.value = response.data.filteredVehicles;
        count.value = response.data.count;
        // max.value = 0;
        // min.value = 0;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

const hideItem = (index) => {
    const item = filteredVehicles.value[index];
    item.isHidden = true;
};

const getDisplayStyle = (item) => {
    return item.isHidden ? "display: none;" : "";
};
const activeRentalTerms = ref('');
const openRentalTerms = (vehicle) => {
    isOpen.value = true
    activeRentalTerms.value = vehicle.rental_terms
}

const priceFiltered = computed(() => {
    if (filteredVehicles.value != []) {
        if (priceRange.value && priceRange.value > min.value) {
            return filteredVehicles.value.filter((vehicle) => {
                return vehicle.final_price <= priceRange.value;
            });
        }
    }
});
const selectedCurrency = computed(() => {
    return localStorage.getItem('currency') ?? 'USD'
})
watchEffect(() => {
    // getFilters();
    getLocations();
});

const goToBookingPage = async (vehicle_id) => {
    form.id = vehicle_id;
    let uri = '/vehicles/book'
    let urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('booking_id')) {
        console.log("=======>")
        console.log(urlParams.get("booking_id"))
        form.booking_id = urlParams.get('booking_id')
        uri = '/update-booking'
    }
    console.log(uri)
    router.get(uri, form)
}
const setParams = async () => {
    let urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('pickupLoc')) {
        form.pickupLoc = await urlParams.get('pickupLoc')
    }
    if (urlParams.has('date_from')) {
        form.date_from = await urlParams.get('date_from')
    }
    if (urlParams.has('date_to')) {
        form.date_to = await urlParams.get('date_to')
    }
    if (urlParams.has('time_from')) {
        form.time_from = await urlParams.get('time_from')
    }
    if (urlParams.has('time_to')) {
        form.time_to = await urlParams.get('time_to')
    }
    if (urlParams.has('category')) {
        category.value = await urlParams.get('category')
    }

    await getVehicles();
}

onMounted(() => {
    setParams();
})
</script>

<style lang="scss">
.show-more-whats-included {
    display: none;
}

@media screen and (max-width: 1328px) {
    .steps-buttons {
        left: 0 !important;
    }
    .steps-button {
        width: 100% !important;
    }
}

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-container {
    width: 900px;
    margin: 150px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
}

.el-slider {
    --el-slider-main-bg-color: #f4d849;
}

.el-radio.is-bordered {
    border: none;
}

.filter_top {
    position: inherit;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 165px;

    img {
        width: 100px;
    }
}

.filter_top_group {
    .el-radio.is-bordered .el-radio__input {
        display: none !important;
    }

    .is-checked {
        .item_filter_group {
            border-color: #f4d849;

            h4 {
                color: #f4d849;
            }
        }
    }
}

.price-range {
    font-size: 14px;
    color: gray;
    font-weight: 500;
}

.is-checked {
    color: #f4d849 !important;
}

.scv-badge.badge-white {
    display: flex;
    min-width: 10px;
    padding: 12px 11px 11px 4px;
    color: #605c5c;
    background-color: #fff;
    border-radius: 2em;
    line-height: 14px;
    vertical-align: middle;
    white-space: normal;
    border: 1px solid #ddd;
}

[id|=sc-be] .be_media {
    overflow: hidden;
    transform: scale(1);
    transform-origin: 0 0;
}

.scv-icon.scv-instant {
    height: 29px;
    min-width: 32px;
    width: 32px;
    display: inline-block;
}

[id|=sc-be] .be_media-middle {
    vertical-align: middle;
}

.scv-inst-text {
    display: inline-block;
    font-size: 11px;
    text-align: left;
    vertical-align: middle;
    -webkit-align-self: center;
    align-self: center;
    margin-left: 2px;
}


</style>
