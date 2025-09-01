<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  name: null,
})
</script>

<template>
    <form @submit.prevent="form.post('/categories/create')">
    <!-- email -->
     <label for="">Category Name</label>
    <input type="text" v-model="form.name">
    <div v-if="form.errors.name">{{ form.errors.name }}</div>
    <button type="submit" :disabled="form.processing">Save Category</button>
  </form>
</template>