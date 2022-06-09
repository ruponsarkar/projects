<template>
  <div app>
    <SideTopNav />
    <div class="content-wrapper">
      <section class="content p-0">
        <div class="container-fluid p-0 m-0">
          <v-app>
            <v-row class="m-2">
              <v-col cols="6" lg="2">
                <v-select
                  :items="AllClass"
                  :menu-props="{ top: true, offsetY: true }"
                  label="Select Class"
                  v-model="selectedClass"
                  :rules="rules"
                ></v-select>
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
                      v-model="selectedMonth"                      
                      label="Select Month"
                      persistent-hint
                      prepend-icon="mdi-calendar"
                      v-bind="attrs"
                      v-on="on"
                      :rules="rules"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="selectedMonth"
                    type="month"
                    no-title
                    @input="menu1 = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>


              <v-col cols="2">
                <v-btn
                  block
                  @click="getStudent"
                  class="btn btn-success"
                  color="primary"
                  :loading="loading"
                  :disabled="loading"
                ><i class="fas fa-search"></i> &nbsp; Show
                </v-btn>
              </v-col>
            </v-row>

            <v-col col="12" v-if="hide">
              <v-simple-table dense class="border">
                <template v-slot:default>
                  <thead class="table-primary">
                    <td class="headerTable" colspan="40">Attendance of {{selectedMonth}} ( Class- {{selectedClass}} )</td>
                    <tr class="v-txt-h">
                      <th class="border-right">Roll No</th>
                      <th class="border-right">Name</th>
                      <th class="border-right" v-for="(item, index) in attendance[1]" :key="index">{{item.date}}</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in student" :key="index">    
                      <td class="border-right">{{item.rollno}}</td>
                      <td class="border-right">{{item.name}}</td>
                      <td v-for="items in attendance[index+1]" :key="items.id" class="border-right text-center">
                      <span v-if="items.attendance=='absent'" style="color:red;"><i class="fas fa-times"></i></span>
                      <span v-else style="color:green;"><i class="fas fa-check"></i></span>
                       
                       </td>
                      
                      
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </v-col>
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
      selectedMonth: "",
      dateFormatted: "",
      menu1: false,
      AllClass: ["1", "2", "3", "4", "5", "6"],
      selectedClass:"",
      attendance:[],
      student:[],
      hide: false,

    };
  },

  methods: {
    getStudent(){
           this.hide = false;
           this.loading = true;

      Emp.getStudent(this.selectedClass, this.selectedMonth)
      .then((res)=>{
        console.log(res);
        this.attendance = res.data.attendance;
        this.student = res.data.students;
        this.loading = false;
        this.hide = true;
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

td.headerTable{
  background: #ea7272;
    text-align: center;
    font-family: fantasy;
    font-size: x-large;
}
 ::v-deep .v-application--wrap {
    min-height: fit-content;
  }
  tbody, td, tfoot, th, thead, tr{
    min-height: max-content;
  }
  .theme--light.v-data-table > .v-data-table__wrapper > table > thead > tr:last-child > th{
    writing-mode: vertical-rl;
  }
  th:nth-child(1), th:nth-child(2){
    writing-mode: horizontal-tb !important;
  }
</style>