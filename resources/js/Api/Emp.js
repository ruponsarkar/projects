import Api from './Api'

export default {
    showClass(selectedClass) {
        return Api().get(`/student/${selectedClass}`)
    },

    submitAttendance(attendance, today, selectedClass){
        return Api().post('/submitAttendance/', {attendance, today,selectedClass});
    },

    getStudent(selectedClass, selectedMonth){
        return Api().post('/getStudent/', {selectedClass, selectedMonth});
    },

    checkAttendance(selectedClass, roll, fromDate, toDate){
        return Api().post('checkAttendance/',{selectedClass, roll, fromDate, toDate});
    },

    


}