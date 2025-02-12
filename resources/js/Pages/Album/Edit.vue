<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head, router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    album: Object,
});

const form = useForm({
    title: props.album.title
})

const update = () => {
    form.put(route('albums.update', props.album.id), {
        preserveScroll: true,
        onSuccess: () => router.push(route('albums.index'))
    })
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
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="update">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input v-model="form.title" type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="Album 1">
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>

                                <NavLink :href="route('albums.index')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 ml-2 rounded">Back</NavLink>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
