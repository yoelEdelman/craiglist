<template>
    <div>
        <navCraiglist :userConnected="infoUserFavorite" />

        <header>
            <img :src="city.picture" alt="">
            <div class="coverCity">
                <p>Nom: {{city.name}}</p>
                <p>Code Postal: {{city.zipcode}}</p>
            </div>
        </header>

        <section v-if="categories.length !== 0" class="sectionCategory">
            <div v-for="singleCategorySubCategory in fusionCategorySubCategory" :key="singleCategorySubCategory.id">
                <inertia-link :href="`/${city.slug}/${singleCategorySubCategory.infoCat.slug}`">
                    <div>
                        <button class="btn">{{ singleCategorySubCategory.infoCat.name }}</button>
                    </div>
                </inertia-link>

                <div class="subCategory">
                    <inertia-link v-for="singleSubCategory in singleCategorySubCategory.infoSub" :key="singleSubCategory.id" :href="`/${city.slug}/${singleCategorySubCategory.infoCat.slug}/${singleSubCategory.slug}`">
                        {{singleSubCategory.name}}
                    </inertia-link>
                </div>
            </div>

        </section>

        <section v-else class="sectionError">
            <div class="noResult">
                <p>Aucune catégorie existante pour le moment !</p>
            </div>
        </section>
    </div>
</template>

<script>
import inputCustom from './../Jetstream/Input'
import btnCustom from './../Jetstream/Button'
import navCraiglist from "./navCraiglist"

export default {
    name: "Category",
    props:{
        categories:Array,
        city:Object,
        subCategories:Array,
        infoUserFavorite:Object
    },
    data(){
        return{
            arrayCategory:this.categories,
            arraySubCategory:this.subCategories,
            fusionCategorySubCategory:[]
        }
    },
    components:{
        inputCustom,
        btnCustom,
        navCraiglist
    },
    methods:{
        fusionCAndS(){
            let obj = {
                infoCat: {},
                infoSub: []
            }

            this.arrayCategory.forEach(element => {
                let obj = {
                    infoCat: element,
                    infoSub: []
                }
                this.fusionCategorySubCategory.push(obj)
            })

            this.subCategories.forEach(subElement =>{
                this.fusionCategorySubCategory.forEach(newArray =>{
                    if (subElement.slug_category === newArray.infoCat.slug){
                        newArray.infoSub.push(subElement)
                    }
                })
            })
        }
    },
    mounted() {
        this.fusionCAndS()
    }
}
</script>

<style lang="css" scoped>
vs-navbar {
    position: initial !important;
}
.subCategory{
    display: grid;
    grid-gap: 5px;
    grid-template-columns: repeat(auto-fit, 190px);
}
.subCategory a{
    text-align: center;
    padding: 5px;
}
.subCategory a:hover{
    background: #f3ae15;
    color: whitesmoke;
}
.sectionError{
    margin: 15px 0;
}
.noResult{
    padding: 10px 30px;
    background: darkred;
    color: whitesmoke;
    border: none;
}
header{
    display: flex;
    align-items: center;
    justify-content: center;
}
.coverCity{
    position: absolute;
    color: whitesmoke;
    border: 1px solid darkgrey;
    padding: 40px;
    border-radius: 4px;
    background-color: rgba(255, 69, 0, 0.7);
    font-size: 35px;
    font-style: italic;
}
.sectionCategory{
    display: grid;
    justify-content: center;
    grid-gap: 50px;
    grid-template-columns: repeat(auto-fit, 190px);
    margin: 20px 15px;
}
header img{
    height: 270px;
    width: 100%;
    object-fit: cover;
    margin-top: 53px;
}
.btn{
    padding:10px;
    border: 1px solid gray;
    background-color: #ff6500;
    color: whitesmoke;
    /*border-radius:6px 6px 0 0;*/
    outline: none;
    width: 190px;
}
.btn:hover{
    background-color: whitesmoke;
    color: #f3ae15;
    border: 1px solid #1a202c;
}
</style>
