<template>
  <h2 class="mb-4">My Profile</h2>
  <div class="formbold-main-wrapper">
      <form @submit.prevent="upload">
          
          <h3 v-if="supplier || activeSupplier || reviewing" class="mb-4">Manager info</h3>
          <div class="formbold-mb-3">
              <label class="formbold-form-label"> User Name </label>
              <input v-model="name" class="formbold-form-input"
                    required />
          </div>

          <div class="formbold-mb-3">
              <label class="formbold-form-label"> Email </label>
              <input v-model="email" class="formbold-form-input disabled"
                    required disabled/>
          </div>

          <div class="formbold-mb-3">
              <label class="formbold-form-label"> Phone </label>
              <input v-model="phone" type="number" class="formbold-form-input"
                    required />
          </div>

          
          <div v-if="customer" class="formbold-mb-3">
              <label class="formbold-form-label">Gender</label>
              <el-select
                  v-model="gender"
                  size="large"
                  placeholder="Gender..."
                  style="width: 100%;"
                  >
                  <el-option
                  key="1"
                  label="Male"
                  value="Male"
                  />
                  <el-option
                  key="2"
                  label="Female"
                  value="Female"
                  />
              </el-select>
          </div>

          <h3 v-if="supplier || activeSupplier || reviewing" class="mb-4">Company info</h3>

          <div v-if="supplier || activeSupplier || reviewing" class="formbold-mb-3">
              <label class="formbold-form-label">
                  Company Logo
              </label>
              <input @change="handle" type="file"
                  class="formbold-form-input formbold-form-file" />
          </div>

          <div v-if="supplier || activeSupplier || reviewing || admin" class="formbold-mb-3">
              <label class="formbold-form-label"> Company Name </label>
              <input v-model="company" type="text" class="formbold-form-input"
                  required />
          </div>

          <label v-if="supplier || activeSupplier || reviewing" class="formbold-form-label"> Branches </label>
          <el-table v-if="supplier || activeSupplier || reviewing" :data="branches" style="width: 800px" max-height="250">
              <el-table-column prop="name" label="Name" />
              <el-table-column prop="location" label="Location" />
              <el-table-column prop="adresse" label="Adress" />
              <el-table-column fixed="right" label="Actions">
                <template #default="scope">
                  <el-button
                    link
                    type="primary"
                    size="small"
                    @click.prevent="deleteRow(scope.$index, scope.row)">
                    Remove
                  </el-button>
                </template>
              </el-table-column>
            </el-table>
            <el-button v-if="supplier || activeSupplier || reviewing" class="mb-4 mt-2" style="width: 100%" @click="onAddItem">Add Branch</el-button>

            <el-dialog v-model="addBranch" title="New Branch">
              <div>
                <div class="formbold-mb-3">
                  <label class="formbold-form-label">Name</label>
                  <el-input v-model="newBranch.name" required/>
                </div>

                <div class="formbold-mb-3">
                <label class="formbold-form-label">Location</label>
                <div class="countries">
                    <el-select
                        v-model="newBranch.country"
                        size="large"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Pickup..."
                        remote-show-suffix
                        :remote-method="remoteCountries"
                        :loading="countries.loading.value"
                        required>
                        <el-option
                        v-for="item in countries.options.value"
                        :key="item.id"
                        :label="item.label"
                        :value="item.label"
                        @click="fetchStates(item.iso)"
                        />
                    </el-select>

                    <el-select
                        v-model="newBranch.state"
                        size="large"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Pickup..."
                        remote-show-suffix
                        :remote-method="remoteStates"
                        :loading="states.loading.value"
                        required>
                        <el-option
                        v-for="item in states.options.value"
                        :key="item.id"
                        :label="item.label"
                        :value="item.label"
                        />
                    </el-select>

                    <div class="formbold-mb-3">
                       
                        <div class="input-with-percent">
                          <input v-model="newBranch.abriviation" maxlength="3" type="text" placeholder="Abriviation" style="padding: 6px 22px; text-transform: uppercase;" class="formbold-form-input" required/>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="supplier || activeSupplier || reviewing" class="formbold-mb-3">
                <label class="formbold-form-label">Address</label>
                <textarea v-model="newBranch.address" class="form-control" rows="3" required></textarea>
            </div>

                <el-form-item>
                  <el-button type="primary" @click="uploadBranch">Add</el-button>
                  <el-button @click="cancelAddItem">Cancel</el-button>
                </el-form-item>
              </div>
            </el-dialog>

          <h3 v-if="supplier || activeSupplier || reviewing" class="mb-4">Password Confirmation</h3>

          <div class="formbold-mb-3">
              <label class="formbold-form-label"> Old Password </label>
              <input v-model="oldPass" type="password" class="formbold-form-input"
                    required />
          </div>

          <h3 v-if="supplier || activeSupplier || reviewing" class="mb-4">New Password</h3>

          <div class="formbold-mb-3">
              <label class="formbold-form-label"> New Password </label>
              <input v-model="newPass" type="password" class="formbold-form-input"
                     />
          </div>

          <div class="formbold-mb-3">
              <label class="formbold-form-label"> Confirm Password </label>
              <input v-model="confirmNewPass" type="password" class="formbold-form-input"
                     />
          </div>

          <div class="text-center">
              <button type="submit" class="formbold-btn">Submit</button>
          </div>
      </form>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'

