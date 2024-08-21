<template>
    <body>
    <div id="wrapper">

        <!-- header begin -->
        <header-one/>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top zebra" id="content">
            <div id="top"></div>

            <!-- section begin -->


            <!-- section close -->
            <div v-if="isOpen" class="modal-mask">
                <div class="modal-wrapper" @click="$emit('close')">
                    <div class="modal-container" ref="target">
                        <div class="modal-header">
                            <slot name="header"> Rental Terms</slot>
                        </div>
                        <div class="modal-body overflow-y-auto" style="max-height: calc(100vh - 210px);">
                            <CAccordion>
                                <CAccordionItem v-for="(item,index) in activeRentalTerms" :item-key="index">
                                    <CAccordionHeader>
                                        <div v-html="item.title"></div>
                                    </CAccordionHeader>
                                    <CAccordionBody>
                                        <div v-html="item.description"></div>
                                    </CAccordionBody>
                                </CAccordionItem>
                            </CAccordion>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <div>
                                    <button class="btn btn-primary" @click="closeModal()">Done</button>
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>

            <section id="section-car-details">
                <div class="col-md-12 mb-3   mt-1 top-buttons">
                    <button class="mr-1 mt-2 btn steps-button "
                            style="width:420px; background: #f9d602; color: #000;"><span
                        class="ti ti-circle-number-1 mr-1"/>Choose Your Location
                    </button>
                    <button class="mr-1 btn mt-2 steps-button " style="width:420px; background: #f9d602; color: #000; "
                    ><span
                        class="ti ti-circle-number-2 mr-2"/>Choose Your Car
                    </button>
                    <button class="btn mt-2 steps-button active"
                            style="width:420px; background: rgb(155,147,84);color: #000;"><span
                        class="ti ti-circle-number-3 mr-2"/>Reserve Your Car
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-3 offset-1 mt-4 ">

                        <div class="p-1 col-11" style="background-color: #e1e1e1; ">
                            <h5 class="p-2">YOUR SEARCH DETAILS</h5>
                        </div>
                        <div class="col-md-11 pb-4" style="background: #fff;">

                            <div class="row" style="background: #fff;">
                                <h5 class="mt-4">PICK-UP - LOCATION </h5>

                                <p class="col-md-11"><span class=" col-md-1 ti ti-gps"></span>{{ form.pickupLoc }}</p>
                                <span class="col-md-6 ti ti-calendar">&nbsp;{{ form.date_from }}</span>
                                <span class="col-md-3 ti ti-clock">&nbsp;{{ form.time_from }}</span>
                            </div>
                            <hr/>
                            <div class=" mt-3 row" style="background: #fff;">
                                <h5>DROP-OFF - LOCATION </h5>
                                <p class="col-12"><span class=" col-md-1 ti ti-gps"></span>{{ form.pickupLoc }}</p>
                                <span class="col-md-6 ti ti-calendar">&nbsp;{{ form.date_to }}</span>
                                <span class="col-md-3 ti ti-clock">&nbsp;{{ form.time_to }}</span>
                            </div>
                        </div>
                        <div class="p-1 col-11 mt-3" style="background: #e1e1e1;">
                            <h5 class="p-2">Booking This Car</h5>
                        </div>
                        <div class="col-md-11 pb-4" style="background: #fff;">

                            <form class="trip-form  px-2" @submit.prevent="search">
                                <div class="row  flex-column">
                                    <div class="w-100 mt-4 mb-3 col-md-11">
                                        <el-select
                                            class="w-100"
                                            v-model="form.pickupLoc"
                                            size="large"
                                            placeholder="Pickup..."
                                            disabled>
                                        </el-select>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="form-control-wrap col-md-7">
                                            <el-date-picker
                                                v-model="form.date_from"
                                                placeholder="Start date"
                                                size="large"
                                                format="YYYY/MM/DD"
                                                value-format="YYYY-MM-DD"
                                                :disabled-date="disabledDate"

                                            />
                                        </div>
                                        <div class="form-control-wrap col-md-5">
                                            <select  class="form-control rounded-1"
                                                    v-model="form.time_from">
                                                <option value="00:00" selected>00:00</option>
                                                <option value="00:30">00:30</option>
                                                <option value="01:00">01:00</option>
                                                <option value="01:30">01:30</option>
                                                <option value="02:00">02:00</option>
                                                <option value="02:30">02:30</option>
                                                <option value="03:00">03:00</option>
                                                <option value="03:30">03:30</option>
                                                <option value="04:00">04:00</option>
                                                <option value="04:30">04:30</option>
                                                <option value="05:00">05:00</option>
                                                <option value="05:30">05:30</option>
                                                <option value="06:00">06:00</option>
                                                <option value="06:30">06:30</option>
                                                <option value="07:00">07:00</option>
                                                <option value="07:30">07:30</option>
                                                <option value="08:00">08:00</option>
                                                <option value="08:30">08:30</option>
                                                <option value="09:00">09:00</option>
                                                <option value="09:30">09:30</option>
                                                <option value="10:00" selected>10:00</option>
                                                <option value="10:30">10:30</option>
                                                <option value="11:00">11:00</option>
                                                <option value="11:30">11:30</option>
                                                <option value="12:00">12:00</option>
                                                <option value="12:30">12:30</option>
                                                <option value="13:00">13:00</option>
                                                <option value="13:30">13:30</option>
                                                <option value="14:00">14:00</option>
                                                <option value="14:30">14:30</option>
                                                <option value="15:00">15:00</option>
                                                <option value="15:30">15:30</option>
                                                <option value="16:00">16:00</option>
                                                <option value="16:30">16:30</option>
                                                <option value="17:00">17:00</option>
                                                <option value="17:30">17:30</option>
                                                <option value="18:00">18:00</option>
                                                <option value="18:30">18:30</option>
                                                <option value="19:00">19:00</option>
                                                <option value="19:30">19:30</option>
                                                <option value="20:00">20:00</option>
                                                <option value="20:30">20:30</option>
                                                <option value="21:00">21:00</option>
                                                <option value="21:30">21:30</option>
                                                <option value="22:00">22:00</option>
                                                <option value="22:30">22:30</option>
                                                <option value="23:00">23:00</option>
                                                <option value="23:30">23:30</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="mb-3 row">
                                        <div class="form-control-wrap col-md-7">
                                            <el-date-picker
                                                v-model="form.date_to"
                                                placeholder="End date"
                                                size="large"
                                                format="YYYY/MM/DD"
                                                value-format="YYYY-MM-DD"
                                                :disabled-date="disabledDate"

                                            />
                                        </div>
                                        <div class="form-control-wrap col-md-5">
                                            <select  class="form-control rounded-1"
                                                     v-model="form.time_to">
                                                <option value="00:00" selected>00:00</option>
                                                <option value="00:30">00:30</option>
                                                <option value="01:00">01:00</option>
                                                <option value="01:30">01:30</option>
                                                <option value="02:00">02:00</option>
                                                <option value="02:30">02:30</option>
                                                <option value="03:00">03:00</option>
                                                <option value="03:30">03:30</option>
                                                <option value="04:00">04:00</option>
                                                <option value="04:30">04:30</option>
                                                <option value="05:00">05:00</option>
                                                <option value="05:30">05:30</option>
                                                <option value="06:00">06:00</option>
                                                <option value="06:30">06:30</option>
                                                <option value="07:00">07:00</option>
                                                <option value="07:30">07:30</option>
                                                <option value="08:00">08:00</option>
                                                <option value="08:30">08:30</option>
                                                <option value="09:00">09:00</option>
                                                <option value="09:30">09:30</option>
                                                <option value="10:00" selected>10:00</option>
                                                <option value="10:30">10:30</option>
                                                <option value="11:00">11:00</option>
                                                <option value="11:30">11:30</option>
                                                <option value="12:00">12:00</option>
                                                <option value="12:30">12:30</option>
                                                <option value="13:00">13:00</option>
                                                <option value="13:30">13:30</option>
                                                <option value="14:00">14:00</option>
                                                <option value="14:30">14:30</option>
                                                <option value="15:00">15:00</option>
                                                <option value="15:30">15:30</option>
                                                <option value="16:00">16:00</option>
                                                <option value="16:30">16:30</option>
                                                <option value="17:00">17:00</option>
                                                <option value="17:30">17:30</option>
                                                <option value="18:00">18:00</option>
                                                <option value="18:30">18:30</option>
                                                <option value="19:00">19:00</option>
                                                <option value="19:30">19:30</option>
                                                <option value="20:00">20:00</option>
                                                <option value="20:30">20:30</option>
                                                <option value="21:00">21:00</option>
                                                <option value="21:30">21:30</option>
                                                <option value="22:00">22:00</option>
                                                <option value="22:30">22:30</option>
                                                <option value="23:00">23:00</option>
                                                <option value="23:30">23:30</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="  ">
                                        <input type="submit" value="Check Availability"
                                               class="btn-main btn-fullwidth " style="background: #f9d602"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-11 pb-4 mt-4" style="background: #e5e5e3; border: 3px solid #eed616;">
                            <div>
                                <p class="mt-3">Total Rental Price</p>
                                <h3>{{ currency + ' ' + vehicle.final_price }}</h3>
                                <p> For {{ daysNumber }} day{{ daysNumber < 2 ? '' : 's' }} -
                                    {{ currency + ' ' + parseFloat((vehicle.final_price / daysNumber)).toFixed(2) }} /
                                    per
                                    day </p>
                                <div class="row">
                                    <p class="col-md-8">Rental Cost</p>
                                    <p class="col-md-3">{{ currency + '&nbsp' + vehicle.final_price }}</p>
                                </div>
                                <div class="row">
                                    <p class="col-md-8">Extras</p>
                                    <p class="col-md-3">{{ currency + '&nbsp' + 0 }}</p>
                                </div>
                                <div class="row">
                                    <p class="col-md-8">Total Rental Cost</p>
                                    <p class="col-md-3">{{ currency + '&nbsp' + vehicle.final_price }}</p>
                                </div>
                                <hr style="margin-bottom: 5%;"/>
                                <div class="row">
                                    <strong class="col-md-8">Pay Now</strong>
                                    <strong class="col-md-4">{{ currency + ' ' + vehicle.final_price }}</strong>
                                </div>
                                <hr style="margin-top: 1%;"/>
                            </div>
                        </div>

                    </div>
                    <Loader v-if="loading"/>
                    <div v-else class="container bg-white col-md-6 offset-md-0 pt-5 pl-5 mt-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div id="slider-carousel">
                                    <h3 class="text-nowrap" style="margin-left: -20px; font-size: 1.3vw;">
                                        {{ vehicle.name }} - <small class="text-nowrap">{{
                                            vehicle?.category?.name
                                        }}</small></h3>
                                    <div class="row"></div>
                                    <div class="item">
                                        <img
                                            :src=" '/img/vehicles/' + vehicle?.photo "
                                            width="250" height="150"/>
                                    </div>
                                    <div class="spacer-30"></div>

                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <div class=" row mt-1">
                                    <h4 class="col-md-4 text-nowrap" style="font-size: 1.1vw">
                                        {{ currency + ' ' + vehicle.final_price }}</h4>
                                    <p class="col-md-7 text-nowrap"> For {{ daysNumber }}
                                        day{{ daysNumber < 2 ? '' : 's' }} -
                                        {{ currency + ' ' + parseFloat((vehicle.final_price / daysNumber)).toFixed(2) }}
                                        / per
                                        day </p>
                                </div>
                                <div class="row de-spec text-nowrap">
                                    <div v-if="vehicle.specifications" v-for="specification in vehicle.specifications" class="col-md-6">
                                        <span>
                                            <img style="width: 35%; margin-right: 2px;"
                                                 :src="'/assets/images/icons/' + specification.icon + '.svg'"/>
                                             {{
                                                specification.option
                                            }} {{
                                                specification.name == 'Number of Seats' ? 'Seats' : specification.name == 'Doors' ? 'Doors' : ''
                                            }}
                                        </span>
                                    </div>
                                </div>
                                <div class="spacer-single"></div>
                            </div>
                            <div class=" rounded-2 py-1 mb-2 ml-1" style="background: #edecec; width: 90%; margin-top: -2%; ">
                                <div class="d-supplier">
                                    <div class="col-md-2 d-img w-100" style="height: 50px">
                                        <img :src="'/img/' + vehicle?.supplier?.logo" height="50"
                                             width="80" alt=""/>
                                    </div>
                                    <div class="col-md-2 row">
                                        <div>
                                                            <span style="font-size: medium;"
                                                                  class="text-nowrap">{{
                                                                    vehicle?.supplier?.company
                                                                }}</span>
                                        </div>
                                        <div>
                                            <small><a class="cursor-pointer text-primary" href="javascript:void(0);"
                                                      @click="openRentalTerms(vehicle)">Rental&nbsp;Terms</a></small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="py-2 px-1 rounded-1 ml-3"
                                              style=" background-color: #f9d602; font-size: 1.0em;font-weight: 600;">7.1/10</span>
                                    </div>
                                    <div class="col-md-3">
                                                        <span class="be_media-body"><h5>Good</h5><span
                                                            style="font-size: medium;">(&nbsp;<strong
                                                            style="color: #f9d602">1000&nbsp;</strong>+&nbsp;reviews)</span></span>
                                    </div>
                                    <div class="col-md-4 ">
                                        <p class="text-nowrap mt-2" style="font-size: 15px;"><i class="fa fa-location"/>
                                            &nbsp;Address:&nbsp;&nbsp;<small
                                                style="font-size: 12px;">{{ vehicle?.supplier?.address }}</small></p>
                                        <p style="margin-top: -20px;"><strong class="text-nowrap"
                                                                              style="font-size: 15px;"><i
                                            class="fa fa-gas-pump"/></strong> &nbsp;Fuel Policy: <small
                                            style="font-size: 12px; margin-top: -10px;" class="text-nowrap"> Full to
                                            Full </small></p>
                                    </div>
                                </div>
                            </div>
                            <div class=" row ml-1 rounded-2 bg-light-gray pt-1 " style="width: 90%; ">
                                <div class="row col-md-12">
                                    <p class="primary bold m-0" style="color: #5e9007;">What is Included!</p>
                                    <ul class="row">
                                        <div class="col-md-5">
                                            <li v-for="(item, index) in vehicle?.included?.slice(0 , (vehicle?.included?.length) /2)"
                                                style="height: 20px">
                                                <div class="row" v-if="index <= (vehicle?.included?.length - 1) / 2">
                                                    <i class="col-md-1 fa fa-check fa-l mt-2 text-nowrap"
                                                       style="color: green;"/>
                                                    <p class="col-md-10 text-nowrap" style="font-size: 0.9vw;">
                                                        {{ item.what_is_included }}</p>
                                                </div>
                                            </li>
                                        </div>
                                        <div class="col-md-3 align-content-center" style="font-size: 2.5vw; color: rgb(94, 144, 7);"><i class="fa fa-plus-circle"/></div>

                                        <div class="col-md-4">
                                            <li v-for="(item, index) in vehicle?.included?.slice( (vehicle?.included?.length-1) /2 +1 ,  vehicle?.included?.length)" style="height: 20px">
                                                <div class="row" >
                                                    <i class="col-md-1 fa fa-check fa-l mt-2 text-nowrap"
                                                       style="color: green;"/>
                                                    <p class="col-md-10 text-nowrap" style="font-size: 0.9vw;">
                                                        {{ item.what_is_included }}</p>
                                                </div>
                                            </li>
                                        </div>

                                    </ul>
                                </div>
                            </div>

                            <div class="de-box row col-lg-12 mt-5 mb25">
                                <div class="col-lg-12">
                                    <div class="">
                                        <div class="row">

                                            <div class="col-lg-12" v-if="!user">
                                                <h4 style="text-align: center;">Register First to continue your
                                                    reservation</h4>
                                                <hr/>
                                                <form method="post" @submit.prevent="register"
                                                >
                                                    <div class="row">
                                                        <div class="formbold-mb-3 col-md-12">
                                                            <div class="row">
                                                                <el-select
                                                                    v-model="RegisterForm.gender"
                                                                    size="large"
                                                                    filterable
                                                                    class="col-md-3"
                                                                    reserve-keyword
                                                                    placeholder="Mr/Mrs..."
                                                                    remote-show-suffix
                                                                    required>
                                                                    <el-option
                                                                        v-for='item in ["Mr.","Mrs."]'
                                                                        :key="'+' + item"
                                                                        :label="item"
                                                                        :value="item"
                                                                    />
                                                                </el-select>
                                                                <el-input
                                                                    v-model="RegisterForm.name"
                                                                    size="large"
                                                                    filterable
                                                                    remote
                                                                    class="col-md-9"
                                                                    reserve-keyword
                                                                    placeholder="Enter Full name here..."
                                                                    remote-show-suffix
                                                                    :loading="countries.loading.value"
                                                                    required>
                                                                </el-input>
                                                            </div>
                                                        </div>
                                                        <div class="formbold-mb-3 col-md-8">
                                                            <div class="row">
                                                                <el-select
                                                                    v-model="RegisterForm.mobile_code"
                                                                    size="large"
                                                                    class="col-md-4"
                                                                    filterable
                                                                    reserve-keyword
                                                                    placeholder="code..."
                                                                    remote-show-suffix
                                                                    required>
                                                                    <el-option
                                                                        v-for='item in countryCodes'
                                                                        :key="'+' + item.code"
                                                                        :label="getUnicodeFlagIcon(item.iso) + ' +' + item.code"
                                                                        :value="'+' + item.code"
                                                                    />
                                                                </el-select>
                                                                <el-input
                                                                    v-model="RegisterForm.phone"
                                                                    size="large"
                                                                    class="col-md-8"
                                                                    filterable
                                                                    remote
                                                                    reserve-keyword
                                                                    placeholder="Phone Number..."
                                                                    remote-show-suffix
                                                                    :loading="countries.loading.value"
                                                                    required>
                                                                </el-input>
                                                            </div>
                                                        </div>
                                                        <div class="formbold-mb-3 col-md-4"
                                                             v-if="!user || user.role !== 'customer' ">
                                                            <div class="countries row">
                                                                <el-select
                                                                    v-model="RegisterForm.country"
                                                                    size="large"
                                                                    class="col-md-12"
                                                                    filterable
                                                                    reserve-keyword
                                                                    placeholder="Select Country..."
                                                                    remote-show-suffix
                                                                    :loading="countries.loading.value"
                                                                    required>
                                                                    <el-option
                                                                        v-for="item in countries.list.value"
                                                                        :key="item.id"
                                                                        :label="item.label"
                                                                        :value="item.label"
                                                                    />
                                                                </el-select>
                                                            </div>
                                                        </div>
                                                        <div class="formbold-mb-3 col-md-6">
                                                            <div class="countries">
                                                                <el-input
                                                                    v-model="RegisterForm.email"
                                                                    size="large"
                                                                    filterable
                                                                    remote
                                                                    reserve-keyword
                                                                    placeholder="E-mail..."
                                                                    remote-show-suffix
                                                                    required>
                                                                </el-input>
                                                            </div>
                                                        </div>
                                                        <div class="formbold-mb-3 col-md-6">
                                                            <div class="countries">
                                                                <el-input
                                                                    v-model="RegisterForm.password"
                                                                    size="large"
                                                                    filterable
                                                                    remote
                                                                    type="password"
                                                                    reserve-keyword
                                                                    placeholder="Account Password ..."
                                                                    remote-show-suffix
                                                                    required>
                                                                </el-input>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </form>
                                            </div><!-- end col -->
                                            <div class="col-lg-12" v-else-if="user && user.role === 'customer' ">
                                                <form method="post" @submit.prevent="register">
                                                    <div class="row">
                                                        <div class=" formbold-mb-3 col-md-6">
                                                            <label class="formbold-form-label">Name On Card</label>
                                                            <div class="countries">
                                                                <el-input
                                                                    v-model="bookingForm.name_on_card"
                                                                    size="large"
                                                                    filterable
                                                                    remote
                                                                    reserve-keyword
                                                                    placeholder="Name on Card..."
                                                                    remote-show-suffix
                                                                    :disabled="loading"
                                                                    required>
                                                                </el-input>
                                                            </div>
                                                        </div>
                                                        <div class="formbold-mb-3 col-md-6">
                                                            <label class="formbold-form-label">Card Number</label>
                                                            <div class="row">
                                                                <el-input
                                                                    v-model="bookingForm.card_number"
                                                                    size="large"
                                                                    filterable
                                                                    remote
                                                                    reserve-keyword
                                                                    placeholder="Enter front card number..."
                                                                    remote-show-suffix
                                                                    :disabled="loading"
                                                                    required>
                                                                </el-input>
                                                            </div>
                                                        </div>
                                                        <div class=" formbold-mb-3 col-md-6">
                                                            <label class="formbold-form-label">CVV</label>
                                                            <el-input
                                                                v-model="bookingForm.CVV"
                                                                size="large"
                                                                class="col-md-4"
                                                                filterable
                                                                remote
                                                                reserve-keyword
                                                                placeholder="CVV..."
                                                                :disabled="loading"

                                                                remote-show-suffix
                                                                required>
                                                            </el-input>
                                                        </div>

                                                        <div class="row formbold-mb-3 col-md-6">
                                                            <label class="formbold-form-label">Exp Date</label>
                                                            <el-input
                                                                v-model="bookingForm.card_exp_date"
                                                                size="large"
                                                                class="col-md-4"
                                                                filterable
                                                                remote
                                                                :disabled="loading"
                                                                reserve-keyword
                                                                placeholder="YY/MM"
                                                                remote-show-suffix
                                                                required>
                                                            </el-input>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <el-checkbox class="mr-2"/>
                                    Remember me on this device. <br/>
                                    <el-checkbox v-model="rental_terms" class="mr-2"/>
                                    I confirm that i have read, understood and agree with the
                                    <a class="cursor-pointer text-primary " style="text-decoration: underline;"
                                       href="javascript:void(0);"
                                       @click="openRentalTerms(vehicle)">Rental&nbsp;Terms</a> .<br/>
                                    <el-checkbox class="mr-2"/>
                                    Subscribe me to the promotional emails.
                                    <hr/>
                                    <ProgressBar v-if="loading" mode="indeterminate" style="height: 6px"></ProgressBar>

                                </div>
                                <button v-if="!loading" id='send_message' @click="book" :disabled="loading"
                                        class="btn-main btn-fullwidth offset-4 col-md-5" style="background: #f9d602">
                                    Continue&nbsp;To&nbsp;Payment
                                </button>
                            </div>

                        </div>
                    </div>

                </div>


            </section>

        </div>
    </div>
    <Footer/>

    </body>
