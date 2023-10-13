<template>
    <div class="container">
        <h1>Create Desk</h1>
        <div class="form-control">
            <input type="text" @keyup="v$.name.$touch()" placeholder="Name Desk" v-model="name" class="form-control"
                   :class="{ 'is-invalid' : v$.name.$error }" >
            <div v-for="error of v$.$errors" :key="error.$uid">
                {{ error.$message }}
            </div>
        </div>
                <div class="alert alert-danger mt-3" role="alert" v-if="errors">
                    Ошибка загрузки данных! <br>
                    {{ errors[0] }}!
                </div>
        <a href="#" @click.prevent="addDesk" class="btn btn-outline-success mt-3">Add Desk</a>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {useVuelidate} from '@vuelidate/core'
import {required, minLength, maxLength, helpers} from '@vuelidate/validators'
import axios from "axios";

export default defineComponent({
    name: "CreateDesk",

    data() {
        return {
            name: null,
            errors: null,
        }
    },
    setup(){
      return {
          v$ : useVuelidate()
      }
    },

    validations(){
      return {
          name: {
              required: helpers.withMessage('Обязательное поле!', required),
              minLength: helpers.withMessage('Минимум 10 символов!', minLength(10)),
              maxLength: helpers.withMessage('Максимум 25 символов!', maxLength(25))
          }
      }
    },

    methods: {
        addDesk(){
            axios.post('/api/desks', {name: this.name})
                .then(res => {
                    this.$router.push({name: 'desk'})
                })
                .catch(err => {
                    console.log(err)
                    this.errors = []
                    this.errors.push(err.response.data.errors.name[0])
                })
        }
    }
})
</script>



