<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card class="transparent" elevation="0">
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="8">
                                <v-carousel  height="600" cycle hide-delimiter-background>
                                    <v-carousel-item
                                        v-for="(photo, i) in _item.photos"
                                        :key="i"
                                        :src="photo.image_path"
                                    >
                                    </v-carousel-item>
                                </v-carousel>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-card elevation="0">
                                     <v-card-title class="d-flex align-start flex-column mb-5">
                                        <div class="indigo--text font-weight-bold text-h5"> {{ _item.name }} </div>
                                        <div class="subtitle-1"> {{ _item.category ? _item.category.name : '--' }} </div>
                                    </v-card-title>

                                    <v-card-text>
                                        <div class="text-caption"> ENCERRAMENTO </div>
                                        <div class="indigo--text font-weight-bold text-h6"> {{ dateFormat(_item.final_date) }} </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div class="text-caption"> DATA DE ABERTURA </div>
                                        <div class="indigo--text font-weight-bold text-h6"> {{ dateFormat(_item.initial_date) }} </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div v-if="_item.city" class="d-flex justify-space-around align-center">
                                            <div> LANCES </div>
                                            <div> {{ _item.bids.length ? _item.bids.length : 'Seja o primeiro a dar um lance' }} </div>
                                        </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div class="grey--text d-flex align-center flex-column mb-1">
                                            <div class="text-caption"> LANCE ATUAL </div>
                                            <div class="indigo--text font-weight-bold text-h4">
                                                R$ {{ atualBid.toLocaleString('pt-BR') }},00
                                            </div>
                                        </div>

                                        <div class="text-caption mt-5"> PRÓXIMO LANCE </div>
                                        <div class="indigo--text font-weight-bold text-h4">
                                            R$ {{ nextBid.toLocaleString('pt-BR') }},00
                                        </div>

                                        <div class="text-caption mt-5"> INCREMENTO </div>
                                        <div class="indigo--text font-weight-bold text-h6">
                                            R$ {{ _item.bid_minimum_value.toLocaleString('pt-BR') }},00
                                        </div>
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-btn color="orange darken-3" class="font-weight-bold white--text" block>
                                            Dar lance
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>

                            <v-col cols="12">
                                <v-card elevation="5">
                                    <v-card-title>
                                        <div class="indigo--text font-weight-bold text-h5"> DESCRIÇÃO </div>
                                    </v-card-title>

                                    <v-card-text class="text--primary">
                                        {{ _item.description }}
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

    moment.locale('pt-Br')

    export default {
        components: {
            AppLayout,
        },
        props: {
            _item: Object,
        },
        data: () => ({
        }),
        methods: {
            dateFormat (date) {
                return moment(date).format('LLLL')
            },
        },
        computed: {
            atualBid () {
                return this._item.bids.length > 0 ? this._item.bids[ this._item.bids.length - 1].value : this._item.initial_value;
            },
            nextBid () {
                return this._item.bids.length > 0 ? this._item.bids[ this._item.bids.length - 1].value + this._item.bid_minimum_value : this._item.initial_value;
            },
        },
        mounted() {
            // this.items = this._items;

            // window.Echo.channel('item-open').listen('ItemOpen', (e) => {
            //     this.items = e.items
            // })
        }
    }
</script>
