<template>
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Bulk Vehicle Upload (Excel)</h2>

            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="upload">
                        <div class="row">
                            <!-- Supplier -->
                            <div class="formbold-mb-3 col-md-2">
                                <label class="formbold-form-label">Suppliers</label>
                                <el-select
                                    v-model="supplier"
                                    size="large"
                                    filterable
                                    remote
                                    reserve-keyword
                                    v-on:change="getBranches()"
                                    placeholder="Suppliers..."
                                    remote-show-suffix
                                    :loading="suppliers.loading.value"
                                    required>
                                    <el-option
                                        v-for="item in suppliers.list.value"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    />
                                </el-select>
                            </div>

                            <!-- Branch -->
                            <div class="formbold-mb-3 col-md-2">
                                <label class="formbold-form-label">Branches</label>
                                <el-select
                                    v-model="branch"
                                    size="large"
                                    filterable
                                    remote
                                    reserve-keyword
                                    placeholder="Branches..."
                                    remote-show-suffix
                                    :loading="branches.loading.value"
                                    required>
                                    <el-option
                                        v-for="item in branches.list.value"
                                        :key="item.id"
                                        :label="item.label"
                                        :value="item.id"
                                    />
                                </el-select>
                            </div>

                            <!-- Excel Upload -->
                            <div class="formbold-mb-3 col-md-2">
                                <label class="formbold-form-label">Upload Excel File</label>
                                <input
                                    type="file"
                                    class="formbold-form-input formbold-form-file"
                                    accept=".xls,.xlsx"
                                    @change="handleFile"
                                    :disabled="!branch"
                                    required
                                />
                            </div>

                            <div class="text-center mt-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary p-3"
                                    :disabled="!file"
                                >
                                    Upload Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Table -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-3">Excel Preview (Mock)</h5>

                    <el-table stripe style="width: 100%">
                        <el-table-column prop="vehicle" label="Vehicle Name"/>
                        <el-table-column prop="category" label="Category"/>
                        <el-table-column prop="price" label="Daily Price"/>
                    </el-table>
                </div>
            </div>

        </div>
    </div>
</template>
<script setup>

import {onMounted, ref} from "vue";

const supplier = ref('')
const loading = ref(false)
const branch = ref('')
const file = ref('')
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';


const suppliers = {
    loading: ref(false),
    all: ref([]),
    list: ref([]),
    options: ref([]),
};
const branches = {
    loading: ref(false),
    all: ref([]),
    list: ref([]),
    options: ref([]),
};
const handleFile = (event) => {
    file.value = event.target.files[0]
}

const upload = async () => {
    const $toast = useToast();

    try {
        const formData = new FormData();
        formData.append('file', file.value);
        formData.append('supplier', supplier.value);
        formData.append('branch', branch.value);
        const response = await axios.post('vehicles/bulk-upload', formData);

        if (response.data.status === true) {
            $toast.success("uploaded Successfully")
        }
    } catch (error) {
        console.log(error.response)

        if(error.response.data.status == false) {
            $toast.error(error.response.data.errors[0].error)
        } else
            $toast.error(error)

    }
}
const getSuppliers = async () => {
    try {
        suppliers.loading.value = true
        const response = await axios.get(`get/suppliers`, {})
        suppliers.all.value = response.data
        suppliers.list.value = suppliers.all.value.map((item) => ({
            value: `${item.name}`,
            label: `${item.name}`,
            id: `${item.id}`,
        }))

    } catch (error) {
        console.error(error)
    } finally {
        suppliers.loading.value = false
    }
}

const getBranches = async () => {
    try {
        const response = await axios.get('get/branches', {
            params: {
                'company_id': supplier.value
            }
        });
        branches.all.value = response.data
        branches.list.value = branches.all.value.map((item) => ({
            value: `${item.name}`,
            label: `${item.name}`,
            id: `${item.id}`,
        }))
    } catch (error) {
        console.error(error);
    }
};
onMounted(() => {
    getSuppliers();
});
</script>
