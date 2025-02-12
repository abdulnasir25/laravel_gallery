<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head, router, useForm } from '@inertiajs/vue3';

defineProps({
    errors: Object
})

const form = useForm({
    title: null
})

const store = () => {
    form.post(route('albums.store'), {
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
                        <form @submit.prevent="store">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input v-model="form.title" type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />

                                <p class="mt-2 text-sm text-red-600" v-if="errors.title" v-text="errors.title"></p>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Create
                                </button>

                                <NavLink :href="route('albums.index')" class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white font-bold py-2 px-4 ml-2 rounded">Back</NavLink>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
