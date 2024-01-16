<template>
    <body>
    <div id="wrapper">
        <!-- header begin -->
        <header-one/>
        <!-- header close -->
        <!-- content begin -->
        <div class="" style="background: #ececec" id="content">
            <div id="top"></div>
            <ProgressBar class="col-12" mode="indeterminate" style="height: 6px"></ProgressBar>

            <section id="section-cars">
                <div class="col-md-12   mb-5" style="margin-left: 18%;">
                    <button class="mr-2  btn " style="width:420px; background: #f9d602; color: #000;"><span
                        class="ti ti-circle-number-1 mr-2"/>Choose Your Location
                    </button>
                    <button class="mr-2 btn mt-2 active"
                            style="width:420px; background: rgb(155,147,84);color: #000;"><span
                        class="ti ti-circle-number-2 mr-2"/>Choose Your Car
                    </button>
                    <button class="btn mt-2" style="width:420px; background: #f9d602; color: #000;"><span
                        class="ti ti-circle-number-3 mr-2"/>Reserve Your Car
                    </button>
                </div>
                <div class="container">
                    <div class="row">


                        <div class="col-lg-3">
                            <div class="col-md-12 pb-4" style="background: #fff;">
                                <div class="p-1"
                                     style="background: #e1e1e1; width: 108.9%; margin-left: -12px; margin-top: 10px;">
                                    <h5 class="p-2">YOUR SEARCH DETAILS</h5>
                                </div>
                                <div class=" mt-3 row" style="background: #fff;">
                                    <h5>PICK-UP - LOCATION </h5>
                                    <span class=" col-md-1 ti ti-gps"></span>
                                    <p class="col-md-11">{{ location }}</p>
                                    <span class="col-md-6 ti ti-calendar">{{ date[0] }}</span>
                                    <span class="col-md-3 ti ti-clock">00:00</span>
                                </div>
                                <hr/>
                                <div class=" mt-3 row" style="background: #fff;">
                                    <h5>DROP-OFF - LOCATION </h5>
                                    <span class=" col-md-1 ti ti-gps"></span>
                                    <p class="col-11">{{ location }}</p>

                                    <span class="col-md-6 ti ti-calendar">{{ date[1] }}</span>
                                    <span class="col-md-3 ti ti-clock">00:00</span>
                                </div>
                            </div>
                            <div class="col-md-12 pb-4"></div>

                            <div class="col-md-12 pb-4" style="background: #fff;">
                                <div class="p-2 pt-3"
                                     style="overflow: hidden; background: #e1e1e1; width: 108.9%; margin-left: -12px;">
                                    <h5>FILTER BY</h5>
                                </div>
                                <div class="mt-3">
                                    <form class="trip-form mt-4 px-2" @submit.prevent="search">
                                        <div class="row align-items-center flex-column">
                                            <div class="w-100 mb-3">
                                                <el-select class="w-100" v-model="location" size="large" filterable
                                                           remote
                                                           reserve-keyword placeholder="PICKUP..."
                                                           remote-show-suffix
                                                           :remote-method="remoteLocations"
                                                           :loading="locations.loading.value">
                                                    <el-option v-for="item in locations.all.value" :label="item"
                                                               :value="item"/>
                                                </el-select>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-control-wrap">
                                                    <el-date-picker v-model="date" type="daterange" range-separator="To"
                                                                    start-placeholder="Start date"
                                                                    end-placeholder="End date"
                                                                    size="large" format="YYYY/MM/DD"
                                                                    value-format="YYYY-MM-DD"/>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="submit" value="Search"
                                                       class="btn-main btn-fullwidth rounded-3"
                                                       style="padding: 7px 25px"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12 mt-2" style="background: #fff;">
                                    <h5 style="margin-bottom: -30px">PRICE RANGE <span class="col-md-1"
                                                                                       style="font-size: small;">{{
                                            priceRange
                                        }} - {{ max }}</span></h5>
                                    <hr/>
                                    <div class="row" style="margin-top: -20px">
                                        <el-slider class="col-md-12" v-model="priceRange" :min="min" :max="max"/>
                                    </div>
                                </div>
                                <div class="col-md-12 my-5" style="background: #fff;">
                                    <h5 style="margin-bottom: -30px">CAR CATEGORIES</h5>
                                    <hr/>
                                    <div style="margin-top: -30px">
                                        <div v-for="category in filteredCategories">
                                            <el-checkbox :label="category.id"
                                                         size="large"
                                                         :model="category"
                                            >
                                                {{ category.name }}
                                            </el-checkbox>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 my-5" style="background: #fff;">
                                    <h4 style="margin-bottom: -30px">Vehicle Suppliers</h4>
                                    <hr/>
                                    <div style="margin-top: -30px">


                                        <el-checkbox v-for="supplier in filteredSuppliers" :label="supplier.id"
                                                     size="large"
                                                     :model="supplier"
                                        >
                                            {{ supplier.company }}
                                        </el-checkbox>
                                    </div>
                                </div>


                                <div v-for="(item, i) in filteredSpecifications" :key="i" style="background: #fff;">
                                    <div class="col-md-12 my-5">
                                        <h4 style="margin-bottom: -30px">{{ item.name }}</h4>
                                        <hr/>
                                        <div style="margin-top: -30px">
                                            <el-checkbox v-for="option in item.options" :label="option" size="large"
                                                         :model="specification[i]"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-loading="loading" class="col-lg-9">
                            <div class="d-flex filter_top_group">
                                <div style="height: 115px; margin-top: 75px; margin-left: -20px;"
                                     v-for="item in filteredCategories">
                                    <el-radio v-model="category" :label="item.id" size="large" border>
                                        <div class="item_filter_group filter_top" style="background: #fff;">
                                            <h4>{{ item.name }}</h4>
                                            <img :src="'img/categories/'+item.photo"/>
                                        </div>
                                    </el-radio>
                                </div>
                            </div>

                            <h3>SEARCH RESULT <strong style="color: #bdaa2f;">{{ count }} CARS FOUND</strong></h3>
                            <div v-for="(vehicle, index) in priceFiltered" :key="index" class="row">
                                <div :style="getDisplayStyle(vehicle)" class="col-lg-12">
                                    <div class="de-item-list mb30 w-100">
                                        <div class="close"
                                             style="position: absolute;top: 9px;right: 25px;cursor: pointer;"
                                             @click="hideItem(index)"
                                        >
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
                                        <div style="width: 120%">
                                            <div>
                                                <div class="col-md-3 d-img">
                                                    <img :src="'img/vehicles/' + vehicle.photo" class="img-fluid"
                                                         width="200" height="100"
                                                         alt=""/>
                                                </div>
                                                <div class="d-info">
                                                    <div class="d-text">
                                                        <h4>
                                                            {{ vehicle.name }}
                                                            <span
                                                                style="font-weight: 600;color: #727272;font-size: 16px;">or Similar</span>
                                                        </h4>
                                                        <span>{{ vehicle?.category?.name }}</span>
                                                        <div class="d-atr-group row">
                                                            <ul class="d-atr col-12">
                                                                <li v-for="specification in vehicle.specifications">
                                                                    <span :class="'fa fa-' + specification.icon"/>
                                                                    <span> {{
                                                                            specification.option
                                                                        }}</span>{{ specification.name }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div
                                                class="de-item-list mb30 mt30 d-flex justify-content-between align-items-center col-11"
                                                style="background: #edecec;">
                                                <div class="d-supplier">
                                                    <div class="d-img w-100" style="height: 50px">
                                                        <img :src="'img/' + vehicle.supplier.logo" height="50" width="50" alt=""/>
                                                    </div>
                                                    <span style="font-size: medium; margin-left: -12px">{{
                                                            vehicle.supplier.company
                                                        }}</span>
                                                    <button class="btn btn-primary w-100">
                                                        <span
                                                            style="background-color: #f9d602;padding: 0.5em 0.4em;font-size: 1.0em;font-weight: 600;">7.1/10</span>
                                                    </button>
                                                    <div>
                                                        <span class="be_media-body"><h5>Good</h5><span
                                                            style="font-size: medium;">(<strong style="color: #f9d602">1000</strong>+ reviews)</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-price d-total w-100 mb30 mt30">
                                            <span class="d-days">for {{ daysNumber }} day{{
                                                    daysNumber < 2 ? '' : 's'
                                                }}</span>
                                            <span>{{ vehicle.final_price }} {{ selectedCurrency }}</span>
                                            <Link class="btn-main select-btn" :href="'/vehicles/' + vehicle.id">
                                                Selcet
                                                <svg width="25" height="25" fill="currentColor" viewBox="0 2 20 20"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="m8.295 16.59 4.58-4.59-4.58-4.59L9.705 6l6 6-6 6-1.41-1.41Z"></path>
                                                </svg>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
import {onMounted, ref, watchEffect, computed} from "vue";
import {useForm, Link, router} from "@inertiajs/vue3";
import HeaderOne from "../components/HeaderOne.vue";
import ProgressBar from "primevue/progressbar"

const form = useForm({
    pickupLoc: "",
    date: "",
});
const date = ref("");
const location = ref("");
const locations = {
    all: ref([]),
    options: ref([]),
    loading: ref(false),
};
const loading = ref(false);
const category = ref("");
const supplier = ref("");
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
const getSpecifications = async () => {
    const response = await axios.get('get/specifications')
    filteredSpecifications.value = response.data
}
const search = () => {
    form.pickupLoc = location.value;
    form.date = date.value;
    form.post("search/vehicles");
    getVehicles();
};

const getVehicles = async () => {
    try {
        loading.value = true;
        const response = await axios.post("filter/vehicles");
        filteredVehicles.value = response.data.filteredVehicles;
        location.value = response.data.location;
        date.value = response.data.date;
        filteredCategories.value = response.data.filteredCategories;
        filteredSuppliers.value = response.data.filteredSuppliers;
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

        filteredSpecifications.value = Array.from(specificationMap.values());
        specification.value = [];
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
        formData.append("priceRange", price.value);
        formData.append("supplier", supplier.value);
        formData.append("specification", specification.value);
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
    return localStorage.getItem('currency') ?? 'EGP'
})
watchEffect(() => {
    getFilters();
    getLocations();
});

onMounted(() => {
    getVehicles();
    getSpecifications();
});
</script>

<style lang="scss">
.el-slider {
    --el-slider-main-bg-color: #f4d849;
}

.el-radio.is-bordered {
    border: none;
}

.filter_top {
    position: relative;
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
</style>
