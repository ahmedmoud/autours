<template>

    <header style="background: #f9d602">
    <div class="row justify-content-between" >
        <Link href="/" class="col-2">
            <img style="max-width:150px;" src="/images/akrom.jpg" alt="logo">
        </Link>

        <div class="col-6 align-self-center text-right d-flex justify-content-end">
            <div v-if="!user" class="row">
                <Link  class="nav-link col-md-6" style="color: #0a3622" href="/login"><span>Manage Booking</span></Link>
                <Link  class="nav-link col-md-6" style="color: #0a3622" href="/register"><span>Register</span></Link>
            </div>
            <Link v-else class="nav-link col-md-6" style="color: #0a3622" href="/company"><span>My Profile</span></Link>
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