</template>

<script setup>
import {ref, onMounted} from 'vue'
import {usePage, useForm} from '@inertiajs/vue3';
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import HeaderOne from '../components/HeaderOne.vue'
import {router} from "@inertiajs/vue3";
import {CAccordion, CAccordionItem, CAccordionHeader, CAccordionBody} from '@coreui/vue';
import Footer from "../components/Footer.vue";
import getUnicodeFlagIcon from "country-flag-icons/unicode";
import ProgressBar from 'primevue/progressbar';
import 'primevue/resources/themes/aura-light-amber/theme.css'
import Loader from '../components/Loader.vue'

const isOpen = ref(false)

const closeModal = () => {
    isOpen.value = false;
}

const countryCodes = [
    {"country": "Algeria", "code": "213", "iso": "DZ"},
    {"country": "Australia", "code": "61", "iso": "AU"},
    {"country": "Bahrain", "code": "973", "iso": "BH"},
    {"country": "Canada", "code": "1", "iso": "CA"},
    {"country": "China", "code": "86", "iso": "CN"},
    {"country": "Denmark", "code": "45", "iso": "DK"},
    {"country": "Egypt", "code": "20", "iso": "EG"},
    {"country": "France", "code": "33", "iso": "FR"},
    {"country": "Germany", "code": "49", "iso": "DE"},
    {"country": "Greece", "code": "30", "iso": "GR"},
    {"country": "India", "code": "91", "iso": "IN"},
    {"country": "Indonesia", "code": "62", "iso": "ID"},
    {"country": "Iran", "code": "98", "iso": "IR"},
    {"country": "Iraq", "code": "964", "iso": "IQ"},
    {"country": "Italy", "code": "39", "iso": "IT"},
    {"country": "Jordan", "code": "962", "iso": "JO"},
    {"country": "Kuwait", "code": "965", "iso": "KW"},
    {"country": "Lebanon", "code": "961", "iso": "LB"},
    {"country": "Libya", "code": "218", "iso": "LY"},
    {"country": "Mexico", "code": "52", "iso": "MX"},
    {"country": "Morocco", "code": "212", "iso": "MA"},
    {"country": "Netherlands", "code": "31", "iso": "NL"},
    {"country": "Oman", "code": "968", "iso": "OM"},
    {"country": "Pakistan", "code": "92", "iso": "PK"},
    {"country": "Palestine", "code": "970", "iso": "PS"},
    {"country": "Poland", "code": "48", "iso": "PL"},
    {"country": "Portugal", "code": "351", "iso": "PT"},
    {"country": "Qatar", "code": "974", "iso": "QA"},
    {"country": "Russia", "code": "7", "iso": "RU"},
    {"country": "Saudi Arabia", "code": "966", "iso": "SA"},
    {"country": "Spain", "code": "34", "iso": "ES"},
    {"country": "Sweden", "code": "46", "iso": "SE"},
    {"country": "Switzerland", "code": "41", "iso": "CH"},
    {"country": "Syria", "code": "963", "iso": "SY"},
    {"country": "Tunisia", "code": "216", "iso": "TN"},
    {"country": "Turkey", "code": "90", "iso": "TR"},
    {"country": "United Arab Emirates", "code": "971", "iso": "AE"},
    {"country": "United Kingdom", "code": "44", "iso": "GB"},
    {"country": "United States", "code": "1", "iso": "US"},
];
const user = ref('')
const rental_terms = ref(false)
const value = ref(0);
const id = ref('')
const vehicle = ref([])
const currency = ref('')
const date = ref([]);
const priceTax = ref("");
const daysNumber = ref("");
const loading = ref(false);

