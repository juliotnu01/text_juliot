import { defineStore } from 'pinia'

export const useDepartmentStore = defineStore('department', {
    state: () => {
        return {
            departments: [],
        };
    },
    getters: {},
    actions: {
        setDeparments(data) {
            this.departments = data;
        },
        async fetchDepartments() {
            try {
                const response = await axios(route('get.department'));
                let { data } = response.data;
                this.setDeparments(data)
            } catch (error) {
                console.log(error);
            }

        }
    }
})
