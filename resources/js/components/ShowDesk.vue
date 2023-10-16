<template>
    <div class="container">
        <h1>Edit Desk</h1>
        <div class="d-flex justify-content-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="form-control">
            <input type="text" @blur="updateDesk" @keyup="v$.name.$touch()" v-model="name" class="form-control"
                   :class="{ 'is-invalid' : v$.name.$error }">
            <div>
                <!--                <span v-if="v$.name.$error">МИН  {{ v$.$errors }} </span><br>-->
                <!--                <span v-if="!v$.name.$silentErrors[0].$validator.required">Поле обязательное </span>-->
                <p v-for="error of v$.$errors" :key="error.$uid">
                    {{ error.$message }}
                </p>
            </div>

            <div class="mt-3">
                <a @click.prevent="deleteDesk(id)" href="#" class="btn btn-outline-warning">Delete Desk</a>
            </div>


            <table class="table table-primary mt-3">
                <thead>
                <tr>
                    <th scope="col">Name List</th>
                    <th scope="col">ID Desk</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody v-for="list_desk in list_desks">
                <tr>
                    <td>{{ list_desk.name }}</td>
                    <td>{{ list_desk.desk_id }}</td>
                    <td><a href="#" @click.prevent="delete_list_desk(list_desk.id)" class="btn btn-outline-danger">Delete List</a></td>
                </tr>
                </tbody>
            </table>
        </div>
        <h1>ADD LIST DESK</h1>
        <div class="form-control">
            <input type="text" @keyup="v$.name_list.$touch()" v-model="name_list" placeholder="add List"
                   class="form-control"
                   :class="{ 'is-invalid' : v$.name_list.$error }">
            <div>
                <p v-for="error of v$.$errors" :key="error.$uid">
                    {{ error.$message }}
                </p>
            </div>

            <a href="#" @click.prevent="add_name_list" class="btn btn-outline-success mt-3">Add List</a>

        </div>


    </div>
</template>

<script>
import {defineComponent} from 'vue'
import axios from "axios";
import {useVuelidate} from '@vuelidate/core'
import {required, minLength, maxLength, helpers} from '@vuelidate/validators'


export default defineComponent({
    name: "ShowDesk",

    props: [
        'id'
    ],

    data() {
        return {

            name: null,
            loading: true,
            errored: false,
            list_desks: null,
            name_list: null,

        }
    },

    setup() {
        return {
            v$: useVuelidate()
        }
    },

    validations() {
        return {
            name: {
                required: helpers.withMessage('Обязательное поле!', required),
                minLength: helpers.withMessage('Минимум 10 символов!', minLength(10)),
                maxLength: helpers.withMessage('Максимум 25 символов!', maxLength(25))
            },
            name_list: {
                // required: helpers.withMessage('Обязательное поле!', required),
                minLength: helpers.withMessage('Минимум 10 символов!', minLength(10)),
                maxLength: helpers.withMessage('Максимум 25 символов!', maxLength(25))
            }
        }
    },

    mounted() {
        this.getDesk();
        this.getDeskLists();
    },

    methods: {
        getDesk() {

            axios.get('/api/desks/' + this.id)
                .then(res => {
                    this.name = res.data.data.name
                    // console.log(res.data);
                    this.loading = false
                })
                .catch(err => {
                    console.log(err);
                })
        },

        updateDesk() {
            this.v$.name.$touch()
            if (!this.v$.name.$error) {
                axios.patch('/api/desks/' + this.id, {name: this.name, _method: 'PUT'})
                    .then(res => {
                        this.errored = false
                    })
                    .catch(err => {
                        this.errored = true
                    })
            }
        },

        deleteDesk(id) {
            if (confirm('Вы действительно хотите удалить?')) {
                axios.delete(`/api/desks/${id}`)
                    .then(res => {
                        this.$router.push({name: 'desk'})
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },

        getDeskLists() {
            axios.get(`/api/list_desks`, {params: {desk_id: this.id}})
                .then(res => {
                    this.list_desks = res.data.data
                })
                .catch(err => {
                    console.log(err);
                })
        },

        add_name_list() {
            this.v$.name_list.$touch()
            if (!this.v$.name_list.$error) {
                axios.post('/api/list_desks', {name: this.name_list, desk_id: this.id})
                    .then(res => {
                        this.getDeskLists();
                        this.name_list = null;

                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        },

        delete_list_desk(id){
            axios.delete(`/api/list_desks/${id}`)
                .then(res => {
                    this.getDeskLists();
                }).catch( err => {
                console.log(err);
            })
        },

    },


})

</script>




