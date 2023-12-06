<template>
    <div class="formbold-main-wrapper">
  
        <form @submit.prevent="upload">
            <div class="formbold-mb-3">
                <label class="formbold-form-label">
                    Vehicle Photo
                </label>
                <el-select
                      v-model="photo"
                      size="large"
                      filterable
                      remote
                      reserve-keyword
                      placeholder="Photo..."
                      remote-show-suffix
                      :remote-method="remotePhotos"
                      :loading="photos.loading.value"
                      @click="remotePhotos()"
                      >
                      <el-option
                        v-for="item in photos.options.value"
                        :key="item.id"
                        :label="item.label"
                        :value="item.photo"
                      >
                      <div class="d-flex" style="gap:10px;">
                        <img :src="'img/vehicles/' + item.photo"  style="width:50px;">
                        {{ item.label }}
                      </div>
                      </el-option>
                  </el-select>
            </div>
            <img v-if="photo" :src="'img/vehicles/' + photo" class="mb-4" style="width:300px;">
            <div class="formbold-mb-3">
                <label class="formbold-form-label"> Vehicle Name </label>
                <input v-model="name" type="text" class="formbold-form-input"
                    required />
            </div>

            <div class="formbold-mb-3">
                <label class="formbold-form-label"> Vehicle Description </label>
                <textarea v-model="description" class="formbold-form-input"></textarea>
            </div>
  
            <div class="formbold-mb-3">
                <label class="formbold-form-label">Price</label>
                <div class="input-with-percent">
                  <input v-model="price" type="text" pattern="[0-9]+([,.][0-9]+)?" class="formbold-form-input" required/>
                  <span class="percent-symbol">$</span>
                </div>
            </div>

            <div class="formbold-mb-3">
                <label class="formbold-form-label">3 - 7 Days Price</label>
                <div class="input-with-percent">
                  <input v-model="weekPrice" type="text" pattern="[0-9]+([,.][0-9]+)?"  class="formbold-form-input" required/>
                  <span class="percent-symbol">$</span>
                </div>
            </div>

            <div class="formbold-mb-3">
                <label class="formbold-form-label">30 Days Price</label>
                <div class="input-with-percent">
                  <input v-model="monthPrice" type="text" pattern="[0-9]+([,.][0-9]+)?" class="formbold-form-input" required/>
                  <span class="percent-symbol">$</span>
                </div>
            </div>

            <div class="formbold-mb-3">
                <label class="formbold-form-label">360 Day Price</label>
                <div class="input-with-percent">
                  <input v-model="yearPrice" type="text" pattern="[0-9]+([,.][0-9]+)?" class="formbold-form-input" required/>
                  <span class="percent-symbol">$</span>
                </div>
            </div>

            <div class="formbold-mb-3">
                <label class="formbold-form-label">Pickup Location</label>
                <div class="countries">
                    <el-select
                        v-model="pickupLoc"
                        size="large"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Pickup..."
                        remote-show-suffix
                        :remote-method="remoteBranches"
                        :loading="locations.loading.value"
                        @click="remoteBranches()"
                        >
                        <el-option
                        v-for="item in locations.options.value"
                        :key="item.id"
                        :label="item.label"
                        :value="item.id"
                        />
                    </el-select>

                </div>
            </div>
            <div class="formbold-mb-3">
                <label class="formbold-form-label">Category</label>
                    <el-select
                        v-model="category"
                        size="large"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Pickup..."
                        remote-show-suffix
                        :remote-method="remoteCategories"
                        :loading="categories.loading.value"
                        @click="remoteCategories()"
                        >
                        <el-option
                        v-for="item in categories.options.value"
                        :key="item.id"
                        :label="item.label"
                        :value="item.id"
                        />
                    </el-select>
            </div>
            <!-- <p v-if="!category" class="error-message" style="font-size: 14px;color: red;">Category is required</p> -->
            <div v-for="(list, i) in specifications" :key="i" class="formbold-mb-3">
                <label class="formbold-form-label">{{list.name}}</label>
                    <el-select
                        v-model="specification[i]"
                        size="large"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Pickup..."
                        remote-show-suffix
                        >
                        <el-option
                        v-for="item in list.options"
                        @click="getSpecificationOption(list.name, item)"
                        :key="item"
                        :label="item"
                        :value="item"
                        />
                    </el-select>
            </div>

            <div class="text-center">
                <button type="submit" class="formbold-btn">Submit</button>
            </div>
        </form>
    </div>
  </template>
  
<script setup>
import { onMounted, ref, watchEffect } from 'vue'

const photo = ref('')
const name = ref('')
const description = ref('')
const price = ref('')
const weekPrice = ref('')
const monthPrice = ref('')
const yearPrice = ref('')
const pickupLoc = ref('')
const locations = {
loading: ref(false),
all:ref([]),
list: ref([]),
options: ref([]),
};

