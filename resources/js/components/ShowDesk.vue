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
                <tbody v-for="list_desk in list_desks" :key="list_desk.id">
                        {{ list_desk.id }}
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

                    <td>{{ list_desk.id }}</td>
                    <td>
                        <a href="#" @click.prevent="change_name_button(list_desk.id)" class="btn btn-outline-secondary">{{
                                button_name
                            }}</a>
                    </td>
                    <td><a href="#" @click.prevent="delete_list_desk(list_desk.id)" class="btn btn-outline-danger">Delete</a>
                    </td>
                    <td>
                        <div class="container text-center" v-for="card in list_desk.cards">
                            <div class="row">

                                <div class="col bg-white">
                                    <h5 class="card-title mb-3">{{ card.name }}</h5>
                                    <button @click.prevent="getCard(card.id)" type="button" class="btn btn-primary me-2"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Open CARD
                                    </button>
                                    <a href="#" @click.prevent="deleteCard(card.id)"
                                       class="btn btn-outline-warning mb-2 mt-2 me-2">Delete CARD</a>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                    Change: {{ current_cards.name }}</h1>


                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>

                                            </div>

                                            <div class="modal-body">
                                                <form>
                                                    <input type="text" v-model="current_cards.name"
                                                           v-if="show_form_edit_card_name"
                                                           class="mt-3 form-control mb-3">
                                                    <div class="alert alert-danger mt-3" role="alert" v-if="errors">
                                                        {{ errors[0] }}!
                                                    </div>
                                                    <input type="submit" class="btn btn-outline-primary"
                                                           v-if="show_form_edit_card_name" value="Save name card"
                                                           @click.prevent="edit_name_card(current_cards.id)">
                                                    <input type="submit" class="btn btn-outline-warning mb-3"
                                                           v-if="!show_form_edit_card_name" value="Edit name card"
                                                           @click.prevent="show_form_edit_card_name = true">

                                                </form>
                                                <div class="form-check form-switch form-check-reverse" v-for="task in current_cards.tasks">
                                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckReverse">

                                                    <form action="#" v-if="show_task_name === task.id">
                                                        <input @blur="edit_task_name(task.id, task.name)" type="text" v-model="task.name" class="form-control">
                                                    </form>
                                                    <label v-else class="form-check-label" for="flexSwitchCheckReverse">{{task.name}}</label>
                                                    <a href="#" v-if="show_task_name !== task.id" @click.prevent="show_task_name_true_or_false(task.id)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ballpen-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M17.828 2a3 3 0 0 1 1.977 .743l.145 .136l1.171 1.17a3 3 0 0 1 .136 4.1l-.136 .144l-1.706 1.707l2.292 2.293a1 1 0 0 1 .083 1.32l-.083 .094l-4 4a1 1 0 0 1 -1.497 -1.32l.083 -.094l3.292 -3.293l-1.586 -1.585l-7.464 7.464a3.828 3.828 0 0 1 -2.474 1.114l-.233 .008c-.674 0 -1.33 -.178 -1.905 -.508l-1.216 1.214a1 1 0 0 1 -1.497 -1.32l.083 -.094l1.214 -1.216a3.828 3.828 0 0 1 .454 -4.442l.16 -.17l10.586 -10.586a3 3 0 0 1 1.923 -.873l.198 -.006zm0 2a1 1 0 0 0 -.608 .206l-.099 .087l-1.707 1.707l2.586 2.585l1.707 -1.706a1 1 0 0 0 .284 -.576l.01 -.131a1 1 0 0 0 -.207 -.609l-.087 -.099l-1.171 -1.171a1 1 0 0 0 -.708 -.293z" stroke-width="0" fill="currentColor"></path>
                                                    </svg>
                                                    </a>

                                                    <a href="#" v-if="show_task_name !== task.id">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16zm-9.489 5.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z" stroke-width="0" fill="currentColor"></path>
                                                        <path d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z" stroke-width="0" fill="currentColor"></path>
                                                    </svg>
                                                    </a>
                                                </div>

                                                <form @submit.prevent="addTask(current_cards.id)">
                                                    <input type="text" v-model="task_name" @keyup="v$.task_name.$touch()" placeholder="input name task" class="form-control" :class="{ 'is-invalid' : v$.task_name.$error }">
                                                    <div>
                                                        <p v-for="error of v$.$errors" :key="error.$uid">
                                                            {{ error.$message }}
                                                        </p>
                                                    </div>
                                                    <input type="submit" value="Add Task" class="btn btn-outline-success mt-3">
                                                </form>
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Button modal ADD NEW CARD -->
                        <button type="button" class="btn btn-outline-success m-4" @click.prevent="list_desk_id=list_desk.id"
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Add New CARD
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                             tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Input New Card</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ this.list_desk_id }}</p>
                                        <p>{{ card_names[list_desk.id] }}</p>
                                        <form @submit.prevent="add_new_card(this.list_desk_id)">
                                            <input type="text" v-model="card_names[this.list_desk_id]"
                                                   class="mt-3 form-control mb-3"
                                                   placeholder="input card">
                                            <div class="alert alert-danger mt-3" role="alert" v-if="errors">
                                                {{ errors[0] }}!
                                            </div>
                                            <input type="submit" class="btn btn-outline-primary" value="Add CARD">

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>

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
            task_name: null,

            list_desk_id: null,
            show_task_name: null

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
                required: helpers.withMessage('Обязательное поле!', required),
                minLength: helpers.withMessage('Минимум 10 символов!', minLength(10)),
                maxLength: helpers.withMessage('Максимум 25 символов!', maxLength(25))
            },
            task_name: {
                required: helpers.withMessage('Обязательное поле!', required),
                minLength: helpers.withMessage('Минимум 10 символов!', minLength(10)),
                maxLength: helpers.withMessage('Максимум 70 символов!', maxLength(70))
            },


        }
    },

    mounted() {
        this.getDesk();
        this.getDeskLists();

    },

    methods: {

        show_task_name_true_or_false(task_id){
            this.show_task_name = task_id;
        },

        edit_task_name(task_id, task_name){
            this.show_task_name = false;
            console.log(task_name, task_id)
        },

        edit_name_card(id) {
            axios.patch(`/api/cards/${id}`, {name: this.current_cards.name})
                .then(res => {
                    this.getDeskLists();
                    this.show_form_edit_card_name = false;
                    this.errors = null
                }).catch(err => {
                this.errors = []
                this.errors.push(err.response.data.errors.name[0])
            })
        },

        getCard(cart_id) {
            this.errors = null
            axios.get(`/api/cards/${cart_id}`)
                .then(res => {
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

        deleteCard(id) {
            if (confirm('Вы действительно хотите удалить?')) {
                axios.delete(`/api/cards/${id}`)
                    .then(res => {
                        this.getDeskLists();
                    }).catch(err => {
                    console.log(err)
                })
            }
        },

        add_new_card(list_desk_id) {
            console.log(list_desk_id)
            console.log(this.card_names)
            axios.post('/api/cards', {name: this.card_names[list_desk_id], list_desk_id: list_desk_id})
                .then(res => {
                    this.getDeskLists()
                    this.card_names[list_desk_id] = ''
                    Object.keys(this.card_names).forEach(list_desk_id => delete this.card_names[list_desk_id]);
                    this.errors = null
                    console.log(this.card_names)
                    this.list_desk_id = null
                })
                .catch(err => {
                    console.log(err);
                    this.errors = []
                    this.errors.push(err.response.data.errors.name[0])
                    this.list_desk_id = null
                })


        },

        updateDesk() {
            this.v$.name.$touch()
            if (!this.v$.name.$error) {
                axios.patch('/api/desks/' + this.id, {name: this.name, _method: 'PUT'})
                    .then(res => {
                        this.errored = false
                        this.v$.name.$reset()
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
                    console.log(this.list_desks)
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
                        this.v$.name_list.$reset();

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
                        this.v$.name_list.$reset()
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
        },

        addTask(id){
            this.v$.task_name.$touch()
            if(!this.v$.task_name.$error){
                axios.post('/api/tasks', {name: this.task_name, card_id: id})
                    .then(res => {
                        this.getCard(id);
                        this.task_name = null;
                        this.v$.task_name.$reset();
                    }).catch(err => {
                    console.log(err);
                })
            }
        },

    },


})

</script>




