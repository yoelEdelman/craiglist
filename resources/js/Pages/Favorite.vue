<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mes Favoris
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-1">
                    <div>
                        <input class="inputSearch" v-model="searchAd" type="search" placeholder="Rechercher dans vos favoris" >
                    </div>

                    <div class="eachAdvert" v-for="advertFavorite in filteredList" :key="advertFavorite.id">
                        <div class="close" @click="deleteFavorite(advertFavorite.user_id_connected,advertFavorite.id)"><font-awesome-icon :icon="['fas', 'times']" /></div>
                        <inertia-link :href="`/${advertFavorite.advert.slug_city}/${advertFavorite.advert.slug_category}/${advertFavorite.advert.slug_subcategory}/${advertFavorite.advert.slug}`">
                            <div class="subCategory">
                                <h3>{{advertFavorite.advert.title}}</h3>
                                <span>Localisation: <b>{{advertFavorite.advert.slug_city}}</b></span><br>
                                <span>Catégorie: <b>{{advertFavorite.advert.slug_category}}</b></span><br>
                                <span>Sous-catégorie: <b>{{advertFavorite.advert.slug_subcategory}}</b></span>
                                <h4><b>Publiée</b> {{ convertDate(advertFavorite.advert.publication_date) }} </h4>
                                <p>{{advertFavorite.advert.content}}</p>
                            </div>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from './../Layouts/AppLayout'
import moment from "moment";
import {Inertia} from "@inertiajs/inertia";
export default {
    name: "Favorite",
    props:{
        advertsFavorites:Array
    },
    data(){
        return{
            searchAd:"",
            dataAd:this.advertsFavorites,
            status:false
        }
    },
    components:{
        AppLayout
    },
    computed:{
        filteredList() {
            return this.dataAd.filter(advert => {
                return advert.advert.title.toLowerCase().includes(this.searchAd.toLowerCase())
            })
        }
    },
    methods: {
        convertDate(dateAdvert) {
            return moment(dateAdvert).startOf('day').locale("fr").fromNow();
        },
        upperCase(name){
            return (name+'').charAt(0).toUpperCase()+name.substr(1);
        },
        deleteFavorite(idUser,idAdvert){
            Inertia.visit('/favorite', {
                method: 'delete',
                data: {
                    user_id_connected:idUser,
                    id:idAdvert
                },
            })
        }
    }
}
</script>

<style scoped>
.eachAdvert{
    position: relative;
}
.close{
    position: absolute;
    right: 0;
    margin: 7px 12px;
    font-size: 20px;
    color: red;
}
.inputSearch{
    padding: 10px;
    width: 250px;
    border: 1px solid gray;
    border-radius: 6px;
}
.p-1{
    padding: 15px;
}
h1{
    color: green;
    font-size: 20px;
    text-align: center;
}
span{
    color: #861d1d;
}
h3{
    font-weight: bold;
}
.subCategory{
    padding: 15px;
    background-color: rgba(255, 69, 0, 0.4);
    margin: 10px 0;
    border-radius: 6px;
}
p{
    text-overflow: ellipsis;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
</style>
