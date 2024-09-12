<script setup>
import { onMounted } from 'vue';
import { useEmployeeStore } from '@/stores/employee';
import { storeToRefs } from "pinia";

const employeeStore = useEmployeeStore();
const { fetchEmployees, openModalAndSetDataForUpdateEmployee, UpdateActiveEmployee, openModalAndSetHistoryEmployee } = employeeStore
const { employeesData } = storeToRefs(employeeStore)

onMounted(async () => {
    await fetchEmployees()
})

</script>

<template>
    <table class="min-w-full table-auto bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-3 px-6 text-center">Employee ID</th>
                <th class="py-3 px-6 text-center">Firstname</th>
                <th class="py-3 px-6 text-center">Lastname</th>
                <th class="py-3 px-6 text-center">Department</th>
                <th class="py-3 px-6 text-center">Total access</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b" v-for="(employee, e) in employeesData" :key="e">
                <td class="py-4 px-6 text-center ">{{ employee.employee_id }}</td>
                <td class="py-4 px-6 text-center ">{{ employee.first_name }}</td>
                <td class="py-4 px-6 text-center ">{{ employee.last_name }}</td>
                <td class="py-4 px-6 text-center ">{{ employee.department.name ?? '' }}</td>
                <td class="py-4 px-6 text-center ">{{ employee.department.access ?? '' }}</td>
                <td class="py-4 px-6 flex justify-center gap-2">
                    <button @click="openModalAndSetDataForUpdateEmployee({ id:employee.id, employee_id:employee.employee_id, first_name: employee.first_name, last_name:employee.last_name, department_id: employee.department.id })"  class="flex items-center px-4 py-2 text-white bg-gray-500 hover:bg-gray-600 rounded gap-2">
                        <svg fill="currentColor" width="20px" height="20px" viewBox="0 0 24 24" id="update-alt"
                            data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
                            <path id="primary" d="M5.07,8A8,8,0,0,1,20,12"
                                style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                            </path>
                            <path id="primary-2" data-name="primary" d="M18.93,16A8,8,0,0,1,4,12"
                                style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                            </path>
                            <polyline id="primary-3" data-name="primary" points="5 3 5 8 10 8"
                                style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                            </polyline>
                            <polyline id="primary-4" data-name="primary" points="19 21 19 16 14 16"
                                style="fill: none; stroke: white; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                            </polyline>
                        </svg>
                        Update
                    </button>
                    <button @click="UpdateActiveEmployee(employee)" :class="{'flex items-center px-4 py-2 text-white bg-gray-500 hover:bg-gray-600 rounded gap-2': !employee.active, 'flex items-center px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded gap-2': employee.active  }">
                        <svg fill="currentColor" height="20px" width="20px" version="1.1" id="Layer_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 472.615 472.615" xml:space="preserve">
                            <g>
                                <g>
                                    <circle cx="147.692" cy="98.47" r="68.923" />
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M271.266,200.647c-10.266-9.228-22.454-16.234-36.014-20.319l-15.854-4.629l-67.946,67.947l-68.045-67.947l-15.854,4.629
			C27.178,192.539,0,228.974,0,271.12v83.407h211.226c-11.629-47.005,0.726-98.784,37.39-135.448
			C255.6,212.093,263.203,205.959,271.266,200.647z" />
                                </g>
                            </g>
                            <g>
                                <g>
                                    <path d="M436.618,233.005c-23.253-23.253-54.16-36.053-87.039-36.053c-32.878,0-63.786,12.8-87.039,36.053
			c-47.995,47.996-47.995,126.082,0,174.078c23.994,23.993,55.517,35.985,87.039,35.985c31.523,0,63.046-11.992,87.039-35.985
			C484.614,359.087,484.614,281.001,436.618,233.005z M246.182,320.044c0-27.619,10.751-53.584,30.283-73.115
			c19.531-19.531,45.495-30.283,73.114-30.283c24.309,0,47.327,8.345,65.814,23.659L269.842,385.856
			C254.527,367.369,246.182,344.352,246.182,320.044z M422.694,393.157c-37.953,37.954-98.327,40.137-138.912,6.608L429.317,254.23
			c15.315,18.487,23.659,41.505,23.659,65.814C452.976,347.662,442.224,373.627,422.694,393.157z" />
                                </g>
                            </g>
                        </svg>
                        {{ employee.active ?  'Disable' : 'Enable'}}
                    </button>
                    <button
                    @click="openModalAndSetHistoryEmployee(employee)"
                        class="flex items-center px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded gap-2">
                        <svg fill="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="20px"
                            viewBox="0 0 503.379 503.379" xml:space="preserve">
                            <g>
                                <path d="M458.091,128.116v326.842c0,26.698-21.723,48.421-48.422,48.421h-220.92c-26.699,0-48.421-21.723-48.421-48.421V242.439
		c6.907,1.149,13.953,1.894,21.184,1.894c5.128,0,10.161-0.381,15.132-0.969v211.594c0,6.673,5.429,12.104,12.105,12.104h220.92
		c6.674,0,12.105-5.432,12.105-12.104V128.116c0-6.676-5.432-12.105-12.105-12.105H289.835c0-12.625-1.897-24.793-5.297-36.315
		h125.131C436.368,79.695,458.091,101.417,458.091,128.116z M159.49,228.401c-62.973,0-114.202-51.229-114.202-114.199
		C45.289,51.229,96.517,0,159.49,0c62.971,0,114.202,51.229,114.202,114.202C273.692,177.172,222.461,228.401,159.49,228.401z
		 M159.49,204.19c49.618,0,89.989-40.364,89.989-89.988c0-49.627-40.365-89.991-89.989-89.991
		c-49.626,0-89.991,40.364-89.991,89.991C69.499,163.826,109.87,204.19,159.49,204.19z M227.981,126.308
		c6.682,0,12.105-5.423,12.105-12.105s-5.423-12.105-12.105-12.105h-56.386v-47.52c0-6.682-5.423-12.105-12.105-12.105
		s-12.105,5.423-12.105,12.105v59.625c0,6.682,5.423,12.105,12.105,12.105H227.981z M367.697,224.456h-131.14
		c-6.682,0-12.105,5.423-12.105,12.105c0,6.683,5.423,12.105,12.105,12.105h131.14c6.685,0,12.105-5.423,12.105-12.105
		C379.803,229.879,374.382,224.456,367.697,224.456z M367.91,297.885h-131.14c-6.682,0-12.105,5.42-12.105,12.105
		s5.423,12.105,12.105,12.105h131.14c6.685,0,12.104-5.42,12.104-12.105S374.601,297.885,367.91,297.885z M367.91,374.353h-131.14
		c-6.682,0-12.105,5.426-12.105,12.105c0,6.685,5.423,12.104,12.105,12.104h131.14c6.685,0,12.104-5.42,12.104-12.104
		C380.015,379.778,374.601,374.353,367.91,374.353z" />
                            </g>
                        </svg>
                        History
                    </button>
                    <button class="flex items-center px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded gap-2">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.1709 4C9.58273 2.83481 10.694 2 12.0002 2C13.3064 2 14.4177 2.83481 14.8295 4"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M18.8332 8.5L18.3732 15.3991C18.1962 18.054 18.1077 19.3815 17.2427 20.1907C16.3777 21 15.0473 21 12.3865 21H11.6132C8.95235 21 7.62195 21 6.75694 20.1907C5.89194 19.3815 5.80344 18.054 5.62644 15.3991L5.1665 8.5"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Delete
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</template>