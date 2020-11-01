<template>
    <div class="center examplex">
        <vs-navbar color="#ff6500" class="custom" text-white square center-collapsed>
            <template #left>
                <inertia-link :href="`/`">
                    <p>Craiglist</p>
                </inertia-link>
            </template>
            <template #right>
                <a v-if="userConnected === null" :href="route('login')">
                    <vs-button color="#fff" flat >Login</vs-button>
                </a>
                <a v-if="userConnected === null" :href="route('register')">
                    <vs-button color="#fff" border >Register</vs-button>
                </a>
                <inertia-link v-if="userConnected !== null"  :href="`/dashboard`">
                    <vs-button color="#fff" border >Dashboard</vs-button>
                </inertia-link>
                <input class="inputReseach" type="search" v-model="researchAdvert" @keyup.enter="researchAd">
            </template>
        </vs-navbar>
    </div>
</template>

<script>
import btnCustom from "../Jetstream/Button";
import {Inertia} from "@inertiajs/inertia";
export default {
    name: "navCraiglist",
    components:{
        btnCustom
    },
    props:{
        userConnected:Object
    },
    data(){
        return{
            researchAdvert:null
        }
    },
    methods:{
        string_to_slug (str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            const from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            const to = "aaaaeeeeiiiioooouuuunc------";
            for (let i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

            return str;
        },
        researchAd(){
            Inertia.visit("/search?title="+this.string_to_slug(this.researchAdvert), { method: 'get' })
        }
    },
}
</script>

<style scoped>
.inputReseach {
    color: black;
    margin-left: 5px;
    padding: 5px;
    border-radius: 6px;
    outline: none;
    font-weight: bold;
}
.inputReseach:focus{
    background-color: #bcffbc;
}
.custom{
    padding: 5px;
}
</style>