const logo = ref('');
const image = ref('');
const name = ref('');
const email = ref('');
const phone = ref('');
const oldPass = ref('');
const newPass = ref('');
const confirmNewPass = ref('');
const company = ref(''); 
const countries = {
loading: ref(false),
all:ref([]),
list: ref([]),
options: ref([]),
};
const states = {
loading: ref(false),
all:ref([]),
list: ref([]),
options: ref([]),
};
const gender = ref('');
const role = ref('')
const admin = ref(false)
const activeSupplier = ref(false)
const supplier = ref(false)
const customer = ref(false)
const reviewing = ref(false)
const formStatus = ref(true)
const addBranch = ref(false);
const newBranch = ref({
  name: '',
  country:'',
  state: '',
  abriviation: '',
  address: '',
});

const branches = ref([])

const onAddItem = () => {
  addBranch.value = true;
};

const fetchBranches = async () => {
  try {
    const response = await axios.get('get/branches');
    branches.value = response.data
  } catch (error) {
    console.error(error);
  }
};

const uploadBranch = async () => {
  newBranch.value.location = `${newBranch.value.country}, ${newBranch.value.state}, (${newBranch.value.abriviation.toUpperCase()})`;
  newBranch.value.adresse = newBranch.value.address
  try {
    const response = await axios.post('upload/branch', newBranch.value);
    if(response.data.message === 0){
      formStatus.value = false;
    } else {
      formStatus.value = true;
    }
    open();
    fetchBranches();
  } catch (error) {
    console.error(error);
  } finally {
    newBranch.value.name = '';
    newBranch.value.country = '';
    newBranch.value.state = '';
    newBranch.value.abriviation = '';
    newBranch.value.address = '';

    newBranch.value.adresse = '';
    newBranch.value.location = '';

    addBranch.value = false;
  }
};

const cancelAddItem = () => {
  newBranch.value = {
    name: '',
    country: '',
    state: '',
    abriviation:'',
    address: '',
  };
  addBranch.value = false;
};

