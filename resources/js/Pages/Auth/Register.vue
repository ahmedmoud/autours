<template>
    <header-one/>

    <div id="wrapper">
        <!-- content begin -->
        <div class="no-bottom no-top" id="content"
             style="background-image: url('/images/background/manage-booking-div.jpg')">
            <div id="top"></div>
            <!-- section begin -->
            <section id="subheader" class="jarallax ">
                <div class="center-y relative text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <!--                                <h2>View / Manage Booking</h2>-->
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section close -->
            <section aria-label="section">
                <div class=" col-md-6 flip-container">
                    <div id="forgetPassword" class="flipper display-none offset-5">
                        <div class="front">
                            <p style="font-size: 50px; margin-top: 5%; margin-left: 20%; font-weight: 1000;">
                                Forget Password</p>
                            <form class="mt-5">
                                <div class="col-md-8" style="left: 15%">
                                    <input placeholder="E-mail" class="input-text mt-4" v-model="forgetPasswordEmail"/>
                                </div>
                                <a style="left: 40%;" class="cursor-pointer btn-main mt-4  rounded-5"
                                   @click="sendForgetPasswordEmail()">Submit</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div :class="RegisterForm.user_type === 'supplier' ? 'register-form' : ''">
                    <div class="row">
                        <div class="row">
                            <div v-if="RegisterForm.user_type === 'supplier'"
                                 class="col-md-5 ml-5  mt-4 supplier-notice"
                                 style=" height: 350px; scrollbar-gutter: auto;
                                            overflow-y: scroll;
                                            scrollbar-width: thin;

                                            scrollbar-color: black rgba(255,255,255,0);
