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
                    <th scope="col"></th>
                    <th scope="col">CARD</th>
                </tr>
                </thead>
                <tbody v-for="list_desk in list_desks">
                <tr>


                    <td v-if="desk_list_input_id === list_desk.id">
                        <form action="#">
                            <input type="text" @blur="update_list_desk(list_desk.id, list_desk.name)"
                                   v-model="list_desk.name" class="form-control" @keyup="v$.name_list.$touch()">
                        </form>
                        <div>
                            <div class="alert alert-danger mt-3" role="alert" v-if="errors">
                                Ошибка! <br>
                                {{ errors[0] }}!
                            </div>
                        </div>
                    </td>
                    <td v-else>{{ list_desk.name }}</td>

                    <td>{{ list_desk.desk_id }}</td>
                    <td>
                        <a href="#" @click.prevent="change_name_button(list_desk.id)" class="btn btn-outline-secondary">{{button_name}}</a>
                    </td>
                    <td><a href="#" @click.prevent="delete_list_desk(list_desk.id)" class="btn btn-outline-danger">Delete</a>
                    </td>
                    <td>
                    <div class="container text-center" v-for="card in list_desk.cards">
                        <div class="row" >

                            <div class="col bg-white">
                                <h5 class="card-title mb-3">{{ card.name }}</h5>
                                <button  @click.prevent="getCard(card.id)" type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Open CARD
                                </button>
                                <a href="#" @click.prevent="deleteCard(card.id)" class="btn btn-outline-warning mb-2 mt-2">Delete CARD</a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ current_cards.name }}</h1>


                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                        </div>

                                        <div class="modal-body">
                                            <form >
                                                <input type="text" v-model="current_cards.name" v-if="show_form_edit_card_name" class="mt-3 form-control mb-3">
                                                    <p>{{this.show_form_edit_card_name}}</p>
                                                <div class="alert alert-danger mt-3" role="alert" v-if="errors">
                                                    {{ errors[0] }}!
                                                </div>
                                                <input type="submit" class="btn btn-outline-primary" :value="value_button_modal" @click.prevent="edit_name_card(current_cards.id)">

                                            </form>
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                        <form @submit.prevent="add_new_card(list_desk.id)">
                            <input type="text" v-model="card_names[list_desk.id]" class="mt-3 form-control mb-3"  placeholder="input card">
                            <div class="alert alert-danger mt-3" role="alert" v-if="errors">
                                {{ errors[0] }}!
                            </div>
                            <input type="submit" class="btn btn-outline-primary" value="Add CARD">

                        </form>

                    </td>
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
import button from "bootstrap/js/src/button.js";


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
            desk_list_input_id: null,
            button_name: "Edit",
            errors: null,
            card_names: [],
            current_cards: [],
            value_button_modal: 'Edit name CARD',
            show_form_edit_card_name: false,

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
            },

        }
    },

    mounted() {
        this.getDesk();
        this.getDeskLists();

    },

    methods: {

        edit_name_card(id){
            this.show_form_edit_card_name = true;
            if(this.show_form_edit_card_name){
                this.value_button_modal = 'Save name Card'
                axios.patch(`/api/cards/${id}`, {name: this.current_cards.name})
                    .then(res => {
                        this.getDeskLists();

                    }).catch(err => {
                    console.log(err);
                })
            }else{
                this.value_button_modal = 'Edit name CARD'
            }

        },

        getCard(cart_id){
          axios.get(`/api/cards/${cart_id}`)
              .then( res => {
                  this.current_cards = res.data.data
                  console.log(this.current_cards)
              })
              .catch(err => {
                  console.log(err);
              })
        },

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

        deleteCard(id){
            axios.delete(`/api/cards/${id}`)
                .then(res => {
                    this.getDeskLists();
                }).catch(err => {
                    console.log(err)
            })
        },

        add_new_card(list_desk_id){
            console.log(this.card_names)
            axios.post('/api/cards', {name: this.card_names[list_desk_id], list_desk_id: list_desk_id })
                .then(res => {
                    this.getDeskLists()
                    this.card_names[list_desk_id] = ''
                })
                .catch(err =>{
                    console.log(err);
                    this.errors = []
                    this.errors.push(err.response.data.errors.name[0])
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

        delete_list_desk(id) {
            axios.delete(`/api/list_desks/${id}`)
                .then(res => {
                    this.getDeskLists();
                }).catch(err => {
                console.log(err);
            })
        },

        update_list_desk(id, name) {
            this.v$.name_list.$touch()
            if (!this.v$.name_list.$error) {
                console.log(name)
                axios.patch(`/api/list_desks/${id}`, {name: name})
                    .then(res => {

                        this.change_name_button(null)
                        this.getDeskLists();
                    }).catch(err => {
                    console.log(err);
                    this.errors = []
                    this.errors.push(err.response.data.errors.name[0])
                })
            }
        },

        change_name_button(id) {
            this.desk_list_input_id = id;
            if (this.desk_list_input_id) {
                this.button_name = 'Save';
            } else {
                this.button_name = 'Edit';
            }
        }

    },


})

</script>