const form = useForm({
    id: "",
    pickupLoc: "",
    date_from: "",
    date_to: "",
    time_from: "",
    time_to: "",
    vehicle: "",
    price: "",
    currency: localStorage.getItem('currency') ?? 'USD',
});
const countries = {
    loading: ref(false),
    all: ref([]),
    list: ref([]),
    options: ref([]),
};

const RegisterForm = useForm({
    name: '',
    phone: '',
    email: '',
    password: '',
    mobile_code: '',
    country: '',
    user_type: '',
    supplier: 0,
    gender: '',
});

const bookingForm = useForm({
    pickupLoc: "",
    date_from: "",
    date_to: "",
    time_from: "",
    time_to: "",
    id: "",
    card_number: "",
    name_on_card: "",
    CVV: "",
    card_exp_date: "",
    currency: ""
});
const $toast = useToast();
const getUser = async () => {
    try {
        const response = await axios.get('/get/user/data');
        user.value = response.data;
    } catch (error) {
        console.error(error);
    }
}
const activeRentalTerms = ref('');
const openRentalTerms = (vehicle) => {
    isOpen.value = true
    activeRentalTerms.value = vehicle.rental_terms
}
const setParams = () => {
    let urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('pickupLoc')) {
        form.pickupLoc = urlParams.get('pickupLoc')
    }
    if (urlParams.has('date_from')) {
        form.date_from = urlParams.get('date_from')

    }
    if (urlParams.has('date_to')) {
        form.date_to = urlParams.get('date_to')

    }

    if (urlParams.has('time_from')) {
        form.time_from = urlParams.get('time_from')
    }
    if (urlParams.has('time_to')) {
        form.time_to = urlParams.get('time_to')
    }

    if (urlParams.has('date')) {
        form.date = urlParams.get('date')
    }
    if (urlParams.has('id')) {
        id.value = urlParams.get('id')
        form.id = urlParams.get('id')
    }
    getVehicle()
}


