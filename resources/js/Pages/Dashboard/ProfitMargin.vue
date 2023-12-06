<template>
   <h2 class="mb-4">Profit Margins</h2>
    <div class="formbold-main-wrapper">
        <form @submit.prevent="upload">  
       
            <div class="formbold-mb-3">
                <label class="formbold-form-label">1 Day</label>
                <div class="input-with-percent">
                  <input v-model="priceTax" type="text" pattern="[0-9]+([,.][0-9]+)?" class="formbold-form-input" />
                  <span class="percent-symbol">%</span>
                </div>
            </div>
            <div class="formbold-mb-3">
                <label class="formbold-form-label">3 - 7 Days</label>
                <div class="input-with-percent">
                  <input v-model="weekPriceTax" type="text" pattern="[0-9]+([,.][0-9]+)?" class="formbold-form-input" />
                  <span class="percent-symbol">%</span>
                </div>
            </div>

            <div class="formbold-mb-3">
                <label class="formbold-form-label">30 Days</label>
                <div class="input-with-percent">
                  <input v-model="monthPriceTax" type="text" pattern="[0-9]+([,.][0-9]+)?" class="formbold-form-input" />
                  <span class="percent-symbol">%</span>
                </div>
            </div>

            <div class="formbold-mb-3">
                <label class="formbold-form-label">360 Days</label>
                <div class="input-with-percent">
                  <input v-model="yearPriceTax" type="text" pattern="[0-9]+([,.][0-9]+)?" class="formbold-form-input" />
                  <span class="percent-symbol">%</span>
                </div>
            </div>

            <div class="formbold-mb-3">
              <label class="formbold-form-label"> Old Password </label>
              <input v-model="oldPass" type="password" class="formbold-form-input"
                    required />
            </div>

            <div class="text-center">
                <button type="submit" class="formbold-btn">Submit</button>
            </div>
        </form>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue'
  
  const priceTax = ref('');
  const weekPriceTax = ref('');
  const monthPriceTax = ref('');
  const yearPriceTax = ref('');
  const oldPass = ref('');
  const formStatus = ref(true)

  const getUserData = async () => {
    try {
      const response = await axios.get('/get/user/data');
      priceTax.value = response.data.price_tax ? response.data.price_tax : '';
      weekPriceTax.value = response.data.week_price_tax ? response.data.week_price_tax : '';
      monthPriceTax.value = response.data.month_price_tax ? response.data.month_price_tax : '';
      yearPriceTax.value = response.data.year_price_tax ? response.data.year_price_tax : '';
    } catch (error) {
      console.error(error);
    }
  }
  
  const upload = async () => {
    const formData = new FormData();
    if (priceTax.value) {
      formData.append('priceTax', priceTax.value);
    }
    if (weekPriceTax.value) {
      formData.append('weekPriceTax', weekPriceTax.value);
    }
    if (monthPriceTax.value) {
      formData.append('monthPriceTax', monthPriceTax.value);
    }
    if (yearPriceTax.value) {
      formData.append('yearPriceTax', yearPriceTax.value);
    }
    if (oldPass.value) {
      formData.append('oldPass', oldPass.value);
    }
    try {
      const response = await axios.post('upload', formData);
      if(response.data.message === 0){
        formStatus.value = false;
      } else {
        formStatus.value = true;
      }
    } catch (error) {
      console.error(error);
    } finally {
      open();
      getUserData();
      oldPass.value = null;
    }
  }

  
  const open = () => {
    if(formStatus.value === true){
      ElMessage({
        showClose: true,
        message: 'Updated successfully.',
        type: 'success',
      })
    } else{
      ElMessage.error('Oops, wrong password.')
    }
  }
  
  onMounted(() => {
    getUserData();
  });

  </script>