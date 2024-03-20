<template>
    <div v-for="(web) in webs" :key="web.id"
        class="w-full rounded-lg p-3 flex-col transition-all duration-1000 from-[#424242] via-[#4d4d4d] to-[#6b6969] bg-gradient-to-br bg-size-200 bg-pos-0 hover:bg-pos-100">
        <div class="flex justify-between text-sm">
            <p class="text-neutral-50">{{ web.name }}</p>
            <p class="text-neutral-50 flex items-center">
                Disponible
                <span class="ml-1 text-green-200">
                    <OkCircleFilled />
                </span>
            </p>
        </div>
        <div class="flex overflow-x-auto py-1" :ref="`days-container-${web.id}`">
            <div class="flex min-w-[528px] justify-between">
                <button v-for="(day, index) in web.days" :key="index" class="w-[6.8px] h-[35px] rounded-lg duration-300"
                    @mouseover="handleMouseOver(web.id, index, day)" @mousedown="handleMouseOver(web.id, index, day)"
                    @mouseleave="tooltipDayDetails.activeButton = null;" :ref="`day-button-${web.id}-${index}`"
                    :class="[{ 'bg-transparent/15': day.status_code === null }, statusToValue(day.status_code).color, day.status_code === null ? 'cursor-default' : 'cursor-pointer']">
                    <transition name="fade">
                        <span v-if="index === tooltipDayDetails.activeButton && dayTemp.web_index === web.id"
                            :style="{ top: tooltipDayDetails.position.top + 'px', left: tooltipDayDetails.position.left + 'px' }"
                            class="flex flex-col fixed shadow-lg text-xs bg-neutral-600 text-white px-3 py-[6px] mx-auto w-max rounded before:w-4 before:h-4 before:rotate-45 before:bg-neutral-600 before:absolute before:z-[-1] before:-bottom-1 before:left-0  before:right-0 before:mx-auto">
                            <span class="font-semibold">
                                {{ statusToValue(dayTemp.status_code).text }}
                            </span>
                            <span class="text-neutral-300">
                                {{ dayTemp.date }}
                            </span>
                        </span>
                    </transition>
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
    created() {
        this.$nextTick(() => {
            this.webs.forEach(web => {
                if (this.$refs[`days-container-${web.id}`] && this.$refs[`days-container-${web.id}`][0]) {
                    let container = this.$refs[`days-container-${web.id}`][0];
                    container.addEventListener('scroll', () => {
                        this.tooltipDayDetails.activeButton = null;
                    });
                    container.scrollLeft = container.scrollWidth - container.offsetWidth;
                }
            });
        });
    },
    unmounted() {
        this.webs.forEach(web => {
            if (this.$refs[`days-container-${web.id}`] && this.$refs[`days-container-${web.id}`][0]) {
                this.$refs[`days-container-${web.id}`][0].removeEventListener('scroll');
            }
        });
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
            this.dayTemp.web_index = web_index;
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

.fade-enter-active {
    transition: opacity 300ms ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
