<template>
    <div class="marginMultiDirectionnel">
        <navCraiglist :userConnected="infoUserFavorite" />
        <h2>{{categorie.name}}</h2>
        <inertia-link v-for="subCategory in subCategories" :key="subCategory.id" :href="`/${citySelected}/${subCategory.category.name}/${subCategory.id}`">
            <div class="subCategory">
                <h3>{{subCategory.name}}</h3>
            </div>
        </inertia-link>
    </div>
</template>

<script>
import navCraiglist from "./navCraiglist"

export default {
    name: "SubCategory",
    components:{
        navCraiglist
    },
    props:{
        subCategories:Array,
        categorie:Object,
        citySelected:String,
        infoUserFavorite:Object
    }
}
</script>

<style scoped lang="css">
.marginMultiDirectionnel{
    margin: 60px auto 25px;
    width: 57%;
}
h2{
    font-size:45px;
    color: green;
}
h3{
    font-weight: bold;
}
.subCategory{
    padding: 15px;
    background-color: #b3b3b3;
    margin: 5px 0;
}
</style>
