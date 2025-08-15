<script setup lang="ts">
import { watch } from "vue";

const props = defineProps<{
    show: boolean;
    title: string;
}>();

const emit = defineEmits(["close"]);

watch(
    () => props.show,
    (show) => {
        document.body.style.overflow = show ? "hidden" : "";
    }
);
</script>

<template>
    <teleport to="body">
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-50"
                style="background-color: rgba(0, 0, 0, 0.5)"
                @click="$emit('close')"
            ></div>
        </transition>

        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 transform scale-95"
            enter-to-class="opacity-100 transform scale-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 transform scale-100"
            leave-to-class="opacity-0 transform scale-95"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-50 flex items-center justify-center"
            >
                <div
                    class="bg-white rounded-lg shadow-xl w-full max-w-2xl"
                    @click.stop
                >
                    <div class="flex justify-between items-center p-4 border-b">
                        <h2 class="text-xl font-bold text-[#6F4E37]">
                            {{ title }}
                        </h2>
                        <button
                            @click="$emit('close')"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            &times;
                        </button>
                    </div>
                    <div class="p-6">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>
