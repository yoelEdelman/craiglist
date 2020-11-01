<template>
    <div class="marginMultiDirectionnel">
        <navCraiglist :userConnected="infoUserFavorite" />

        <section v-if="changeDisplay">
            <h1>Catégorie: {{categorySelected.name}}</h1>
            <h2><b>{{cityPosition.name}}</b></h2>
            <inertia-link v-for="advert in adverts.data" :key="advert.id" :href="`/${advert.city.slug}/${advert.category.slug}/${advert.sub_category.slug}/${advert.slug}`">
                <div class="subCategory">
                    <h3>{{advert.title}}</h3>
                    <h4><b>Publiée</b> {{ convertDate(advert.publication_date) }} </h4>
                    <span>Sous-catégorie: <b>{{advert.sub_category.name}}</b></span>
                    <p>{{advert.content}}</p>
                </div>
            </inertia-link>

            <div class="chevron">
                <button @click="paginateCategory(1)"  :disabled="adverts.current_page === 1">
                    <font-awesome-icon :icon="['fas', 'angle-double-left']" />
                </button>
                <button @click="paginateCategory(adverts.current_page -=1)"  :disabled="adverts.current_page === 1">
                    <font-awesome-icon :icon="['fas', 'chevron-left']" />
                </button>

                <span><b>{{adverts.current_page}} / {{adverts.last_page}}</b></span>

                <button @click="paginateCategory(adverts.current_page +=1)" :disabled="adverts.current_page === adverts.last_page">
                    <font-awesome-icon :icon="['fas', 'chevron-right']" />
                </button>

                <button @click="paginateCategory(adverts.last_page)"  :disabled="adverts.current_page === adverts.last_page">
                    <font-awesome-icon :icon="['fas', 'angle-double-right']" />
                </button>
            </div>
        </section>

        <section v-else>
            <h1>Catégorie: {{categorySelected.name}}</h1>
            <h1>Sous-Catégorie: {{subCategorySelected.name}}</h1>
            <h2><b>{{cityPosition.name}}</b></h2>
            <inertia-link v-for="advert in switchBetweenAd.data" :key="advert.id" :href="`/${advert.city.slug}/${advert.category.slug}/${advert.sub_category.slug}/${advert.slug}`">
                <div class="subCategory">
                    <h3>{{advert.title}}</h3>
                    <h4><b>Publiée</b> {{ convertDate(advert.publication_date) }} </h4>
                    <p>{{advert.content}}</p>
                </div>
            </inertia-link>

            <div class="chevron">
                <button @click="paginateAdvert(1)"  :disabled="switchBetweenAd.current_page === 1">
                    <font-awesome-icon :icon="['fas', 'angle-double-left']" />
                </button>
                <button @click="paginateAdvert(switchBetweenAd.current_page -=1)"  :disabled="switchBetweenAd.current_page === 1">
                    <font-awesome-icon :icon="['fas', 'chevron-left']" />
                </button>

                <span><b>{{switchBetweenAd.current_page}} / {{switchBetweenAd.last_page}}</b></span>

                <button @click="paginateAdvert(switchBetweenAd.current_page +=1)" :disabled="switchBetweenAd.current_page === switchBetweenAd.last_page">
                    <font-awesome-icon :icon="['fas', 'chevron-right']" />
                </button>

                <button @click="paginateAdvert(switchBetweenAd.last_page)"  :disabled="switchBetweenAd.current_page === switchBetweenAd.last_page">
                    <font-awesome-icon :icon="['fas', 'angle-double-right']" />
                </button>
            </div>
        </section>
    </div>
</template>

<script>
import navCraiglist from "./navCraiglist"
import moment from "moment"
import { Inertia } from '@inertiajs/inertia'

export default {
    name: "Advert",
    components:{
        navCraiglist
    },
    props:{
        adverts:Object,
        categorySelected:Object,
        cityPosition:Object,
        subCategorySelected:Object,
        changeDisplay:Boolean,
        switchBetweenAd:Object,
        infoUserFavorite:Object
    },
    methods:{
        convertDate(dateAdvert) {
            return moment(dateAdvert).startOf('day').locale("fr").fromNow();
        },
        paginateAdvert(pageNumber){
            //const regex =/\/[a-z0-]+/g
            //this.switchBetweenAd.path.match(regex)
            let $url =this.switchBetweenAd.path
            /*let arrayUrl = this.switchBetweenAd.path.match(regex)
            let newUrl = ""

            arrayUrl.forEach(url => {
                newUrl = newUrl + url
            })*/
            Inertia.visit(`${$url}?page=`+pageNumber, { method: 'get' })
        },
        paginateCategory(pageNumber){
            // const regex =/\/[a-z0-]+/g
            let $url =this.adverts.path
            /*let arrayUrl = this.adverts.path.match(regex)
            let newUrl = ""

            arrayUrl.forEach(url => {
                newUrl = newUrl + url
            })*/
            Inertia.visit(`${$url}?page=`+pageNumber, { method: 'get' })
        }
    },
}
</script>

<style scoped lang="css">
.chevron{
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    margin-top: 10px;
}
.marginMultiDirectionnel{
    margin: 60px auto 25px;
    width: 57%;
}
h1{
    color: green;
    font-size: 20px;
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
button {
    background-color: #ff6500;
    color: whitesmoke;
    border: 1px solid #ff6500;
    border-radius: 6px;
    padding: 7px 15px;
    outline: none;
}
button:hover{
     background-color: rgba(255, 69, 0, 0.4);
 }
button:disabled{
     color: #ffffff;
     background-color: #8a8a94;
     border: 1px solid #8a8a94;
}
</style>
