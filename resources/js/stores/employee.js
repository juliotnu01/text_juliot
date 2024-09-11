import { defineStore } from 'pinia'

export const useEmployeeStore = defineStore('employee', {
    state: () => {
        return {
            employees: [],
            openModalAddEmployee: true,
            filters: {
                employee_id: '',
                department: '',
                init_date: '',
                end_date: ''
            },
            employee: {
                employee_id: '',
                first_name: '',
                last_name: '',
                department_id: '',
            },
            errors: null,
        };
    },
    getters: {
        filteredEmployees(state) {
            return state.employees.filter(employee => {
                let matchesFilter = true;
                if (state.filters.employee_id && !employee.employee_id.toLowerCase().includes(state.filters.employee_id.toLowerCase())) {
                    matchesFilter = false;
                }
                if (state.filters.department && !employee.department.name.toLowerCase().includes(state.filters.department.toLowerCase())) {
                    matchesFilter = false;
                }
                return matchesFilter;
            });
        },
        employeesData() {
            return this.filteredEmployees;
        }
    },
    actions: {
        setEmployees(data) {
            this.employees = data;
        },
        setFilters(filters) {
            this.filters = { ...this.filters, ...filters };
        },
        async fetchEmployees() {
            try {
                const response = await axios(route('get.room.employee'));
                let { data } = response.data;
                this.setEmployees(data)
            } catch (error) {
                console.log(error);
            }

        },
        async StoreEmployee() {
            try {
                await axios.post(route('store.employee.room'), this.employee);
                this.openModalAddEmployee = false;
                this.employee = {
                    employee_id: '',
                    first_name: '',
                    last_name: '',
                    department_id: '',
                }
                this.errors = null

            } catch (error) {
                this.errors = error.response.data;
                console.log(error.response.data);
            }
        },
        clearFilter() {
            this.filters = {
                employee_id: '',
                department: '',
                init_date: '',
                end_date: ''
            }
        }
    }
})
