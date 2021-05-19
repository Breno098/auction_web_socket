<template>
  <v-app id="inspire">
    <v-system-bar app color="indigo darken-3" height="35">
        <v-spacer></v-spacer>

        <v-btn class="white--text" text>
            Fale Conosco
        </v-btn>
    </v-system-bar>

    <v-app-bar app color="grey darken-1"  height="100">
        <!-- <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title> Leilão </v-toolbar-title> -->
            <inertia-link
                v-for="item in menu"
                :key="item.title"
                :href="route(item.route)"
                style="text-decoration: none"
            >
                <v-btn text>
                    {{ item.title }}
                </v-btn>
            </inertia-link>
    </v-app-bar>

<!--
    <v-navigation-drawer
      v-model="drawer"
      fixed
      app
    >
        <v-list shaped>
                <div v-for="menuItem in menu"  :key="menuItem.title">
                    <v-subheader>{{menuItem.title}}</v-subheader>

                    <inertia-link
                        v-for="item in menuItem.items"
                        :key="item.title"
                        :href="route(item.route)"
                        style="text-decoration: none"
                    >
                        <v-list-item class="d-flex justify-start ">
                            <v-list-item-icon>
                                <v-icon color="indigo darken-1">{{ item.icon }}</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title v-text="item.title"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </inertia-link>

                    <v-divider color="indigo darken-1" class="mx-5 mb-5"></v-divider>
                </div>
            </v-list>
    </v-navigation-drawer> -->

    <v-main>
      <!-- <v-container> -->
        <slot></slot>
      <!-- </v-container> -->
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
        drawer: null,
        // menu: [{
        //         title: 'Home',
        //         items: [
        //             { title: 'Dashboard', icon: 'mdi-view-dashboard', route: 'dashboard.index' },
        //         ]
        //     }, {
        //         title: 'Cadastros',
        //         items: [
        //             { title: 'Itens', icon: 'mdi-format-list-bulleted', route: 'item.index' },
        //             { title: 'Categorias', icon: 'mdi-format-list-bulleted', route: 'category.index' },
        //         ]
        //     },
        // ],
        menu: [
            { title: 'Dashboard', icon: 'mdi-view-dashboard', route: 'dashboard.index' },
        ],
        right: null,
    }),
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
    },
    // mounted(){
    //     this.$vuetify.theme.dark = true;
    // },
  }
</script>


<style>
@import 'vuetify/dist/vuetify.min.css';
/* @import url('https://fonts.googleapis.com/css2?family=Akaya+Telivigala&family=RocknRoll+One&display=swap');

* {
    font-family: 'RocknRoll One', sans-serif;
} */

.v-application ::-webkit-scrollbar {
    height: 8px;
    width: 13px;
}

.v-application ::-webkit-scrollbar-corner {
    background: transparent;
}

.v-application ::-webkit-scrollbar-thumb {
    background: #3949AB;
    border-radius: 8px;
}
</style>
