import './bootstrap';
import "bootstrap/dist/css/bootstrap.min.css"
import { createApp } from 'vue';
import router from "../router/index.js";
import App from './components/App.vue';




const app = createApp(App);
app.use(router);

app.mount('#app');
import "bootstrap/dist/js/bootstrap.js"