const getVehicle = async () => {
    try {

        loading.value = true


        form.id = id.value;
        form.currency = localStorage.getItem('currency') ?? 'USD';

        const response = await axios.post('/get/vehicle/data', form)

        vehicle.value = response.data.data.vehicle
        form.vehicle = vehicle.value.id
        form.price = vehicle.value.final_price

        form.date_from = response.data.data.date_from
        form.date_to = response.data.data.date_to

        date.value = response.data.data.date
        daysNumber.value = response.data.data.days
        loading.value = false

    } catch (error) {
        if (!error.response.data.status) {
            $toast.error(error.response.data.message, {position: 'top'})
            // router.get('/')
        }
        loading.value = false
        console.error(error)
    }
}


const book = async () => {
    try {
        loading.value = true;
        if (user.value === '' || user.value === null || user.value === undefined) {

            register();
            loading.value = false;
            return
        }

        if (user.value.role !== 'customer') {
            $toast.error("You are not a customer!", {position: 'top'})
            loading.value = false;

            return;
        }
        if (rental_terms.value !== true) {
            $toast.error("Please Approve on the rental terms !", {position: 'top'})
            loading.value = false;

            return;
        }

        bookingForm.id = id.value;
        bookingForm.pickupLoc = form.pickupLoc;
        bookingForm.date_from = form.date_from;
        bookingForm.date_to = form.date_to;
        bookingForm.time_from = form.time_from;
        bookingForm.time_to = form.time_to;
        bookingForm.currency = currency.value;

        const resposne = await axios.post("/book/vehicles", form.data());
        if (resposne.status) {
            $toast.success("Thank You for your payment!", {position: 'top', duration: 1000})
            $toast.success("Your Booking has been placed successfully", {position: 'top'})
            router.get('/my-profile')
            loading.value = false;
        }
    } catch (e) {
        loading.value = false;

        $toast.error(e.response.data.message, {position: 'top'})
    }
};

