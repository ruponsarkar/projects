<template>
  <div data-app>
    <SideTopNav />

    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid pt-2">
          <v-card>
            <div class="row">
              <div class="col-md-6 col-12 offset-md-3">
                <form class="form-inline">
                  <div class="form-group col-3 mx-sm-3 mb-2">
                    <v-select
                      :items="classes"
                      label="Select Class"
                      v-model="selectedClass"
                      prepend-icon="mdi-account"
                    ></v-select>
                  </div>

                  <div class="form-group col-3 mx-sm-3 mb-2">
                    <v-text-field
                      label="Select Month"
                      type="month"
                      v-model="selectedMonth"
                    ></v-text-field>
                  </div>
                  <div class="form-group col-3 mx-sm-3 mb-2">
                    <v-btn
                      @click="showClass"
                      class="btn btn-success mr-4"
                      :loading="loading"
                      :disabled="loading"
                    > 
                      Show
                    </v-btn>
                  </div>
                </form>
              </div>
            </div>
          </v-card>
            <!-- testing purpose  -->
            <v-card>
              <div>
                Data
              </div>
            </v-card>
            <!-- end testing purpose  -->
          <v-app id="inspire">
            <v-card>
              <v-card-title>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-data-table
                :headers="headers"
                :items="desserts"
                :search="search"
              ></v-data-table>
            </v-card>
          </v-app>
        </div>
      </section>
    </div>
  </div>
</template>

    
<script>
import SideTopNav from "../Partial/SideTopNav.vue";
import Emp from "../../Api/Emp";

export default {
  // vuetify: new Vuetify(),
  components: {
    SideTopNav,
  },

  data() {
    return {
      loader: null,
      loading: false,
      classes: ["1", "2", "3", "4"],
      selectedClass: "",
      selectedMonth:"2022-05",
      attendance:[],
      allAttendance:[],


      search: "",
      headers: [
        {
          text: "Student Name",
          align: "start",
          // filterable: false,
          value: "name",
        },
        { text: "Roll No", value: "rollno" },
        { text: "01", value: "fat" },
        { text: "02", value: "carbs" },
        { text: "03", value: "protein" },
        { text: "04", value: "iron" },
      ],
      desserts: [
       
      ],
    };
  },

  methods: {



    showClass(){
      if (this.selectedClass == "") {
        console.log("Please select a class");
        return;
      }

      this.desserts = [];
      Emp.getStudent(this.selectedClass, this.selectedMonth)
        .then((res) => {
          console.log(res);
          this.desserts = res.data.students;
          this.attendance = res.data.a;
          console.log("****=>>>",this.attendance.length);

      // for(let i = 0; i <this.attendance.length; i++){
          this.attendance.map((attendance) => {
            let i =1;
              if(attendance.roll =i){
              this.allAttendance.push({
                  roll: attendance.roll,
                  date: [attendance.attendance],
              })
            }
            
            


          console.log(attendance.roll, attendance.attendance ) ;
          i++;

      });
      console.log(this.allAttendance);
      // }
         


        })
        .catch((err) => {
          console.log(err);
        });
    }

  },

  mounted() {
    // this.getStudent();





  },
};
</script>