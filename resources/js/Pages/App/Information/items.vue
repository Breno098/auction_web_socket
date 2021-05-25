<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card class="transparent" elevation="0">
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="3">
                                <v-card elevation="3">
                                    <v-card-title>
                                        Categorias
                                    </v-card-title>

                                    <v-card-text class="d-flex align-start flex-column">
                                         <v-container fluid>
                                            <v-btn v-on:click="items = itemsOriginals" block class="d-flex justify-space-between">
                                                <div>
                                                    Todos
                                                </div>
                                                <div>
                                                    <v-icon color="orange darken-3">mdi-view-headline</v-icon>
                                                </div>
                                            </v-btn>

                                            <v-divider class="mx-1 my-2"></v-divider>
                                        </v-container>

                                        <v-container
                                            v-for="category in _categories"
                                            :key="category.name"
                                            fluid
                                        >
                                            <v-btn v-on:click="filterCategory(category)" block class="d-flex justify-space-between">
                                                <div>
                                                    {{ category.name }}
                                                </div>
                                                <div>
                                                    <v-icon color="orange darken-3">  {{ category.icon }}</v-icon>
                                                </div>
                                            </v-btn>

                                            <v-divider class="mx-1 my-2"></v-divider>
                                        </v-container>
                                    </v-card-text>
                                </v-card>
                            </v-col>

                            <v-col cols="12" md="9">
                                <v-row>
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

                                            <inertia-link :href="route('informations.item', item)" style="text-decoration: none">
                                                <v-card-title class="d-flex align-start flex-column mb-2 pt-2 pb-0">
                                                    <div class="indigo--text font-weight-bold text-h5">
                                                        {{ item.name }}
                                                    </div>
                                                    <div class="subtitle-1 d-flex">
                                                        {{ item.category ? item.category.name : '--' }}

                                                        <v-icon color="grey darken-3" class="text-subtitle-1 ml-2" v-if="item.category.icon">
                                                            {{ item.category.icon }}
                                                        </v-icon>
                                                    </div>
                                                </v-card-title>

                                                <v-card-text>
                                                    <div class="grey--text d-flex align-center flex-column mb-1">
                                                        <div class="text-caption">
                                                            VALOR ATUAL
                                                        </div>
                                                        <div class="indigo--text font-weight-bold text-h5">
                                                            R$ {{ item.atual_bid ? item.atual_bid.value.toLocaleString('pt-BR') : item.initial_value.toLocaleString('pt-BR') }},00
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-space-between align-center">
                                                        <v-icon color="brown darken-1">mdi-gavel</v-icon>
                                                        {{ item.bids_count > 0 ? item.bids_count : 'Dê o primeiro lance' }}
                                                    </div>

                                                    <v-divider class="mx-1 my-2"></v-divider>

                                                    <div v-if="item.city" class="d-flex justify-space-between align-center">
                                                        <v-icon color="grey darken-1">mdi-map-marker</v-icon>
                                                        {{ item.city }} {{ item.state ? item.state : '' }}
                                                    </div>

                                                    <v-divider class="mx-1 my-2"></v-divider>

                                                    <div class="text-caption d-flex justify-space-between align-center">
                                                        <v-icon color="indigo darken-1">mdi-calendar</v-icon>
                                                        {{ dateFormat(item.initial_date)  }}
                                                    </div>

                                                    <div class="text-caption d-flex justify-end align-center">
                                                        {{ dateFormat(item.final_date)  }}
                                                    </div>

                                                    <v-divider class="mx-1 my-2"></v-divider>

                                                    <inertia-link :href="route('informations.item', item)" style="text-decoration: none">
                                                        <v-btn color="orange darken-3" class="font-weight-bold white--text" block small>
                                                            Aberto para lances
                                                        </v-btn>
                                                    </inertia-link>
                                                </v-card-text>
                                            </inertia-link>
                                        </v-card>
                                    </v-col>
                                </v-row>
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
            itemsOriginals: [],
            filter: [],
            categoryFilter: null
        }),
        methods: {
            dateFormat (date) {
                return moment(date).format('DD/MM/YYYY | HH:mm')
            },
            getOpenStatusItems(){
                    window.Echo
                    .channel('all.items')
                    .listen('.all.items', async (e) => {
                        this.itemsOriginals =  e._items

                        await this.filterCategory();
                    })
            },
            async filterCategory(category = null){
                this.categoryFilter = category ? category : this.categoryFilter;

                this.items = await this.itemsOriginals.filter(item => item.category.id ===  this.categoryFilter.id)
            }
        },
        mounted() {
            this.items = this._items;
            this.getOpenStatusItems();

            this.itemsOriginals = this._items;
        }
    }
</script>
