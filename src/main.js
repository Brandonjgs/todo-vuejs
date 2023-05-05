import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { DatePicker } from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';

const app = createApp(App)

app.use(DatePicker);
app.use(router)

app.mount('#app')
