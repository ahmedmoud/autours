<template>
<body>
    <!-- banner -->
    <div class="jumbotron jumbotron-fluid" id="banner" style="background-image: url(img/banner-bk.jpg);background-size: cover;background-position: center;background-repeat: no-repeat;">
        <div class="container text-center text-md-left" >
            <header-one/>
            <h1 data-aos="fade" data-aos-easing="linear" data-aos-duration="1000" data-aos-once="true" class="display-3 text-white font-weight-bold my-5">
            	Looking for a vehicle?<br>
            	You're at the right place.
            </h1>
            <form class="trip-form w-100 d-flex justify-content-center" @submit.prevent="search">
                <div class="row align-items-center w-100 d-flex justify-content-center">
                  <div class="mb-3 mb-md-0 col-md-3">
                    <el-select
                      v-model="location"
                      size="large"
                      filterable
                      remote
                      reserve-keyword
                      placeholder="Pickup..."
                      remote-show-suffix
                      :remote-method="remoteLocations"
                      :loading="locations.loading.value"
                    >
                      <el-option
                        v-for="item in locations.options.value"
                        :key="item.id"
                        :label="item"
                        :value="item"
                      />
                    </el-select>

                  </div>
                  <div class="mb-3 mb-md-0 col-md-6.5">
                    <div class="form-control-wrap">
                      <el-date-picker
                        v-model="date"
                        type="daterange"
                        range-separator="To"
                        start-placeholder="Start date"
                        end-placeholder="End date"
                        size="large"
                        format="YYYY/MM/DD"
                        value-format="YYYY-MM-DD"
                      />
                    </div>
                  </div>
                  <div class="mb-3 mb-md-0 col-md-3">
                    <input type="submit" value="Search" class="btn-main btn-fullwidth rounded-3" style="padding:9px 25px"/>
                  </div>
                </div>
              </form>
        </div>
    </div>
    <!-- client -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="row" style="justify-content: center;">
                <div v-for="logo in logos" class="col-sm-4 col-md-2 py-2 align-self-center">
                    <img :src="'img/' + logo" class="mx-auto d-block">
                </div>
            </div>
        </div>
    </div>
    <!-- three-blcok -->
    <div class="container my-5 py-2">
        <h2 class="text-center font-weight-bold my-5">Why book a car rental with Autours?</h2>
        <div class="row">
            <div data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000" data-aos-once="true" class="col-md-4 text-center">
                <img src="img/feature-1.png" width="250px" alt="Phishing Detect" class="mx-auto my-4">
                <h4>Pas de frais cachés</h4>
                <p>Une fois que vous avez payé, vous êtes tranquilles. Pas de surprise de dernière minute.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="0" data-aos-duration="1000" data-aos-once="true" class="col-md-4 text-center">
                <img src="img/feature-1.png" width="250px" alt="Phishing Detect" class="mx-auto my-4">
                <h4>Anti-spam</h4>
                <p>Lorem ipsum dolor sit amet porro his no his deleniti</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" data-aos-once="true" class="col-md-4 text-center">
                <img src="img/feature-1.png" width="250px" alt="Phishing Detect" class="mx-auto my-4">
                <h4>Phishing Detect</h4>
                <p>Ne error antiopam usu. Sed vocen concludaturque ea</p>
            </div>
            
        </div>
    </div>
    <!-- images -->
    <div class="container my-5 py-2">
        <h2 class="text-center font-weight-bold my-5">Popular car rental locations worldwide</h2>
    <section>
        <div class="card">
        <div class="card__img">  
        <img src="https://images.unsplash.com/photo-1486299267070-83823f5448dd?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80" alt="Big Ben">
            <!-- <span><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>4.5</span> -->
        <div class="card__overlay">
            <h2>London</h2>
            <p>Big Ben</p>
        </div>
        </div>
        </div>
            <div class="card">
        <div class="card__img">  
        <img src="https://images.unsplash.com/photo-1581010864468-c972b8705439?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80" alt="Eiffel Tower">

        <div class="card__overlay">
            <h2>Paris</h2>
            <p>Eiffel Tower</p>
        </div>
        </div>
        </div>
            <div class="card">
        <div class="card__img">  
        <img src="https://images.unsplash.com/photo-1552832230-c0197dd311b5?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1096&q=80" alt="Colosseum">

        <div class="card__overlay">
            <h2>Rome</h2>
            <p>Colosseum</p>
        </div>
        </div>
        </div>
            <div class="card">
        <div class="card__img">  
        <img src="https://images.unsplash.com/photo-1581473483413-313a5afffb08?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=714&q=80" alt="Pisa Tower">
        <div class="card__overlay">
            <h2>Pisa</h2>
            <p>Pisa Tower</p>
        </div>
        </div>
        </div>
            <div class="card">
        <div class="card__img">  
        <img src="https://images.unsplash.com/photo-1585155967849-91c736589c84?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=627&q=80" alt="">
        <div class="card__overlay">
            <h2>New York</h2>
            <p>Statue of Liberty</p>
        </div>
        </div>
        </div>
            <div class="card">
        <div class="card__img">  
        <img src="https://images.unsplash.com/photo-1527915676329-fd5ec8a12d4b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1171&q=80" alt="Sydney Opera House">
        <div class="card__overlay">
            <h2>Sydney</h2>
            <p>Sydney Opera House</p>
        </div>
        </div>
        </div>
    </section>
    </div>
    <!-- feature (skew background) -->
    <div class="jumbotron jumbotron-fluid feature" id="feature-first">
        <div class="container my-5">
            <div class="row justify-content-between text-center text-md-left">
                <div data-aos="fade-right" data-aos-duration="1000" data-aos-once="true" class="col-md-6">
                    <h2 class="font-weight-bold">Take a look inside</h2>
                    <p class="my-4">Te iisque labitur eos, nec sale argumentum scribentur no,
                        <br> augue disputando in vim. Erat fugit sit at, ius lorem deserunt deterruisset no.</p>
                    <a href="#" class="btn my-4 font-weight-bold atlas-cta cta-blue">Learn More</a>
                </div>
                <div data-aos="fade-left" data-aos-duration="1000" data-aos-once="true" class="col-md-6 align-self-center">
                    <img src="img/feature-1.png" alt="Take a look inside" class="mx-auto d-block">
                </div>
            </div>
        </div>
    </div>
    <!-- feature (green background) -->
    <div class="jumbotron jumbotron-fluid feature" id="feature-last">
        <div class="container">
            <div class="row justify-content-between text-center text-md-left">
                <div data-aos="fade-left" data-aos-duration="1000" data-aos-once="true" class="col-md-6 flex-md-last">
                    <h2 class="font-weight-bold">Safe and reliable</h2>
                    <p class="my-4">
                        Duo suas detracto maiestatis ad, commodo lucilius invenire nec ad,
                        <br> eum et oratio disputationi. Falli lobortis his ad
                    </p>
                    <a href="#" class="btn my-4 font-weight-bold atlas-cta cta-blue">Learn More</a>
                </div>
                <div data-aos="fade-right" data-aos-duration="1000" data-aos-once="true" class="col-md-6 align-self-center flex-md-first">
                    <img src="img/feature-2.png" alt="Safe and reliable" class="mx-auto d-block">
                </div>
            </div>
        </div>
    </div>

    <!-- price table -->
    <div class="container my-5 py-2" id="price-table">
        <h2 class="text-center font-weight-bold d-block mb-3">FAQ</h2>
        <div class="acc d-flex">
            <div class='wrapper w-50'>
                        <input id='pictures' type='checkbox'>
                        <label for='pictures'>
                            <p>Why book a car rental with Autours?</p>
                            <div class='lil_arrow'></div>
                            <div class='content'>
                            <ul>
                                <li>
                                <a href='#'>Design briefs</a>
                                </li>
                                <li>
                                <a href='#'>Non Disclosure</a>
                                </li>
                                <li>
                                <a href='#'>Company Brochure</a>
                                </li>
                            </ul>
                            </div>
                            <span></span>
                        </label>
                        <input id='jobs' type='checkbox'>
                        <label for='jobs'>
                            <p>Upcoming Jobs</p>
                            <div class='lil_arrow'></div>
                            <div class='content'>
                            <ul>
                                <li>
                                <a href='#'>Weekly Forecast</a>
                                </li>
                                <li>
                                <a href='#'>Timescales</a>
                                </li>
                                <li>
                                <a href='#'>Quotes</a>
                                </li>
                            </ul>
                            </div>
                            <span></span>
                        </label>
                        <input id='events' type='checkbox'>
                        <label for='events'>
                            <p>Events & Task Management</p>
                            <div class='lil_arrow'></div>
                            <div class='content'>
                            <ul>
                                <li>
                                <a href='#'>Calendar</a>
                                </li>
                                <li>
                                <a href='#'>Important Dates</a>
                                </li>
                                <li>
                                <a href='#'>Someting Event related</a>
                                </li>
                            </ul>
                            </div>
                            <span></span>
                        </label>
                       
            </div>
            <div class='wrapper w-50 mx-4'>
                        <input id='financial' type='checkbox'>
                        <label for='financial'>
                            <p>Invoicing & financial</p>
                            <div class='lil_arrow'></div>
                            <div class='content'>
                            <ul>
                                <li>
                                <a href='#'>Invoicing Templates</a>
                                </li>
                                <li>
                                <a href='#'>Invoice Archives</a>
                                </li>
                                <li>
                                <a href='#'>Send Invoice</a>
                                </li>
                            </ul>
                            </div>
                            <span></span>
                        </label>
                        <input id='settings' type='checkbox'>
                        <label for='settings'>
                            <p>System Settings</p>
                            <div class='lil_arrow'></div>
                            <div class='content'>
                            <ul>
                                <li>
                                <a href='#'>User Settings</a>
                                </li>
                                <li>
                                <a href='#'>Edit Profile</a>
                                </li>
                                <li>
                                <a href='#'>Do something cool</a>
                                </li>
                            </ul>
                            </div>
                            <span></span>
                        </label>
            </div>
        </div>
    </div>
    <!-- contact -->
    <div class="jumbotron jumbotron-fluid" id="contact" style="background: #f4d849;">
        <div class="container my-5">
            <div class="row justify-content-between">
                <div class="col-md-6 text-black">
                    <h2 class="font-weight-bold">Contact Us</h2>
                    <p class="my-4">
                        Te iisque labitur eos, nec sale argumentum scribentur,
                        <br> augue disputando in vim. Erat fugit sit at, ius lorem.
                    </p>
                    <ul class="list-unstyled">
                        <li>Email : company_email@com</li>
                        <li>Phone : 361-688-5824</li>
                        <li>Address : 4826 White Avenue, Corpus Christi, Texas</li>
                    </ul>
                </div>
                <div class="col-md-6">
                        
                </div>
            </div>
        </div>
    </div>
    
	<!-- copyright -->
	<div class="jumbotron jumbotron-fluid" id="copyright" style="background: black;">
        <div class="container">
            <div class="row justify-content-between">
            	<div class="col-md-6 text-white align-self-center text-center text-md-left my-2">
                    Copyright © 2023.
                </div>
                <div class="d-flex align-items-center" style="gap:15px;">
                  <a href="https://www.facebook.com/profile.php?id=61552833342138&mibextid=LQQJ4d" target="_blank">
                    <svg width="25" height="25" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path d="M22.08 12.539c0-5.335-4.298-9.66-9.6-9.66-5.304.001-9.602 4.325-9.602 9.661 0 4.82 3.511 8.817 8.1 9.541v-6.75H8.542v-2.79h2.438v-2.13c0-2.421 1.434-3.758 3.627-3.758 1.05 0 2.149.188 2.149.188v2.376h-1.21c-1.192 0-1.564.745-1.564 1.51v1.812h2.661l-.425 2.791H13.98v6.75c4.59-.725 8.1-4.72 8.1-9.541Z"></path>
                    </svg>
                  </a>
                  <a href="https://instagram.com/autotours_?igshid=NzZlODBkYWE4Ng%3D%3D&utm_source=qr"  target="_blank">
                    <svg width="25" height="25" fill="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path d="M12 2c-2.714 0-3.055.013-4.121.06-1.066.05-1.793.217-2.429.465a4.896 4.896 0 0 0-1.771 1.154A4.909 4.909 0 0 0 2.525 5.45c-.248.635-.416 1.362-.465 2.425C2.013 8.944 2 9.284 2 12.001c0 2.715.013 3.055.06 4.121.05 1.066.217 1.792.465 2.428a4.91 4.91 0 0 0 1.154 1.771 4.88 4.88 0 0 0 1.77 1.154c.637.247 1.362.416 2.427.465 1.068.047 1.408.06 4.124.06 2.716 0 3.055-.012 4.122-.06 1.064-.05 1.793-.218 2.43-.465a4.893 4.893 0 0 0 1.77-1.154 4.91 4.91 0 0 0 1.153-1.771c.246-.636.415-1.363.465-2.428.047-1.066.06-1.406.06-4.122s-.012-3.056-.06-4.124c-.05-1.064-.219-1.791-.465-2.426a4.907 4.907 0 0 0-1.154-1.771 4.888 4.888 0 0 0-1.771-1.154c-.637-.248-1.365-.416-2.429-.465-1.067-.047-1.406-.06-4.123-.06H12Zm-.896 1.803H12c2.67 0 2.987.008 4.04.057.975.044 1.505.208 1.858.344.466.181.8.399 1.15.748.35.35.566.683.747 1.15.138.352.3.882.344 1.857.049 1.053.059 1.37.059 4.039 0 2.668-.01 2.986-.059 4.04-.044.974-.207 1.503-.344 1.856a3.09 3.09 0 0 1-.748 1.149 3.09 3.09 0 0 1-1.15.747c-.35.137-.88.3-1.857.345-1.053.047-1.37.059-4.04.059s-2.987-.011-4.041-.059c-.975-.045-1.504-.208-1.856-.345a3.097 3.097 0 0 1-1.15-.747 3.1 3.1 0 0 1-.75-1.15c-.136-.352-.3-.882-.344-1.857-.047-1.054-.057-1.37-.057-4.041 0-2.67.01-2.985.057-4.039.045-.975.208-1.505.345-1.857.181-.466.399-.8.749-1.15a3.09 3.09 0 0 1 1.15-.748c.352-.137.881-.3 1.856-.345.923-.042 1.28-.055 3.144-.056v.003Zm6.235 1.66a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4ZM12 6.865a5.136 5.136 0 1 0-.16 10.272A5.136 5.136 0 0 0 12 6.865Zm0 1.801a3.334 3.334 0 1 1 0 6.668 3.334 3.334 0 0 1 0-6.668Z"></path>
                    </svg>
                  </a>
                </div>
                <Link  class="nav-link" href="supplier/login"><span>Supplier Login</span></Link>
                <Link  class="nav-link" href="supplier/signup"><span>Supplier Signup</span></Link>
                <div class="col-md-6 align-self-center text-center text-md-right my-2" id="social-media">
                    
                    <!-- <a href="#" class="d-inline-block text-center ml-2">
                    	<i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="d-inline-block text-center ml-2">
                    	<i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="d-inline-block text-center ml-2">
                    	<i class="fa fa-medium" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="d-inline-block text-center ml-2">
                    	<i class="fa fa-linkedin" aria-hidden="true"></i>
                    </a> -->
                </div>
            </div>
        </div>
    </div>

