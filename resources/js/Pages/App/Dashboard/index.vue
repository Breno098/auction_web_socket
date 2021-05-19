<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card class="transparent" elevation="0">
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-sheet  elevation="5" class="py-4 px-4">
                                    <v-chip-group multiple active-class="indigo--text text--accent-4 indigo" v-model="filter">
                                        <v-chip v-for="categorie in _categories" :key="categorie.name" filter outlined>
                                            {{ categorie.name }}
                                        </v-chip>
                                    </v-chip-group>
                                </v-sheet>
                            </v-col>

                            <v-col cols="12" md="4" v-for="(item, i) in items" :key="i">
                                <v-card elevation="5">
                                    <v-carousel  height="200" cycle hide-delimiter-background>
                                        <v-carousel-item
                                            v-for="(photo, i) in item.photos"
                                            :key="i"
                                            :src="photo.image_path"
                                        >
                                        </v-carousel-item>
                                    </v-carousel>

                                    <v-card-title class="d-flex align-start flex-column mb-2 pt-2 pb-0">
                                        <div class="indigo--text font-weight-bold text-h5">
                                            {{ item.name }}
                                        </div>
                                        <div class="subtitle-1">
                                            {{ item.category ? item.category.name : '--' }}
                                        </div>
                                    </v-card-title>

                                    <v-card-text>
                                        <div class="grey--text d-flex align-center flex-column mb-1">
                                            <div class="text-caption">
                                                VALOR ATUAL
                                            </div>
                                            <div class="indigo--text font-weight-bold text-h5">
                                                R$ {{ item.bids.length > 0 ?  item.bids[item.bids.length - 1].value.toLocaleString('pt-BR') : item.initial_value.toLocaleString('pt-BR') }},00
                                            </div>
                                        </div>

                                        <div class="d-flex justify-space-between align-center">
                                            <v-icon color="brown darken-1">mdi-gavel</v-icon>
                                            {{ item.bids.length ? item.bids.length : 'Seja o primeiro a dar um lance' }}
                                        </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div v-if="item.city" class="d-flex justify-space-between align-center">
                                            <v-icon color="grey darken-1">mdi-map-marker</v-icon>
                                            {{ item.city }} {{ item.state ? item.state : '' }}
                                        </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div class="text-caption d-flex justify-space-between align-center">
                                            <v-icon color="indigo darken-1">mdi-calendar</v-icon>
                                            {{ dateFormat(item.initial_date)  }} - {{ dateFormat(item.final_date)  }}
                                        </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <v-btn color="orange darken-3" class="font-weight-bold white--text" block>
                                            Aberto para lances
                                        </v-btn>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import moment from 'moment';

    export default {
        components: {
            AppLayout,
        },
        props: {
            _items: Array,
            _categories: Array,
        },
        data: () => ({
            items: [],
            filter: [2]
        }),
        methods: {
            dateFormat (date) {
                return moment(date).format('DD/MM/YYYY | HH:mm')
            },
        },
        mounted() {
            this.items = this._items;

            window.Echo.channel('item-open').listen('ItemOpen', (e) => {
                this.items = e.items
            })
        }
    }
</script>
