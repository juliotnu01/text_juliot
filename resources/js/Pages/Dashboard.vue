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

const { StoreEmployee, clearFilter, cancelUpdateEmployee, UpdateEmployee } = employeeStore;
const { fetchDepartments } = departmentStore;

const { filters, openModalAddEmployee, employee, errors, openModalUpdateEmployee } = storeToRefs(employeeStore)
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
                <label for="input_search_name" class="mb-1 invisible">Placeholder</label>
                <select v-model="filters.department" class="h-10 px-2 border rounded">
                    <option value="">Select Department</option>
                    <option :value="department.name" v-for="(department, d) in departments" :key="d">{{ department.name
                        }}
                    </option>
                </select>
            </div>
            <div class="flex flex-col w-2/12">
                <label for="initial_access_date" class="mb-2 text-sm text-gray-700">Initial access date:</label>
                <input type="date" class="h-10 px-2 border rounded" placeholder="Start date" id="initial_access_date">
            </div>
            <div class="flex flex-col w-2/12">
                <label for="final_access_date" class="mb-2 text-sm text-gray-700">Final access date:</label>
                <input type="date" class="h-10 px-2 border rounded" placeholder="End date" id="final_access_date">
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
        <div class="w-full  px-6 flex justify-end ">
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
                </div>
            </div>
        </div>
    </AppLayout>
</template>
