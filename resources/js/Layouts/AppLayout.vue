<template>
  <v-app id="inspire">
    <v-app-bar app>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title> Features </v-toolbar-title>
    </v-app-bar>

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
                        <v-list-item :class="route().current().replace('.index', '').replace('.create', '') == item.route.replace('.index', '').replace('.create', '') ? 'success' : ''">
                            <v-list-item-icon>
                                <v-icon :v-text="item.icon"></v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </inertia-link>
                </div>
            </v-list>
    </v-navigation-drawer>

    <v-main>
      <v-container  class="mt-6">
        <slot></slot>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
        drawer: null,
        menu: [{
                title: 'Home',
                items: [
                    { title: 'Dashboard',   icon: 'mdi-team', route: 'dashboard' },
                ]
            },
        ],
        right: null,
    }),
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
    },
    mounted(){
        this.$vuetify.theme.dark = true;
    },
  }
</script>


<style>
@import 'vuetify/dist/vuetify.min.css';
@import url('https://fonts.googleapis.com/css2?family=Akaya+Telivigala&family=RocknRoll+One&display=swap');

* {
    font-family: 'RocknRoll One', sans-serif;
}

.v-application ::-webkit-scrollbar {
    height: 8px;
    width: 13px;
}

.v-application ::-webkit-scrollbar-corner {
    background: transparent;
}

.v-application ::-webkit-scrollbar-thumb {
    background: #43A047;
    border-radius: 8px;
}
</style>
