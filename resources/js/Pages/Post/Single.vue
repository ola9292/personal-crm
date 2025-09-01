<script setup>
import { ref } from 'vue'
    import Nav from '../../Shared/Nav.vue';
    import { Link, useForm } from '@inertiajs/vue3'

    const props = defineProps({ post: Object})
const showModal = ref(false)
const form = useForm({
    id:null,
    name:null
})
const openModal = (category) => {
    showModal.value = true
        form.title = null
    form.content = null
    form.img_url = null
    form.category_id = null
    form.forceFormData = true
}
const closeModal = () => {
    showModal.value = false
}
   </script>
<template>
    <Nav />
    <h1>Show</h1>
    <div>
        <h2>{{ post.title }}</h2>
        <img v-if="post.image_url" :src="post.image_url">
        <div class="cta">
            <a @click="openModal(post)">Edit</a>
            <a href="">Delete</a>
        </div>
    </div>
     <!-- modal -->
    <div v-if="showModal">
        <div class="modal">
             <div class="modal-content">
                 <form @submit.prevent="form.post('/posts/create')">
                     <span class="close" @click="closeModal">&times;</span>
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
            </div>
        </div>
    </div>
</template>