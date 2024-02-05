<template>
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Rental Terms</h2>
            <div class="card">
                <div class=" d-flex">
                    <el-table :data="filterTableData" style="width: 100%" :loading="loading" stripe>
                        <el-table-column width="100" label="Select">
                            <template #default="scope">
                            <el-checkbox  :checked="scope.row.selected" size="large" v-on:click="selectTerm(scope.row)"/>
                            </template>
                        </el-table-column>
                        <el-table-column label="Title">
                            <template #default="scope">
                                <div v-html="scope.row.title"></div>
                            </template>
                        </el-table-column>

                        <el-table-column label="Description">
                            <template #default="scope">
                                <div v-html="scope.row.description"></div>
                            </template>
                        </el-table-column>
                        <el-table-column align="right">
                            <template #header>
                                <el-input v-model="search" size="small" placeholder="Type to search"/>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3';
import {onMounted, computed, ref, nextTick} from 'vue'
import Editor from 'primevue/editor';

import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const search = ref('')
const tableData = ref([])
const loading = ref(false)

const inputValue = ref('')
const dynamicTags = ref([])
const inputVisible = ref(false)
const InputRef = ref(false)
const $toast = useToast();
const handleClose = (tag) => {
    dynamicTags.value.splice(dynamicTags.value.indexOf(tag), 1)
}
const selectTerm = async (item) => {
    try {
        const formData = new FormData();


        formData.append('term_id', item.id);

        const response = await axios.post('select-rental-terms', formData);
        if(response.data.status) {
            $toast.success('Rental Term added successfully', {position: 'top'})
            form.reset();
        }
        console.log(response.data.status);
    } catch (error) {
        $toast.error(error.response.data.message, {position: 'top'});
    } finally {
        getData();
    }
}



const getData = async () => {
    try {
        loading.value = true;
        const response = await axios.get('get/rental-terms');
        tableData.value = response.data;
        console.log(response.data)
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
}

const filterTableData = computed(() => {
        return tableData.value.filter((data) => !search.value || data.name.toLowerCase().includes(search.value.toLowerCase()))
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
        const response = await axios.post('delete/rental-terms', row);
        if(response.data.status) {
            $toast.success('Rental Term deleted', {position: 'top'})
        }
    } catch (error) {
        $toast.error(error.response.data.message, {position: 'top'});
    } finally {
        loading.value = false;
        getData()
    }
}

const form = useForm({
    title: '',
    description: ''
});

const postData = async () => {
    try {
        const formData = new FormData();
        const options = dynamicTags.value;

        if(form.title === '' || form.title === null || form.title === undefined) {
            $toast.error('Please Insert Valid Title', {position: 'top'});
            return
        }
        if(form.description === '' || form.description === null || form.description === undefined) {
            $toast.error('Please Insert Valid description', {position: 'top'});
            return
        }
        formData.append('title', form.title);
        formData.append('description', form.description);

        const response = await axios.post('post/rental-terms', formData);
        if(response.data.status) {
            $toast.success('Rental Term added successfully', {position: 'top'})
            form.reset();
        }
        console.log(response.data.status);
    } catch (error) {
        $toast.error(error.response.data.message, {position: 'top'});
    } finally {
        getData();
    }
};

onMounted(() => {
        getData()
    }
)
</script>

<style>

.el-tag {
    .el-icon,
    .el-tag__content {
        color: #111111;
    }
}

</style>