</body>
</template>

<script setup >
import { ref, onMounted } from 'vue'
import { useForm, Link } from '@inertiajs/vue3';
import HeaderOne from '../components/HeaderOne.vue'

const form = useForm({
    pickupLoc: '',
    date: '',
});
const logos = ref({})
const date = ref('')
const location = ref('')
const locations = {
  all: ref([]),
  options: ref([]),
  loading: ref(false),
}

const vehicles = ref([])

const getLogos = async () => {
    try {
        const response = await axios.get('get/logos')
        logos.value = response.data
    } catch (error) {
        console.error(error)
    }
}

const getVehicles = async () => {
    try {
        const response = await axios.get('get/vehicles')
        vehicles.value = response.data
    } catch (error) {
        console.error(error)
    }
}

const getLocations = async () => {
    locations.loading.value = true;
    try {
        const response = await axios.get('/get/locations')
        locations.all.value = Object.values(response.data)
    } catch (error) {
        console.error(error)
    } finally {
       locations.loading.value = false;
    }
}

const remoteLocations = (query) => {
  if (query) {
    locations.loading.value = true
    setTimeout(() => {
      locations.loading.value = false
      locations.options.value = locations.all.value.filter((item) =>
          item.toLowerCase().includes(query.toLowerCase())
        )
    }, 200)


  } else {
    locations.options.value = [];
  }
}