">
                                <p style="    border-color: black;
                                            border-width: 10px;">Become a car rental supplier!
                                    Autours is a company operating in the tourism field since its establishment in
                                    2005, with car rental bookings being our main area of expertise.
                                    We provide you a great chance to increase the business, as through our
                                    multilingual www.autours.net millions of customers from different countries book
                                    their car rental. We have a huge affiliate and reseller network worldwide, who
                                    send us high amount of car bookings in different countries and destinations. It
                                    is an opportunity for you to expand your business in different markets.
                                    If you are a car rental company, small or big, and you want to increase the
                                    volume of your car rental reservations, you are welcome to join our car rental
                                    partner network.
                                    Benefits from joining the car rental network of www.autours.net
                                    No financial risk at all. The customers pay directly to you upon the arrival.
                                    Immediate increase of your car rental sales.
                                    No entry/administration fee or other costs.
                                    Access to our agent area for special offers, stop sales, statistics, information
                                    and evaluation results from customers. The results from the feedback and
                                    evaluation will help you and improve your service.
                                    Smart reservation procedure for confirming via e-mail or Dashboard for your
                                    admin interface.
                                    Flexible system for amendments, cancellations and one-way rentals.
                                    Guaranteed bookings and very low volume of no-show customers
                                    Our team will assist you, proposing rates, car groups purchase, changes and
                                    tips.
                                    Please fill in the Supplier Application Form in order to get more information on
                                    how you can become an www.autours.net
                                    Supplier.
                                </p>
                            </div>

                            <div class=" col-md-6 flip-container">

                                <div :class="RegisterForm.user_type !== 'supplier' ? 'flipper offset-5' : 'flipper' "
                                     v-bind:class="(RegisterForm.supplier) ? 'flip' : ''" id="flipper">
                                    <div class="front">
                                        <p style="font-size: 50px; margin-top: 5%; margin-left: 20%; font-weight: 1000;">
                                            Manage Booking</p>
                                        <form class="form-border" @submit.prevent="manageBooking">

                                            <div class="row">
                                                <div class="col-md-12 mt-3">
                                                    <div class="field-set">
                                                        <input placeholder="E-mail" v-model="loginForm.email"
                                                               type="email" class="input-text"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                    <div class="field-set">
                                                        <input v-model="loginForm.password" type='password'
                                                               name='password' placeholder="Password" id='password'
                                                               class="input-text">
                                                    </div>
                                                </div>


                                                <div class=" mt-5 row">
                                                    <div id='submit' class="pull-left col-md-8">
                                                        <button type='submit' id='send_message'
                                                                class="btn-main color-2 rounded-5" :disabled="loading">
                                                            LOGIN
                                                            <span><i
                                                                class="fa fa-arrow-right ml-2"/></span></button>
                                                    </div>
                                                    <div id='submit' class="mt-4 col-md-4 ">
                                                        <a class="flipbutton cursor-pointer" id="loginButton"
                                                           v-on:click="createAccount()">Create my account →</a>
                                                    </div>
                                                    <div id='submit' class="mt-4 col-md-4 ">
                                                        <a class="flipbutton cursor-pointer" id="loginButton"
                                                           v-on:click="forgetPassword()">Forget Your Password ? </a>
                                                    </div>

                                                    <div id='mail_success' class='success'>Your message has been sent
                                                        successfully.
                                                    </div>
                                                    <div id='mail_fail' class='error'>Sorry, error occurred this time
                                                        sending your message.
                                                    </div>
                                                    <div class="clearfix"></div>

                                                </div>

                                            </div>
                                        </form>

                                    </div>

                                    <div class="back">
                                        <h3 class="title my-3">Register</h3>
                                        <form class="form-border" autocomplete="off" @submit.prevent="postUserData">

                                            <div class="row ">

                                                <div class="col-md-6 mt-3">
                                                    <div class="field-set">
                                                        <input v-model="RegisterForm.name" type="text"
                                                               placeholder="Full name" class="input-text"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mt-3">
                                                    <div class="field-set">
                                                        <input v-model="RegisterForm.email" type="email" id="email"
                                                               placeholder="E-mail" name="email" class="input-text"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field-set">
                                                        <input v-model="RegisterForm.country" type="text"
                                                               placeholder="Country" class="input-text"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="field-set">
                                                        <input v-model="RegisterForm.code" type='text' name='code'
                                                               placeholder="+20" autocomplete="false" id='code'
                                                               class="input-text">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="field-set">
                                                        <input v-model="RegisterForm.phone" autocomplete="false"
                                                               placeholder="phone number" type='text' name='phone'
                                                               id='phone' class="input-text">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="field-set">
                                                        <input v-model="RegisterForm.password" type="password"
                                                               placeholder="Passwrod" name="password" id="password"
                                                               class="input-text"/>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mt-2 row">

                                                    <div id='submit' class="pull-left col-md-8 ">
                                                        <button type='submit' id='send_message'
                                                                class="btn-main color-2 rounded-5 mt-4">Register
                                                            <span><i
                                                                class="fa fa-arrow-right ml-2"/></span></button>
                                                    </div>
                                                    <div class="col-md-4 mt-5">
                                                        <a class="flipbutton cursor-pointer" id="registerButton"
                                                           v-on:click="LoginToMyAccount()">Manage My Booking →</a></div>

                                                    <div id='mail_success' class='success'>Your message has been sent
                                                        successfully.
                                                    </div>
                                                    <div id='mail_fail' class='error'>Sorry, error occurred this time
                                                        sending your message.
                                                    </div>
                                                    <div class="clearfix"></div>

                                                </div>

                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- content close -->
    </div>
    <Footer/>

</template>

<script setup>
import {router, useForm} from '@inertiajs/vue3';
import {ref} from 'vue';
import HeaderOne from "../../components/HeaderOne.vue";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import Footer from "../../components/Footer.vue"
import Contactus from "../../components/Contactus.vue"
import {onMounted, onBeforeMount} from 'vue'


const RegisterForm = useForm({
    name: '',
    phone: '',
    email: '',
    country: '',
    password: '',
    user_type: '',
    code: '',
    supplier: 0
});

const loginForm = useForm({
    email: '',
    password: '',
});

const countries = {
    loading: ref(false),
    all: ref([]),
    list: ref([]),
    options: ref([]),
};
const $toast = useToast();
const fetchCountries = async () => {
    countries.loading.value = true;
    try {
        //
        const response = await axios.get('https://countriesnow.space/api/v0.1/countries', {})
        countries.all.value = response.data.data
        countries.list.value = countries.all.value.map((item) => ({
            id: `${item.id}`,
            label: `${item.country}`,
            iso: `${item.iso2}`
        }))
    } catch (error) {
        console.error(error)
    } finally {
        countries.loading.value = false;
    }
}
const forgetPasswordEmail = ref('')
const loading = ref(false);
const postUserData = async () => {
    loading.value = true

    if (RegisterForm.name === undefined || RegisterForm.name === null || RegisterForm.name.length === 0) {
        $toast.error("Please Insert valid Name", {position: 'top'});
        return;
    }
    if (RegisterForm.email === undefined || RegisterForm.email === null || RegisterForm.email.length === 0) {
        $toast.error("Please Insert valid Email", {position: 'top'});
        return;
    }
    if (RegisterForm.password === undefined || RegisterForm.password === null || RegisterForm.password.length === 0) {
        $toast.error("Please Insert valid Password", {position: 'top'});
        return;
    }
    try {

        const response = await axios.post('/post/user/data', RegisterForm.data())
        if (response.data.status) {
            $toast.success('You Have Successfully Registered', {position: 'top'})
            setTimeout(function () {
                window.location.href = '/'
            }, 1000)
        }
    } catch ($error) {
        loading.value = false
        $toast.error($error.response.data.message, {position: 'top'})
    }
};

