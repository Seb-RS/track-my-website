<template>
    <div v-for="(web) in webs" :key="web.id" class="w-full bg-neutral-700 rounded-lg p-3 flex-col">
        <div class="flex justify-between text-sm">
            <p class="text-neutral-50">{{ web.name }}</p>
            <p class="text-neutral-50 flex items-center">
                Disponible
                <span class="ml-1 text-green-200">
                    <OkCircleFilled />
                </span>
            </p>
        </div>
        <div class="flex overflow-x-auto py-1">
            <div class="flex min-w-[528px] justify-between">
                <button v-for="(day, index) in web.days" :key="index" class="w-[6.8px] h-[35px] rounded-lg"
                    @mouseover="handleMouseOver(web.id, index, day)"
                    @mouseleave="tooltipDayDetails.activeButton = null;" :disabled="day.status_code === null"
                    :ref="`day-button-${web.id}-${index}`"
                    :class="[{ 'bg-transparent/15': day.status_code === null }, statusToValue(day.status_code).color]">

                    <span v-if="index === tooltipDayDetails.activeButton && dayTemp"
                        :style="{ top: tooltipDayDetails.position.top + 'px', left: tooltipDayDetails.position.left + 'px' }"
                        class="flex flex-col fixed shadow-lg text-xs bg-neutral-600 text-white px-3 py-[6px] mx-auto w-max rounded before:w-4 before:h-4 before:rotate-45 before:bg-neutral-600 before:absolute before:z-[-1] before:-bottom-1 before:left-0  before:right-0 before:mx-auto">
                        <span class="font-semibold">
                            {{ statusToValue(dayTemp.status_code).text }}
                        </span>
                        <span class="text-neutral-300">
                            {{ dayTemp.date }}
                        </span>
                    </span>
                </button>
            </div>
        </div>
        <div class="text-neutral-300 flex justify-between italic text-xs">
            <p>60 días</p>
            <p>Hoy</p>
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
            dayTemp: null,
        }
    },
    components: {
        OkCircleFilled
    },
    methods: {
        handleMouseOver(web_index, index, day) {
            const ref = this.$refs[`day-button-${web_index}-${index}`];
            const element = ref[0];
            const rect = element.getBoundingClientRect();
            this.tooltipDayDetails.activeButton = index;
            this.dayTemp = day;

            this.$nextTick(() => {
                const child = element.children[0];
                this.tooltipDayDetails.position = {
                    top: rect.top - 55,
                    left: rect.left - (child.offsetWidth / 2) + 3.5
                };
            });
        },
        statusToValue(status_code) {
            switch (status_code) {
                case 200:
                case 202:
                case 204:
                    return { text: 'Disponible', color: 'bg-green-300 hover:bg-green-400' };
                case 301:
                    return { text: 'Redirección permanente', color: 'bg-yellow-300 hover:bg-yellow-400' };
                case 302:
                    return { text: 'Redirección temporal', color: 'bg-yellow-300 hover:bg-yellow-400' };
                case 400:
                    return { text: 'Solicitud incorrecta', color: 'bg-red-300 hover:bg-red-400' };
                case 404:
                    return { text: 'No encontrado', color: 'bg-red-300 hover:bg-red-400' };
                case 500:
                    return { text: 'No disponible', color: 'bg-red-300 hover:bg-red-400' };
                case 503:
                    return { text: 'Mantenimiento', color: 'bg-blue-300 hover:bg-blue-400' };
                case null:
                    return { text: 'Sin registrar', color: 'bg-transparent/20 hover:bg-transparent/30' };
                default:
                    return { text: 'Desconocido', color: 'bg-gray-300 hover:bg-gray-400' };
            }
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