const deleteRow = async (index, row) => {
  try {
    const response = await axios.post('delete/branches', row);
    branches.value = response.data;
  } catch (error) {
    console.error(error);
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

const getRole = async () => {
    try{
        const response = await axios.get('get/user/role');
        role.value = response.data;
    } catch (error) {
        console.error(error);
    } finally {
        if (role.value === 'admin') {
            admin.value = true
        } else if (role.value === 'active_supplier') {
            activeSupplier.value = true
        } else if (role.value === 'supplier') {
            supplier.value = true
        } else if (role.value === 'customer') {
            customer.value = true
        } else if (role.value === 'reviewing') {
            reviewing.value = true
        }
    }
}

const handle = (event) => {
  image.value = event.target.files[0]
}

const getUserData = async () => {
  try {
    const response = await axios.get('/get/user/data');
    logo.value = response.data.logo ? response.data.logo : '';
    name.value = response.data.name ? response.data.name : '';
    email.value = response.data.email ? response.data.email : '';
    phone.value = response.data.phone_num ? response.data.phone_num : '';
    company.value = response.data.company ? response.data.company : '';
    gender.value = response.data.gender ? response.data.gender : '';
  } catch (error) {
    console.error(error);
  }
}

const fetchCountries = async () => {
    countries.loading.value = true;
    try {
        const response = await axios.get('https://api.countrystatecity.in/v1/countries', {
        headers: {
            'X-CSCAPI-KEY': 'NVZhakViaFdtOXBJZ0xoQW1lWkJGTmlGUW1Kb05XaElGbXhocnNNOA=='
        }
        })
        countries.all.value = response.data
        countries.list.value = countries.all.value.map((item) => ({
        id: `${item.id}`,
        label: `${item.name}`,
        iso: `${item.iso2}`
        }))   
    } catch (error) {
        console.error(error)
    } finally {
        countries.loading.value = false;
    }
}

const remoteCountries = (query) => {
  if (query) {
    countries.loading.value = true
    setTimeout(() => {
      countries.loading.value = false
      countries.options.value = countries.list.value.filter((item) =>
        item.label.toLowerCase().includes(query.toLowerCase())
      )
    }, 200)
  } else {
    countries.options.value = []
  }
}

const fetchStates = async (iso) => {
    states.loading.value = true
    try {
        const response = await axios.get(`https://api.countrystatecity.in/v1/countries/${iso}/states`, {
        headers: {
            'X-CSCAPI-KEY': 'NVZhakViaFdtOXBJZ0xoQW1lWkJGTmlGUW1Kb05XaElGbXhocnNNOA=='
        }
        })
        states.all.value = response.data
        states.list.value = states.all.value.map((item) => ({
        value: `${item.id}`,
        label: `${item.name}`,
        }))
    } catch (error) {
        console.error(error)
    } finally {
        states.loading.value = false
    }
}

const remoteStates = (query) => {
  if (query) {
    states.loading.value = true
    setTimeout(() => {
        states.loading.value = false
        states.options.value = states.list.value.filter((item) =>
        item.label.toLowerCase().includes(query.toLowerCase())
      )
    }, 200)
  } else {
    states.options.value = []
  }
}

const upload = async () => {
  const formData = new FormData();
  if (image.value) {
    formData.append('logo', image.value);
  }
  if (name.value) {
    formData.append('name', name.value);
  }
  if (email.value) {
    formData.append('email', email.value);
  }
  if (phone.value) {
    formData.append('phone', phone.value);
  }
  if (oldPass.value) {
    formData.append('oldPass', oldPass.value);
  }
  if (newPass.value) {
    formData.append('newPass', newPass.value);
  }
  if (confirmNewPass.value) {
    formData.append('confirmNewPass', confirmNewPass.value);
  }
  if (company.value) {
    formData.append('company', company.value);
  }
  if (gender.value) {
    formData.append('gender', gender.value);
  }
  try {
    const response = await axios.post('upload', formData);
    if(response.data.message === 0){
      formStatus.value = false;
    } else {
      formStatus.value = true;
    }
    open();
    getUserData();
  } catch (error) {
    console.error(error);
  } finally {
    oldPass.value = null;
    newPass.value = null;
    confirmNewPass.value = null;
  }
}

onMounted(() => {
  getUserData();
  getRole();
  fetchCountries();
  fetchBranches();
});

</script>

<style scoped>
.formbold-form-input.disabled{
  background: rgba(128, 128, 128,0.1);
  color: rgba(0, 0, 0,0.3);
}

:deep(.el-dialog__header){
  background: transparent;
}
:deep(.el-dialog__body){
  padding-top: 80px;
}
  
</style>