 <template>
    <v-app>
       <v-main>
            <v-container fluid fill-height style="background: #7986CB; background: linear-gradient(to bottom, #9FA8DA, #5C6BC0, #303F9F);">
                <v-layout flex align-center justify-center>
                    <v-flex xs12 sm8 elevation-6>
                        <v-card elevation="24" color="indigo darken-3">
                            <v-row>
                                <v-col cols="4" class="py-0 mx-0 px-0">
                                    <v-container
                                        align-center
                                        justify-space-around
                                        fill-height
                                        flex-column
                                    >
                                        <div>
                                            <v-icon dark class="text-h1">mdi-gavel</v-icon>
                                        </div>

                                        <div class="white--text text-h3">
                                            Auction
                                        </div>
                                    </v-container>
                                </v-col>

                                <v-col cols="8" class="py-0 mx-0 px-0">
                                    <v-card class="py-12 px-10">
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="form.email"
                                                    label="Email"
                                                    color="indigo darken-3"
                                                    required
                                                    v-on:keyup.enter="submit"
                                                    outlined
                                                    dense
                                                    prepend-inner-icon="mdi-email"
                                                    :hint="errors.email === 'The email field is required.' ? 'Insira a email' : errors.email"
                                                    :persistent-hint="errors.email"
                                                ></v-text-field>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="form.password"
                                                    label="Password"
                                                    color="indigo darken-3"
                                                    required
                                                    type="password"
                                                    v-on:keyup.enter="submit"
                                                    outlined
                                                    dense
                                                    prepend-inner-icon="mdi-lock-open"
                                                    :hint="errors.password === 'The password field is required.' ? 'Insira a senha' : errors.password"
                                                    :persistent-hint="errors.password"
                                                ></v-text-field>
                                            </v-col>

                                            <v-col cols="8">
                                                <div class="indigo--text text-caption">
                                                    Ainda não possui conta? <b>Clique aqui</b>
                                                </div>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-btn color="indigo darken-3 white--text" v-on:click="submit" large>
                                                    Entrar
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-card>
                                </v-col>
                            </v-row>
                            <!--
                                <inertia-link v-if="true" :href="route('password.request')" style="text-decoration: none; color: white">
                                    Forgot your password?
                                </inertia-link>
                            -->
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
  </v-app>
</template>

<script>
  export default {
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },
    props: {
        canResetPassword: Boolean,
        status: String,
        errors: Object,
    },
    methods: {
        submit() {
            this.form.transform(data => ({
                ... data,
                remember: this.form.remember ? 'on' : ''
            }))
            .post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
            })
        },
    },
    // mounted(){
    //     this.$vuetify.theme.dark = true;
    // },
  }
</script>


<style>
@import 'vuetify/dist/vuetify.min.css';
</style>
