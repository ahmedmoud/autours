<template>
    <div>
      <h2 class="mb-4">Categories</h2>
        <div class="formbold-main-wrapper">
            <form @submit.prevent="postData">
                <div class="formbold-mb-3">
                    <label class="formbold-form-label">
                        Category Photo
                    </label>
                    <input @change="handle" type="file"
                        class="formbold-form-input formbold-form-file" />
                </div>
                <div class="formbold-mb-3">
                    <label class="formbold-form-label"> Category Name </label>
                    <input v-model="form.name" type="text" class="formbold-form-input"
                        required />
                </div>
    
                <div class="text-center">
                    <button type="submit" class="formbold-btn">Submit</button>
                </div>
            </form>
        </div>
        <div class="table d-flex">
            <el-table :data="filterTableData" style="width: 80%" :loading="loading" stripe>
                <el-table-column label="Photo" prop="">
                    <template #default="scope">
                        <img :src="'img/categories/' + scope.row.photo" class="w-50">
                    </template>
                </el-table-column>
                <el-table-column label="Category" prop="name" />

                <el-table-column align="right">

                <template #header>
                    <el-input v-model="search" size="small" placeholder="Type to search" />
                </template>

                <template #default="scope">
                    <!-- <el-button size="small" @click="handleEdit(scope.$index, scope.row)"
                    >Edit</el-button> -->

                    <el-button
                    size="small"
                    type="danger"
                    @click="handleDelete(scope.$index, scope.row)"
                    >Delete</el-button>
                </template>

                </el-table-column>
            </el-table>
        </div>
    </div>
  </template>
  
<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, computed, ref } from 'vue'

const search = ref('')
const tableData = ref([])
const loading = ref(false)

const getData = async () => {
  try {
    loading.value = true;
    const response = await axios.get('get/categories');
    tableData.value = response.data;
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
}

const filterTableData = computed(() => {
    return  tableData.value.filter((data) => !search.value || data.name.toLowerCase().includes(search.value.toLowerCase()))
}
)

const handle = (event) => {
    image.value = event.target.files[0]
}

const handleEdit = (index, row) => {
  console.log(index, row)
}

const handleDelete = async (index, row) => {
  try {
    loading.value = true;
    const response = await axios.post('delete/categories', row);
    tableData.value = response.data;
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
}

const form = useForm({
    name: '',
});

const image = ref('')

const postData = async () => {
  try {
    const formData = new FormData();
    formData.append('photo', image.value);
    formData.append('name', form.name);
    const response = await axios.post('post/categories', formData);
  } catch (error) {
    console.error(error);
  } finally {
    getData();
    form.reset();
  }
};
  
onMounted(() => {
    getData()
}
) 
</script>