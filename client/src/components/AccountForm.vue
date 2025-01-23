<template>
  <form
    @submit.prevent="submitForm"
    class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md m-4"
    :class="{
      'bg-opacity-50 backdrop-blur-md pointer-events-none': isSubmitting,
    }"
  >
    <h2 class="text-2xl font-semibold text-white mb-6 text-center">
      Створити акаунт
    </h2>

    <form-input
      label="Назва акаунта"
      :inputValue="accountName"
      :validationRules="[required, isName]"
      @update:inputValue="accountName = $event"
      @validate="updateValidation('accountName', $event)"
    />
    <form-input
      label="Телефон"
      :inputValue="phoneNumber"
      :validationRules="[required, isPhoneNumber]"
      @update:inputValue="phoneNumber = $event"
      @validate="updateValidation('phoneNumber', $event)"
    />

    <form-input
      label="Назва вебсайту"
      :inputValue="websiteName"
      :validationRules="[required, isURL]"
      @update:inputValue="websiteName = $event"
      @validate="updateValidation('websiteName', $event)"
    />

    <div class="flex justify-between flex-col sm:flex-row sm:items-center">
      <button
        type="submit"
        class="bg-black bg-opacity-50 backdrop-blur-md text-white px-4 py-2 rounded hover:bg-opacity-70 transition duration-200 mb-3 sm:mb-0"
      >
        Створити акаунт
      </button>

      <div
        @click="handleClick"
        class="bg-blue-600 text-center text-white px-4 py-2 rounded hover:bg-blue-500 transition duration-200 cursor-pointer"
      >
        Перейти до угоди
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
import { createAccount } from "../api";

import FormInput from "./FormInput.vue";

const emit = defineEmits(["toggle-form"]);

const accountName = ref("");
const phoneNumber = ref("");
const websiteName = ref("");

const successMessage = ref("");
const failedMessage = ref("");

const isSubmitting = ref(false);

const handleClick = () => {
  emit("toggle-form");
};

const validationStatus = ref({
  accountName: false,
  phoneNumber: false,
  websiteName: false,
});

const updateValidation = (field, isValid) => {
  validationStatus.value[field] = isValid;
};
const required = (value) => {
  return value ? true : "Це поле є обов'язковим.";
};
const isPhoneNumber = (value) => {
  const phonePattern = /^\+?[0-9\s\-]{10,15}$/;
  return phonePattern.test(value) ? true : "Невірний формат номеру телефону.";
};
const isName = (value) => {
  const namePattern = /^[a-zA-Zа-яА-ЯіІїЇєЄґҐ\s\-]+$/u;
  return namePattern.test(value)
    ? true
    : "Ім'я акаунту має містити тільки літери, пробіли та тире.";
};
const isURL = (value) => {
  const urlPattern = /^(https?:\/\/)?([\w.-]+)\.([a-z]{2,6})([\/\w .-]*)*\/?$/i;
  return urlPattern.test(value) ? true : "Невірний формат URL.";
};

const isFormValid = computed(() =>
  Object.values(validationStatus.value).every((status) => status)
);

const submitForm = async () => {
  if (!isFormValid.value) {
    successMessage.value = "";
    failedMessage.value = "";
    return;
  }

  isSubmitting.value = true;

  const data = {
    Account_Name: accountName.value,
    Phone: phoneNumber.value,
    Website: websiteName.value,
  };

  try {
    const response = await createAccount(data);

    if (response.success === false) {
      failedMessage.value = Object.values(response.errors)[0][0];
    } else if (response.data[0]?.code === "SUCCESS") {
      successMessage.value = "Акаунт успішно створено!";

      accountName.value = "";
      phoneNumber.value = "";
      websiteName.value = "";
    }
  } catch (error) {
    failedMessage.value = "Сталася помилка під час створення акаунта.";
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
