<template>

<header>
    <div class="row justify-content-between">
        <Link href="/" class="col-2">
            <img style="max-width:150px;" src="/img/logo.svg" alt="logo">
        </Link>
        <div class="col-6 align-self-center text-right d-flex justify-content-end">
            <div v-if="!user" class="d-flex">
                <Link  class="nav-link" href="/login"><span>Manage Booking</span></Link>
                <Link  class="nav-link" href="/register"><span>Register</span></Link>
            </div>
            <Link v-else class="nav-link" href="/company"><span>My Profile</span></Link>
        </div>
    </div>
</header>

</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
const user = ref('')

const getUser = async () => {
    try{
        const response = await axios.get('/get/user/data');
        user.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

onMounted(() => {
  getUser();
})

</script>