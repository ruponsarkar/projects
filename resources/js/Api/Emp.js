import Api from './Api'

export default {
    showClass(selectedClass) {
        return Api().get(`/student/${selectedClass}`)
    },

    submitAttendance(attendance, today){
        return Api().post('/submitAttendance/', {attendance, today});
    },

    getStudent(selectedClass, selectedMonth){
        return Api().post('/getStudent/', {selectedClass, selectedMonth});
    },

    


}