const manageBooking = async () => {
    loading.value = true

    if (loginForm.email === undefined || loginForm.email === null || loginForm.email.length === 0) {
        $toast.error("Please Insert Email", {position: 'top'});
        return;
    }
    if (loginForm.password === undefined || loginForm.password === null || loginForm.password.length === 0) {
        $toast.error("Please Insert  Yor password", {position: 'top'});
        return;
    }
    try {
        const response = await axios.post('/login', loginForm.data())
        if (response.data.status) {
            $toast.success('You Have Successfully Logged In', {position: 'top'})
            setTimeout(function () {
                if (response.data.user_type !== 'customer') {
                    window.location.href = '/index'
                } else {
                    window.location.href = '/'
                }
            }, 1000)
        }
    } catch ($error) {
        loading.value = false
        $toast.error($error.response.data.message, {position: 'top'})
    }
};
const forgetPassword = () => {
    $("#flipper").hide();
    $(".supplier-notice").hide();
    $("#forgetPassword").show();
}
const createAccount = () => {
    document.querySelector("#flipper").classList.toggle("flip");
}


const LoginToMyAccount = () => {
    document.querySelector("#flipper").classList.toggle("flip");

}
const getUserData = async () => {
    try {
        const response = await axios.get('/get/user/data');
        if (response.data) {
            router.get('/')
        }
    } catch (error) {
        console.error(error);
    }
}
const sendForgetPasswordEmail = async () => {
    try {
        const response = await axios.post('/forget-password', {email: forgetPasswordEmail.value});
        $toast.success("Email Sent Successfully to reset password", {position: "top"});
        router.get('/')

    } catch (e) {
        $toast.error("Something went wrong")
        console.log(e)
    }
}
onBeforeMount(() => {
    getUserData();

})
onMounted(() => {

    let urlParams = new URLSearchParams(window.location.search);
    fetchCountries()
    RegisterForm.user_type = urlParams.get('user_type');
    if (RegisterForm.user_type == 'supplier') {
        console.log(RegisterForm.supplier)
        RegisterForm.supplier = 1;
        console.log(RegisterForm.supplier)

    }
})
</script>

<style scoped>


#subheader h3, h2 {
    font-family: 'Outfit';
    margin-top: 100px;
    margin-bottom: 10px;
    letter-spacing: -2px;
}


.flipper {
    padding: 30px;
    width: 95%;
    left: 5%;
    height: 450px;
    position: relative;
    background-image: url('/images/background/manage-booking-form.png');
    background-repeat: no-repeat;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;

    transition: 0.6s;
    transform-style: preserve-3d;
}

.front, .back {
    /*background-color: rgba(0,0,0,.3);*/
    position: absolute;
    padding: 10px 30px;

    top: 0;
    left: 0;
    right: 0;

    backface-visibility: hidden;
}

.front {

    z-index: 2;
    /* for firefox 31 */
    transform: rotateY(0deg);
}

.back {
    transform: rotateY(180deg);
}

.flip {
    transform: rotateY(180deg);
}

input {
    width: 100%;
    margin-bottom: 15px;
    height: 40px;
    box-sizing: border-box;
    padding: 10px;
}

.title {
    text-align: center;
}

.flipbutton {
    color: #4096ee;
    text-decoration: none;
    text-align: left !important;
}

@media screen and (max-width: 1000px) {

    .flip-container {
        width: 100%;

    }

    .flipper {
        top: -120px;
        width: 100%;
        left: 0;
        background: #ffffff;
    }
}

.input-text {
    border-radius: 50px !important;
    border-width: 3px !important;
    border-color: black !important;
}

.register-form {
    background-image: url('/images/background/manage-booking-form.png');
    background-repeat: no-repeat;
}
</style>
