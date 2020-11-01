<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Poster une annonce
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-1">
                    <div class="center content-inputs p-5">
                        <form @submit="formSubmit" enctype="multipart/form-data">
                            <div class="inputField">
                                <vs-input type="text" placeholder="Titre" v-model="title"/>

                                <div>
                                    <vs-select placeholder="Etat" v-model="isActive">
                                        <vs-option label="Actif" value="1">
                                            Actif
                                        </vs-option>
                                        <vs-option label="Inactif" value="0">
                                            Inactif
                                        </vs-option>
                                    </vs-select>
                                </div>

                                <div>
                                    <vs-select placeholder="Ville" v-model="citySelect">
                                        <vs-option v-for="city in cities" :key="city.id" :label="city.name" :value="city.slug">
                                            {{city.name}}
                                        </vs-option>
                                    </vs-select>
                                </div>

                                <div>
                                    <vs-select @change="changeCategory" placeholder="Categorie" v-model="categorySelected">
                                        <vs-option v-for="category in categories" :key="category.id" :label="category.name" :value="category.slug">
                                            {{category.name}}
                                        </vs-option>
                                    </vs-select>
                                </div>

                                <div v-if="dataSubCategory.length !== 0">
                                    <select v-model="subCategorySelected" name="subCategorie" id="subCategorie">
                                        <option disabled value="">Sous-categorie</option>
                                        <option v-for="subcategory in dataSubCategory" :key="subcategory.id" :value="subcategory.slug">
                                            {{subcategory.name}}
                                        </option>
                                    </select>
                                </div>
                                <vs-input type="url" v-model="urlPicture" label="Url"/>

                                <vs-input type="date" v-model="isPublished" label="Date"/>
                            </div>
                            <div>
                                <span>Description</span><br>
                                <textarea v-model="content"  rows="10" cols="140" placeholder="Contenu de l'annonce"></textarea>
                            </div>

                            <vs-button warn gradient @click="active = 3">
                                <img class="pr-2" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAABFElEQVRIS92U0XHCMBBEHxUkHQAVkBLSCaSDUEnoANJJSggdQAekApjN3GU0suSTzfiD6Mdj+7Tvdk+jGROv2cT6/E/AK7AHFiPjOwFvwJf2lyJSwXykuG+TxrIGuFrVBdgCh0bYBvgAnq3+t/mSAwe4rgACCVhaEpSwAOkKAcpxBzwB35arnul6sXnp+QO82/tf830O9E8b5WBlDtLI0kiO5kANeAKhA4crAjlZW+s+E4/k0zr3CENAbaYS9MhU45Hkh6AKyIfbGVgSmf4JmM9E3+8CtJzY0RG1iPc6cIFaVK0XY+hgckAURd9h8L1nvywj27mY6iOAxHXCqrdp6qAEiBx2L6RBOwYWRxENlOuWPz7gBo3POBm4kF6TAAAAAElFTkSuQmCC"/> Envoyer
                            </vs-button>
                        </form>
                        <p class="success" v-if="type === 1">
                            {{msg}}
                        </p>
                        <p class="failed" v-if="type === 0">
                            {{msg}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from './../Layouts/AppLayout'
import {Inertia} from '@inertiajs/inertia'
export default {
    name: "CreateAd",
    components:{
        AppLayout
    },
    props:{
        cities: Array,
        categories: Array,
        subCategories : Array,
        msg:String,
        type:Number
    },
    data(){
        return{
            title:'',
            content:null,
            isActive:'',
            isPublished:'',
            citySelect:'',
            categorySelected:'',
            subCategorySelected:'',
            selectSubCategory:this.subCategories,
            dataSubCategory:[],
            urlPicture:''
        }
    },
    methods:{
        changeCategory(){
            this.dataSubCategory = []
            this.subCategorySelected = ''
            this.selectSubCategory.forEach(subCategory =>{
                if ( this.categorySelected === subCategory.slug_category){
                    this.dataSubCategory.push(subCategory)
                }
            })
        },
        async formSubmit(e) {
            e.preventDefault();

            await Inertia.visit('/createAdvert', {
                method: 'post',
                data: {
                    title: this.title,
                    description: this.content,
                    isActive: this.isActive,
                    isPublished: this.isPublished,
                    city:this.citySelect,
                    category: this.categorySelected,
                    subCategory: this.subCategorySelected,
                    imageUrl:this.urlPicture
                },
            })
        },
    },
}
</script>

<style scoped>
.inputField{
    display: grid;
    justify-content: center;
    grid-gap: 50px;
    grid-template-columns: repeat(auto-fit, 250px);
    margin: 20px 0;
}
select{
    background-color: #f3f7f8;
    border-radius: 13px;
    padding: 10px;
    outline: none;
    width: 200px;
}
.success{
    color: green;
}
.failed{
    color: red;
}
p{
    margin-top: 10px;
}
textarea{
    border: 1px solid black;
    border-radius: 6px;
    padding: 5px;
}
</style>
