<template>
  <div class="mb-4">
    <label class="block text-gray-300">{{ label }}</label>
    <input
      :value="inputValue"
      @input="validateAndUpdate"
      @blur="validateAndUpdate"
      :type="type"
      :class="[
        'mt-1 block w-full border rounded p-2 bg-gray-700 text-white',
        'border-gray-600',
        { 'border-red-500': error },
      ]"
    />
    <p v-if="error" class="text-red-500 text-sm">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { defineProps, defineEmits } from "vue";

const error = ref("");

const props = defineProps({
  label: { type: String, required: true },
  type: { type: String, default: "text" },
  inputValue: { type: String, required: true },
  validationRules: { type: Array, required: false, default: () => [] },
});
const emit = defineEmits(["update:inputValue", "validate"]);

const validate = (value) => {
  for (const rule of props.validationRules) {
    const result = rule(value);
    if (result !== true) {
      error.value = result;
      return false;
    }
  }

  error.value = "";
  return true;
};

const validateAndUpdate = (event) => {
  const value = event.target.value;
  const isValid = validate(value);
  emit("update:inputValue", value);
  emit("validate", isValid);
};
</script>
