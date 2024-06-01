<template>

    <header style="background: #f9d602">
        <div class="row justify-content-between">
            <a href="/" class="col-2"><img style="max-width:150px;" src="/images/akrom.jpg" alt="logo"></a>

            <div class="topnav" id="myTopnav">

                <div class="row menu-responsive">

                    <a v-if="!user" class="nav-link col-md-8  text-black bold"  href="/register">Manage&nbsp;Booking</a>
                    <a v-else-if="user.role !== 'customer'" class="nav-link col-md-8 text-black bold"
                       href="/company"><span>My&nbsp;console</span></a>


                    <a v-if="user.role === 'customer'" class="col-md-7">
                        <CDropdown togglerText="Dropdown button" class="mt-1">
                            <CDropdownToggle component="a" style="color: rgba(30, 30, 30, 1);">{{
                                    user.name
                                }}
                            </CDropdownToggle>
                            <CDropdownMenu>
                                <CDropdownItem class="cursor-pointer" @click="() => router.get('/my-profile')"><i
                                    class="fa fa-user text-black bold"/>&nbsp;&nbsp;My&nbsp;Profile
                                </CDropdownItem>
                                <CDropdownItem class="cursor-pointer text-black bold" @click="() => router.get('/logout')"><i
                                    class="fa fa-door-closed"/>&nbsp;&nbsp;Log&nbsp;Out
                                </CDropdownItem>
                            </CDropdownMenu>
                        </CDropdown>
                    </a>
                    <a class="col-md-4">
                        <CDropdown togglerText="Dropdown button" class="mt-1 ">
                            <CDropdownToggle component="a" style="color: rgba(30, 30, 30, 1);">{{
                                    selectedCurrency
                                }}
                            </CDropdownToggle>
                            <CDropdownMenu>
                                <CDropdownItem class="cursor-pointer " v-for="currency in currencies"
                                               v-on:click="changeCurrency(currency.name)">
                                    <p class="text-black bold">{{ getUnicodeFlagIcon(currency.flag) }} {{ currency.name }}</p>
                                </CDropdownItem>
                            </CDropdownMenu>
                        </CDropdown>
                    </a>
                </div>

                <!--                <a href="#news">News</a>-->
                <!--                <a href="#contact">Contact</a>-->
                <!--                <a href="#about">About</a>-->
                <a href="javascript:void(0);" class="icon " @click="myFunction()">
                    <i class="fa fa-bars"/>
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
    } else {
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
    color: black;
    height: 0;
    margin-top: 4%;
}

@media screen and (max-width: 1500px) {
    .nav-icon {
        margin-left: 50% !important;
    }
}

@media screen and (max-width: 1000px) {
    .topnav a {
        display: none;
    }

    .topnav a.icon {
        float: right;
        display: block;

    }

    .topnav p {
        font-size: 5vw;
    }

    .topnav.responsive {
        position: relative;
    }

    .topnav.responsive .icon {
        position: absolute;
        right: 8%;
        top: 3%;
    }

    .topnav.responsive a {
        float: right;
        display: block;
        text-align: right;
    }

    .menu-responsive {
        margin-top: 8%;
    }
}
</style>
