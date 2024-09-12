import { defineStore } from 'pinia'

export const useEmployeeStore = defineStore('employee', {
    state: () => {
        return {
            employees: [],
            openModalAddEmployee: false,
            openModalUpdateEmployee: false,
            openModalHistoryEmployee: false,
            filters: {
                employee_id: '',
                department: '',
                first_name: '',
                last_name: '',
                init_date: '',
                end_date: ''
            },
            employee: {
                id: '',
                employee_id: '',
                first_name: '',
                last_name: '',
                department_id: '',
                active: '',
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
                if (state.filters.first_name && !employee.first_name.toLowerCase().includes(state.filters.first_name.toLowerCase())) {
                    matchesFilter = false;
                }
                if (state.filters.last_name && !employee.last_name.toLowerCase().includes(state.filters.last_name.toLowerCase())) {
                    matchesFilter = false;
                }
                if (state.filters.department && !employee.department.name.toLowerCase().includes(state.filters.department.toLowerCase())) {
                    matchesFilter = false;
                }
                if (state.filters.init_date || state.filters.end_date) {
                    const employeeHistory = employee.history;

                    const filteredByDate = employeeHistory.some(entry => {
                        const incomeDate = entry.income.substring(0, 10); 
                        const exitDate = entry.exit.substring(0, 10);     

                        const initDate = state.filters.init_date ? new Date(state.filters.init_date) : null;
                        const endDate = state.filters.end_date ? new Date(state.filters.end_date) : null;

                        const income = new Date(incomeDate);
                        const exit = new Date(exitDate);

                        let isInRange = true;

                        if (initDate && income < initDate) {
                            isInRange = false;
                        }

                        if (endDate && exit > endDate) {
                            isInRange = false;
                        }

                        return isInRange;
                    });

                    if (!filteredByDate) {
                        matchesFilter = false;
                    }
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
        async UpdateEmployee() {
            try {
                await axios.put(route('update.employee', { employee: this.employee.id }), this.employee);
                this.openModalUpdateEmployee = false;
                this.employee = {
                    employee_id: '',
                    first_name: '',
                    last_name: '',
                    department_id: '',
                };

                this.errors = null;
                this.fetchEmployees()

            } catch (error) {
                this.errors = error.response?.data ?? null;
                console.log(error.response?.data);
            }
        },
        async UpdateActiveEmployee(employee) {
            try {
                await axios.put(route('update.active.employee', { employee: employee.id }), { active: employee.active = !employee.active });
                this.errors = null;
                this.fetchEmployees()

            } catch (error) {
                this.errors = error.response?.data ?? null;
                console.log(error.response?.data);
            }
        },
        clearFilter() {
            this.filters = {
                employee_id: '',
                department: '',
                first_name: '',
                last_name: '',
                init_date: '',
                end_date: ''
            }
        },
        openModalAndSetDataForUpdateEmployee(data) {
            this.employee = { ...this.employee, ...data };
            this.openModalUpdateEmployee = true;
        },
        cancelUpdateEmployee() {
            this.employee = {
                employee_id: '',
                first_name: '',
                last_name: '',
                department_id: '',
            }
            this.openModalUpdateEmployee = false;
        },
        openModalAndSetHistoryEmployee(data) {
            this.openModalHistoryEmployee = true
            this.employee = data
        }
    }
})
