<template>
    <div class="container">
        <h1>Edit Desk</h1>
        <div class="d-flex justify-content-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="form-control" v-if="desk">
            <input type="text" @blur="updateDesk(desk.id)" v-model="desk.name" class="form-control">
        </div>
        <div class="alert alert-danger" role="alert" v-if="errored">
            Поле не может быть пустым!
        </div>

    </div>
</template>

<script>
import {defineComponent} from 'vue'
import axios from "axios";

export default defineComponent({
    name: "ShowDesk",

    props: [
        'id'
    ],

    data() {
        return {
            desk: null,
            loading: true,
            errored: false
        }
    },

    mounted() {
        this.getDesk();
    },

    methods: {
      getDesk(){
          console.log(this.id)
        axios.get('/api/desks/' + this.id)
            .then( res => {
                this.desk = res.data.data
                this.loading = false
            })
            .catch(err => {
                console.log(err);
            })
      },

        updateDesk(){
          axios.patch('/api/desks/' + this.id, {name: this.desk.name, _method: 'PUT'})
              .then(res => {
                  this.errored = false
              })
              .catch(err => {
                  this.errored = true
              })
        }
    }
})
</script>



