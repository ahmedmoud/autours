<template>

    <header style="background: #f9d602">
        <div class="row justify-content-between">
            <Link href="/" class="col-2">
                <img style="max-width:150px;" src="/images/akrom.jpg" alt="logo">
            </Link>


            <div class="col-10 align-self-center text-right d-flex justify-content-end">

                <div v-if="!user" class="row">
                    <!--                <Link  class="nav-link col-md-3" style="color: #0a3622" href="/login"><span>Login</span></Link>-->
                    <Link class="nav-link col-md-6" style="color: #0a3622" href="/register"><span>Manage Booking</span>
                    </Link>
                </div>
                <Link v-else-if="user.role !== 'customer'" class="nav-link col-md-2" style="color: #0a3622" href="/company"><span>My Profile</span></Link>
                <nav v-else class="navbar navbar-expand-lg navbar-light mr-5">
                    <CDropdown togglerText="Dropdown button" class="mt-1 offset-9">
                        <CDropdownToggle component="a" style="color: rgba(30, 30, 30, 1);" aria-selected="true">
                            <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                        </CDropdownToggle>
                        <CDropdownMenu>
                            <CDropdownItem href="#">My profile</CDropdownItem>
                            <CDropdownItem href="/logout">Log out</CDropdownItem>
                        </CDropdownMenu>
                    </CDropdown>

                </nav>

                <CDropdown togglerText="Dropdown button" class="mt-1">
                    <CDropdownToggle component="a" style="color: rgba(30, 30, 30, 1);">{{ selectedCurrency }}
                    </CDropdownToggle>
                    <CDropdownMenu>
                        <CDropdownItem v-for="currency in currencies" v-on:click="changeCurrency(currency.name)">
                            {{ getUnicodeFlagIcon(currency.flag) }} {{ currency.name }}
                        </CDropdownItem>
                    </CDropdownMenu>
                </CDropdown>

                <!--            <CDropdown togglerText="Dropdown button" class="mt-1">-->
                <!--                <CDropdownToggle component="a" style="color: rgba(30, 30, 30, 1);" aria-selected="true">English</CDropdownToggle>-->
                <!--                <CDropdownMenu>-->
                <!--                    <CDropdownItem href="#">French</CDropdownItem>-->
                <!--                    <CDropdownItem href="#">Arabic</CDropdownItem>-->
                <!--                </CDropdownMenu>-->
                <!--            </CDropdown>-->
            </div>

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

</script>
