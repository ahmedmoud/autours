<template>
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Rentals</h2>
            <div class=" d-flex">
                <el-table :data="filterTableData" style="width: 100%" :loading="loading" stripe>
                    <el-table-column label="Photo" prop="">
                        <template #default="scope">
                            <img :src="'/img/vehicles/' + scope.row.vehicle.photo" class="w-100">
                        </template>
                    </el-table-column>
                    <el-table-column label="Name" prop="vehicle.name"/>
                    <el-table-column label="Pickup" prop="vehicle.pickup_loc"/>
                    <el-table-column label="Total Price" prop="supplier_price"/>
                    <el-table-column label="Rental Status" prop="status.name_en"/>
                    <el-table-column label="Start Date" prop="start_date"/>
                    <el-table-column label="End Date" prop="end_date"/>
                    <el-table-column label="Status" prop="status.name_en"/>
                    <el-table-column align="right">
                        <template #header>
                            <el-input v-model="search" size="small" placeholder="Type to search"/>
                        </template>

                        <template v-if="role === 'active_supplier'" #default="scope">
                            <el-button
                                v-if="scope.row.order_status === 0" size="small"
                                type="success"
                                @click="handleAccept(scope.$index, scope.row)"
                            >Activate
                            </el-button>

                            <el-button
                                v-if="scope.row.order_status === 0 || scope.row.order_status === 1"
                                size="small"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)"
                            >{{
                                    scope.row.order_status === 0 ? 'Delete' : (scope.row.order_status === 1 ? 'Disable' : '')
                                }}
                            </el-button>
                        </template>

                    </el-table-column>
                </el-table>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, computed, ref} from 'vue'

const search = ref('')
const tableData = ref([])
const loading = ref(false)
const role = ref('')

const getRole = async () => {
    try {
        const response = await axios.get('/get/user/role');
        role.value = response.data;
    } catch (error) {
        console.error(error);
    }
}

const getData = async () => {
    try {
        loading.value = true;
        const response = await axios.get('/get/rentals');
        tableData.value = response.data;
        console.log(tableData.value)
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
}

const filterTableData = computed(() => {
        return tableData.value.filter((data) => !search.value || data.vehicle.name.toLowerCase().includes(search.value.toLowerCase()))
    }
)

const handleAccept = async (index, row) => {
    try {
        loading.value = true;
        const response = await axios.post('accept/rentals', row);
        tableData.value = response.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
}

const handleDelete = async (index, row) => {
    try {
        loading.value = true;
        const response = await axios.post('delete/rentals', row);
        tableData.value = response.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
        getRole()
        getData()
        fetchCountries()
    }
)
</script>

<style lang="scss">
.el-table td.el-table__cell:last-child div {
    gap: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;

    button {
        width: 100%;
        margin: 0;
    }
}
</style>
