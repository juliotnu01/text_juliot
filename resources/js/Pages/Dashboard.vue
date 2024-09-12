<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TableDashboardVue from '@/Components/TableDashboard.vue';
import DialogModal from '@/Components/DialogModal.vue';

import { useEmployeeStore } from '@/stores/employee';
import { useDepartmentStore } from '@/stores/department';

import { ref, onMounted, onUnmounted, computed } from 'vue';
import { storeToRefs } from "pinia";

const currentDate = ref(new Date().toLocaleString());
const updateDateTime = () => {
    currentDate.value = new Date().toLocaleString();
};

const employeeStore = useEmployeeStore();
const departmentStore = useDepartmentStore();

const { StoreEmployee, clearFilter, cancelUpdateEmployee, UpdateEmployee, importEmployee, handleFile } = employeeStore;
const { fetchDepartments } = departmentStore;

const { filters, openModalAddEmployee, employee, errors, openModalUpdateEmployee, openModalHistoryEmployee, openModalImportEmployee, file } = storeToRefs(employeeStore)
const { departments } = storeToRefs(departmentStore)


onMounted(() => {
    const interval = setInterval(updateDateTime, 1000);
    onUnmounted(() => {
        clearInterval(interval);
    });
    fetchDepartments()
});

</script>

<template>
    <AppLayout title="Room 911">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="text-center w-full bg-[#cecece] capitalize font-bold ">
            <p>administrative menu</p>
        </div>
        <div class="flex justify-between px-5">
            <p class=" text-blue-500 font-bold  text-[16px] ">
                {{ currentDate }}
            </p>
            <div class="flex gap-2 text-blue-500 font-bold  text-[16px] capitalize">
                <p>
                    Welcome :
                </p>
                <p class="text-blue-500 font-bold  text-[16px] capitalize"> {{ $page.props.auth.user.name }} </p>
            </div>
        </div>
        <div class="flex mt-10 gap-4 px-6 justify-center">
            <div class="flex flex-col w-2/12">
                <label for="input_search_employee" class="mb-1 invisible">Placeholder</label>
                <input v-model="filters.employee_id" type="text" class="h-10 px-2 border rounded"
                    placeholder="Search by employee ID" id="input_search_employee">
            </div>
            <div class="flex flex-col w-2/12">
                <label for="input_search_employee" class="mb-1 invisible">Placeholder</label>
                <input v-model="filters.first_name" type="text" class="h-10 px-2 border rounded"
                    placeholder="Search by firstname" id="input_search_employee">
            </div>
            <div class="flex flex-col w-2/12">
                <label for="input_search_employee" class="mb-1 invisible">Placeholder</label>
                <input v-model="filters.last_name" type="text" class="h-10 px-2 border rounded"
                    placeholder="Search by lastname" id="input_search_employee">
            </div>
            <div class="flex flex-col w-2/12">
                <label for="input_search_name" class="mb-1 invisible">Placeholder</label>
                <select v-model="filters.department" class="h-10 px-2 border rounded">
                    <option value="">Select Department</option>
                    <option :value="department.name" v-for="(department, d) in departments" :key="d">{{ department.name
                        }}
                    </option>
                </select>
            </div>
            <div class="flex flex-col w-1/12">
                <label for="initial_access_date" class="mb-2 text-sm text-gray-700">Initial access date:</label>
                <input v-model="filters.init_date" type="date" class="h-10 px-2 border rounded" placeholder="Start date"
                    id="initial_access_date">
            </div>
            <div class="flex flex-col w-1/12">
                <label for="final_access_date" class="mb-2 text-sm text-gray-700">Final access date:</label>
                <input v-model="filters.end_date" type="date" class="h-10 px-2 border rounded" placeholder="End date"
                    id="final_access_date">
            </div>
            <div class="flex items-end gap-2">
                <button @click="clearFilter"
                    class="px-4 py-[5px] text-white bg-gray-500 rounded hover:bg-gray-600 flex gap-2 ">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class=" self-center ">
                        <path
                            d="M10.0303 8.96967C9.73741 8.67678 9.26253 8.67678 8.96964 8.96967C8.67675 9.26256 8.67675 9.73744 8.96964 10.0303L10.9393 12L8.96966 13.9697C8.67677 14.2626 8.67677 14.7374 8.96966 15.0303C9.26255 15.3232 9.73743 15.3232 10.0303 15.0303L12 13.0607L13.9696 15.0303C14.2625 15.3232 14.7374 15.3232 15.0303 15.0303C15.3232 14.7374 15.3232 14.2625 15.0303 13.9697L13.0606 12L15.0303 10.0303C15.3232 9.73746 15.3232 9.26258 15.0303 8.96969C14.7374 8.6768 14.2625 8.6768 13.9696 8.96969L12 10.9394L10.0303 8.96967Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.0574 1.25H11.9426C9.63424 1.24999 7.82519 1.24998 6.41371 1.43975C4.96897 1.63399 3.82895 2.03933 2.93414 2.93414C2.03933 3.82895 1.63399 4.96897 1.43975 6.41371C1.24998 7.82519 1.24999 9.63422 1.25 11.9426V12.0574C1.24999 14.3658 1.24998 16.1748 1.43975 17.5863C1.63399 19.031 2.03933 20.1711 2.93414 21.0659C3.82895 21.9607 4.96897 22.366 6.41371 22.5603C7.82519 22.75 9.63423 22.75 11.9426 22.75H12.0574C14.3658 22.75 16.1748 22.75 17.5863 22.5603C19.031 22.366 20.1711 21.9607 21.0659 21.0659C21.9607 20.1711 22.366 19.031 22.5603 17.5863C22.75 16.1748 22.75 14.3658 22.75 12.0574V11.9426C22.75 9.63423 22.75 7.82519 22.5603 6.41371C22.366 4.96897 21.9607 3.82895 21.0659 2.93414C20.1711 2.03933 19.031 1.63399 17.5863 1.43975C16.1748 1.24998 14.3658 1.24999 12.0574 1.25ZM3.9948 3.9948C4.56445 3.42514 5.33517 3.09825 6.61358 2.92637C7.91356 2.75159 9.62177 2.75 12 2.75C14.3782 2.75 16.0864 2.75159 17.3864 2.92637C18.6648 3.09825 19.4355 3.42514 20.0052 3.9948C20.5749 4.56445 20.9018 5.33517 21.0736 6.61358C21.2484 7.91356 21.25 9.62177 21.25 12C21.25 14.3782 21.2484 16.0864 21.0736 17.3864C20.9018 18.6648 20.5749 19.4355 20.0052 20.0052C19.4355 20.5749 18.6648 20.9018 17.3864 21.0736C16.0864 21.2484 14.3782 21.25 12 21.25C9.62177 21.25 7.91356 21.2484 6.61358 21.0736C5.33517 20.9018 4.56445 20.5749 3.9948 20.0052C3.42514 19.4355 3.09825 18.6648 2.92637 17.3864C2.75159 16.0864 2.75 14.3782 2.75 12C2.75 9.62177 2.75159 7.91356 2.92637 6.61358C3.09825 5.33517 3.42514 4.56445 3.9948 3.9948Z"
                            fill="currentColor" />
                    </svg>
                    <p class=" self-center ">
                        Clear Filter
                    </p>
                </button>
            </div>
        </div>
        <div class="border-solid border-[1px] border-black w-11/12 mx-auto my-10" />
        <div class="w-full  px-6 flex justify-end gap-4">
            <button @click="openModalImportEmployee = !openModalImportEmployee"
                class="px-4 py-[10px] text-white bg-orange-500 rounded hover:bg-orange-600 flex gap-2 ">
                <svg width="20px" height="20px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.5 3.5H14V3.29289L13.8536 3.14645L13.5 3.5ZM10.5 0.5L10.8536 0.146447L10.7071 0H10.5V0.5ZM6.5 6.5V6H6V6.5H6.5ZM6.5 8.5H6V9H6.5V8.5ZM8.5 8.5H9V8H8.5V8.5ZM8.5 10.5V11H9V10.5H8.5ZM10.5 9.5H10V9.70711L10.1464 9.85355L10.5 9.5ZM11.5 10.5L11.1464 10.8536L11.5 11.2071L11.8536 10.8536L11.5 10.5ZM12.5 9.5L12.8536 9.85355L13 9.70711V9.5H12.5ZM2.5 6.5V6H2V6.5H2.5ZM2.5 10.5H2V11H2.5V10.5ZM2 5V1.5H1V5H2ZM13 3.5V5H14V3.5H13ZM2.5 1H10.5V0H2.5V1ZM10.1464 0.853553L13.1464 3.85355L13.8536 3.14645L10.8536 0.146447L10.1464 0.853553ZM2 1.5C2 1.22386 2.22386 1 2.5 1V0C1.67157 0 1 0.671573 1 1.5H2ZM1 12V13.5H2V12H1ZM2.5 15H12.5V14H2.5V15ZM14 13.5V12H13V13.5H14ZM12.5 15C13.3284 15 14 14.3284 14 13.5H13C13 13.7761 12.7761 14 12.5 14V15ZM1 13.5C1 14.3284 1.67157 15 2.5 15V14C2.22386 14 2 13.7761 2 13.5H1ZM9 6H6.5V7H9V6ZM6 6.5V8.5H7V6.5H6ZM6.5 9H8.5V8H6.5V9ZM8 8.5V10.5H9V8.5H8ZM8.5 10H6V11H8.5V10ZM10 6V9.5H11V6H10ZM10.1464 9.85355L11.1464 10.8536L11.8536 10.1464L10.8536 9.14645L10.1464 9.85355ZM11.8536 10.8536L12.8536 9.85355L12.1464 9.14645L11.1464 10.1464L11.8536 10.8536ZM13 9.5V6H12V9.5H13ZM5 6H2.5V7H5V6ZM2 6.5V10.5H3V6.5H2ZM2.5 11H5V10H2.5V11Z"
                        fill="currentColor" />
                </svg>
                <p class=" self-center ">
                    Import employee
                </p>
            </button>
            <button @click="openModalAddEmployee = !openModalAddEmployee"
                class="px-4 py-[10px] text-white bg-blue-500 rounded hover:bg-blue-600 flex gap-2 ">
                <p class=" self-center ">
                    New employee
                </p>
            </button>
        </div>
        <div class="py-4">
            <div class=" mx-auto px-6 ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TableDashboardVue />
                    <DialogModal :show="openModalAddEmployee" closeable>
                        <template #content>
                            <form>
                                <div class="flex flex-col w-full my-4 ">
                                    <label for="employee_id" class="mb-1 ">Employee ID </label>
                                    <input v-model="employee.employee_id" type="text" class="h-10 px-2 border rounded"
                                        placeholder="Enter employee ID" id="employee_id">
                                    <small v-if="errors && errors.errors.employee_id" class="text-red-700">{{
                                        errors.errors.employee_id }}</small>
                                </div>
                                <div class="flex flex-col w-full my-4 ">
                                    <label for="firtname" class="mb-1 ">Firstname</label>
                                    <input v-model="employee.first_name" type="text" class="h-10 px-2 border rounded"
                                        placeholder="Enter firstname" id="firtname">
                                    <small v-if="errors && errors.errors.first_name" class="text-red-700">{{
                                        errors.errors.first_name }}</small>
                                </div>
                                <div class="flex flex-col w-full my-4 ">
                                    <label for="lastname" class="mb-1 ">LastName</label>
                                    <input v-model="employee.last_name" type="text" class="h-10 px-2 border rounded"
                                        placeholder="Enter lastname" id="lastname">
                                    <small v-if="errors && errors.errors.last_name" class="text-red-700">{{
                                        errors.errors.last_name }}</small>
                                </div>
                                <div class="flex flex-col w-full my-4 ">
                                    <label for="lastname" class="mb-1 ">LastName</label>
                                    <select v-model="employee.department_id" class="h-10 px-2 border rounded">
                                        <option value="">Select Department</option>
                                        <option :value="department.id" v-for="(department, d) in departments" :key="d">
                                            {{ department.name }}
                                        </option>
                                    </select>
                                    <small v-if="errors && errors.errors.department_id" class="text-red-700">{{
                                        errors.errors.department_id }}</small>
                                </div>
                            </form>
                        </template>
                        <template #footer>
                            <div class="flex gap-2">
                                <button @click="StoreEmployee"
                                    class="flex items-center px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded gap-2">
                                    Save
                                </button>
                                <button @click="openModalAddEmployee = !openModalAddEmployee"
                                    class="flex items-center px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded gap-2">
                                    Cancel
                                </button>
                            </div>
                        </template>
                    </DialogModal>
                    <DialogModal :show="openModalUpdateEmployee" closeable>
                        <template #title>
                            <div class="text-[16px]"> Update employee</div>
                        </template>
                        <template #content>
                            <form>
                                <div class="flex flex-col w-full my-4 ">
                                    <label for="employee_id" class="mb-1 ">Employee ID </label>
                                    <input v-model="employee.employee_id" type="text" class="h-10 px-2 border rounded"
                                        placeholder="Enter employee ID" id="employee_id">
                                    <small v-if="errors && errors.errors.employee_id" class="text-red-700">{{
                                        errors.errors.employee_id }}</small>
                                </div>
                                <div class="flex flex-col w-full my-4 ">
                                    <label for="firtname" class="mb-1 ">Firstname</label>
                                    <input v-model="employee.first_name" type="text" class="h-10 px-2 border rounded"
                                        placeholder="Enter firstname" id="firtname">
                                    <small v-if="errors && errors.errors.first_name" class="text-red-700">{{
                                        errors.errors.first_name }}</small>
                                </div>
                                <div class="flex flex-col w-full my-4 ">
                                    <label for="lastname" class="mb-1 ">LastName</label>
                                    <input v-model="employee.last_name" type="text" class="h-10 px-2 border rounded"
                                        placeholder="Enter lastname" id="lastname">
                                    <small v-if="errors && errors.errors.last_name" class="text-red-700">{{
                                        errors.errors.last_name }}</small>
                                </div>
                                <div class="flex flex-col w-full my-4 ">
                                    <label for="lastname" class="mb-1 ">LastName</label>
                                    <select v-model="employee.department_id" class="h-10 px-2 border rounded">
                                        <option value="">Select Department</option>
                                        <option :value="department.id" v-for="(department, d) in departments" :key="d">
                                            {{ department.name }}
                                        </option>
                                    </select>
                                    <small v-if="errors && errors.errors.department_id" class="text-red-700">{{
                                        errors.errors.department_id }}</small>
                                </div>
                            </form>
                        </template>
                        <template #footer>
                            <div class="flex gap-2">
                                <button @click="UpdateEmployee"
                                    class="flex items-center px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded gap-2">
                                    Update
                                </button>
                                <button @click="cancelUpdateEmployee"
                                    class="flex items-center px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded gap-2">
                                    Cancel
                                </button>
                            </div>
                        </template>
                    </DialogModal>
                    <DialogModal :show="openModalHistoryEmployee" closeable>
                        <template #title>
                            <div class="text-[16px]"> Hitory access of employee: {{ employee.first_name }} </div>
                        </template>
                        <template #content>
                            <table class="min-w-full table-auto bg-white shadow-md rounded-lg overflow-hidden">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-3 px-6 text-center">Income</th>
                                        <th class="py-3 px-6 text-center">Exit</th>
                                        <th class="py-3 px-6 text-center">Diff. Hours</th>
                                        <th class="py-3 px-6 text-center">Department</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(record, r) in employee.history" :key="r">
                                        <td class="py-4 px-6 text-center ">{{ record.income }}</td>
                                        <td class="py-4 px-6 text-center ">{{ record.exit }}</td>
                                        <td class="py-4 px-6 text-center ">{{ record.diff_income_exit_hours }}</td>
                                        <td class="py-4 px-6 text-center ">{{ employee.department.name }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </template>
                        <template #footer>
                            <div class="flex gap-2">

                                <button @click="openModalHistoryEmployee = !openModalHistoryEmployee"
                                    class="flex items-center px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded gap-2">
                                    Cancel
                                </button>
                            </div>
                        </template>
                    </DialogModal>
                    <DialogModal :show="openModalImportEmployee" closeable>
                        <template #title>
                            <div class="text-[16px]"> Import csv file</div>
                        </template>
                        <template #content>
                            <div class="flex flex-col w-full">
                                <label for="input_search_employee" class="mb-1 invisible">File import</label>
                                <input @change="handleFile" ref="file" type="file" class="h-10 px-2 border rounded"
                                    placeholder="Search by employee ID" id="input_search_employee">
                            </div>
                        </template>
                        <template #footer>
                            <div class="flex gap-2">
                                <button @click="importEmployee"
                                    class="flex items-center px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded gap-2">
                                    Import
                                </button>
                                <button @click="openModalImportEmployee = !openModalImportEmployee"
                                    class="flex items-center px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded gap-2">
                                    Cancel
                                </button>
                            </div>
                        </template>
                    </DialogModal>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
