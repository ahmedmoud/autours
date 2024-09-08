<script setup>
import {Link, router} from "@inertiajs/vue3";
import {onMounted, ref} from "vue";
import {CDropdown, CDropdownItem, CDropdownMenu, CDropdownToggle} from '@coreui/vue';

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
    <footer class="wrapper" id="copyright" style="background: rgb(249, 214, 2);">
        <div class="container">
            <img src="/images/akrom.jpg" alt="logo" style="max-width: 150px;">
            <hr class="w-25"/>
            <div class="row">
                <div class="col-md-4 " id="company">
                    <h4 class="text-black">Company</h4>
                    <div>
                        <a href="#" class="text-black text-decoration-underline footer_link" >About us</a>
                    </div>
                    <div class="mt-1">
                        <a href="#" class="text-black text-decoration-underline footer_link" >Contact us</a>
                    </div>
                    <div class="mt-1">
                        <a href="#" class="text-black text-decoration-underline footer_link" >Privacy
                            Policy</a>
                    </div>
                    <div class="mt-1">
                        <a href="#" class="text-black text-decoration-underline footer_link" >Terms
                            &Condition</a>
                    </div>
                    <div class="mt-1">
                        <a href="#" class="text-black text-decoration-underline footer_link" >Site Map</a>
                    </div>
                </div>
                <div class="col-md-4" id="support">
                    <div class="row justify-content-between">
                        <h4 class="text-black">Support</h4>
                        <div>
                            <a href="#" class="text-black text-decoration-underline footer_link" >Manage
                                Booking</a>
                        </div>
                        <div class="mt-1">
                            <a href="#" class="text-black text-decoration-underline footer_link" >FAQ</a>
                        </div>
                        <div class="mt-1">
                            <a href="#" class="text-black text-decoration-underline footer_link"
                               >Subscribe</a>
                        </div>
                        <div class="mt-1">
                            <a href="#" class="text-black text-decoration-underline footer_link" >Why
                                Autours?</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" id="support">
                    <div class="row justify-content-between">
                        <h4 class="text-black">Supplier</h4>
                        <div>
                            <a href="#" class="text-black text-decoration-underline footer_link" >Be
                                Supplier</a>
                        </div>
                        <div class="mt-1">
                            <a href="#" class="text-black text-decoration-underline footer_link" >Where we
                                are?</a>
                        </div>
                        <div class="mt-1">
                            <a href="#" class="text-black text-decoration-underline footer_link" >Our
                                Fleet</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mt-4">
                    <div class="row justify-content-between">
                        <div class="col-md-6  mb-3 align-self-center text-center text-md-left my-2">
                            Copyright © 2024.
                        </div>
                        <div class="d-flex align-items-center" style="gap:15px;">
                            <a href="https://www.facebook.com/profile.php?id=61560740824598" style="color: black"
                               target="_blank">
                                <i class="fa-brands fa-facebook fa-xl"/>

                            </a>
                            <a href="https://www.instagram.com/autours_/"
                               target="_blank" style="color: black">
                                <i class="fa-brands fa-instagram fa-xl"/>

                            </a>
                            <a href="https://www.linkedin.com/company/autours/" style="color: black" target="_blank">
                                <i class="fa-brands fa-linkedin-in fa-xl"/>
                            </a>
                            <a href="https://x.com/Autours_" style="color: black" target="_blank">
                                <i class="fa-brands fa-x-twitter fa-xl"/>
                            </a>
                            <a href="mailto:admin@info.net" style="color: black" target="_blank">
                                <i class="fa fa-envelope " style="font-size: 22px;"/>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 mt-3">
                    <div class="row justify-content-between">
                        <div class="col-md-6  mb-3 align-self-center text-center text-md-left my-2" >
                           Payment Methods
                        </div>
                        <div class="d-flex align-items-center" style="gap:15px;">
                            <i class="fa fa-cc-visa " style="font-size: 30px;"/>
                            <i class="fa fa-cc-mastercard " style="font-size: 30px;"/>
                            <img width="50" height="27" src="https://www.knet.com.kw/wp-content/uploads/2019/07/KNETLogo.svg" class="header_logo header-logo" alt="The Shared Electronic Banking Services">

                        </div>
                    </div>

                </div>
            </div>

        </div>


    </footer>

</template>

<style scoped>
.wrapper {
    min-height: 100px; /* Adjust 60px to your footer's actual height */
    position: relative;
    overflow: auto;
    padding-bottom: 5%; /* Adjust to match your footer's height */
}

.footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: black;
    color: white;
    padding: 10px;
    text-align: center;
}

.footer_link {
    font-size: 20px;
}
</style>
