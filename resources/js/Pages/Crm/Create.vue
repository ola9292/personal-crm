<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name:null,
    email: null,
    businessId: null,
    phone: null,
    country: null,
})
</script>

<template>
    <div class="container">
        <h1>Create New Customer</h1>
        <form @submit.prevent="form.post('/customers')">
             <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name" v-model="form.name">
                 <div v-if="form.errors.name">{{ form.errors.name }}</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Business ID</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Business ID" v-model="form.businessId">
                 <div v-if="form.errors.businessId">{{ form.errors.businessId }}</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" v-model="form.email">
                <div v-if="form.errors.email">{{ form.errors.email }}</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                <input type="phone" class="form-control" id="exampleFormControlInput1" placeholder="0783647858" v-model="form.phone">
                <div v-if="form.errors.phone">{{ form.errors.phone }}</div>
            </div>
             <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Country</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Country" v-model="form.country">
                <div v-if="form.errors.country">{{ form.errors.country }}</div>
            </div>
            <div class="mt-3">
                <button class="btn btn-success" type="submit">Save Customer</button>
            </div>
        </form>


    </div>

</template>