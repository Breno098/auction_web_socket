<template>
  <v-app id="inspire">
    <v-system-bar app color="indigo darken-3" height="35">
        <v-spacer></v-spacer>

        <v-btn class="white--text" text small>
            Ajuda
        </v-btn>

        <v-btn class="white--text" text small>
            Fale Conosco
        </v-btn>
    </v-system-bar>

    <v-app-bar app color="grey lighten-2">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

        <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
                <v-btn icon v-bind="attrs" v-on="on">
                    <v-icon color="indigo darken-1">mdi-home</v-icon>
                </v-btn>
            </template>
            <span>Inicio</span>
        </v-tooltip>

        <v-spacer></v-spacer>

        <v-tooltip left>
            <template v-slot:activator="{ on, attrs }">
                <inertia-link :href="route('informations.bids-to-user')" style="text-decoration: none">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon color="indigo darken-1">mdi-format-list-bulleted</v-icon>
                    </v-btn>
                </inertia-link>
            </template>
            <span>Meus itens</span>
        </v-tooltip>


        <!-- <v-toolbar-title> Leilão </v-toolbar-title> -->

        <!-- <template v-slot:extension>
            <v-spacer></v-spacer>
            <v-btn text>
                <v-icon color="indigo darken-1"  @click="drawerBids = !drawerBids">mdi-cart</v-icon>
            </v-btn>
        </template> -->
    </v-app-bar>


    <v-navigation-drawer v-model="drawer" fixed floating temporary>
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
    </v-navigation-drawer>

    <v-main>
      <!-- <v-container> -->
        <slot></slot>
      <!-- </v-container> -->
    </v-main>

    <v-divider class="mx-1 my-5"></v-divider>

    <v-footer class="transparent" padless>
        <v-row no-gutters>
            <v-btn color="black" text rounded class="text-capitalize">
                Quem somos
            </v-btn>

            <v-btn color="black" text rounded class="text-capitalize">
                Ajuda
            </v-btn>

            <v-btn color="black" text rounded class="text-capitalize">
                Fale conosco
            </v-btn>

            <v-col class="indigo lighten-5 py-2 mt-5 text-center black--text" cols="12">
                {{ new Date().getFullYear() }}  <strong> BILD | VITTA </strong>
            </v-col>
        </v-row>
    </v-footer>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
        drawer: false,
        drawerBids: false,
        menu: [{
                title: 'Home',
                items: [
                    { title: 'Dashboard', icon: 'mdi-view-dashboard', route: 'dashboard.index' },
                ]
            }, {
                title: 'Cadastros',
                items: [
                    { title: 'Itens', icon: 'mdi-format-list-bulleted', route: 'item.index' },
                    { title: 'Categorias', icon: 'mdi-format-list-bulleted', route: 'category.index' },
                ]
            },
        ],
        right: null,
        user_bids: []
    }),
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
        channelUserBids(){
            window.Echo
            .channel('bids.to.user')
            .listen('.bids.to.user', (e) => {
                this.user_bids = e._bids;
            })
        },
    },
    mounted() {
        // this.$vuetify.theme.dark = true;
    }
  }
</script>


<style>
@import 'vuetify/dist/vuetify.min.css';
/* @import url('https://fonts.googleapis.com/css2?family=Akaya+Telivigala&family=RocknRoll+One&display=swap'); */

* {
    /* font-family: 'RocknRoll One', sans-serif; */
    font-size: 10px;
}

.v-application ::-webkit-scrollbar {
    height: 8px;
    width: 13px;
}

.v-application ::-webkit-scrollbar-corner {
    background: transparent;
}

.v-application ::-webkit-scrollbar-thumb {
    background: #d5dbff;
    border-radius: 8px;
}
</style>
