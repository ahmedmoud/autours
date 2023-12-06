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
                    <img src="images/background/2.jpg" class="jarallax-img" alt="" style="object-fit: cover;
                            object-position: center;
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
                            transform: translate3d(0px, -161.5px, 0px);
                        " />
                    <div class="center-y relative text-center">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h1>
                                        <span v-loading="loading">
                                            {{ count }}
                                        </span>
                                        &nbsp; Cars Listings Found
                                    </h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- section close -->

                <section id="section-cars">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="item_filter_group">
                                    <h4>Vehicle Date</h4>
                                    <form class="trip-form mt-4 px-2" @submit.prevent="search">
                                        <div class="row align-items-center flex-column">
                                            <div class="w-100 mb-3">
                                                <el-select class="w-100" v-model="location" size="large" filterable remote
                                                    reserve-keyword placeholder="Pickup..." remote-show-suffix
                                                    :remote-method="remoteLocations
                                                        " :loading="locations.loading.value
        ">
                                                    <el-option v-for="item in locations
                                                        .options.value" :key="item.id" :label="item" :value="item" />
                                                </el-select>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-control-wrap">
                                                    <el-date-picker v-model="date" type="daterange" range-separator="To"
                                                        start-placeholder="Start date" end-placeholder="End date"
                                                        size="large" format="YYYY/MM/DD" value-format="YYYY-MM-DD" />
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="submit" value="Search" class="btn-main btn-fullwidth rounded-3"
                                                    style="padding: 7px 25px" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="item_filter_group">
                                    <h4>Price: <span class="price-range">{{ priceRange }}$</span></h4>
                                    <el-slider v-model="priceRange" :min="min" :max="max" :show-tooltip="false"/>
                                </div>
                                
                                <div class="item_filter_group">
                                    <h4>Vehicle Suppliers</h4>
                                    <el-radio-group v-model="supplier"
                                        class="radio d-flex flex-column align-items-start gap-10">
                                        <el-radio v-for="supplier in filteredSuppliers" :label="supplier.id" size="large"
                                            border>
                                            {{ supplier.company }}
                                        </el-radio>
                                    </el-radio-group>
                                </div>

                                <div class="item_filter_group">
                                    <h4>Vehicle Categories</h4>
                                    <el-radio-group v-model="category"
                                        class="radio d-flex flex-column align-items-start gap-10">
                                        <el-radio v-for="category in filteredCategories" :label="category.id" size="large"
                                            border>
                                            {{ category.name }}</el-radio>
                                    </el-radio-group>
                                </div>

                                <div v-for="(item, i) in filteredSpecifications" :key="i">
                                    <div class="item_filter_group">
                                        <h4>{{ item.name }}</h4>
                                        <el-radio-group v-model="specification[i]"
                                            class="radio d-flex flex-column align-items-start gap-10">
                                            <el-radio v-for="option in item.options" :label="option" size="large"  border/>
                                        </el-radio-group>
                                    </div>
                                </div>
                            </div>

                            <div v-loading="loading" class="col-lg-9">
                                <div class="d-flex filter_top_group">
                                    <div style="height: 115px;margin-top: 75px;margin-left: -20px;" v-for="item in filteredCategories">
                                        <el-radio v-model="category" :label="item.id" size="large" border>
                                            <div class="item_filter_group filter_top">
                                                <h4>{{ item.name }}</h4>
                                                <img :src="'img/categories/' +
                                                    item.photo
                                                    " />
                                            </div>
                                        </el-radio>
                                    </div>
                                </div>

                                <div v-for="(vehicle, index) in priceFiltred" :key="index" class="row">
                                    <div :style="getDisplayStyle(vehicle)" class="col-lg-12">
                                        <div class="de-item-list mb30 w-100">
                                            <div class="close" style="position: absolute;top: 25px;right: 40px;cursor: pointer;" @click="hideItem(index)">
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
                                                <div>
                                                    <div class="d-img">
                                                        <img :src="'img/vehicles/' + vehicle.photo" class="img-fluid" alt="" />
                                                    </div>
                                                    <div class="d-info">
                                                        <div class="d-text">
                                                            <h4>
                                                                {{ vehicle.name }}
                                                                <span style="font-weight: 600;color: #727272;font-size: 16px;">or Similar</span>
                                                            </h4>
                                                            <span>{{vehicle?.category?.name}}</span>
                                                            <div class="d-atr-group">
                                                                <ul class="d-atr">
                                                                    <li v-for="specification in vehicle.specifications">
                                                                        <span>{{specification.name}}</span>{{specification.option}}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div
                                                    class="de-item-list mb30 mt30 d-flex justify-content-between align-items-center">
                                                    <div class="d-supplier">
                                                        <div class="d-img w-100">
                                                            <img style="width: 100px !important;" :src="'img/' + vehicle.supplier.logo" class="w-50 img-fluid" alt="" />
                                                        </div>
                                                        <span>{{ vehicle.supplier.company }}</span>
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="d-price d-total w-100 mb30 mt30">
                                                <span class="d-days">for {{ daysNumber }} day{{ daysNumber < 2  ? '' : 's' }}</span>
                                                <span>{{ calculatedPrice(vehicle, daysNumber) }}$</span>
                                                <Link class="btn-main select-btn" :href="'/vehicles/' + vehicle.id">
                                                   Selcet
                                                   <svg width="25" height="25" fill="currentColor" viewBox="0 2 20 20" xmlns="http://www.w3.org/2000/svg">
                                                       <path d="m8.295 16.59 4.58-4.59-4.58-4.59L9.705 6l6 6-6 6-1.41-1.41Z"></path>
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
import { onMounted, ref, watchEffect, computed } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import HeaderOne from "../components/HeaderOne.vue";

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
const priceRange = ref(0);
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
        max.value = 0;
        min.value = 0;
        priceTax.value = response.data.priceTax;
        daysNumber.value = '';
        daysNumber.value = response.data.daysNumber;
        const specificationMap = new Map();
        filteredVehicles.value.forEach(vehicle => {
        const specifications = vehicle.specifications;
        for (const key in specifications) {
            if (specifications.hasOwnProperty(key)) {
            const { name, option } = specifications[key];
            if (specificationMap.has(name)) {
                const specItem = specificationMap.get(name);
                if (!specItem.options.includes(option)) {
                    specItem.options.push(option);
                }
            } else {
                specificationMap.set(name, { name, options: [option] });
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
        max.value = 0;
        min.value = 0;
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

const calculatedPrice = (vehicle, days) => {
    const basePrice =
    days >= 1 && days < 7 ? vehicle.price :
    days >= 7 && days < 30 ? vehicle.week_price :
    days >= 30 && days < 365 ? vehicle.month_price :
    days >= 365 ? vehicle.year_price : vehicle.price;
    const finalPrice = (basePrice + ((priceTax.value * basePrice) / 100)) * days
    if(finalPrice > max.value){
        max.value = Math.ceil(finalPrice);
        min.value = max.value
    }
    if(finalPrice < min.value){
        min.value = finalPrice;
    }
    return finalPrice;
}

const priceFiltred = computed(() => {
    if(priceRange.value && priceRange.value > min.value){
        return filteredVehicles.value.filter((vehicle) => {
            const price = calculatedPrice(vehicle, daysNumber.value);
            return price <= priceRange.value;
        });
    } else {
        return filteredVehicles.value
    }
});

watchEffect(() => {
    getFilters();
    getLocations();
});

onMounted(() => {
    getVehicles();
});
</script>

<style lang="scss">
.el-slider{
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
            border-color: var(--el-color-primary);
            h4 {
                color: var(--el-color-primary);
            }
        }
    }
}

.price-range{
    font-size: 14px;
    color: gray;
    font-weight: 500;
}
</style>