const search = () => {
    getVehicle();
};

const register = async () => {
    loading.value = true

    if (RegisterForm.gender === undefined || RegisterForm.gender === null || RegisterForm?.gender?.length === 0) {
        $toast.error("Please Select Mr/Mrs", {position: 'top'});
        loading.value = false
        return;
    }
    if (RegisterForm.name === undefined || RegisterForm.name === null || RegisterForm?.name?.length === 0) {
        $toast.error("Please Insert valid Name", {position: 'top'});
        loading.value = false
        return;
    }
    if (RegisterForm.email === undefined || RegisterForm.email === null || RegisterForm?.email?.length === 0) {
        $toast.error("Please Insert valid Email", {position: 'top'});
        loading.value = false

        return;
    }
    if (RegisterForm.phone === undefined || RegisterForm.phone === null || RegisterForm?.phone?.length === 0) {
        $toast.error("Please Insert valid Phone number", {position: 'top'});
        loading.value = false

        return;
    }
    if (RegisterForm.mobile_code === undefined || RegisterForm.mobile_code === null || RegisterForm?.mobile_code?.length === 0) {
        $toast.error("Please Insert valid Phone number", {position: 'top'});
        loading.value = false

        return;
    }
    if (RegisterForm.country === undefined || RegisterForm.country === null || RegisterForm?.country?.length === 0) {
        $toast.error("Please Insert Select Country", {position: 'top'});
        loading.value = false

        return;
    }
    if (RegisterForm.password === undefined || RegisterForm.password === null || RegisterForm?.password?.length === 0) {
        $toast.error("Please Insert valid Password", {position: 'top'});
        loading.value = false

        return;
    }
    try {
        RegisterForm.name = RegisterForm.gender + ' ' + RegisterForm.name
        const response = await axios.post('/post/user/data', RegisterForm.data())
        if (response.data.status) {
            $toast.success('You Have Successfully Registered', {position: 'top'})
            setTimeout(function () {
                window.location.reload()
            }, 1000)
        }
    } catch ($error) {
        loading.value = false
        $toast.error($error.response.data.message, {position: 'top'})
    }
}

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

