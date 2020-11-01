<template>
    <div class="marginMultiDirectionnel">
        <navCraiglist :userConnected="infoUserFavorite" />
        <h1> {{ resultSearch.length > 1 ? "Résultats" : "Résultat" }} de la recherche sur <b>{{titleResearch}}</b> ({{resultSearch.length}})</h1>
        <section>
            <inertia-link v-for="advert in resultSearch" :key="advert.id" :href="`/${advert.slug_city}/${advert.slug_category}/${advert.slug_subcategory}/${advert.slug}`">
                <div class="subCategory">
                    <h3>{{advert.title}}</h3>
                    <h4><b>Publiée</b> {{ convertDate(advert.publication_date) }} </h4>
                    <span>Localisation: <b>{{advert.city.name}}</b></span><br>
                    <span>Catégorie: <b>{{advert.category.name}}</b></span><br>
                    <span>Sous-catégorie: <b>{{advert.subcategory.name}}</b></span>
                    <p>{{advert.content}}</p>
                </div>
            </inertia-link>
        </section>
    </div>
</template>

<script>
import navCraiglist from "./navCraiglist"
import moment from "moment";
export default {
    name: "Search",
    props:{
        resultSearch:Array,
        titleResearch:String,
        infoUserFavorite:Object
    },
    components:{
        navCraiglist
    },
    methods: {
        convertDate(dateAdvert) {
            return moment(dateAdvert).startOf('day').locale("fr").fromNow();
        },
    },
    mounted() {
        console.log(this.resultSearch)
    }
}
</script>

<style scoped>
.marginMultiDirectionnel{
    margin: 60px auto 25px;
    width: 57%;
}
h1{
    color: green;
    font-size: 20px;
    text-align: center;
}
h2{
    font-size:35px;
}
span{
    color: #861d1d;
}
h3{
    font-weight: bold;
}
.subCategory{
    padding: 15px;
    background-color: #dedede;
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
