require('./bootstrap')
require('select2')

import { createApp } from 'vue'
import Welcome from './components/Welcome'

const app = createApp({})

app.component('welcome', Welcome)

app.mount('#app')