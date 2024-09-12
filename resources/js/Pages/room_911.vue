<script setup>
import { useRoom911tStore } from '@/stores/record';
import { storeToRefs } from 'pinia';
import { ref, onMounted, onUnmounted } from 'vue';


const room911Store = useRoom911tStore();
const { record, errors, message } = storeToRefs(room911Store);
const { postAccess } = room911Store;

const currentDate = ref(new Date().toLocaleString());
const updateDateTime = () => {
    currentDate.value = new Date().toLocaleString();
};

onMounted(() => {
    const interval = setInterval(updateDateTime, 1000);
    onUnmounted(() => {
        clearInterval(interval);
    });
});

</script>

<template>
    <div>
        <div class="text-center text-white text-[20px] w-full bg-[#252525] capitalize font-bold py-4 ">
            <p>ROOM 911 Authentication</p>
        </div>
        <div class=" flex justify-center mt-20 flex-col items-center gap-5 ">
            <svg width="100px" height="100px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8 7C9.65685 7 11 5.65685 11 4C11 2.34315 9.65685 1 8 1C6.34315 1 5 2.34315 5 4C5 5.65685 6.34315 7 8 7Z"
                    fill="#000000" />
                <path d="M14 12C14 10.3431 12.6569 9 11 9H5C3.34315 9 2 10.3431 2 12V15H14V12Z" fill="#000000" />
            </svg>
            <div class="flex justify-center px-5 w-full">
                <p class=" text-blue-500 font-bold  text-[26px]  ">
                    {{ currentDate }}
                </p>
            </div>
            <div class="flex flex-col w-4/12">
                <input v-model="record.employee_id" type="text" class="h-10 px-2 border rounded" placeholder="ID">
                <small v-if="errors" class="text-red-700">{{ errors.message }}</small>
            </div>
            <div v-if="message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex gap-2" role="alert">
                <span class="block sm:inline">{{message.message}}</span>
            </div>
            <button @click="postAccess"
                class="flex items-center px-4 py-2 text-white bg-sky-500 hover:bg-sky-600 rounded gap-2">
                <svg fill="currentColor" width="20px" height="20px" viewBox="0 0 96 96"
                    xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <path
                            d="M43.7578,61.7578a5.9994,5.9994,0,1,0,8.4844,8.4844l18-18a5.9979,5.9979,0,0,0,0-8.4844l-18-18a5.9994,5.9994,0,0,0-8.4844,8.4844L51.5156,42H6A6,6,0,0,0,6,54H51.5156Z" />
                        <path
                            d="M90,0H30a5.9966,5.9966,0,0,0-6,6V18a6,6,0,0,0,12,0V12H84V84H36V78a6,6,0,0,0-12,0V90a5.9966,5.9966,0,0,0,6,6H90a5.9966,5.9966,0,0,0,6-6V6A5.9966,5.9966,0,0,0,90,0Z" />
                    </g>
                </svg>
                Access
            </button>
        </div>
    </div>
</template>
