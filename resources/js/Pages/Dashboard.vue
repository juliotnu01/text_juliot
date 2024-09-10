<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import TableDashboardVue from '@/Components/TableDashboard.vue';
import { ref, onMounted, onUnmounted } from 'vue';

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
    <AppLayout title="Dashboard">
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
                <input type="text" class="h-10 px-2 border rounded" placeholder="Search by employee ID"
                    id="input_search_employee">
            </div>
            <div class="flex flex-col w-2/12">
                <label for="input_search_name" class="mb-1 invisible">Placeholder</label>
                <input type="text" class="h-10 px-2 border rounded" placeholder="Search by Department"
                    id="input_search_name">
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
                <button class="px-4 py-[5px] text-white bg-gray-500 rounded hover:bg-gray-600 flex gap-2 ">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class=" self-center ">
                        <path
                            d="M14 20.5H10C9.80189 20.4974 9.61263 20.4176 9.47253 20.2775C9.33244 20.1374 9.25259 19.9481 9.25 19.75V12L3.9 4.69C3.81544 4.58007 3.76395 4.44832 3.75155 4.31018C3.73915 4.17204 3.76636 4.03323 3.83 3.91C3.89375 3.78712 3.98984 3.68399 4.10792 3.61173C4.226 3.53947 4.36157 3.50084 4.5 3.5H19.5C19.6384 3.50084 19.774 3.53947 19.8921 3.61173C20.0101 3.68399 20.1062 3.78712 20.17 3.91C20.2336 4.03323 20.2608 4.17204 20.2484 4.31018C20.236 4.44832 20.1846 4.58007 20.1 4.69L14.75 12V19.75C14.7474 19.9481 14.6676 20.1374 14.5275 20.2775C14.3874 20.4176 14.1981 20.4974 14 20.5ZM10.75 19H13.25V11.75C13.2492 11.5907 13.302 11.4357 13.4 11.31L18 5H6L10.62 11.31C10.718 11.4357 10.7708 11.5907 10.77 11.75L10.75 19Z"
                            fill="currentColor" />
                    </svg>
                    <p class=" self-center ">
                        Filter
                    </p>
                </button>
                <button class="px-4 py-[5px] text-white bg-gray-500 rounded hover:bg-gray-600 flex gap-2 ">
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
            <button class="px-4 py-[10px] text-white bg-blue-500 rounded hover:bg-blue-600 flex gap-2 ">
                <p class=" self-center ">
                    New employee
                </p>
            </button>
        </div>

        <div class="py-4">
            <div class=" mx-auto px-6 ">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <TableDashboardVue />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
