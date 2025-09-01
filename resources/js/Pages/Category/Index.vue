<script setup>
import Nav from '../../Shared/Nav.vue';
defineProps({ categories: Array })
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3'

const showModal = ref(false)

const form = useForm({
    id:null,
    name:null
})

const openModal = (category) => {
    showModal.value = true
    form.name = category.name
    form.id = category.id
}
const closeModal = () => {
    showModal.value = false
}
</script>

<template>
    <Nav />
    <h1>All Categories</h1>
   <table>

        <tr>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <tr v-for="cat in categories" :key="cat.id">
            <td>{{ cat.name }}</td>
            <td>
                <div class="cta">
                    <a @click="openModal(cat)">Edit</a>
                    <a href="">Delete</a>
                </div>

            </td>

        </tr>
   </table>

   <!-- modal -->
    <div v-if="showModal">
        <div class="modal">
             <div class="modal-content">
                <form @submit.prevent="form.put(`/category/${form.id}/edit`,{onSuccess: () => showModal = false})">
                     <span class="close" @click="closeModal">&times;</span>
                    <div class="modal-details">
                        <label for="">Category Name</label>
                        <input type="text" v-model="form.name">
                        <div v-if="form.errors.name">{{ form.errors.name }}</div>
                        <button type="submit" :disabled="form.processing">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

.modal { /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 30%; /* Could be more or less, depending on screen size */
}
.modal-details{
    display: flex;
    flex-direction: column;
    gap:10px
}
/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.cta{
    display: flex;
    gap:10px;
}
</style>