import { defineStore } from 'pinia'

export const useRoom911tStore = defineStore('room911', {
    state: () => {
        return {
            record: {
                income: null,
                exit: null,
                employee_id: ''
            },
            errors: null,
            message: null,
        };
    },
    getters: {},
    actions: {
        async postAccess() {
            try {
                this.record.income = new Date().toLocaleString()
                this.record.exit = new Date().toLocaleString()
                let { data } = await axios.post(route('access.room.911'), { ...this.record })
                this.message = data
                this.record = {
                    income: null,
                    exit: null,
                    employee_id: ''
                }
                this.errors = null
            } catch (error) {
                this.errors = error.response.data;
            }
        }
    }
})
