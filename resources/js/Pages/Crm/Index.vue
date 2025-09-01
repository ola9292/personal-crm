<script setup>
import { ref, watch } from 'vue'
import { Link, useForm, router } from '@inertiajs/vue3'

const props = defineProps({
    customers: Array
})

const currentCustomer = ref(0)

const isOpen = ref(false)

const toggleIsOpen = () => {
    isOpen.value = !isOpen.value
}

const selectCustomer = (index) => {
    currentCustomer.value = index
}

const editCustomer = (id) => {
   isOpen.value = true
    form.name =props.customers[currentCustomer.value].name;
    form.email = props.customers[currentCustomer.value].email;
    form.businessId = props.customers[currentCustomer.value].businessId;
    form.phone = props.customers[currentCustomer.value].phone;
    form.country = props.customers[currentCustomer.value].country;
}

const deleteCustomer = (customerId) => {

      if (confirm('Are you sure you want to delete this customer?')) {
        router.delete(`/customers/delete/${customerId}`, {
          onSuccess: () => {
            console.log('Customer deleted successfully')

          },
          onError: (errors) => {
            console.error('Error deleting customer:', errors)
          },

        })
      }
        router.visit('/customers', {
            only: ['customers'],
            })
    }

const form = useForm({
    name: props.customers[currentCustomer.value]?.name ?? '',
    email: props.customers[currentCustomer.value]?.email ?? '',
    businessId: props.customers[currentCustomer.value]?.businessId ?? '',
    phone: props.customers[currentCustomer.value]?.phone ?? '',
    country: props.customers[currentCustomer.value]?.country ?? '',
})

const emailForm = useForm({
    email: props.customers[currentCustomer.value]?.email ?? '',
    message:''
})

const switchOpen = () => {
    console.log('lol!')
    isOpen.value = false
}

watch(currentCustomer, (newIndex) => {
      if (props.customers[newIndex]) {
        emailForm.email = props.customers[newIndex].email || ''
      }
    })
</script>

<template>
    <div class="container-whole" v-if="customers.length > 0">

        <div class="sidebar">
            <div class="mb-3">
                <Link href="/customer/create" class="btn btn-primary">New Customer</Link>
            </div>

            <div @click="selectCustomer(index)" class="customer" :class="{ active: currentCustomer == index }" v-for="(customer, index) in customers" :key="customer.id">
                {{ customer.name.toUpperCase() }}
                </div>
        </div>

        <div class="main">

            <div class="detail">
                <h1>{{ customers[currentCustomer].name.toUpperCase() }}</h1>
                <div>
                    <p>Business Id</p>
                    <h3>{{ customers[currentCustomer].businessId }}</h3>
                </div>
                <div>
                    <p>Email</p>
                    <h3>{{ customers[currentCustomer].email }}</h3>
                </div>
                <div>
                    <p>Contact Number</p>
                    <h3>{{ customers[currentCustomer].phone }}</h3>
                </div>
                <div>
                    <p>Correspondence</p>
                    <h3>Important client. Likes prompt follow-ups.</h3>
                </div>

                <div>
                     <form @submit.prevent="emailForm.post('/send-email')">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name" v-model="emailForm.email">
                                <div v-if="form.errors.email">{{ form.errors.email }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Message</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Message" v-model="emailForm.message">
                                <div v-if="form.errors.message">{{ form.errors.message }}</div>
                            </div>
                            <button type="submit">send</button>
                        </form>
                </div>
            </div>

            <div>
               <button @click="editCustomer(customers[currentCustomer].id)" class="btn btn-outline-primary me-2">Edit</button>

                <!-- <Link class="btn btn-outline-danger" :href="'/customers/delete/'+customers[currentCustomer].id" method="delete">Delete</Link> -->

                 <button
                        @click="deleteCustomer(customers[currentCustomer].id)"
                        class="btn btn-outline-danger"
                        >
                        Delete
                        </button>
            </div>
        </div>

    </div>
    <div v-else>

            <div class="alert alert-primary mb-3">
                No customers yet, add one. <Link href="/customer/create" >New Customer</Link>
            </div>
    </div>
   <div class="dialog" v-if="isOpen">
            <span @click="toggleIsOpen">X</span>
           <form @submit.prevent="form.post('/customers/edit/'+customers[currentCustomer].id, {
                preserveScroll: true,
                onSuccess: () => {switchOpen()},
                })">
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
                <button class="btn btn-success" type="submit">Update Customer</button>
            </div>
            </form>
        </div>
</template>

<style scoped>
 body {
      margin: 0;
      background: green;
      color: #333;
      border:1px solid red;
    }

    .dialog{
        position: absolute;
        top:0;
        left: 0;
         background-color: rgb(0,0,0); /* Fallback color */
         background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        width: 100%;
        height: 100svh;
        display: flex;
        justify-content: center;
        align-items: center;

    }
    .dialog > form{
        width: 30%;
        padding: 20px;
        background: lightgray;
    }
    .dialog > span{
        position: absolute;
        top:0;
        right: 10px;
        cursor: pointer;
    }
 .container-whole {
     font-family: sans-serif;
      display: flex;
      height: 100vh;
      width: 100%;
      border: 1px solid red;
    }

    .sidebar {
      width: 20%;
      background: #fff;
      border-right: 1px solid #ddd;
      overflow-y: auto;
      padding: 1rem;
    }

    .sidebar h2 {
      font-size: 1.2rem;
      margin-bottom: 1rem;
    }

    .customer {
      padding: 0.75rem 1rem;
      border-radius: 8px;
      cursor: pointer;
      margin-bottom: 0.5rem;
      transition: background 0.2s ease;
    }

    .customer:hover {
      background: #f0f0f0;
    }

    .customer.active {
      background: #e0e7ff;
    }
    .main {
      width: 80%;
      padding: 2rem;
      overflow-y: auto;
      display: flex;
      justify-content: space-between;
    }

    .main h2 {
      margin-top: 0;
      font-size: 1.5rem;
    }

    .detail > div > p{
        margin-bottom: 0;
        padding-bottom: 0;
        color:grey
    }
    .detail {
      /* margin-top: 1rem;
      line-height: 1.5; */
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
</style>