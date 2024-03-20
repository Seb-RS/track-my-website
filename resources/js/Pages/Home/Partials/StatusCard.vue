<template>
    <div v-for="(web) in webs" :key="web.id" class="w-full bg-neutral-700 rounded-lg p-3 flex-col">
        <div class="flex justify-between text-sm">
            <h1 class="text-neutral-50">{{ web.name }}</h1>
            <h1 class="text-neutral-50 flex items-center">
                Disponible
                <span class="ml-1 text-green-200">
                    <OkCircleFilled />
                </span>
            </h1>
        </div>
        <div class="flex overflow-x-auto py-1">
            <div class="flex min-w-[528px] justify-between">
                <button v-for="(day, index) in web.days" :key="index" class="w-[6.8px] h-[35px] rounded-lg"
                    :class="[{ 'bg-transparent/15': day.status_code === null }, { 'bg-green-300': day.status_code == '200' }]">
                </button>
            </div>
        </div>
        <div class="text-neutral-300 flex justify-between italic text-xs">
            <h2>60 días</h2>
            <h2>Hoy</h2>
        </div>
    </div>
</template>

<script>
import OkCircleFilled from '@/Components/Icons/OkCircleFilled.vue';

export default {
    props: {
        webs: {
            type: Object,
            required: true
        }
    },
    components: {
        OkCircleFilled
    },
}

</script>

<style scoped>
::-webkit-scrollbar {
    width: 3px;
    height: 3px;
}

::-webkit-scrollbar-thumb {
    background-color: #848484;
    border-radius: 5px;
}
</style>
