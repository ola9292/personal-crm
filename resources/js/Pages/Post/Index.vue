<script setup>
import Nav from '../../Shared/Nav.vue';
defineProps({ posts: Array })
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <Nav />
    <h1>All Posts</h1>

    <ul>
        <li v-for="post in posts" :key="post.id">
            <Link :href="`/posts/${post.id}`">{{ post.title }}</Link>
        </li>
    </ul>
</template>