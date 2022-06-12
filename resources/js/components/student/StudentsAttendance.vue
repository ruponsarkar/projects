<template>
  <div data-app>
    <SideTopNav />

    <div class="content-wrapper">
      <section class="content p-0">
        <div class="container-fluid p-0 m-0">
          <v-app>
          <div class="row">
              <div class="col-md-6 col-12 offset-md-3">
                <form class="form-inline">
                  <div class="form-group col-6 mx-sm-3 mb-2">
                    <v-select
                      :items="classes"
                      label="Select Class"
                      v-model="selectedClass"
                      prepend-icon="mdi-account"
                    ></v-select>
                  </div>

                  <v-btn
                    @click="showClass"
                    class="btn btn-success mr-4"
                    :loading="loading"
                    :disabled="loading"
                  >
                    Show
                  </v-btn>
                </form>
              </div>
            </div>

          
            <div v-if="hide">
              <v-divider></v-divider>
              <v-card class="mx-auto mt-3" max-width="344">
                <v-card-title>
                  You have selected 
                  class {{ selectedClass }}
                </v-card-title>

                <v-card-subtitle>
                  Total students {{ countStudents }}
                </v-card-subtitle>
              </v-card>

              <div class="row">
                <div class="col-md-12">
                  <div>
                    <v-card-title>
                      <v-spacer />
                      <div class="text-center">
                        <h3 class="headline pink--text text--accent-2">
                          Attendance list
                        </h3>

                        <div>
                          <span
                            style="
                              background-color: red;
                              height: 5px;
                              weight: 10px;
                            "
                          ></span>
                          Some description about the headline
                        </div>
                      </div>
                      <v-spacer />
                    </v-card-title>

                    <div class="row p-2">
                      <v-col v-for="student in allStudents" :key="student.id" class="col-md-3 col-12">
                        <button
                          type="button"
                          value="kundan"
                          class="btn btn-danger text-white btn-sm btn-block shadow"
                          @click="attendance(student.id)"
                          v-bind:id="'attendancBtn' + student.id"
                          block>
                          ({{ student.rollno }}) &nbsp;{{ student.name }}
                        </button>
                      </v-col>
                    </div>
                    <br>
                    <button
                      type="button"
                      class="btn btn-info btn-sm btn-block"
                      @click="submitAttendance"
                      block>
                      Submit
                    </button>
                  </div>
                </div>
              </div>

          <v-divider></v-divider>
              <div class="mt-6">
                <v-col> Last Day Absences: </v-col>
                <v-col>
                  <button
                      type="button"
                      class="btn btn-warning"
                      @click="lastDayAbsenca"
                    >
                      Last Day Absences
                    </button>
                    <button
                      type="button"
                      class="btn btn-warning"
                      @click="$router.push('registerBook')"
                    >
                     Go to Register Book
                    </button>

                </v-col>
                <v-col v-if="LastDayTable">
                  <table class="table">
                    <thead class="thead-dark">
                      <td class="headerTable" colspan="40">{{message}}</td>
                      <tr>
                        <th scope="col">Roll</th>
                        <th scope="col">Name</th>
                        <th scope="col">Total in this month</th>
                        <th scope="col">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="absence in lastAbsence">
                        <th scope="row">{{absence.roll}}</th>
                        <td>{{absence.name}}</td>
                        <td>{{absence.attendance}}</td>
                        <td>{{absence.date}}</td>
                      </tr>
                    </tbody>
                  </table>
                </v-col>
              </div>
            </div>
          </v-app>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import SideTopNav from "../Partial/SideTopNav.vue";
import RegisterBook from "../student/RegisterBook.vue";
import Emp from "../../Api/Emp";
import { resolveObjectURL } from "buffer";

export default {
  name: "Students",
  components: {
    SideTopNav,
    RegisterBook,
  },

  data() {
    return {
      loader: null,
      loading: false,
      classes: ["1", "2", "3", "4"],
      selectedClass: "",
      allStudents: [],
      countStudents: "",
      lastAbsence:[],
      message:'',
      hide: false,
      LastDayTable: false,

      allAttendance: {},
      today: "",
      // props: {}
    };
  },

  methods: {
    showClass() {
      if (this.selectedClass == "") {
        console.log("Please select a class");
        return;
      }

      this.hide = false;
      this.loading = true;

      Emp.showClass(this.selectedClass)
        .then((res) => {
          this.allStudents = res.data.students;
          this.countStudents = res.data.count;
          console.log("Show class response", res);
          this.hide = true;
          console.log("Response Data", this.allStudents);
          this.loading = false;
          if (res.data.status == 404) {
            Swal.fire(
              "The Internet?",
              "That thing is still around?",
              "question"
            );
          }
        })
        .catch((err) => {
          console.log("error=>", err);
          this.hide = false;
          this.loading = false;
          this.$swal.fire(
            "The Internet?",
            "That thing is still around?",
            "question"
          );
        });
    },

    lastDayAbsenca(){
      Emp.lastDayAbsenca(this.today, this.selectedClass)
      .then((res)=>{
        console.log(res);
        this.lastAbsence = res.data.lastAbsence;
        this.message = res.data.message;
        this.LastDayTable = true;
      })
      .catch((err)=>{
        console.log(err);
      })

    },

    attendance(id) {
      // for present
      if (
        document.getElementById("attendancBtn" + id).className ==
        "btn btn-danger btn-sm btn-block"
      ) {
        document.getElementById("attendancBtn" + id).className =
          "btn btn-success btn-sm btn-block";
      } else {
        // for absent
        document.getElementById("attendancBtn" + id).className =
          "btn btn-danger btn-sm btn-block";
      }
    },

    submitAttendance() {
      let att = [];
      var present = document.getElementsByClassName(
        "btn btn-success btn-sm btn-block"
      );
      for (let item of present) {
        var roll = item.innerText.split(" ")[0].slice(1, 2);
        att.push({
          id: roll,
          status: "present",
        });
      }
      var absent = document.getElementsByClassName(
        "btn btn-danger btn-sm btn-block"
      );
      for (let item of absent) {
        var roll = item.innerText.split(" ")[0].slice(1, 2);
        att.push({
          id: roll,
          status: "absent",
        });
      }
      this.allAttendance = att;
      Emp.submitAttendance(this.allAttendance, this.today, this.selectedClass)
        .then((res) => {
          console.log("Response**************", res);
          if (res.data.status == 200) {
            this.$swal.fire({
              icon: "success",
              title: "Done",
              text: res.data.message,
              footer: '<a href="">Attendance reports</a>',
            });
          }
          if (res.data.status == 403) {
            this.$swal.fire(
              res.data.message,
              "That thing is still around?",
              "question"
            );
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },

  mounted() {
    let today = new Date().toISOString().slice(0, 10);
    console.log(today);
    this.today = today;

    // setInterval(() => {
    //   this.submitAttendance();
    //     console.log ("w");
    // }, 5000);
  },
};
</script>

<style scoped>

tbody tr{
  background-color: brown;
  color:white;
}
td.headerTable{
  background: #ea7272;
    text-align: center;
    font-family: fantasy;
    font-size: x-large;
}


.custom-loader {
  animation: loader 1s infinite;
  display: flex;
}
@-moz-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-webkit-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@-o-keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
@keyframes loader {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>

