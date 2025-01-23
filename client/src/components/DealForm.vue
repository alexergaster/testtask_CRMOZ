<template>
  <form
    @submit.prevent="submitDeal"
    class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md"
    :class="{
      'bg-opacity-50 backdrop-blur-md pointer-events-none': isSubmitting,
    }"
  >
    <h2 class="text-2xl font-semibold text-white mb-6 text-center">
      Створити угоду
    </h2>

    <form-input
      label="Назва угоди"
      :inputValue="dealName"
      :validationRules="[required]"
      @update:inputValue="dealName = $event"
      @validate="updateValidation('dealName', $event)"
    />

    <form-input
      label="Стадія угоди"
      :inputValue="dealStage"
      :validationRules="[required]"
      @update:inputValue="dealStage = $event"
      @validate="updateValidation('dealStage', $event)"
    />

    <div class="flex justify-between items-center">
      <button
        type="submit"
        class="bg-black bg-opacity-50 backdrop-blur-md text-white px-4 py-2 rounded hover:bg-opacity-70 transition duration-200"
      >
        Створити угоду
      </button>

      <div
        @click="handleClick"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500 transition duration-200 cursor-pointer"
      >
        Перейти до акаунту
      </div>
    </div>

    <p
      v-if="successMessage || failedMessage"
      :class="{
        'text-green-500': successMessage,
        'text-red-500': failedMessage,
      }"
      class="mt-4 text-center"
    >
      {{ successMessage || failedMessage }}
    </p>
  </form>
</template>

<script setup>
import { ref, computed } from "vue";
import { createDeal } from "../api";
import FormInput from "./FormInput.vue";

const emit = defineEmits();

const dealName = ref("");
const dealStage = ref("");

const successMessage = ref("");
const failedMessage = ref("");

const isSubmitting = ref(false);

const handleClick = () => {
  emit("toggle-form");
};

const required = (value) => {
  return value ? true : "Це поле є обов'язковим.";
};

const updateValidation = (field, isValid) => {
  validationStatus.value[field] = isValid;
};

const validationStatus = ref({
  dealName: false,
  dealStage: false,
});

const isFormValid = computed(() =>
  Object.values(validationStatus.value).every((status) => status)
);

const submitDeal = async () => {
  if (!isFormValid.value) {
    successMessage.value = "";
    failedMessage.value = "";
    return;
  }

  isSubmitting.value = true;

  const data = {
    Deal_Name: dealName.value,
    Stage: dealStage.value,
  };

  try {
    const response = await createDeal(data);

    if (response.success === false) {
      failedMessage.value = Object.values(response.errors)[0][0];
    } else if (response.data[0]?.code === "SUCCESS") {
      successMessage.value = "Угода успішно створена!";

      dealName.value = "";
      dealStage.value = "";
    }
  } catch (error) {
    failedMessage.value = "Помилка при створенні угоди!";
    console.error(error);
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
@media (min-width: 640px) {
  .max-w-md {
    max-width: 900px;
  }
}
</style>
