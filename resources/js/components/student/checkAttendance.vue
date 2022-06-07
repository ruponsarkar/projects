<template>
  <div app>
    <SideTopNav />
    <div class="content-wrapper">
      <section class="content">
        <v-container>
          <v-app>
            <v-row class="m-2">
              <v-col cols="6" lg="3">
                <v-select
                  :items="AllClass"
                  :menu-props="{ top: true, offsetY: true }"
                  label="Select Class"
                  v-model="selectedClass"
                  :rules="rules"
                ></v-select>
              </v-col>

              <v-col cols="6" lg="3">
                <v-text-field
                  label="Roll No"
                  :rules="rules"
                  hide-details="auto"
                  v-model="rollno"
                ></v-text-field>
              </v-col>

              <v-col cols="6" lg="3">
                <v-menu
                  ref="menu1"
                  v-model="menu1"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="fromDate"
                      label="From Date"
                      persistent-hint
                      prepend-icon="mdi-calendar"
                      v-bind="attrs"
                      v-on="on"
                      :rules="rules"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="fromDate"
                    type="date"
                    no-title
                    @input="menu1 = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>

              <v-col cols="6" lg="3">
                <v-menu
                  v-model="menu2"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="toDate"
                      label="To Date"
                      persistent-hint
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :rules="rules"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="toDate"
                    type="date"
                    no-title
                    @input="menu2 = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>

              <v-col cols="12">
                <v-btn
                  block
                  @click="checkAttendance"
                  class="btn btn-success"
                  color="primary"
                  :loading="loading"
                  :disabled="loading"
                >
                  Show
                </v-btn>
              </v-col>
            </v-row>

            <v-col col="12">
              <v-simple-table dense class="border">
                <template v-slot:default>
                  <thead class="table-primary">
                    <tr>
                      <th class="border-right">Roll No</th>
                      <th class="border-right">Name</th>
                      <th v-for="(item, index) in attendance[1]" :key="index" class="text-left">{{item.date}}</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in student" :key="index">    
                      <td class="border-right">{{item.rollno}}</td>
                      <td class="border-right">{{item.name}}</td>
                      <td v-for="items in attendance[index+1]" :key="items.id" class="text-left">
                      <span v-if="items.attendance=='absent'" style="color:red;">{{items.attendance}}</span>
                      <span v-else style="color:green;">{{items.attendance}}</span>
                       
                       </td>
                      
                      
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-col>
          </v-app>
        </v-container>
      </section>
    </div>
  </div>
</template>


 

<script>
import SideTopNav from "../Partial/SideTopNav.vue";
import Emp from "../../Api/Emp";

export default {
  components: {
    SideTopNav,
  },
  data() {
    return {
      rules: [
        (value) => !!value || "Required.",
        // value => (value && value.length >= 3) || 'Min 3 characters',
      ],
      loader: null,
      loading: false,
      fromDate: "",
      toDate: "",
      dateFormatted: "",
      menu1: false,
      menu2: false,
      AllClass: ["1", "2", "3", "4", "5", "6"],
      rollno: "",
      selectedClass:"",
      attendance:[],
      student:[],

    };
  },

  methods: {
    checkAttendance(){

      Emp.checkAttendance(this.selectedClass, this.rollno, this.fromDate, this.toDate)
      .then((res)=>{
        console.log(res);
        this.attendance = res.data.attendance;
        this.student = res.data.students;
        console.log(this.student);
      })
      .catch((err)=>{
        console.log(err);
      })
    }

  }
};
</script>


<style scoped lang="scss">
 ::v-deep .v-application--wrap {
    min-height: fit-content;
  }
</style>