const search = () => {
  form.pickupLoc = location.value
  form.date = date.value
    form.post('search/vehicles');
}

onMounted(() => {
  getLocations();
  getVehicles();
  getLogos();
})
</script>

<style lang="scss" scoped>
@import '../../css/custom.css';

#banner{
  position: relative;
  &::before{
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba($color: #000000, $alpha: .5);
  }
}

header {
    width: 100%;
    position: static;  
    background: transparent;
    margin: 0;
    border-bottom: none;
}
.trip-form {
  border-radius: 7px;
  padding: 40px;
  background: #fff;
  position: relative;
  z-index: 3;
  -webkit-box-shadow: 0 15px 30px 0px rgba(0, 0, 0, 0.1);
  box-shadow: 0 15px 30px 0px rgba(0, 0, 0, 0.1);
}

$easing:cubic-bezier(0.680, -0.550, 0.265, 1.550);
$color:white;

.acc{
  .wrapper{
    width:400px;
    margin:0 auto;
    background: white;
    border-radius:4px;
    position:relative;
    box-shadow: 0px 2px rgba(0, 0, 0, 0.12);
    p{
        display: block;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        transition: all .3s ease;
    }
    label{
      display: block;
      position:relative;
      color: #b5abab;
      overflow:hidden;
      cursor: pointer;
      height: 56px;
      -webkit-transition: text-indent 0.2s;
      text-indent:20px;
      padding-top: 1px;
    }
    ul{
      margin:0;
      padding:0;
    }
    li{
      color:white;
      list-style-type:none;
      a{
        display:block;
        width:100%;
        padding: 15px 0px;
        text-decoration:none;
        color:#434447;
        border-bottom:1px solid rgba(0, 0, 0, 0.06);
      }
      a:hover{
        background-color:rgba(0, 0, 0, 0.06);
      }
    }
    label:hover{
      background:rgba(244, 216, 73, 0.5) !important;
      color: #434447;
      p {
        transform: translateX(20px);
      }  
    }
    input[type="checkbox"]{
      display:none;
    }
    span{
      height:3px;
      position:absolute;
      width:0px;
      display:block;
      top: 58px;
      background:#f4d849;
    }
    .content{
      height: 0;
      background: rgba(244, 216, 73, 0.7);
      height: 300px;
      position: relative;
      border-top: 2px solid rgba(0, 0, 0, 0.12);
      top: 4px;
    }
    .lil_arrow{
      width:5px;
      height:5px;
      -webkit-transition: transform 0.8s;
      transition: transform 0.8s;
      -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
      border-top:2px solid rgba(0, 0, 0, 0.33);
      border-right:2px solid rgba(0, 0, 0, 0.33);
      float:right;
      position:relative;
      top: -30px;
      right: 27px;
      transform:rotate(45deg)
    }
    input[type="checkbox"]:checked + label > .content{
      display:block;
    }
    input[type="checkbox"]:checked + label > span{
      display:none;
    }
    input[type="checkbox"]:checked + label > .lil_arrow{
      -webkit-transition: transform 0.8s;
      transition: transform 0.8s;
      -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
      transform:rotate(135deg)
    }
    input[type="checkbox"]:checked + label{
      display: block;
      background: rgba(244, 216, 73, 0.5) !important;
      color: #434447;
      text-indent:30px;height: 275px;
      -webkit-transition: height 0.8s;
      transition: height 0.8s;
      -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    label:hover > span{
      width:100%;
     -webkit-transition-timing-function:$easing;
      transition: width 0.4s;
    }
    input[type='checkbox']:not(:checked) + label{
      display:block;
      -webkit-transition: height 0.8s;
	    -moz-transition: height 0.8s;
	    transition: height 0.8s;
      height:60px;
      -webkit-transition-timing-function:$easing;
    }
  }
}
::-webkit-scrollbar { 
  display: none; 
}

// images

@mixin mQ($px){
@media screen and (max-width:$px){
@content;
}
}

section{
  display:grid;
  grid-template-columns:25% 30% 15% 25%;
  gap:15px;
  place-content: center;
  grid-template-rows: 50% 50%;
  height:80vh;
  min-height:460px;
  padding:max(2vh,1.5rem);

    img{
        width:100%;
        display:block;
        height:100%;
        object-fit:cover;
    }

    h2{
        color:white;
        font-size: clamp(1rem, 0.8750rem + 0.6250vw, 1.5rem);
        line-height:1.3;
        font-weight:700;
    }
  
  @include mQ(690px){
    height:65vh;  
      }
  
    @include mQ(470px){
        grid-template-columns:repeat(2,1fr);
        grid-template-rows: repeat(3, 35%);
      }
  
  .card{
       border-radius:25px;
        box-shadow: -2px 4px 15px rgb(0 0 0 / 26%);
    
      @include mQ(470px){
      grid-column:span 1;
      }
    
    &:nth-child(2){
    grid-column:2/3;
      grid-row:span 2;
      
      @include mQ(690px){
      grid-column:span 1;
      grid-row:span 1;
      }
    }
    
     &:nth-child(3){
      grid-column:span 2;
       
            @include mQ(690px){
    grid-column: 2/4;
    grid-row: 1/2;
      }
    }
  
         @include mQ(690px){
           &:nth-child(6){
     grid-column: 2/4;
    grid-row: 2/3;
             }
    }
    
         @include mQ(470px){
            
        &:nth-child(5){
     grid-column:span 2;
             }
    }
    
    p{
font-size: clamp(0.9rem, 0.8750rem + 0.1250vw, 1rem);
      line-height:1.4;
    }
    
    
    img{
      border-radius:25px;
    }
    .card__img{
      position:relative;
      height:100%;
      
      .card__overlay{
        position:absolute;
        bottom:0;
        left:0;
        content:"";
        color:#fff;
      padding: clamp(0.938rem,5vw,1.563rem);
     background: rgb(2,2,46);
background: linear-gradient(0deg, rgb(0 0 0 / 57%) 0%, rgb(255 255 255 / 0%) 100%);
        width:100%;
        height:100%;
     border-radius:25px;
        display:flex;
        justify-content:flex-end;
        flex-direction:column;
      }
      
      span{
        position:absolute;
        top:25px;
        left:min(2vmax, 1.563rem);
        color:#ff7b29;
        background:#fff;
        border-radius:50px;
padding:2px 8px 2px 6px;
        display:flex;
        box-shadow: 0px 1px 20px #0000002b;
        
        @include mQ(690px){
          top:20px;
        }
        
           @include mQ(470px){
          top:15px;
        }
        
        svg{
          fill:#ff7b29;
          width:20px;
          margin-right:2px;
        }
      }
    }
  }
}


</style>