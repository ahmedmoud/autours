<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="formbold-mb-3 col-md-2">
                    <label class="formbold-form-label">Country</label>
                    <el-select
                        v-model="country"
                        size="large"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Countries..."
                        remote-show-suffix
                        :loading="countries.loading.value"
                        v-on:change="getSuppliers()"
                        required>
                        <el-option
                            v-for="item in countries.list.value"
                            :key="item.id"
                            :label="item.label"
                            :value="item.label"
                        />
                    </el-select>
                </div>
                <div class="formbold-mb-3 col-md-2">
                    <label class="formbold-form-label">Suppliers</label>
                    <el-select
                        v-model="supplier"
                        size="large"
                        filterable
                        remote
                        reserve-keyword
                        v-on:change="getSupplierInvoices()"
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
            </div>
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
                    <el-table-column label="Total Price" prop="price"/>
                    <el-table-column label="Profit" prop="profit_margin"/>
                    <el-table-column label="Supplier price" prop="supplier_price"/>
                    <el-table-column label="Currency" prop="currency"/>

                    <el-table-column label="Supplier name" prop="vehicle.supplier.name"/>
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
    <div v-if="supplier" class="col-md-4 mt-5 offset-3">
        <div class="text-muted text-sm-end">
            <table class="table align-middle table-nowrap table-centered mb-0">

                <!-- end col -->

                <thead>
                <tr>
                    <th style="width: 250px;">Number of rentals</th>
                    <th style="width: 250px;">To be paid</th>
                    <th style="width: 250px;">Currency</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 250px;">{{invoices?.count_rentals}}</td>
                    <td style="width: 250px;">
                        <div>
                            {{invoices?.total_price}}
                        </div>
                    </td>
                    <td style="width: 250px;">{{invoices?.currency}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row ml-5 mt-5" v-if="invoices?.total_price > 0">
            <a @click="reconcile()" class=" col-2 text-white btn btn-success mr-5">Pay</a>
            <a @click="cancel()" class="col-2 btn btn-danger text-white">Cancel</a>
        </div>
    </div>

</template>

<script setup>
import {onMounted, computed, ref} from 'vue'
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const country = ref('')
const supplier = ref('')
const branch = ref('')
const countries = {
    loading: ref(false),
    all: ref([]),
    list: ref([]),
    options: ref([]),
};
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
const search = ref('')
const tableData = ref([])
const loading = ref(false)
const role = ref('')
const invoices = ref({})
const $toast = useToast();
const fetchCountries = async () => {
    countries.loading.value = true;
    try {
        //
        const response = await axios.get('/get/countries', {})
        countries.all.value = response.data
        console.log(response);
        countries.list.value = countries.all.value.map((item) => ({
            id: `${item}`,
            label: `${item}`,
            iso: `${item}`
        }))
    } catch (error) {
        console.error(error)
    } finally {
        countries.loading.value = false;
    }
}

const cancel = () =>{
    supplier.value = '';
    country.value  = ''
    getData()
}
const reconcile = async () =>{
    try {
        suppliers.loading.value = true
        if (country.value) {
            const response = await axios.post(`/rentals/reconcile`, {'supplier_id': supplier.value})
            if(response.data.status) {
                $toast.success('Supplier Rentals Reconciled Successfully', {position: 'top'});
                getData()
            }
        }
    } catch (error) {
        console.error(error)
    } finally {
        suppliers.loading.value = false
    }
}
const getSuppliers = async () => {
    try {
        suppliers.loading.value = true
        if (country.value) {
            const response = await axios.get(`/get/suppliers`, {
                params: {
                    'country': country.value
                }
            })
            suppliers.all.value = response.data
            suppliers.list.value = suppliers.all.value.map((item) => ({
                value: `${item.name}`,
                label: `${item.name}`,
                id: `${item.id}`,
            }))

        }
    } catch (error) {
        console.error(error)
    } finally {
        suppliers.loading.value = false
    }
}

const getSupplierInvoices = async () => {
    try {
        const response = await axios.get('/get/supplier/invoice', {
            params: {
                'company_id': supplier.value
            }
        });
        invoices.value = response.data.data
        getData()
    } catch (error) {
        console.error(error);
    }
};

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
        let params = {};
        if(supplier.value != [] || supplier.value != null || supplier.value != undefined || supplier.value != "") {
            params ={supplier_id:  supplier.value}
        }
        const response = await axios.get('/get/rentals/admin', {params: params});
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
