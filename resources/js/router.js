import Vue from 'vue';
import VueRouter from 'vue-router';
import StudentAttendance from './components/student/StudentsAttendance';
import RegisterBook from './components/student/RegisterBook';
import checkAttendance from './components/student/checkAttendance';
import addStudent from './components/student/addStudent';



import test from './components/Partial/test';


Vue.use(VueRouter);

const routes = [
    { path: '/', component: StudentAttendance },
    { path: '/home', component: StudentAttendance },
    { path: '/RegisterBook', component: RegisterBook },
    { path: '/test', component: test },
    { path: '/checkAttendance', component: checkAttendance },
    { path: '/addStudent', component: addStudent},
];

export default new VueRouter({
    routes,

});