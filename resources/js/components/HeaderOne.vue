<template>

    <header style="background: #f9d602">
    <div class="row justify-content-between" >
        <Link href="/" class="col-2">
            <img style="max-width:150px;" src="/images/akrom.jpg" alt="logo">
        </Link>


        <div class="col-10 align-self-center text-right d-flex justify-content-end">

            <div v-if="!user" class="row">
<!--                <Link  class="nav-link col-md-3" style="color: #0a3622" href="/login"><span>Login</span></Link>-->
                <Link  class="nav-link col-md-6" style="color: #0a3622" href="/register"><span>Manage Booking</span></Link>
            </div>
            <Link v-else class="nav-link col-md-2" style="color: #0a3622" href="/company"><span>My Profile</span></Link>

            <CDropdown togglerText="Dropdown button" class="mt-1">
                <CDropdownToggle component="a" style="color: rgba(30, 30, 30, 1);">{{selectedCurrency}}</CDropdownToggle>
                <CDropdownMenu>
                    <CDropdownItem v-for="currency in currencies" v-on:click="changeCurrency(currency.name)" >{{currency.flag}} {{currency.name}}</CDropdownItem>
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
import { Link,router } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import { CDropdown,CDropdownItem,CDropdownMenu,CDropdownToggle } from '@coreui/vue';
import getUnicodeFlagIcon from 'country-flag-icons/unicode'

const currencies = [
    {name: 'USD', flag: getUnicodeFlagIcon('US')},
    {name: 'AED', flag: getUnicodeFlagIcon('AE')},
    {name: 'EUR', flag: getUnicodeFlagIcon('EU')},
    {name: 'GBP', flag: getUnicodeFlagIcon('US')},
    {name: 'SAR', flag: getUnicodeFlagIcon('SA')},
    {name: 'EGP', flag: getUnicodeFlagIcon('EG')}
];

const user = ref('')
let selectedCurrency = ref('EGP');
const getUser = async () => {
    try{
        const response = await axios.get('/get/user/data');
        user.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

const changeCurrency =  (currency) => {
selectedCurrency.value = currency
    localStorage.removeItem('currency')
    localStorage.setItem('currency', currency)
    window.location.reload()
}

onMounted(() => {

    selectedCurrency.value = localStorage.getItem('currency') ?? 'EGP'
    getUser();
})

</script>
