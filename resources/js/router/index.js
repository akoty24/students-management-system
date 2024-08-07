import { createRouter, createWebHistory } from 'vue-router';
import StudentManagement from '../components/StudentManagement/StudentManagement.vue';
import CourseManagement from '../components/CourseManagement/CourseManagement.vue';
import Home from '../components/Home.vue';
import CourseDetails from '../components/CourseDetails/CourseDetails.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/students', component: StudentManagement },
  { path: '/courses', component: CourseManagement },
  {
    path: '/course/:id',
    name: 'CourseDetails',
    component: CourseDetails,
    props: true
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
