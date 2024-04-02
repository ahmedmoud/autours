<template>
    <body>
    <div id="wrapper">

        <!-- header begin -->
        <header-one/>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>
            <section id="section-car-details" >
                <div class="container mt-5">

                    <div class="row align-items-center">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <!-- Bg -->
                            <div class="pt-20 rounded-top" style="background: url('/images/akrom.jpg'); height: 345px;  background-size: cover;">
                            </div>
                            <div class="card rounded-bottom smooth-shadow-sm">
                                <div class="d-flex align-items-center justify-content-between pt-4 pb-6 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xxl avatar-indicators  me-2 position-relative d-flex justify-content-end align-items-end mt-n10">
                                            <div class="position-absolute mr-3 cursor-pointer"><i class="fa fa-camera"/></div>
                                            <input type="file" v-on:change="uploadPhoto" id="profile_pic" hidden />
                                            <img @click="updatePhoto" :src="'img/' + user.logo" class="cursor-pointer avatar-xxl rounded-circle border border-2 " alt="Image" />
                                        </div>
                                        <div class="lh-1">
                                            <h2 class="mb-0">{{user.name}}
                                                <a href="#!" class="text-decoration-none">

                                                </a>
                                            </h2>
                                            <p class="mb-0 d-block">{{user.email}}</p>
                                        </div>
                                    </div>
                                    <div>
<!--                                        <a href="#" class="btn btn-outline-primary d-none d-md-block">Edit Profile</a>-->
                                    </div>
                                </div>
                                <ul class="nav nav-lt-tab px-4" id="pills-tab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" href="#"> Rentals ({{user.rentals?.length}})</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="py-6">
                        <div class="row">
                            <div v-for="rental in user.rentals" class="col-lg-4 col-12">
                                <!-- card -->
                                <div class="card mb-5 rounded-3">
                                    <div>
                                        <img :src="'img/vehicles/'+ rental.vehicle.photo" alt="Image" class="img-fluid rounded-top">
                                    </div>
                                    <!-- avatar -->
                                    <div class="avatar avatar-xl mt-n7 ms-4">
                                        <img :src="'img/'+ rental.vehicle.supplier.logo" alt="Image"
                                             class="rounded-circle border-4
              border-white-color-40">
                                    </div>
                                    <!-- card body -->
                                    <div class="card-body">
                                        <!-- Title -->
                                        <h4 class="mb-1">{{rental.vehicle.name}}</h4>
                                        <p>{{rental.vehicle.supplier.name}}</p>
                                        <p>{{rental.start_date}} to {{rental.end_date}}</p>
                                        <div>
                                            <!-- Dropdown -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a style="color:white" :class="
                                                rental.status.id=== 2 ? 'btn btn-success'
                                                : rental.status.id=== 3 ? 'btn btn-danger'
                                                : rental.status.id=== 4 ? 'btn btn-warning'
                                                 : 'btn btn-primary' ">{{rental.status.name_en}}</a>
                                                <div >
                                                    {{rental.vehicle.branch.location}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- content begin -->
    <Footer/>
    </body>
</template>
<script setup>
import {ref, onMounted} from 'vue'
import Footer from "../components/Footer.vue";
import HeaderOne from "../components/HeaderOne.vue";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import {router} from '@inertiajs/vue3';

const $toast = useToast();
const loading = ref(false)
const user = ref('');
const photo = ref('');

const uploadPhoto = async (event) => {
    try {
        let d = confirm("Are you sure you want to update the profile picture ?")
        if (!d) return;
        photo.value = event.target.files[0]
        const formData = new FormData();
        formData.append('logo', photo.value)


        const response = await axios.post('upload', formData);
        if (response.data.message === 0) {
            $toast.success("profile picture updated successfully!")
            getUser()
        }
    } catch (e) {
        console.log(e)
        $toast.error("Something went wrong!")
    }
}
const updatePhoto = () => {
    document.getElementById('profile_pic').click()
}

const getUser = async () => {
    try {
        loading.value = true
        const params = {};

        const response = await axios.get('/my-current-user-profile' );
        user.value = response.data.data;
        console.log(user.value)
    } catch (error) {
       router.get('/')
    } finally {
        loading.value = false;
    }
}
onMounted(() => {
    getUser()
})


</script>
<style>

.card {
    border: 0;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,20,.08), 0 1px 2px rgba(0,0,20,.08);
}
.rounded-bottom {
    border-bottom-left-radius: 0.375rem !important;
    border-bottom-right-radius: 0.375rem !important;
}

.avatar-xxl {
    height: 7.5rem;
    width: 7.5rem;
}
.nav-lt-tab {
    border-top: 1px solid var(--dashui-border-color);
}
.px-4 {
    padding-left: 1rem!important;
    padding-right: 1rem!important;
}

.avatar-sm {
    height: 2rem;
    width: 2rem;
}

.nav-lt-tab .nav-item {
    margin: -0.0625rem 1rem 0;
}
.nav-lt-tab .nav-item .nav-link {
    border-radius: 0;
    border-top: 2px solid transparent;
    color: var(--dashui-gray-600);
    font-weight: 500;
    padding: 1rem 0;
}

.pt-20 {
    padding-top: 8rem!important;
}

.avatar-xxl.avatar-indicators:before {
    bottom: 5px;
    height: 16%;
    right: 17%;
    width: 16%;
}
.avatar-online:before {
    background-color: #198754;
}
.avatar-indicators:before {
    border: 2px solid #FFF;
    border-radius: 50%;
    bottom: 0;
    content: "";
    display: table;
    height: 30%;
    position: absolute;
    right: 5%;
    width: 30%;
}

.avatar-xxl {
    height: 7.5rem;
    width: 7.5rem;
}
.mt-n10 {
    margin-top: -3rem!important;
}
.me-2 {
    margin-right: 0.5rem!important;
}
.align-items-end {
    align-items: flex-end!important;
}
.rounded-circle {
    border-radius: 50%!important;
}
.border-2 {
    --dashui-border-width: 2px;
}
.border {
    border: 1px solid #dcdcdc !important;
}

.py-6 {
    padding-bottom: 1.5rem!important;
    padding-top: 1.5rem!important;
}

.bg-gray-300 {
    --dashui-bg-opacity: 1;
    background-color: #cbd5e1!important;
}

.mb-6 {
    margin-bottom: 1.5rem!important;
}
.align-items-center {
    align-items: center!important;
}


.mb-4 {
    margin-bottom: 1rem!important;
}

.mb-8 {
    margin-bottom: 2rem!important;
}
.shadow-none {
    box-shadow: none!important;
}

.card>.list-group:last-child {
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
    border-bottom-width: 0;
}
.card>.list-group:first-child {
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
    border-top-width: 0;
}
.card>.list-group {
    border-bottom: inherit;
    border-top: inherit;
}

.avatar-xl {
    height: 5rem;
    width: 5rem;
}
.avatar {
    display: inline-block;
    height: 3rem;
    position: relative;
    width: 3rem;
}
.mt-n7 {
    margin-top: -1.75rem!important;
}
.ms-4 {
    margin-left: 1rem!important;
}

.avatar img {
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    width: 100%;
}
</style>
