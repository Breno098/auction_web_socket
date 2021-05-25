<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card class="transparent" elevation="0">
                    <v-card-title class="d-flex justify-start mb-6">
                        {{ category ? 'Editando Registro' : 'Novo Registro' }}
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="form.name"
                                        label="Nome"
                                        required
                                        color="indigo darken-1"
                                        v-on:keyup.enter="store"
                                        outlined
                                    ></v-text-field>
                                    <div v-if="errors.name">
                                        <v-alert dense type="error" text>{{ errors.name }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12">
                                    <v-textarea
                                        v-model="form.description"
                                        label="Descrição"
                                        required
                                        color="indigo darken-1"
                                        outlined
                                    ></v-textarea>
                                    <div v-if="errors.description">
                                        <v-alert dense type="error" text>{{ errors.description }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12">
                                    <v-chip-group mandatory active-class="indigo darken-1 white--text" v-model="form.icon">
                                        <v-chip v-for="icon in icons" :key="icon" :value="icon">
                                            <v-icon> {{ icon }}</v-icon>
                                        </v-chip>
                                    </v-chip-group>
                                </v-col>

                                <v-col cols="12">
                                    <v-btn color="green darken-1" @click="store">
                                        Salvar &nbsp; <v-icon dark>mdi-content-save</v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    export default {
        components: {
            AppLayout,
        },
        props: {
            category: Object,
            errors: Object,
        },
        data: () => ({
            form: {
                name: '',
                description: '',
                id: null,
                icon: 'mdi-home'
            },
            icons: [
                'mdi-home',
                'mdi-car',
                'mdi-motorbike',
                'mdi-mouse',
                'mdi-sofa',
                'mdi-home-variant',
                'mdi-treasure-chest',
                'mdi-tshirt-crew',
                'mdi-book-open-variant',
                'mdi-cat',
                'mdi-wrench',
                'mdi-view-list',
                'mdi-format-list-bulleted'
            ]
        }),
        mounted(){
            if(this.category){
                this.form = this.category;
            }
        },
        methods: {
            store(){
                if(!this.category){
                    this.$inertia.post(route('category.store'), this.form);
                } else {
                    this.$inertia.put(route('category.update', { category: this.form }), this.form);
                }
            },
        },
    }
</script>
