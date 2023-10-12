<template>
    <div class="container">
        <h1>Desks</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Last</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="desk in desks">
                <td>ID {{ desk.id }}</td>
                <td>
                    <router-link :to="{name: 'show.desk', params: {id: desk.id} }">{{ desk.name }}</router-link>
                </td>
                <td></td>
            </tr>

            </tbody>
        </table>
        <div class="alert alert-danger" role="alert" v-if="errored">
            Ошибка загрузки данных!!!
        </div>
        <div class="d-flex justify-content-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</template>


<script>
import {defineComponent} from 'vue'
import axios from "axios";

export default defineComponent({
    name: "Desk",

    data() {
      return {
          desks: null,
          errored: false,
          loading: true,
      }
    },

    mounted() {
        this.getDesks()
    },

    methods: {
        getDesks(){
            axios.get('/api/desks')
                .then(res => {
                    this.desks = res.data.data
                    this.loading = false
                }).catch(error => {
                console.log(error);
                this.errored = true
            })
        }
    },
})
</script>