const disabledDate = (time) => {
    const date = new Date();
    date.setHours(0, 0, 0, 0)
    return time < date
}

onMounted(() => {
    currency.value = localStorage.getItem('currency') ?? 'USD'
    setParams();
    fetchCountries()
    getUser()
    // fetchVehicles();
})

</script>

<style scoped>
li::before {
    display: none;
}

.item-list {
    display: grid;
    align-items: flex-end;
    padding: 20px;
    background: #ffffff;
    border: solid 1px #dddddd;
    box-shadow: 3px 3px 9px rgba(164, 164, 186, 0.2);
    border-radius: 6px;
}

.scv-badge.badge-white {
    display: flex;
    min-width: 10px;
    padding: 2px 6px 3px 3px;
    color: #605c5c;
    background-color: #fff;
    border-radius: 2em;
    line-height: 14px;
    vertical-align: middle;
    white-space: normal;
    border: 1px solid #ddd;
}

[id|=sc-be] .be_media {
    overflow: hidden;
    transform: scale(1);
    transform-origin: 0 0;
}

.scv-icon.scv-instant {
    height: 29px;
    min-width: 32px;
    width: 32px;
    display: inline-block;
}

[id|=sc-be] .be_media-middle {
    vertical-align: middle;
}

.scv-inst-text {
    display: inline-block;
    font-size: 11px;
    text-align: left;
    vertical-align: middle;
    -webkit-align-self: center;
    align-self: center;
    margin-left: 2px;
}

@media (min-width: 1700px) {
    .included-font {
        font-size: 12px;
    }

    .top-buttons {
        margin-left: 12%;
    }
}

@media (max-width: 1699px) {
    .included-font {
        font-size: 11px;
    }

    .top-buttons {
        margin-left: 7%;
    }
}

@media (max-width: 1500px) {
    .included-font {
        font-size: 9.5px;
    }

    .top-buttons {
        margin-left: 5%;
    }
}
</style>
