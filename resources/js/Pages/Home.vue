<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Home
            </h2>
        </template>

        <div class="py-12">
            <div class="w-full">
                <img :src="publicImagePath"/>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <p v-if="!home_page_html">You have no content, please go the the 'Edit' link to add</p>
                    <show-home :page="home_page_html"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import ShowHome from './Home/Show'

    export default {
        components: {
            AppLayout,
            ShowHome,
        },

        data(){
            return {
                publicImagePath: `/storage/${this.image_path}`
            }

        },

        props: {
            home_page_html: String,
            image_path: String
        },

        mounted: () => console.log(`you are in home page`)



    }
</script>
