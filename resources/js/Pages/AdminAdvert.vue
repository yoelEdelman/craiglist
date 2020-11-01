<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mes annonces
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="myAdverts.length !==0" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-1">
                    <div>
                        <input v-model="searchMyAdvert" class="inputSearch" type="search" placeholder="Rechercher dans vos annonces" :disabled="this.searchMyAdvertCity !=='' || this.status !== 'null'">
                        <input v-model="searchMyAdvertCity" class="inputSearch ml-3" type="search" placeholder="Rechercher par ville" :disabled="this.searchMyAdvert !==''|| this.status !== 'null'">

                        <input type="radio" id="all" class="ml-4"  value="null" v-model="status" :disabled="this.searchMyAdvert !==''|| this.searchMyAdvertCity !== ''">
                        <label for="all">Tout</label>

                        <input type="radio" id="active" class="ml-4" value="active" v-model="status" :disabled="this.searchMyAdvert !==''|| this.searchMyAdvertCity !== ''">
                        <label for="active">Actif</label>

                        <input type="radio" id="inactive" class="ml-4" value="inactive" v-model="status" :disabled="this.searchMyAdvert !==''|| this.searchMyAdvertCity !== ''">
                        <label for="inactive">Inactif</label>
                    </div>

                    <div class="eachAdvert" v-for="advertFavorite in filteredList" :key="advertFavorite.id">
                        <div class="close time" @click="deleteFavorite(advertFavorite.id)"><font-awesome-icon :icon="['fas', 'times']" /></div>
                        <div class="close edit "><inertia-link :href="`/modeEdition/${advertFavorite.slug}`"><font-awesome-icon :icon="['fas', 'pencil-alt']" /></inertia-link></div>
                        <div class="subCategory">
                            <h3>{{advertFavorite.title}}</h3>
                            <span>Localisation: <b>{{advertFavorite.city.name}}</b></span><br>
                            <span>Catégorie: <b>{{advertFavorite.category.name}}</b></span><br>
                            <span>Sous-catégorie: <b>{{advertFavorite.sub_category.name}}</b></span><br>
                            <span>Etat: <b>{{advertFavorite.is_active === 1 ? "Actif" : "Inactif"}}</b></span>
                            <h4><b>Publiée</b> {{ convertDate(advertFavorite.publication_date) }} </h4>
                            <p>{{advertFavorite.content}}</p>
                        </div>
                    </div>
                </div>
                <div v-else class="eachAdvert">
                    <p class="fail">Vous n'avez pas d'annonces postées</p>
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
    name: "AdminAdvert",
    components:{
        AppLayout
    },
    props:{
        myAdverts:Array
    },
    data(){
        return{
            searchMyAdvert:'',
            searchMyAdvertCity:'',
            status:"null",
            dataAd:this.myAdverts,
        }
    },
    computed:{
        filteredList() {
            if (this.searchMyAdvert !==''){
                return this.dataAd.filter(advert => {
                    return advert.title.toLowerCase().includes(this.searchMyAdvert.toLowerCase())
                })
            }
            if (this.searchMyAdvertCity !== ''){
                return this.dataAd.filter(advert => {
                    return advert.city.name.toLowerCase().includes(this.searchMyAdvertCity.toLowerCase())
                })
            }
            if (this.status === 'active'){

                return this.dataAd.filter(advert => {
                    return advert.is_active === 1
                })
            }
            if (this.status === 'inactive'){

                return this.dataAd.filter(advert => {
                    return advert.is_active === 0
                })
            }
            else{
                return this.dataAd
            }

        }
    },
    methods:{
        convertDate(dateAdvert) {
            return moment(dateAdvert).startOf('day').locale("fr").fromNow();
        },
        deleteFavorite(idAdvert){
            Inertia.visit('/myAdvert', {
                method: 'delete',
                data: {
                    user_id_advert:this.$page.user.id,
                    id:idAdvert
                },
            })
        },
    }
}
</script>

<style scoped>
.edit{
    top: 35px;
    color: #ee9d06;
}
.inputSearch{
    padding: 10px;
    width: 260px;
    border: 1px solid gray;
    border-radius: 6px;
}
.eachAdvert{
    position: relative;
}
.close{
    position: absolute;
    right: 0;
    margin: 7px 12px;
    font-size: 20px;
}
.time{
    color: red;
}
.p-1{
    padding: 15px;
}
h1{
    color: green;
    font-size: 20px;
    text-align: center;
}
span, .fail{
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
