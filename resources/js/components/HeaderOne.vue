<template>

    <header style="background: #f9d602">
        <div class="row justify-content-between">
            <Link href="/" class="col-2">
                <img style="max-width:150px;" src="/images/akrom.jpg" alt="logo">
            </Link>
            <div class="topnav" id="myTopnav">
                <a v-if="!user" class="nav-link col-md-2 " style="color: #0a3622; margin-left: 52%" href="/register">Manage Booking</a>
                <Link v-else-if="user.role !== 'customer'" class="nav-link col-md-2" style="color: #0a3622"
                      href="/company"><span>My Profile</span></Link>
                <nav v-else class="navbar navbar-expand-lg navbar-light mr-5">
                    <CDropdown togglerText="Dropdown button" class="mt-1 offset-9">
                        <CDropdownToggle component="a" style="color: rgba(30, 30, 30, 1);" aria-selected="true">
                            <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35"
                                 class="rounded-circle">
                        </CDropdownToggle>
                        <CDropdownMenu>
                            <CDropdownItem href="#">My profile</CDropdownItem>
                            <CDropdownItem href="/logout">Log out</CDropdownItem>
                        </CDropdownMenu>
                    </CDropdown>

                </nav>
                <a class="col-md-1">
                    <CDropdown togglerText="Dropdown button" class="mt-1">
                        <CDropdownToggle component="a" style="color: rgba(30, 30, 30, 1);">{{ selectedCurrency }}
                        </CDropdownToggle>
                        <CDropdownMenu>
                            <CDropdownItem class="pointer-event" v-for="currency in currencies"
                                           v-on:click="changeCurrency(currency.name)">
                                {{ getUnicodeFlagIcon(currency.flag) }} {{ currency.name }}
                            </CDropdownItem>
                        </CDropdownMenu>
                    </CDropdown>
                </a>
                <!--                <a href="#news">News</a>-->
                <!--                <a href="#contact">Contact</a>-->
                <!--                <a href="#about">About</a>-->
                <a href="javascript:void(0);" class="icon" @click="myFunction()">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <!--            <div class="col-10 align-self-center text-right d-flex justify-content-end topnav" id="myTopnav">-->


            <!--           -->

            <!--            </div>-->

        </div>
    </header>

</template>
<script setup>
import {Link, router} from '@inertiajs/vue3'
import {onMounted, ref} from 'vue'
import {CDropdown, CDropdownItem, CDropdownMenu, CDropdownToggle} from '@coreui/vue';
import getUnicodeFlagIcon from 'country-flag-icons/unicode'

let currencies = [
    {name: 'USD', flag: getUnicodeFlagIcon('US')},
    {name: 'AED', flag: getUnicodeFlagIcon('AE')},
    {name: 'EGP', flag: getUnicodeFlagIcon('EG')}
];

const user = ref('')
let selectedCurrency = ref('EGP');
const getUser = async () => {
    try {
        const response = await axios.get('/get/user/data');
        user.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

const getCurrencies = async () => {
    try {
        const response = await axios.get('/get/currencies');
        currencies = response.data
    } catch (error) {
        console.log(error.response.data.message);
    }
}
const changeCurrency = (currency) => {
    selectedCurrency.value = currency
    localStorage.removeItem('currency')
    localStorage.setItem('currency', currency)
    window.location.reload()
}

onMounted(() => {

    selectedCurrency.value = localStorage.getItem('currency') ?? 'USD'
    getUser();
    getCurrencies();
})
const myFunction = () => {
    var x = document.getElementById("myTopnav");

    if (x.className === "topnav") {
        x.className += " responsive";
    }  else {
        x.className = "topnav";
    }
}
</script>

<style>
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
}

.topnav {
    overflow: hidden;
    justify-content: flex-end !important;
    align-self: center !important;
    display: contents !important;
    width: 50%;
    height: 10%;
}

.topnav a {
    align-items: end;
    display: block;
    color: #f2f2f2;
    text-align: center;
    //padding: 14px 16px;
    text-decoration: none;

    font-size: 17px;
}

.topnav a:hover {
    background-color: rgba(206, 197, 7, 0.34);
}


.topnav .icon {
    display: none;
}

@media screen and (max-width: 600px) {
    .topnav a {
        display: none;
    }

    .topnav a.icon {
        float: right;
        display: block;
    }
}

@media screen and (max-width: 600px) {
    .topnav.responsive {
        position: relative;
    }

    .topnav.responsive .icon {
        position: absolute;
        right: 0;
        top: 0;
    }

    .topnav.responsive a {
        float: none;
        display: block;
        text-align: left;
    }
}
</style>
