<template>
  <v-container>
    <v-app>
      <v-row>
        <v-col cols="12" lg="3">
          <v-select
            :items="AllClass"
            :menu-props="{ top: true, offsetY: true }"
            label="Select Class"
          ></v-select>
        </v-col>

        <v-col cols="12" lg="3">
          <v-select
            :items="items"
            :menu-props="{ top: true, offsetY: true }"
            label="Roll No"
          ></v-select>
        </v-col>

        <v-col cols="12" lg="3">
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
                v-model="date"
                label="From Date"
                hint="MM/DD/YYYY format"
                persistent-hint
                prepend-icon="mdi-calendar"
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="date"
              type="month"
              no-title
              @input="menu1 = false"
            ></v-date-picker>
          </v-menu>
        </v-col>

        <v-col cols="12" lg="3">
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
                v-model="date"
                label="To Date"
                hint="MM/DD/YYYY format"
                persistent-hint
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="date"
              type="month"
              no-title
              @input="menu2 = false"
            ></v-date-picker>
          </v-menu>
        </v-col>
      </v-row>

    
        <v-col cols="12">
          <v-btn
          block
            @click="showClass"
            class="btn btn-success"
            color="primary"
            :loading="loading"
            :disabled="loading"
          >
            Show
          </v-btn>
        </v-col>
      
    </v-app>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      loader: null,
      loading: false,
      date: "",
      dateFormatted: "",
      menu1: false,
      menu2: false,
      AllClass: ['1','2','3'],
    };
  },
};
</script>