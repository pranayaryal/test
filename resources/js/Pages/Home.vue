<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Home
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl">
                <img :src="image_path"/>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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

        props: {
            home_page_html: String,
            image_path: String
        },

        mounted: () => console.log(`you are in home page`)



    }
</script>
