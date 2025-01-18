<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

const users = ref([]);
const errorMessage = ref('');
const selectedUsers = ref<number[]>([]);
const currentPage = ref(1);
const lastPage = ref(1);
const perPage = ref(5);
const nameFilter = ref('');
const emailFilter = ref('');
const activeFilter = ref('');

const fetchUsers = async (page = 1, per_page = 5, name = '', email = '', active = '') => {
    try {
        const response = await axios.get(`/users`, {
            params: {
                page,
                per_page,
                name,
                email,
                active
            }
        });
        users.value = response.data.data;
        currentPage.value = response.data.current_page;
        lastPage.value = response.data.last_page;
    } catch (error) {
        errorMessage.value = 'Error fetching users: ' + error.message;
        console.error('Error fetching users:', error);
    }
};

const toggleUserActive = async (user) => {
    try {
        const response = await axios.patch(`/users/${user.id}`, { active: !user.active });
        console.log('User updated:', response.data);
        user.active = !user.active;
    } catch (error) {
        errorMessage.value = 'Error updating user: ' + error.message;
        console.error('Error:', error);
    }
}

const deleteSelectedUsers = async () => {
    try {
        await axios.post('/users/delete-batch', { ids: selectedUsers.value });
        users.value = users.value.filter(user => !selectedUsers.value.includes(user.id));
        selectedUsers.value = [];
    } catch (error) {
        errorMessage.value = 'Error deleting users: ' + error.message;
        console.error('Error deleting users:', error);
    }
};

const goToPage = (page) => {
    fetchUsers(page, perPage.value, nameFilter.value, emailFilter.value, activeFilter.value);
};

const handlePerPageChange = (event) => {
    perPage.value = parseInt(event.target.value);
    fetchUsers(currentPage.value, perPage.value, nameFilter.value, emailFilter.value, activeFilter.value);
};

watch([nameFilter, emailFilter, activeFilter], () => {
    fetchUsers(currentPage.value, perPage.value, nameFilter.value, emailFilter.value, activeFilter.value);
});

onMounted(() => {
    fetchUsers();
});

</script>

<template>
    <AppLayout title="Clients">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Alert Component -->
                    <div v-if="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ errorMessage }}</span>
                        <span @click="errorMessage = ''" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.828l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/></svg>
                        </span>
                    </div>

                    <!-- Control Bar -->
                    <div class="mb-4 flex justify-end">
                        <Link 
                            href="clients/create" 
                            class="bg-blue-500 hover:bg-blue-700 text-white text-xs py-2 px-4 rounded ml-2">
                                Novo
                            </Link>
                        <button 
                            @click="deleteSelectedUsers" 
                            class="bg-red-500 hover:bg-red-700 text-white text-xs py-2 px-4 rounded"
                            :disabled="selectedUsers.length === 0">
                            Remover Selecionados
                        </button>
                    </div>

                    <!-- Filter Bar -->
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <label for="nameFilter" class="mr-2 text-xs">Nome:</label>
                            <input id="nameFilter" v-model="nameFilter" type="text" class="text-xs form-input" placeholder="Filtrar por nombre">
                        </div>
                        <div>
                            <label for="emailFilter" class="mr-2 text-xs">Email:</label>
                            <input id="emailFilter" v-model="emailFilter" type="text" class="text-xs form-input" placeholder="Filtrar por email">
                        </div>
                        <div>
                            <label for="activeFilter" class="mr-2 text-xs">Ativo:</label>
                            <select id="activeFilter" v-model="activeFilter" class="form-select text-xs">
                                <option value="">Todos</option>
                                <option value="1">Sím</option>
                                <option value="-1">Não</option>
                            </select>
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ativo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acts</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in users" :key="user.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" v-model="selectedUsers" :value="user.id" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button 
                                        @click="toggleUserActive(user)" 
                                        :class="user.active ? 'bg-green-500 hover:bg-green-700' : 'bg-red-500 hover:bg-red-700'" 
                                        class="text-white font-bold py-1 px-2 rounded text-xs"
                                    >
                                        {{ user.active ? 'sim' : 'não' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <Link 
                                        :href="`/clients/${user.id}/edit`" 
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs"
                                    >
                                        Edit
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    
                    <div class="mt-4">
                        <div>
                            <label for="perPage" class="mr-2 text-xs">Registros por página:</label>
                            <select id="perPage" @change="handlePerPageChange" class="form-select text-xs">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pagination Controls -->
                    <div class="mt-4 flex justify-between">
                        <button 
                            @click="goToPage(currentPage - 1)" 
                            :disabled="currentPage === 1" 
                            type="button"
                            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                ant
                            </span>
                        </button>

                        <button 
                            @click="goToPage(currentPage + 1)" 
                            :disabled="currentPage === lastPage" 
                            type="button"
                            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                seg
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
