<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card class="transparent" elevation="0">
                    <v-card-text>
                        <v-container>
                            <v-card-title class="d-flex justify-start mb-1">
                                <!-- <pre> {{ form.photos }} </pre> -->
                                Informações
                            </v-card-title>
                            <v-row>
                                <v-file-input
                                    ref="photosfile"
                                    v-model="images"
                                    @change="onFilePicked"
                                    multiple
                                    style="display: none"
                                />

                                 <v-col cols="12">
                                    <div style="overflow: auto; white-space: nowrap; display: flex; flex-direction: row">
                                        <v-img
                                            v-for="(image, i) in form.photos"
                                            :key="i"
                                            height="300"
                                            width="400"
                                            gradient="to left, rgba(0,0,0,0), rgba(0,0,0,0.7)"
                                            :src="image.src || image.image_path"
                                            style="display: flex;"
                                            class="white--text align-end mx-1 mb-2"
                                        >
                                            <v-card-title>
                                                <v-btn color="red darken-1" dark small @click="removeFile(image.id || i)">
                                                    <v-icon dark>mdi-close</v-icon>
                                                </v-btn>
                                            </v-card-title>

                                            <v-card-text>
                                                <v-text-field
                                                    v-model="image.description"
                                                    label="Descrição"
                                                    required
                                                    color="indigo darken-1"
                                                    v-on:keyup.enter="store"
                                                    solo
                                                    dense
                                                ></v-text-field>
                                            </v-card-text>
                                        </v-img>
                                    </div>

                                    <v-btn color="indigo darken-1 mt-2" block text @click="selectFile">
                                        Adicionar fotos
                                    </v-btn>
                                </v-col>

                                <v-col cols="12" md="6">
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

                                <v-col cols="12" md="6">
                                    <v-select
                                        v-model="form.category_id"
                                        :items="categories"
                                        label="Categoria"
                                        required
                                        item-text="name"
                                        item-value="id"
                                        color="indigo darken-1"
                                        outlined
                                    ></v-select>
                                    <div v-if="errors.category_id">
                                        <v-alert dense type="error" text>{{ errors.category_id }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-menu
                                        v-model="menu_initial_date"
                                        :close-on-content-click="false"
                                        max-width="290"
                                        transition="scale-transition"
                                        offset-y
                                        color="green darken-1"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            append-icon="mdi-calendar"
                                            :value="initialDateFormat"
                                            clearable
                                            label="Data de Inicio"
                                            readonly
                                            v-bind="attrs"
                                            color="indigo darken-1"
                                            v-on="on"
                                            @click:clear="form.initial_date = null"
                                            outlined
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="form.initial_date"
                                        @change="menu_initial_date = false"
                                        no-title
                                        crollable
                                        color="indigo darken-1"
                                    ></v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-menu
                                        v-model="menu_final_date"
                                        :close-on-content-click="false"
                                        max-width="290"
                                        transition="scale-transition"
                                        offset-y
                                        color="green darken-1"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            append-icon="mdi-calendar"
                                            :value="finalDateFormat"
                                            clearable
                                            label="Data de Encerramento"
                                            readonly
                                            v-bind="attrs"
                                            color="indigo darken-1"
                                            v-on="on"
                                            @click:clear="form.final_date = null"
                                            outlined
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="form.final_date"
                                        @change="menu_final_date = false"
                                        no-title
                                        crollable
                                        color="indigo darken-1"
                                    ></v-date-picker>
                                    </v-menu>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        v-model="form.initial_value"
                                        suffix=",00"
                                        label="Valor inicial"
                                        required
                                        color="indigo darken-1"
                                        outlined
                                        prefix="R$"
                                        type="number"
                                    ></v-text-field>
                                    <div v-if="errors.initial_value">
                                        <v-alert dense type="error" text>{{ errors.initial_value }}</v-alert>
                                    </div>
                                </v-col>

                                <v-col cols="12" md="6">
                                    <v-text-field
                                        v-model="form.bid_minimum_value"
                                        suffix=",00"
                                        label="Valor minimo para lance"
                                        required
                                        color="indigo darken-1"
                                        outlined
                                        prefix="R$"
                                        type="number"
                                    ></v-text-field>
                                    <div v-if="errors.bid_minimum_value">
                                        <v-alert dense type="error" text>{{ errors.bid_minimum_value }}</v-alert>
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
                                    <v-expansion-panels multiple>
                                        <v-expansion-panel>
                                            <v-expansion-panel-header>Endereço </v-expansion-panel-header>

                                            <v-expansion-panel-content>
                                                <v-row>
                                                    <v-col cols="12"  md="10">
                                                        <v-text-field
                                                            v-model="form.street"
                                                            label="Rua"
                                                            required
                                                            color="indigo darken-1"
                                                            outlined
                                                        ></v-text-field>
                                                        <div v-if="errors.street">
                                                            <v-alert dense type="error" text>{{ errors.street }}</v-alert>
                                                        </div>
                                                    </v-col>

                                                    <v-col cols="12"  md="2">
                                                        <v-text-field
                                                            v-model="form.number"
                                                            label="Nº"
                                                            required
                                                            color="indigo darken-1"
                                                            outlined
                                                        ></v-text-field>
                                                        <div v-if="errors.number">
                                                            <v-alert dense type="error" text>{{ errors.number }}</v-alert>
                                                        </div>
                                                    </v-col>

                                                    <v-col cols="12"  md="6">
                                                        <v-text-field
                                                            v-model="form.district"
                                                            label="Bairro"
                                                            required
                                                            color="indigo darken-1"
                                                            outlined
                                                        ></v-text-field>
                                                        <div v-if="errors.district">
                                                            <v-alert dense type="error" text>{{ errors.district }}</v-alert>
                                                        </div>
                                                    </v-col>

                                                    <v-col cols="12" md="4">
                                                        <v-text-field
                                                            v-model="form.city"
                                                            label="Cidade"
                                                            required
                                                            color="indigo darken-1"
                                                            outlined
                                                        ></v-text-field>
                                                        <div v-if="errors.city">
                                                            <v-alert dense type="error" text>{{ errors.city }}</v-alert>
                                                        </div>
                                                    </v-col>

                                                    <v-col cols="12" md="2">
                                                        <v-select
                                                            v-model="form.state"
                                                            :items="states"
                                                            label="Estado"
                                                            required
                                                            color="indigo darken-1"
                                                            outlined
                                                        ></v-select>
                                                        <div v-if="errors.state">
                                                            <v-alert dense type="error" text>{{ errors.state }}</v-alert>
                                                        </div>
                                                    </v-col>
                                                </v-row>
                                            </v-expansion-panel-content>
                                        </v-expansion-panel>

                                         <v-expansion-panel>
                                                <v-expansion-panel-header>Outras informações </v-expansion-panel-header>
                                                <v-expansion-panel-content>
                                                            <v-row>
                                                                <v-col cols="12" md="6">
                                                                    <v-text-field
                                                                        v-model="form.brand"
                                                                        label="Marca"
                                                                        required
                                                                        color="indigo darken-1"
                                                                        outlined
                                                                    ></v-text-field>
                                                                    <div v-if="errors.brand">
                                                                        <v-alert dense type="error" text>{{ errors.brand }}</v-alert>
                                                                    </div>
                                                                </v-col>

                                                                <v-col cols="12" md="6">
                                                                    <v-text-field
                                                                        v-model="form.model"
                                                                        label="Modelo"
                                                                        required
                                                                        color="indigo darken-1"
                                                                        outlined
                                                                    ></v-text-field>
                                                                    <div v-if="errors.model">
                                                                        <v-alert dense type="error" text>{{ errors.model }}</v-alert>
                                                                    </div>
                                                                </v-col>

                                                                <v-col cols="12" md="6">
                                                                    <v-text-field
                                                                        v-model="form.year"
                                                                        label="Ano"
                                                                        required
                                                                        color="indigo darken-1"
                                                                        outlined
                                                                    ></v-text-field>
                                                                    <div v-if="errors.year">
                                                                        <v-alert dense type="error" text>{{ errors.year }}</v-alert>
                                                                    </div>
                                                                </v-col>

                                                                <v-col cols="12" md="6">
                                                                    <v-text-field
                                                                        v-model="form.color"
                                                                        label="Cor"
                                                                        required
                                                                        color="indigo darken-1"
                                                                        outlined
                                                                    ></v-text-field>
                                                                    <div v-if="errors.color">
                                                                        <v-alert dense type="error" text>{{ errors.color }}</v-alert>
                                                                    </div>
                                                                </v-col>

                                                            </v-row>
                                                </v-expansion-panel-content>
                                        </v-expansion-panel>
                                    </v-expansion-panels>
                                </v-col>

                            </v-row>
                        </v-container>

                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-btn color="green darken-1" @click="store" x-large block>
                                        {{ this.item ? 'Editar' : 'Salvar' }} &nbsp; <v-icon dark>mdi-content-save</v-icon>
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
     import moment from 'moment'
    import { format, parseISO } from 'date-fns'

    export default {
        components: {
            AppLayout,
        },
        props: {
            item: Object,
            errors: Object,
            categories: Array
        },
        data: () => ({
            states: [
                'AC','AL','AP','AM','BA','CE','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO','DF'
            ],
            menu_initial_date: false,
            menu_final_date: false,
            images: [],
            form: {
                name: '',
                description: '',
                category_id: null,
                initial_value: 0,
                bid_minimum_value: 0,
                initial_date: format( parseISO(new Date().toISOString()), 'yyyy-MM-dd'),
                final_date: format( parseISO(new Date().toISOString()), 'yyyy-MM-dd'),
                street: '',
                district: '',
                city: '',
                number: null,
                state: null,
                id: null,
                year: null,
                brand: null,
                color: null,
                model: null,
                photos: [],
            }
        }),
        mounted(){
            if(this.item){
                this.form = this.item;
            }
        },
        methods: {
            store(){
                if(!this.item){
                    this.$inertia.post(
                        route('item.store'),
                        this.form
                    );
                } else {
                    this.$inertia.post(
                        route('item.update-with-image', { item: this.item }),
                        this.form
                    );
                }
            },
            selectFile(){
                this.$refs.photosfile.$refs.input.click();
            },
            onFilePicked() {
                if (this.images !== undefined) {
                    this.images.forEach((photo, index) => {
                        const fr = new FileReader()
                        fr.readAsDataURL(photo);
                        fr.addEventListener('load', () => {
                            this.form.photos.push({ src: fr.result, description: '', id: index, photo})
                        })
                    })
                }
            },
            removeFile(index){
                this.form.photos = this.form.photos.filter(item => item.id != index)
            }
        },
        computed: {
            initialDateFormat () {
                return this.form.initial_date ? moment(this.form.initial_date).format('DD/MM/YYYY') : ''
            },
            finalDateFormat () {
                return this.form.final_date ? moment(this.form.final_date).format('DD/MM/YYYY') : ''
            },
        },
    }
</script>


