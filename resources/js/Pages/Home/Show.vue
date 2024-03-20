<template>
    <div class="min-h-screen max-h-max bg-gradient-to-t bg-neutral-900">
        <div class="mx-auto w-full max-w-screen-md px-4 pb-8 pt-20 flex justify-center">
            <div class="max-w-xl w-full h-full flex flex-col justify-center space-y-10">
                <div class="w-full bg-neutral-800 rounded-lg p-3 flex-col space-y-2">
                    <StatusCard :webs="webs" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StatusCard from './Partials/StatusCard.vue';

export default {
    props: {
        webs: {
            type: Object,
            required: true
        }
    },
    components: {
        StatusCard
    },
}
</script>