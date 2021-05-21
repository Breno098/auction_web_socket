<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card class="transparent" elevation="0">
                    <v-card-title class="d-flex align-start flex-column">
                        <div class="indigo--text font-weight-bold text-h5"> {{ item.name }} </div>
                        <div class="subtitle-1"> {{ item.category ? item.category.name : '--' }} </div>

                        <div class="subtitle-1">{{ item.city }}, {{ item.state }}</div>
                    </v-card-title>

                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="7">
                                <v-carousel  height="500" cycle hide-delimiter-background>
                                    <v-carousel-item
                                        v-for="(photo, i) in item.photos"
                                        :key="i"
                                        :src="photo.image_path"
                                    >
                                    </v-carousel-item>
                                </v-carousel>
                            </v-col>

                            <v-col cols="12" md="5">
                                <v-card elevation="0">
                                    <v-card-text>
                                        <div class="text-caption"> FECHA EM: </div>
                                        <div class="indigo--text font-weight-bold text-body-1"> {{ endDate }} </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div class="text-caption"> ENCERRAMENTO: </div>
                                        <div class="indigo--text font-weight-bold text-body-1"> {{ dateFormatString(item.real_final_date) }} </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div class="text-caption"> DATA DE ABERTURA: </div>
                                        <div class="indigo--text font-weight-bold text-body-1"> {{ dateFormatString(item.initial_date) }} </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div v-if="item.city" class="d-flex justify-space-around align-center">
                                            <div> LANCES </div>
                                            <div> {{ item.bids ? item.bids.length : 'Seja o primeiro a dar um lance' }} </div>
                                        </div>

                                        <v-divider class="mx-1 my-2"></v-divider>

                                        <div class="grey--text d-flex align-center flex-column mb-1">
                                            <div class="text-caption"> LANCE ATUAL </div>
                                            <div class="indigo--text font-weight-bold text-h5">
                                                R$ {{
                                                    item.latest_bid ? item.latest_bid.value.toLocaleString('pt-BR') :
                                                    item.initial_value ? item.initial_value.toLocaleString('pt-BR') : (0).toLocaleString('pt-BR')
                                                }},00
                                            </div>
                                        </div>

                                        <div class="text-caption mt-5"> PRÓXIMO LANCE </div>
                                        <div class="indigo--text font-weight-bold text-h5">
                                            R$ {{ nextBid() }},00
                                        </div>

                                        <div class="text-caption mt-2"> INCREMENTO </div>
                                        <div class="indigo--text font-weight-bold text-body-1">
                                            R$ {{ item.bid_minimum_value ? item.bid_minimum_value.toLocaleString('pt-BR') : 0 }},00
                                        </div>

                                        <div class="text-caption mt-2"> VALOR INICIAL </div>
                                        <div class="indigo--text font-weight-bold text-body-1">
                                            R$ {{ item.initial_value ? item.initial_value.toLocaleString('pt-BR') : 0 }},00
                                        </div>
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-btn color="orange darken-3" class="font-weight-bold white--text" block @click="dialog = true">
                                            Dar lance
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>

                            <v-divider class="mx-1 my-5"></v-divider>

                            <v-col cols="12">
                                <v-card elevation="0">
                                    <v-card-title>
                                        <div class="indigo--text font-weight-bold text-body-1"> DESCRIÇÃO </div>
                                    </v-card-title>

                                    <v-card-text>
                                        <div class="text-caption">
                                        {{ item.description }}
                                        </div>
                                    </v-card-text>
                                </v-card>
                            </v-col>

                            <v-divider class="mx-1 my-5"></v-divider>

                            <v-col cols="12">
                                <v-card elevation="0">
                                    <v-card-title class="white--text orange darken-3">
                                        Lances ({{ item.bids ? item.bids.length : 'Seja o primeiro a dar um lance' }})
                                    </v-card-title>

                                    <v-card-text class="mt-2">
                                        <v-virtual-scroll
                                            :items="item.bids ? item.bids.slice().reverse() : []"
                                            height="300"
                                            item-height="64"
                                        >
                                            <template v-slot:default="{ item }">
                                                <v-list-item :key="item.id">
                                                    <v-list-item-icon>
                                                            {{ item.user.name }}
                                                    </v-list-item-icon>
                                                    <v-list-item-content>
                                                        R$ {{ item.value.toLocaleString('pt-BR') }},00
                                                    </v-list-item-content>
                                                    <v-list-item-action>
                                                        {{ dateFormat(item.date) }}
                                                    </v-list-item-action>
                                                </v-list-item>
                                                <v-divider class="mx-1 my-2"></v-divider>
                                            </template>
                                        </v-virtual-scroll>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="dialog" max-width="300">
            <v-card>
                <v-img height="80" src="https://www.defensoria.rn.def.br/sites/default/files/2021-03/duvida-vale-pena-comprar-imovel-em-leilao.png">
                    <v-card-title>
                            Confirmar?
                    </v-card-title>
                </v-img>

                <v-card-text class="mt-3">
                    Confirmar seu interesse em {{ item.name }}, oferencendo um lance de  R$ {{ nextBid() }},00
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" class="font-weight-bold" text @click="dialog = false">
                        Não
                    </v-btn>
                        <v-spacer></v-spacer>
                    <v-btn color="green" text @click="bid">
                        Sim
                    </v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>

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
            item: {},
            dialog: false,
            endDate: '-- dias | --:--:--'
        }),
        methods: {
            bid(){
                window.axios.post(
                    route('bid.set-to-user', this.item)
                )
                .then(res => console.log(res.data))
                .catch(err => console.log(err))

                this.dialog = false;
            },
            dateFormatString (date) {
                return moment(date).format('LLLL')
            },
            dateFormat (date) {
                return moment(date).format('DD/MM/YYYY | HH:mm')
            },
            nextBid(){
                return this.item.latest_bid ? (this.item.latest_bid.value + this.item.bid_minimum_value).toLocaleString('pt-BR') :
                       this.item.initial_value ? this.item.initial_value.toLocaleString('pt-BR') : (0).toLocaleString('pt-BR');
            },
            endDateTime(){
                var rfd = moment(this.item.real_final_date);
                var now = moment();

                let diff = rfd.diff(now);
                this.endDate = moment.utc(diff).format("DD [dia(s)] | HH:mm:ss");
            },
            startChannelBid(){
                window.Echo
                    .channel(`bids.to.item.${this.item.id}`)
                    .listen('.bids.to.item', (e) => {
                        this.item = e._item
                    });
            }
        },
        mounted() {
            this.item = this._item;
            this.startChannelBid();

            setInterval(() => this.endDateTime(), 1000)
        }
    }
</script>
