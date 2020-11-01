<template>
    <div class="margin">
        <navCraiglist :userConnected="infoUserFavorite" />

        <header>
            <h1>{{advertSelected.title}}</h1>
            <h3 v-if="advertSelected.category.name">Categorie : {{advertSelected.category.name}}</h3>
            <h3 v-if="advertSelected.sub_category.name">Sous-catégorie : {{advertSelected.sub_category.name}}</h3>
            <div class="informationDate">
                <h4>Publiée le {{convertDate(advertSelected.publication_date)}}</h4>
                <h4>Mise à jour le : {{convertDate(advertSelected.update_date)}}</h4>
            </div>
            <div class="informationDate">
                <h5>Localisation de l'annonce : {{advertSelected.city.name}}</h5>
                <h5>Auteur : {{advertSelected.user.name}}</h5>
            </div>
        </header>

        <section class="qrcodePrint">
            <div v-if="advertSelected.picture">
                <img :src="advertSelected.picture" alt="">
            </div>
            <p>{{advertSelected.content}}</p>
            <QrcodeVue class="print-only" :value="urlValue" :size="sizeQrCode" level="H"></QrcodeVue>

            <button @click="printAd" class="btnPrint"><font-awesome-icon :icon="['fas', 'print']" /> Imprimer</button>

            <inertia-link :href="`/${advertSelected.city.slug}/${advertSelected.category.slug}/${advertSelected.sub_category.slug}/${advertSelected.slug}/response`">
                <button class="btnPrint"><font-awesome-icon :icon="['fas', 'envelope']" /> Répondre par mail</button>
            </inertia-link>

            <inertia-link :href="`/${advertSelected.city.slug}/${advertSelected.category.slug}/${advertSelected.sub_category.slug}/${advertSelected.slug}/share`">
                <button class="btnPrint"><font-awesome-icon :icon="['fas', 'share-alt']" /> Partager </button>
            </inertia-link>

            <button @click="addToFavorites" v-if=" this.checkUserConnected !== null && this.statusFavorite === false" class="btnPrint"><font-awesome-icon :icon="['fas', 'star']" /> Ajouter aux favoris </button>
            <span class="stillFavorite" v-if=" this.checkUserConnected !== null && this.statusFavorite"><font-awesome-icon :icon="['fas', 'star']" /> Déjà dans vos favoris !</span>

            <div v-if="type">
                <p v-if="type === 1" class="success mt">
                    {{messageReturn}}
                </p>
                <p v-if="type === 0" class="failed mt">
                    {{messageReturn}}
                </p>
            </div>
        </section>
    </div>
</template>

<script>
import navCraiglist from "./navCraiglist"
import moment from "moment";
import QrcodeVue from 'qrcode.vue'
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "AdvertSelected",
    components:{
        navCraiglist,
        QrcodeVue
    },
    data(){
        return{
            sizeQrCode:140,
            urlValue:window.location.href,
            statusFavorite: false,
        }
    },
    props:{
        advertSelected:Object,
        type:Number,
        messageReturn:String,
        status:Number,
        checkUserConnected:Object,
        infoUserFavorite:Object
    },
    methods:{
        convertDate(dateAdvert){
            return moment(dateAdvert).locale("fr").format('Do MMMM YYYY')
        },
        printAd(){
            window.print();
        },
        async addToFavorites(){
            this.activeFuncStatus = true
            let urlAdSelected = `/${this.advertSelected.city.slug}/${this.advertSelected.category.slug}/${this.advertSelected.sub_category.slug}/${this.advertSelected.slug}`
            await Inertia.visit(urlAdSelected, {
                method: 'post',
                data: {
                    user_id_connected: this.checkUserConnected.id,
                    advert_slug: this.advertSelected.slug,
                },
            })
            .then(() =>{

            })
        },
        checkIfUserHasStillFavorite(slugAdvert){
            if (this.checkUserConnected !== null){
                this.infoUserFavorite.advert_favorite.forEach(element =>{
                    if (slugAdvert === element.advert_slug){
                        this.statusFavorite = true
                    }
                })

            }
        }
    },
    mounted() {
        this.checkIfUserHasStillFavorite(this.advertSelected.slug)
    }
}
</script>

<style scoped>
.stillFavorite{
    color: orange;
}
.mt{
    margin-top: 15px;
}
.success{
    color: green;
}
.failed{
    color: red;
}
.margin{
    width: 65%;
    margin: 60px auto 60px;
    max-width: 960px;
}
h1{
    font-size: 27px;
    font-weight: bold;
    color: #808080;
}
h3{
    font-size: 17px;
    color: #526796;
}
h4{
    color: #719a95;
}
h5{
    font-size: 14px;
    color: #ac6006;
}
.informationDate{
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
section{
    margin-top: 10px;
}
.print-only {
     display: none;
 }
.btnPrint{
    margin-top: 20px;
    border-radius: 6px;
    color:whitesmoke;
    background-color: #ff6500;
    border: none;
    padding: 8px;
    font-size:13px;
    outline: none;
}
.btnPrint:hover{
    color:#1a202c;
    background-color: rgba(255, 69, 0, 0.4);
    border:1px solid #ff6500;
}
@media print{
    .print-only {
        margin-top: 40px;
        display: block;
    }
    .btnPrint{
        display:none;
    }
    .stillFavorite{
        display: none;
    }
    .success{
        display: none;
    }
}
</style>
