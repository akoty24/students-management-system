import { createApp } from 'vue';
import '@fortawesome/fontawesome-free/css/all.min.css';
import App from './components/App.vue';
import './components/CourseDetails/CourseDetails.css';
import './components/CourseManagement/CourseManagement.css';
import './components/StudentManagement/StudentManagement.css';
import router from './router';

createApp(App).use(router).mount('#app');


