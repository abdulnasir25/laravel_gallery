<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    albums: Object,
})

const deleteAlbum = async (url) => {
    if (confirm('Are you sure you want to delete this album?')) {
        await axios.delete(url);
        // refresh page
        location.reload();
    }
}
</script>

<template>
    <Head title="Album" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Album
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <!-- create btn -->
                    <div class="p-6 bg-white border-b border-slate-400">
                        <NavLink :href="route('albums.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Album</NavLink>
                    </div>

                    <div class="p-6 text-gray-900">
                        <table class="w-full border border-collapse border-slate-400 text-left text-sm text-gray-500 divide-y divide-slate-400">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">ID</th>
                                    <th class="border px-4 py-2">Title</th>
                                    <th class="border px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="album in albums" :key="album.id">
                                    <td class="border px-4 py-2">{{ album.id }}</td>
                                    <td class="border px-4 py-2">{{ album.title }}</td>
                                    <td class="border px-4 py-2">
                                        <NavLink :href="route('albums.edit', album.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</NavLink>
                                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" @click="deleteAlbum(route('albums.destroy', album.id))">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
