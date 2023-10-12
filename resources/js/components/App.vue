<template>
    <div class="alert alert-info">
        <router-link class="btn btn-outline-primary m-4" :to="{ name: 'home' }">Home</router-link>
        <router-link class="btn btn-outline-primary m-4" :to="{ name: 'desk' }">Desks</router-link>
        <router-link class="btn btn-outline-primary m-4" :to="{ name: 'create.desk' }">Desk Create</router-link>
        <router-view></router-view>
    </div>
</template>


<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "App"
})
</script>

