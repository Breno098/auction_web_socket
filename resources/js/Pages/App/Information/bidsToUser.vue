<template>
    <app-layout>
        <v-row class="justify-center">
            <v-col cols="12">
                <v-card class="transparent" elevation="0">
                    <v-card-title class="d-flex align-start flex-column">
                        <!-- <div class="indigo--text font-weight-bold text-h5"> {{ item.name }} </div>
                        <div class="subtitle-1"> {{ item.category ? item.category.name : '--' }} </div>

                        <div class="subtitle-1">{{ item.city }}, {{ item.state }}</div> -->
                    </v-card-title>

                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-card elevation="0">
                                    <v-card-title>
                                        Meus lances
                                    </v-card-title>

                                    <v-card-text class="mt-2">
                                        <v-virtual-scroll
                                            :items="this._user.bids.slice().reverse()"
                                            height="300"
                                            item-height="64"
                                        >
                                            <template v-slot:default="{ item }">
                                                <v-list-item :key="item.id">
                                                    <v-list-item-icon>
                                                            {{ item.item.name }}
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
            _user: Object,
        },
        data: () => ({
            user: {},
            dialog: false,
        }),
        methods: {
            dateFormatString (date) {
                return moment(date).format('LLLL')
            },
            dateFormat (date) {
                return moment(date).format('DD/MM/YYYY | HH:mm')
            },
            startChannelBid(){
                // window.Echo
                //     .channel(`bids.to.item.${this.item.id}`)
                //     .listen('.bids.to.item', (e) => {
                //         // this.item = e._item
                //     });
            }
        },
        mounted() {
            this.user = this._user;
            // this.startChannelBid();
        }
    }
</script>
