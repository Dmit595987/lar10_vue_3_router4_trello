<template>
    <div class="container">
        <h1>Create Desk</h1>
        <div class="form-control">
            <input type="text" placeholder="Name Desk" v-model="name" class="form-control">
        </div>
        <a href="#" class="btn btn-outline-success mt-3">Add Desk</a>
    </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CreateDesk",

    data() {
        return {
            name: null,
        }
    },

    methods: {
        addDesk(){

        }
    }
})
</script>



