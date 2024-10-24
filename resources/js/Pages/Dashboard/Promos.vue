<template>
  <div class="card">
    <div class="card-body">
      <h2 class="mb-4">Promos</h2>
      <div class="card">
        <div class="card-body">
          <el-table :data="filterTableData" :loading="loading" stripe>
            <el-table-column label="Select Promotion">
              <template #default="scope">
                <input :disabled="promos.indexOf(scope.row.id) > -1" type="radio" :value="scope.row.id" v-model="selectedIncluded"/>
              </template>
            </el-table-column>
            <el-table-column label="What is included?" prop="what_is_included"/>
            <el-table-column label="Is Promoted ?">
              <template #default="scope">
                {{promos.indexOf(scope.row.id) > -1 ? 'Promoted' : 'Not Promoted'}}
              </template>
            </el-table-column>
            <el-table-column align="center">
              <template #header>
                <el-input v-model="search" size="small" placeholder="Type to search"/>
              </template>
            </el-table-column>
            <el-table-column >
              <template #default="scope">
                <button v-if="promos.indexOf(scope.row.id) > -1" class="btn btn-danger" @click="deletePromo(scope.row.id)"> Remove promo</button>
              </template>
            </el-table-column>

          </el-table>


        </div>
      </div>
      <div v-if="selectedIncluded">
        <h2>Select Vehicle</h2>
        <div class="card">

          <div class="card-body">
            <el-table :data="vehicleFilterTableData" style="width: 100%" :loading="loading" stripe>
              <el-table-column label="What is included?" prop="what_is_included">

                <template #default="scope">
                  <el-checkbox :value="scope.row.id" @click="selectVehicle(scope.row.vehicle_id)"/>
                </template>
              </el-table-column>
              <el-table-column label="Photo" prop="">
                <template #default="scope">
                  <img :src="'/img/vehicles/' + scope.row.photo" width="150" height="100">
                </template>
              </el-table-column>
              <el-table-column label="Vehicle Name" prop="vehicle_name"/>
              <el-table-column label="Country" prop="branch_country"/>
              <el-table-column label="Branch Name" prop="branch_name"/>
            </el-table>

          </div>
        </div>
        <button class="btn btn-primary" @click="AddPromo()"> Add Promo</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed, onMounted, ref} from 'vue'
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const $toast = useToast();
const search = ref('')
const tableData = ref([])
const vehicleTableData = ref([])
const loading = ref(false)

const selectedIncluded = ref("")
const selectedVehicles = ref([])
const promos = ref([])
const getData = async () => {
  try {
    loading.value = true;
    const response = await axios.get('get/included');
    tableData.value = response.data;
    console.log(response.data)
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
}

const deletePromo = async (promo) => {
  const response = await axios.delete('/promo/'+ promo);
  window.location.reload()
}

const AddPromo = async () => {
  try {
    if (selectedIncluded.value === [] || selectedIncluded.value === undefined || selectedIncluded.value === null) {
      $toast.error("Please select promo first form whats included", {position: "top"})
      return
    }
    if (selectedVehicles.value.length === 0) {
      $toast.error("Please select Vehicles to apply the promo on", {position: "top"})
      return
    }
    const formData = new FormData();
    formData.set("included_id", selectedIncluded.value)
    formData.set("selected_vehicles", selectedVehicles.value)

    const response = await axios.post('/promo', formData);
    window.location.reload()

    console.log(response)
  } catch (e) {
    $toast.error("something went wrong")
    console.error(e)
  }
}
const selectVehicle = (vehicle) => {
  console.log(vehicle)
  if (selectedVehicles.value?.indexOf(vehicle) >= 0) {
    selectedVehicles.value.splice(selectedVehicles.value.indexOf(vehicle), 1);
  } else {
    selectedVehicles.value.push(vehicle);
  }
  console.log(selectedVehicles.value)
}

const filterTableData = computed(() => {
      if (typeof search.value === 'string')
        return tableData.value.filter((data) => !search.value || data.what_is_included != undefined || data.what_is_included.toLowerCase().includes(search.value.toLowerCase()))
      else search.value = ''
    }
)
const vehicleFilterTableData = computed(() => {

  const dataArray = Array.isArray(vehicleTableData.value) ? vehicleTableData.value : [];

  return dataArray.filter((data) =>
      !search.value
      || !country.value
      || (data.vehicle_name && data.vehicle_name.toLowerCase().includes(search.value.toLowerCase()))
      || (data.vehicle_name && data.vehicle_name.toLowerCase().includes(country.value.toLowerCase()))
      || (data.branch_name && data.branch_name.toLowerCase().includes(search.value.toLowerCase()))
      || (data.branch_country && data.branch_country.toLowerCase().includes(search.value.toLowerCase()))
  );

})
const getPromos = async () => {
  try {
    loading.value = true
    const response = await axios.get('/promo');
    console.log(response.data)
    promos.value = response.data
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
}
const getVehiclesData = async (index) => {
  try {
    loading.value = true
    const params = {};

    const response = await axios.get('/get/profit', {params: params});
    vehicleTableData.value = response.data.data
    for (const key in vehicleTableData.value[index]) {
      data.value[key] = vehicleTableData.value[index][key] || '';
    }
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
}
onMounted(() => {
  getData()
  getVehiclesData()
  getPromos()

});

</script>

