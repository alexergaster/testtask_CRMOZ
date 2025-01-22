<template>
  <form
    @submit.prevent="submitForm"
    class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md m-4"
  >
    <h2 class="text-2xl font-semibold text-white mb-6 text-center">
      Створити акаунт
    </h2>

    <div class="mb-4">
      <label class="block text-gray-300">Ім'я акаунту</label>
      <input
        v-model="accountName"
        type="text"
        class="mt-1 block w-full border border-gray-600 rounded p-2 bg-gray-700 text-white"
        :class="{ 'border-red-500': errors.accountName }"
      />
      <p v-if="errors.accountName" class="text-red-500 text-sm">
        {{ errors.accountName }}
      </p>
    </div>

    <div class="mb-4">
      <label class="block text-gray-300">Номер телефону</label>
      <input
        v-model="phoneNumber"
        type="tel"
        class="mt-1 block w-full border border-gray-600 rounded p-2 bg-gray-700 text-white"
        :class="{ 'border-red-500': errors.phoneNumber }"
      />
      <p v-if="errors.phoneNumber" class="text-red-500 text-sm">
        {{ errors.phoneNumber }}
      </p>
    </div>

    <div class="mb-4">
      <label class="block text-gray-300">Назва вебсайту</label>
      <input
        v-model="websiteName"
        type="text"
        class="mt-1 block w-full border border-gray-600 rounded p-2 bg-gray-700 text-white"
        :class="{ 'border-red-500': errors.websiteName }"
      />
      <p v-if="errors.websiteName" class="text-red-500 text-sm">
        {{ errors.websiteName }}
      </p>
    </div>

    <button
      type="submit"
      class="bg-black bg-opacity-50 backdrop-blur-md text-white px-4 py-2 rounded hover:bg-opacity-70 transition duration-200"
    >
      Створити акаунт
    </button>

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

<script>
import { ref } from "vue";
import { createAccount } from "../api";

export default {
  setup(props, { emit }) {
    const accountName = ref("");
    const phoneNumber = ref("");
    const websiteName = ref("");
    const errors = ref({});
    const successMessage = ref("");
    const failedMessage = ref("");

    const validateForm = () => {
      errors.value = {};
      let isValid = true;

      if (!accountName.value) {
        errors.value.accountName = "Ім'я акаунту є обов'язковим.";
        isValid = false;
      }
      const nameRegex = /^[a-zA-Zа-яА-ЯіІїЇєЄґҐ\s\-]+$/u;
      if (!accountName.value || !nameRegex.test(accountName.value)) {
        errors.value.accountName =
          "Ім'я акаунту має містити тільки літери, пробіли та тире.";
        isValid = false;
      }

      const phoneRegex = /^\+?[0-9\s\-]{10,15}$/;
      if (!phoneNumber.value || !phoneRegex.test(phoneNumber.value)) {
        errors.value.phoneNumber =
          "Номер телефону має містити від 10 до 15 цифр.";
        isValid = false;
      }

      if (!websiteName.value) {
        errors.value.websiteName = "Назва вебсайту є обов'язковою.";
        isValid = false;
      }

      return isValid;
    };

    const submitForm = async () => {
      if (validateForm()) {
        const data = {
          Account_Name: accountName.value,
          Phone: phoneNumber.value,
          Website: websiteName.value,
        };

        const response = await createAccount(data);

        if (response.data[0].code === "SUCCESS") {
          successMessage.value = "Акаунт успішно створено!";
        } else if (!response.success) {
          failedMessage.value = Object.values(response.errors)[0][0];
        }
        emit("account-created");

        accountName.value = "";
        phoneNumber.value = "";
        websiteName.value = "";
      } else {
        successMessage.value = "";
        failedMessage.value = "";
      }
    };

    return {
      accountName,
      phoneNumber,
      websiteName,
      errors,
      successMessage,
      failedMessage,
      submitForm,
    };
  },
};
</script>

<style scoped>
@media (min-width: 640px) {
  .max-w-md {
    max-width: 900px;
  }
}
</style>
