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
                    @mouseover="handleMouseOver(web.id, index)" @mouseleave="tooltipDayDetails.activeButton = null;"
                    :disabled="day.status_code === null"
                    :ref="`day-button-${web.id}-${index}`"
                    :class="[{ 'bg-transparent/15': day.status_code === null }, { 'bg-green-300': day.status_code == '200' }]">
                    <span v-if="index === tooltipDayDetails.activeButton"
                        :style="{ top: tooltipDayDetails.position.top + 'px', left: tooltipDayDetails.position.left + 'px' }"
                        class="flex flex-col fixed shadow-lg text-xs bg-neutral-600 text-white px-3 py-[6px] mx-auto w-[100px] rounded before:w-4 before:h-4 before:rotate-45 before:bg-neutral-600 before:absolute before:z-[-1] before:-bottom-1 before:left-0  before:right-0 before:mx-auto">
                        <span class="font-semibold">
                            {{ day.status_code ? statusToText(day.status_code) : 'Sin registrar' }}
                        </span>
                        <span class="text-neutral-300">
                            {{ day.date }}
                        </span>
                    </span>
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
    data() {
        return {
            tooltipDayDetails: {
                activeButton: null,
                position: {
                    top: 0, left: 0
                }
            },
        }
    },
    components: {
        OkCircleFilled
    },
    methods: {
        handleMouseOver(web_index, index) {
            const ref = this.$refs[`day-button-${web_index}-${index}`];
            const element = ref[0];
            const rect = element.getBoundingClientRect();
            const child = element.children[0];
            this.tooltipDayDetails.position = {
                top: rect.top - 55,
                left: rect.left - (100 / 2) + 3.5
            };
            this.tooltipDayDetails.activeButton = index;
        },
        statusToText(status_code) {
            if (status_code == '200') {
                return 'Disponible';
            }
            return 'No disponible';
        }
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
