<script setup>
import { VueCal } from 'vue-cal'
import 'vue-cal/style'
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'



const props = defineProps({
  events: Array
})

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
    alert('hey')
}

const createEvent = ({event, resolve}) =>{
    console.log(event.start)
    let start_time = event.start
    let end_time = new Date(event.start.getTime() + 60 * 60 * 1000)
    form.start = start_time.toISOString()
    form.end = end_time.toISOString()
    sendAppointment()
}
</script>
<template>
    <vue-cal
    :events="events"
    @event-create="createEvent"
    editable-events
    :time-from="9 * 60"
    :time-to="17 * 60"
    :time-step="60"
    active-view="week"
    >
    </vue-cal>
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