// <template>
//   <form @submit.prevent="submitForm" class="bg-white p-6 rounded shadow-md mt-4">
//     <h2 class="text-xl font-semibold mb-4">Створити угоду</h2>
//     <div class="mb-4">
//       <label class="block text-gray-700">Назва угоди</label>
//       <input v-model="dealName" type="text" class="mt-1 block w-full border rounded p-2" required />
//     </div>
//     <div class="mb-4">
//       <label class="block text-gray-700">Стадія</label>
//       <select v-model