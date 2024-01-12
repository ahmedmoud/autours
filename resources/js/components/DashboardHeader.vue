<template>


    <header class="" style=" position: relative; z-index: 50;width: 100%; padding: 0 25px; background: #f9d602; height: 60px;">
        <nav class="navbar navbar-expand-lg navbar-light">
            <Link href="/" class="col-2">
                <img style="max-width:150px;" src="/images/akrom.jpg" alt="logo">
            </Link>
            <div class="col-10 align-self-center text-right d-flex justify-content-end">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                    <li id="nav-dropdown" style="position: relative;" >
                        <a class="nav-link nav-icon-hover show" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="true">
                            <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                        </a>
                        <div id="dorp-menu" class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up show" style="display: none;"  aria-labelledby="drop2" data-bs-popper="static">
                            <div class="message-body">
                                <Link  class="nav-link col-md-12" style="color: #0a3622" href="/company">
                                    <span>My Profile</span>
                                </Link>
                                <a href="logout" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>

        </nav>
    </header>

</template>

<script setup>
import {Link} from '@inertiajs/vue3'
import {onMounted, ref} from 'vue'

const user = ref('')

const getUser = async () => {
    try {
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
