<template>
    <body>
    <div id="wrapper">

        <!-- header begin -->
        <header-one/>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>

            <div style="margin-left: 40%; width: 15%;"><h1>Contact Us</h1></div>
            <div class="contact-info row">
                <div class="col-lg-3 offset-1">
                    <div
                        class="my-3"
                        style="background-image: url('/assets/images/icons/whatsapp-icon.png');  width: 220px; height: 148px; justify-content: center; display: flex;">
                        <p style="color: gold; font-weight: bold; margin-top: 25%;">Message Us <br>+965 6048 0382</p>
                    </div>
                    <div
                        class="my-3"
                        style="background-image: url('/assets/images/icons/phone-icon.png');  width: 220px; height: 148px; justify-content: center; display: flex;">
                        <p style="color: gold; font-weight: bold; margin-top: 25%;">
                            Call Us <br> +965 6048 0382
                        </p>
                    </div>
                    <div
                        style="background-image: url('/assets/images/icons/Email-icom.png');  width: 220px; height: 148px; justify-content: center; display: flex;">
                        <p style="color: gold; font-weight: bold; margin-top: 25%;">
                            Email Us <br>Info@autours.net
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 my-5 row">
                    <form>
                        <input class="col-md-6 contact_form" type="text" placeholder="First name" required>
                        <input class="col-md-6 contact_form" type="text" placeholder="Last name" required>
                        <input class="col-md-6 contact_form" type="email" placeholder="E-mail Address" required>
                        <input class="col-md-6 contact_form" type="tel" placeholder="Phone number" required>
                        <textarea class="contact_form" placeholder="Message" rows="4" v-model="form.message" type="text"
                                  required/>
                        <div class="col-md-12">
                            <button class="btn btn-primary text-black p-3 mt-3" onclick="()=> event.preventDefault()" type="submit">SUBMIT</button>
                        </div>

                    </form>
                </div>
                <div class="my-5">
                    <a href="#" class="mx-5"><img width="30" height="60" src="/assets/images/icons/f.png"
                                                  alt="Facebook"></a>
                    <a href="#" class="mx-5"><img width="60" height="60" src="/assets/images/icons/n.png"
                                                  alt="Instgram"></a>
                    <a href="#" class="mx-5"><img width="60" height="60" src="/assets/images/icons/x.png" alt="Twitter"></a>
                    <a href="#" class="mx-5"><img width="60" height="60" src="/assets/images/icons/t.png" alt="TikTok"></a>
                    <a href="#" class="mx-5"><img width="60" height="60" src="/assets/images/icons/in.png"
                                                  alt="LinkedIn"></a>
                </div>
            </div>

        </div>
    </div>
    <Footer/>

    </body>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import 'vue-toast-notification/dist/theme-sugar.css';
import HeaderOne from '../components/HeaderOne.vue'
import Footer from "../components/Footer.vue";
import 'primevue/resources/themes/aura-light-amber/theme.css'
import Editor from 'primevue/editor';

const form = {
    first_name: ref(""),
    last_name: ref(""),
    email: ref(""),
    mobile: ref(""),
    description: ref(""),
}

onMounted(() => {

})

</script>

<style scoped>


div.contact-info {
    background-color: #fff5a9;
    padding: 20px;
    text-align: center;
}

section.contact-info div {
    margin: 10px 0;
}

form {
    text-align: center;
    padding: 20px;
}

form input, form textarea {
    margin: 5px;
    padding: 10px;
    width: 80%;
    max-width: 400px;
}



footer {
    text-align: center;
    padding: 20px;
}

footer img {
    width: 30px;
    margin: 0 10px;
}

#map {
    width: 100%;
    height: 300px;
}

#top {
    margin-top: 6%;
}

.contact_form {
    background: rgb(255, 229, 140);
    border-radius: 50px;
}

input::placeholder,
textarea::placeholder {
    margin-left: 50px;
    color: #000000; /* Change to your preferred color */
    opacity: 1; /* Ensures the placeholder is fully opaque */
}
</style>
