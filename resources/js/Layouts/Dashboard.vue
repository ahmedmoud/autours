<template>
<body>
    <div id="wrapper">
        <header-one />
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <img src="images/background/14.jpg" class="jarallax-img" alt=""
                style="
                    object-fit: cover;
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
									<h1>Dashboard</h1>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- section close -->

            <section id="section-cars" class="bg-gray-100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 mb30">
                            <div class="card p-4 rounded-5">
                                <div class="profile_avatar">
                                    <div v-if="supplier || activeSupplier || reviewing && user.logo !== null" class="profile_img">
                                        <img :src="user.logo ? 'img/' + user.logo : ''" alt="logo" style="border-radius: 100%; object-fit: contain;">
                                    </div>
                                    <div v-else-if=" admin " class="profile_img">
                                        <img src="images/logo_white.png" alt="logo" style="border-radius: 100%; object-fit: contain;">
                                    </div>
                                    <div class="profile_name">
                                        <h4>
                                            {{ user.company }}                                           
                                            <span class="profile_username text-gray"> {{ user.email }}</span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="spacer-20"></div>
                                <ul class="menu-col">

                                    <li class="nav-item active">
                                            <Link class="nav-link"  href="company">
                                                <i class="fa fa-user"></i>
                                                <span>My Profile</span></Link>
                                    </li>

                                    <div v-if="admin">
                                        <li class="nav-item active">
                                            <Link class="nav-link"  href="margin">
                                                <i class="fa fa-dollar-sign"></i>
                                                <span>Profit Margin</span></Link>
                                        </li>
                                        <li class="nav-item active">
                                            <Link class="nav-link"  href="photos">
                                                <i class="fa fa-list"></i>
                                                <span>Vehicles Photos</span></Link>
                                        </li>
                                        <li class="nav-item active">
                                            <Link class="nav-link"  href="categories">
                                                <i class="fa fa-list"></i>
                                                <span>Categories</span></Link>
                                        </li>
                                        <li class="nav-item active">
                                            <Link class="nav-link"  href="specifications">
                                                <i class="fa fa-list"></i>
                                                <span>Specifications</span></Link>
                                        </li>
                                        <li class="nav-item active">
                                            <Link class="nav-link"  href="memberships">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <span>Memberships</span></Link>
                                        </li>

                                        <li class="nav-item active">
                                        <Link class="nav-link"  href="vehicles">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <span>Vehicles</span></Link>
                                        </li>

                                    </div>

                                    <div v-if="activeSupplier"> 
                                        
                                        <li class="nav-item active">
                                            <Link class="nav-link"  href="vehicle">
                                                <i class="fa fa-car"></i>
                                                <span>Crete a Vehicle</span></Link>
                                        </li>

                                        <li class="nav-item active">
                                        <Link class="nav-link"  href="vehicles">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <span>My Vehicles</span></Link>
                                        </li>
                                        
                                    </div>

                                    <div v-if="supplier || activeSupplier || reviewing"> 
                                        
                                        <li class="nav-item active">
                                        <Link class="nav-link"  href="membership">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <span>Membership</span></Link>
                                        </li>

                                    </div>

                                    <div v-if="customer"> 
                                        
                                        <!-- <li class="nav-item active">
                                            <Link class="nav-link" href="dashboard">
                                                <i class="fa fa-bookmark" aria-hidden="true"></i>
                                                <span>Rentals History</span></Link>
                                        </li> -->

                                    </div>

                                    <li class="nav-item active">
                                        <Link class="nav-link"  href="rentals">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <span>Rentals</span></Link>
                                    </li>

                                    <li>
                                        <Link class="nav-link" href="logout">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                <span>Sign Out</span></Link>
                                                
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-9">
                            <div class="main w-100"><slot /></div>
                        </div>
                    </div>
                </div>
            </section>
			
			
        </div>
        <!-- content close -->

        <a href="#" id="back-to-top"></a>        
    </div>

</body>
</template>

<script setup>
import '../../css/bootstrap.min.css'

import '../../css/dashboard.css'
import '../../css/scheme.css'
import '../../css/coloring.css'
import '../../css/app.css'


import { Link } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import HeaderOne from '../components/HeaderOne.vue'

const user = ref('')
const role = ref('')
const admin = ref(false)
const activeSupplier = ref(false)
const supplier = ref(false)
const customer = ref(false)
const reviewing = ref(false)

const getRole = async () => {
    try{
        const response = await axios.get('get/user/role');
        role.value = response.data;
    } catch (error) {
        console.error(error);
    } finally {
        if (role.value === 'admin') {
            admin.value = true
        } else if (role.value === 'active_supplier') {
            activeSupplier.value = true
        } else if (role.value === 'supplier') {
            supplier.value = true
        } else if (role.value === 'customer') {
            customer.value = true
        } else if (role.value === 'reviewing') {
            reviewing.value = true
        }
    }
}

const getUser = async () => {
    try{
        const response = await axios.get('/get/user/data');
        user.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

onMounted(() => {
    getRole();
    getUser();
})

</script>

<style>
header {
    width: 100%;
    position: absolute;  
    padding: 1rem 10%;
    border-bottom: none;
}
</style>