<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const fileInput = ref(null);

const props = defineProps({
    album: Object,
    photos: Object,
    errors: Object
});

const form = useForm({
    photo: null,
    previewUrl: null,
})

const handleFileChange = (event) => {
    const file = event.target.files[0];

    if (file) {
        // create a preview URL
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = (e) => {
            form.previewUrl = reader.result;
        }
    }
};

const submit = () => {
    form.post(route('albums.photos.store', props.album.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.previewUrl = null;

            // reset the file input
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
        onError: (errors) => {
            form.errors = errors;
        }
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
                        <form @submit.prevent="submit">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Album Image</label>
                                <input
                                    ref="fileInput"
                                    type="file"
                                    @input="form.photo = $event.target.files[0]"
                                    @change="handleFileChange"
                                    accept="image/*"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                />
                                <p v-if="errors.photo" class="mt-2 text-sm text-red-600" id="email-error">{{ errors.photo }}</p>

                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>

                                <div v-if="form.previewUrl">
                                    <img :src="form.previewUrl" class="mt-2 w-32 h-32 object-cover" />
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload</button>

                                <NavLink :href="route('albums.index')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 ml-2 rounded">Back</NavLink>
                            </div>
                        </form>
                    </div>
                    <!-- list of photos -->
                    <div v-if="props.photos.length" class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            <div v-for="photo in props.photos" :key="photo.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <img :src="photo.original_url" class="w-full h-32 object-cover" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
