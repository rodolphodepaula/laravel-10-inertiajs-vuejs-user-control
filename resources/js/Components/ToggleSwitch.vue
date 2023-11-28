<template>
  <label for="toggle" class="inline-flex relative items-center cursor-pointer">
    <input type="checkbox" id="toggle" class="sr-only peer" v-model="checked">
    <div
      class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-blue-600 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:bg-gray-700 peer-checked:bg-blue-600">
    </div>
    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ label }}</span>
  </label>
</template>

<script>
export default {
  name: 'ToggleSwitch',
  props: {
    modelValue: {
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      default: '',
    },
  },
  emits: ['update:modelValue'],
  computed: {
    checked: {
      get() {
        return this.modelValue;
      },
      set(newValue) {
        this.$emit('update:modelValue', newValue);
      },
    },
  },
};
</script>
