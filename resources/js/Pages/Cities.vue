<template>
    <div>
        <navCraiglist :userConnected="infoUserFavorite" />
        <div>
            <h2 class="p-3" >Toutes les villes de France</h2>
            <section class="sectionCities" >
                <inertia-link v-for="city in cities" :key="city.id" :href="`/${city.slug}`">
                    <div class="posRelative">
                        <img :src="city.picture" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">{{ city.name }}</p>
                            <p class="zipcode">{{city.zipcode}}</p>
                        </div>
                    </div>
                </inertia-link>
            </section>
        </div>
    </div>
</template>

<script>
import inputCustom from './../Jetstream/Input'
import btnCustom from './../Jetstream/Button'
import navCraiglist from "./navCraiglist"

export default {
    name: "Cities",
    props:{
        cities:Array,
        infoUserFavorite:Object
    },
    components:{
        inputCustom,
        btnCustom,
        navCraiglist
    }
}
</script>

<style lang="css" scoped>
    .navLink{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background-color: #718096;
        flex-wrap: wrap;
    }
    .white{
        color: whitesmoke;
        font-size: 20px;
    }
    .white:focus{
        color: black;
    }
    .sectionCities{
        display: grid;
        justify-content: center;
        grid-gap: 50px;
        grid-template-columns: repeat(auto-fit, 360px);
        margin: 20px 15px;
    }
    .posRelative{
        position: relative;
        display: flex;
    }
    .sectionCities a{
        display: flex;
    }
    .card-body{
        position: absolute;
        background-color: rgba(255, 69, 0, 0.4);
        width: 100%;
        /*border-radius: 6px;*/
        height: 100%;
    }
    .card-text{
        position: absolute;
        width: 100%;
        height: 100%;
        color: whitesmoke;
        display: flex;
        justify-content: center;
        font-size: 30px;
        align-items: center;
    }
    .card-img-top{
        /*border-radius: 6px;*/
        object-fit: cover;
    }
    .zipcode{
        color: whitesmoke;
        font-weight: bold;
        padding: 5px;
    }
</style>
