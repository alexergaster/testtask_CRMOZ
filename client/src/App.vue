<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-900">
    <AccountForm @account-created="handleAccountCreated" />
    <!-- <DealForm v-if="accountCreated" /> -->
  </div>
</template>

<script>
import AccountForm from "./components/AccountForm.vue";
// import DealForm from "./components/DealForm.vue";

export default {
  components: {
    AccountForm,
    // DealForm,
  },
  data() {
    return {
      accountCreated: false,
    };
  },
  methods: {
    handleAccountCreated() {
      this.accountCreated = true;
    },
  },
};
</script>

<style>
::selection {
  background-color: #111;
  color: white;
}
</style>
