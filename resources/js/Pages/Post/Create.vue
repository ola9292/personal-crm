<script setup>
import Nav from '../../Shared/Nav.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ categories: Array })

const form = useForm({
  title: null,
  content: null,
  img_url: null,
  category_id: null,
  forceFormData: true,
})
</script>

<template>
    <Nav />
    <h1>Create Post</h1>

    <form @submit.prevent="form.post('/posts/create')">

        <input type="text" v-model="form.title">
        <div v-if="form.errors.title">{{ form.errors.title }}</div> <br>

        <textarea name="" id="" cols="30" rows="10" v-model="form.content"></textarea>
        <div v-if="form.errors.content">{{ form.errors.content }}</div><br>

        <select v-model="form.category_id">
            <option :value="null" disabled>choose option</option>
            <option :value="category.id" v-for="category in categories" :key="category.id">{{ category.name }}</option>
        </select>

        <input type="file" @input="form.img_url = $event.target.files[0]" />
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
        <!-- <input type="checkbox" v-model="form.remember"> Remember Me -->

        <button type="submit" :disabled="form.processing">save</button>
  </form>
</template>