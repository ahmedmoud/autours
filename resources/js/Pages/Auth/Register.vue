<template>
    <header-one/>

    <div id="wrapper">
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
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
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="spacer-10"></div>
                            <div class="flip-container">
                                <div class="flipper" v-bind:class="(RegisterForm.supplier) ? 'flip' : ''" id="flipper">
                                    <div class="front">
                                        <h3 class="title my-3">Manage Booking</h3>
                                        <form class="form-border" @submit.prevent="manageBooking">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="field-set">
                                                        <label>Email Address</label>
                                                        <input v-model="loginForm.email" type="email"
                                                               class="formbold-form-input"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="field-set">
                                                        <label>Password</label>
                                                        <input v-model="loginForm.password" type='password'  name='password' id='password' class="form-control">
                                                    </div>
                                                </div>


                                                <div class=" mt-2 row">
                                                    <div id='submit' class="pull-left col-md-8">
                                                        <button type='submit' id='send_message'
                                                                class="btn-main color-2" :disabled="loading">Continue <span><i
                                                            class="fa fa-arrow-right ml-2"/></span></button>
                                                    </div>
                                                    <div id='submit' class="mt-4 col-md-4 ">
                                                        <a class="flipbutton cursor-pointer" id="loginButton"
                                                           v-on:click="createAccount()">Create my account →</a>
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
                                        <form class="form-border" @submit.prevent="postUserData">

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="field-set">
                                                        <label>Name </label>
                                                        <input v-model="RegisterForm.name" type="text"
                                                               class="formbold-form-input"/>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="field-set">
                                                        <label>Email Address</label>
                                                        <input v-model="RegisterForm.email" type="email"
                                                               class="formbold-form-input"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="field-set">
                                                        <label>Phone</label>
                                                        <input v-model="RegisterForm.phone" type='text' name='phone'
                                                               id='phone' class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="field-set">
                                                        <label>Password</label>
                                                        <input v-model="RegisterForm.password" type="password"
                                                               class="formbold-form-input"/>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mt-2 row">

                                                    <div id='submit' class="pull-left col-md-8 ">
                                                        <button type='submit' id='send_message'
                                                                class="btn-main color-2">Register <span><i
                                                            class="fa fa-arrow-right ml-2"/></span></button>
                                                    </div>
                                                    <div class="col-md-4 mt-4">
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
import { useForm} from '@inertiajs/vue3';
import {ref} from 'vue';
import HeaderOne from "../../components/HeaderOne.vue";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import Footer from "../../components/Footer.vue"
import Contactus from "../../components/Contactus.vue"
import { onMounted} from 'vue'


const RegisterForm = useForm({
    name: '',
    phone: '',
    email: '',
    country : '',
    password: '',
    user_type: '',
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
        if(response.data.status) {
            $toast.success('You Have Successfully Logged In', {position: 'top'})
            setTimeout(function () {
                if(response.data.user_type !== 'customer') {
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
const createAccount = () => {
    document.querySelector("#flipper").classList.toggle("flip");
}


const LoginToMyAccount = () => {
    document.querySelector("#flipper").classList.toggle("flip");

}

onMounted(()=> {
    let urlParams = new URLSearchParams(window.location.search);
    fetchCountries()
    RegisterForm.user_type = urlParams.get('user_type');
    if (RegisterForm.user_type == 'supplier'){
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
    width: 50%;
    left: 25%;
    height: 360px;
    position: relative;
    background: #f5f5f5;
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
@media screen and (max-width: 1000px){

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

</style>