const category = ref('')
const categories = {
loading: ref(false),
all:ref([]),
list: ref([]),
options: ref([]),
};

const specification  = ref([])
const specifications  = ref([])
const selectedSpecifications = ref([])

const photos = {
loading: ref(false),
all:ref([]),
list: ref([]),
options: ref([]),
};

const getSpecificationOption = (name, option) => {
  const s = {
    'name': name,
    'option': option,
  }
  
  const isDuplicate = selectedSpecifications.value.some(item => (
    item.name === name
  ));

  if (!isDuplicate) {
    selectedSpecifications.value.push(s);
  } else {
    const existingItem = selectedSpecifications.value.find(item => item.name === name);
    if (existingItem) {
      existingItem.option = option;
  }
}
};

const fetchSpecifications = async () => {
  try {
    const response = await axios.get('get/specifications');
    specifications.value = response.data;
  } catch (error) {
    console.error(error);
  } finally {
    
  }
}

const fetchCategories = async () => {
    categories.loading.value = true;
    try {
        const response = await axios.get('get/categories')
        categories.all.value = response.data
        categories.list.value = categories.all.value.map((item) => ({
        id: `${item.id}`,
        label: `${item.name}`,
        }))   
    } catch (error) {
        console.error(error)
    } finally {
        categories.loading.value = false;
    }
}

const remoteCategories = (query) => {
  if (query) {
    categories.loading.value = true
    setTimeout(() => {
      categories.loading.value = false
      categories.options.value = categories.list.value.filter((item) =>
        item.label.toLowerCase().includes(query.toLowerCase())
      )
    }, 200)
  } else {
    categories.options.value = categories.list.value;
  }
}

const fetchBranches = async () => {
    locations.loading.value = true;
    try {
        const response = await axios.get('get/branches')
        locations.all.value = response.data
        locations.list.value = locations.all.value.map((item) => ({
        id: `${item.id}`,
        label: `${item.name}`,
        }))   
    } catch (error) {
        console.error(error)
    } finally {
      locations.loading.value = false;
    }
}

const remoteBranches = (query) => {
  if (query) {
    locations.loading.value = true
    setTimeout(() => {
      locations.loading.value = false
      locations.options.value = locations.list.value.filter((item) =>
        item.label.toLowerCase().includes(query.toLowerCase())
      )
    }, 200)
  } else {
    locations.options.value = locations.list.value;
  }
}

const fetchPhotos = async () => {
  photos.loading.value = true;
    try {
        const response = await axios.get('/get/photos')
        photos.all.value = response.data
        photos.list.value = photos.all.value.map((item) => ({
        id: `${item.id}`,
        label: `${item.name}`,
        photo: `${item.photo}`,
        }))   
    } catch (error) {
        console.error(error)
    } finally {
      photos.loading.value = false;
    }
}

const remotePhotos = (query) => {
  if (query) {
    photos.loading.value = true
    setTimeout(() => {
      photos.loading.value = false
      photos.options.value = photos.list.value.filter((item) =>
        item.label.toLowerCase().includes(query.toLowerCase())
      )
    }, 200)
  } else {
    photos.options.value = photos.list.value;
  }
}  
  const upload = async () => {
    try {
        const formData = new FormData();
        formData.append('photo', photo.value);
        formData.append('name', name.value);
        formData.append('description', description.value);
        formData.append('price', price.value);
        formData.append('week_price', weekPrice.value);
        formData.append('month_price', monthPrice.value);
        formData.append('year_price', yearPrice.value);
        formData.append('pickupLoc', pickupLoc.value);
        formData.append('category', category.value);
        formData.append('specifications', JSON.stringify(selectedSpecifications.value));
        const response = await axios.post('post/vehicles', formData);
        open(response.data);
        if(response.data === 1){
          photo.value = null;
          name.value = null;
          description.value = null;
          price.value = null;
          weekPrice.value = null;
          monthPrice.value = null;
          category.value = null;
        }
    } catch (error) {
      console.error(error);
    }
  }

  const open = (response) => {
    if(response === 1){
      ElMessage({
        showClose: true,
        message: 'Created successfully.',
        type: 'success',
      })
    } else{
      ElMessage.error('Oops, something went wrong.')
    }
  }
  
  // watchEffect(() => {
  //   console.log(photo.value)
  //   console.log(photos.all.value)
  //   const matchingPhoto = photos.all.value.find(p => p.id === photo.value);
  //   console.log(matchingPhoto)
  //   if (matchingPhoto) {
  //     image.value = matchingPhoto.photo;
    
  //   }
  // })
  
  onMounted(() => {
    fetchBranches();
    fetchCategories();
    fetchSpecifications();
    fetchPhotos();
  });
  </script>