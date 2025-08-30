import './bootstrap';

import { createApp } from 'vue';
import TaskBoard from './components/TaskBoard.vue';

const app = createApp({});
app.component('task-board', TaskBoard);
app.mount('#app');