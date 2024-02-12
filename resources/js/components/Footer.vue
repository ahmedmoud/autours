<script setup>
import {Link} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";

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

<template>
    <footer class="" id="copyright" style="background: black;
">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-6 text-white align-self-center text-center text-md-left my-2">
                    Copyright © 2024.
                </div>
                <div class="d-flex align-items-center" style="gap:15px;">
                    <a href="https://www.facebook.com/profile.php?id=61552833342138&mibextid=LQQJ4d" target="_blank">
                        <svg width="25" height="25" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.08 12.539c0-5.335-4.298-9.66-9.6-9.66-5.304.001-9.602 4.325-9.602 9.661 0 4.82 3.511 8.817 8.1 9.541v-6.75H8.542v-2.79h2.438v-2.13c0-2.421 1.434-3.758 3.627-3.758 1.05 0 2.149.188 2.149.188v2.376h-1.21c-1.192 0-1.564.745-1.564 1.51v1.812h2.661l-.425 2.791H13.98v6.75c4.59-.725 8.1-4.72 8.1-9.541Z"></path>
                        </svg>
                    </a>
                    <a href="https://instagram.com/autotours_?igshid=NzZlODBkYWE4Ng%3D%3D&utm_source=qr"
                       target="_blank">
                        <svg width="25" height="25" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2c-2.714 0-3.055.013-4.121.06-1.066.05-1.793.217-2.429.465a4.896 4.896 0 0 0-1.771 1.154A4.909 4.909 0 0 0 2.525 5.45c-.248.635-.416 1.362-.465 2.425C2.013 8.944 2 9.284 2 12.001c0 2.715.013 3.055.06 4.121.05 1.066.217 1.792.465 2.428a4.91 4.91 0 0 0 1.154 1.771 4.88 4.88 0 0 0 1.77 1.154c.637.247 1.362.416 2.427.465 1.068.047 1.408.06 4.124.06 2.716 0 3.055-.012 4.122-.06 1.064-.05 1.793-.218 2.43-.465a4.893 4.893 0 0 0 1.77-1.154 4.91 4.91 0 0 0 1.153-1.771c.246-.636.415-1.363.465-2.428.047-1.066.06-1.406.06-4.122s-.012-3.056-.06-4.124c-.05-1.064-.219-1.791-.465-2.426a4.907 4.907 0 0 0-1.154-1.771 4.888 4.888 0 0 0-1.771-1.154c-.637-.248-1.365-.416-2.429-.465-1.067-.047-1.406-.06-4.123-.06H12Zm-.896 1.803H12c2.67 0 2.987.008 4.04.057.975.044 1.505.208 1.858.344.466.181.8.399 1.15.748.35.35.566.683.747 1.15.138.352.3.882.344 1.857.049 1.053.059 1.37.059 4.039 0 2.668-.01 2.986-.059 4.04-.044.974-.207 1.503-.344 1.856a3.09 3.09 0 0 1-.748 1.149 3.09 3.09 0 0 1-1.15.747c-.35.137-.88.3-1.857.345-1.053.047-1.37.059-4.04.059s-2.987-.011-4.041-.059c-.975-.045-1.504-.208-1.856-.345a3.097 3.097 0 0 1-1.15-.747 3.1 3.1 0 0 1-.75-1.15c-.136-.352-.3-.882-.344-1.857-.047-1.054-.057-1.37-.057-4.041 0-2.67.01-2.985.057-4.039.045-.975.208-1.505.345-1.857.181-.466.399-.8.749-1.15a3.09 3.09 0 0 1 1.15-.748c.352-.137.881-.3 1.856-.345.923-.042 1.28-.055 3.144-.056v.003Zm6.235 1.66a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4ZM12 6.865a5.136 5.136 0 1 0-.16 10.272A5.136 5.136 0 0 0 12 6.865Zm0 1.801a3.334 3.334 0 1 1 0 6.668 3.334 3.334 0 0 1 0-6.668Z"></path>
                        </svg>
                    </a>
                </div>

                <!--<Link v-else class="nav-link col-md-2 offset-8" style="color: #0a3622" href="/company"><span>My Profile</span></Link>-->
                <div class="row" v-if="!user">
                    <a class="nav-link col-12" href="/register"><span>Supplier&nbsp;Login</span></a>
                    <a class="nav-link col-12" href="/register?user_type=supplier"><span>Supplier&nbsp;Signup</span></a>
                </div>
                <div class="col-md-6 align-self-center text-center text-md-right my-2" id="social-media"></div>
            </div>

        </div>
    </footer>

</template>

<style scoped>

</style>
