<template>
    <div class="mt">
        <navCraiglist :userConnected="infoUserFavorite" />

        <h4 class="not-margin">
            Partager l'<b>annonce</b> : {{advertSelected.title}}
        </h4>

        <div class="center content-inputs">
            <div style="display: flex;justify-content: space-between">
                <vs-input style="margin: 5px 1px" type="text" dark v-model="firstName" placeholder="Votre Nom">
                    <template #icon>
                        <font-awesome-icon :icon="['fas', 'user']" />
                    </template>
                </vs-input>

                <vs-input style="margin: 5px 1px" type="text" dark v-model="lastName" placeholder="Votre Prenom">
                    <template #icon>
                        <font-awesome-icon :icon="['fas', 'user']" />
                    </template>
                </vs-input>
            </div>
        </div>

        <div class="con-form">
            <vs-input dark block type="email" v-model="email" placeholder="Email destinataire">
                <template #icon>
                    @
                </template>
            </vs-input>
        </div>

        <div class="con-form">
            <vs-input style="margin: 5px 0;" type="text" dark block v-model="msg" placeholder="Votre message" />
        </div>

        <div class="footer-dialog">
            <vs-button @click="responseToShare" color="medium" block>
                Envoyer
            </vs-button>
        </div>

        <p v-if="type === 1" class="success mtMsg">
            {{messageReturn}}
        </p>

        <p v-if="type === 0" class="failed mtMsg">
            {{messageReturn}}
        </p>
    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import navCraiglist from "./navCraiglist"

export default {
    name: "ShareAdvert",
    props:{
        advertSelected:Object,
        type:Number,
        messageReturn:String,
        infoUserFavorite:Object
    },
    components:{
        navCraiglist,
    },
    data(){
        return{
            email: '',
            firstName:'',
            lastName:'',
            msg:'',
        }
    },
    methods:{
        responseToShare(){
            let urlAdSelected = `/${this.advertSelected.city.slug}/${this.advertSelected.category.slug}/${this.advertSelected.sub_category.slug}/${this.advertSelected.slug}/share`
            Inertia.visit(urlAdSelected, {
                method: 'post',
                data: {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    mail: this.email,
                    message:this.msg,
                    linkUrl:`${this.getUrl()}/${this.advertSelected.city.slug}/${this.advertSelected.category.slug}/${this.advertSelected.sub_category.slug}/${this.advertSelected.slug}`,
                    titleAd:this.advertSelected.slug
                },
            })
        },
        getUrl(){
            const regex = new RegExp(/(https?|ftp|ssh|mailto):\/\/[a-z0-9.:]+/g)
            let url = window.location.href.match(regex);
            return url['0']
        }
    }
}
</script>

<style scoped>
.mt{
    margin: 100px auto 280px auto;
    max-width: 509px;
}
.mtMsg{
    margin-top: 15px;
}
.success{
    color: green;
}
.failed{
    color: red;
}
</style>
