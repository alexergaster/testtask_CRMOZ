<template>
  <div
    class="flex flex-col items-center justify-center min-h-screen bg-gray-900"
  >
    <div class="form-container">
      <transition name="slide-fade" mode="out-in">
        <component
          :is="showAccountForm ? AccountForm : DealForm"
          key="form"
          @toggle-form="toggleForm"
        />
      </transition>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import AccountForm from "./components/AccountForm.vue";
import DealForm from "./components/DealForm.vue";

const showAccountForm = ref(true);

const toggleForm = () => {
  showAccountForm.value = !showAccountForm.value;
};
</script>

<style>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: opacity 0.5s ease, transform 0.5s ease;
}

.slide-fade-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

.form-container {
  position: relative;
  width: 100%;
  max-width: 900px;
}
</style>
