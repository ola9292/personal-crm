<script setup>
import { VueCal } from 'vue-cal'
import 'vue-cal/style'
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'



const props = defineProps({
  events: Array
})
const modal = ref(false)

// Use Inertia's useForm for proper form handling
const form = useForm({
  start: '',
  end: '',
  title: '',
  details: ''
})

const events = props.events

const sendAppointment = () => {
    form.post('/calendar')
}

const openModal = (event) => {
    // checkEventClash(event.cursor.date)
    modal.value = true
    console.log(event.cursor.date)
    let clickedDate = event.cursor.date
    const startDate = new Date(clickedDate);
    startDate.setMinutes(0, 0, 0);
    console.log(formattedDateTime(startDate))

    const endDate = new Date(startDate);
    endDate.setHours(endDate.getHours() + 1);
    console.log(formattedDateTime(endDate))

    //fill form
    form.start = formattedDateTime(startDate)
    form.end = formattedDateTime(endDate)
    form.title = title
    form.details = details

}
const removeModal = () => {
    modal.value = false
}
const editAppointment = (event) => {
    console.log(event)
}
const checkEventClash = (start) => {
    events.value.forEach(event => {
        if(event.start == start){
            alert('there is a clash!')
        }else{
            alert('notin')
        }
    });
}
const formattedDateTime = (date) => {
     const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}
</script>
<template>
  <vue-cal
    :events="events"
    @cell-click="openModal"
    @event-click="editAppointment"
    :editable-events="false"
    :time-from="9 * 60"
    :time-to="17 * 60"
    :time-step="60"
    active-view="week"
  />

  <div v-if="modal" class="modal">
    <form @submit.prevent="sendAppointment">
        <span @click="removeModal">X</span>
      <input v-model="form.title" type="text" placeholder="Title" required />
      <textarea v-model="form.details" placeholder="Details"></textarea>
      <button type="submit">Save</button>
    </form>
  </div>
</template>
<style scoped>
.appointment-booking {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.booking-container {
  display: flex;
  gap: 20px;
}

.calendar {
  flex: 2;
}

.form-container {
  flex: 1;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input, textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

textarea {
  height: 100px;
  resize: vertical;
}

button {
  background: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background: #0056b3;
}
</style>