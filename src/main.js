import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import '@fullcalendar/core/main.css';
import '@fullcalendar/daygrid/main.css';
import '@fullcalendar/interaction/main.css';


import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
