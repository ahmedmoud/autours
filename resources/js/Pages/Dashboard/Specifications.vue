<template>
    <div>
      <h2 class="mb-4">Specifications</h2>
        <div class="formbold-main-wrapper">
            <form @submit.prevent="postData">
                <div class="formbold-mb-3">
                    <label class="formbold-form-label"> Specification Name </label>
                    <input v-model="form.name" type="text" class="formbold-form-input"
                        required />
                </div>
                <div class="formbold-mb-3">
                    <label class="formbold-form-label"> Specification Options </label>
                    <el-tag
                      v-for="tag in dynamicTags"
                      :key="tag"
                      class="mx-1"
                      size="large"
                      closable
                      :disable-transitions="false"
                      @close="handleClose(tag)"
                      >
                      {{ tag }}
                    </el-tag>
                    <el-input
                      v-if="inputVisible"
                      ref="InputRef"
                      v-model="inputValue"
                      class="ml-1 w-20"
                      size="large"
                      @keyup.enter="handleInputConfirm"
                      @blur="handleInputConfirm"
                    />
                    <el-button v-else class="button-new-tag ml-1" size="large" @click="showInput">
                      + New Option
                    </el-button>
                </div>
    
                <div class="text-center">
                    <button type="submit" class="formbold-btn">Submit</button>
                </div>
            </form>
        </div>
        <div class="table d-flex">
            <el-table :data="filterTableData" style="width: 80%" :loading="loading" stripe>
                <el-table-column label="Name" prop="name" />
                <el-table-column label="Options">
                  <template #default="scope">
                    <span v-if="Array.isArray(scope.row.options)">
                      {{ scope.row.options.join(', ') }}
                    </span>
                    </template>
                </el-table-column>
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
import { onMounted, computed, ref, nextTick } from 'vue'

const search = ref('')
const tableData = ref([])
const loading = ref(false)

const inputValue = ref('')
const dynamicTags = ref([])
const inputVisible = ref(false)
const InputRef = ref(false)

const handleClose = (tag) => {
  dynamicTags.value.splice(dynamicTags.value.indexOf(tag), 1)
}

const showInput = () => {
  inputVisible.value = true
  nextTick(() => {
    InputRef.value.input.focus()
  })
}

const handleInputConfirm = () => {
  if (inputValue.value) {
    dynamicTags.value.push(inputValue.value)
  }
  inputVisible.value = false
  inputValue.value = ''
}

const getData = async () => {
  try {
    loading.value = true;
    const response = await axios.get('get/specifications');
    tableData.value = response.data;
    console.log(response.data)
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
    const response = await axios.post('delete/specifications', row);
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

const postData = async () => {
  try {
    const formData = new FormData();
    const options = dynamicTags.value;
    formData.append('name', form.name);
    formData.append('options', JSON.stringify(options));
    const response = await axios.post('post/specifications', formData);
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

<style>

.el-tag{
  .el-icon,
  .el-tag__content{
    color:#111111;
  }
}

</style>