<template>
    <div class="mt">
        <navCraiglist :userConnected="infoUserFavorite" />

        <h4 class="not-margin">
            Votre <b>Message</b> sur l'annonce <b>{{advertSelected.title}}</b>
        </h4>

        <div class="center content-inputs">
            <div style="display: flex;justify-content: space-between">
                <vs-input style="margin: 5px 1px" type="text" dark v-model="firstName" placeholder="Nom">
                    <template #icon>
                        <font-awesome-icon :icon="['fas', 'user']" />
                    </template>
                </vs-input>

                <vs-input style="margin: 5px 1px" type="text" dark v-model="lastName" placeholder="Prenom">
                    <template #icon>
                        <font-awesome-icon :icon="['fas', 'user']" />
                    </template>
                </vs-input>
            </div>
        </div>

        <div class="con-form">
            <vs-input dark block type="email" v-model="email" placeholder="Votre e-mail">
                <template #icon>
                    @
                </template>
            </vs-input>
        </div>

        <div class="con-form">
            <vs-input style="margin: 5px 0" type="text" dark block v-model="subject" placeholder="Sujet" />
        </div>

        <div class="con-form">
            <vs-input style="margin: 5px 0;" type="text" dark block v-model="msg" placeholder="Votre message" />
        </div>

        <div class="footer-dialog">
            <vs-button color="medium" @click="responseToAdvert" block>
                Envoyer
            </vs-button>
        </div>

        <p v-if="type === 1" class="success mtMsg">
            {{messageReturn}}
        </p>

        <p v-else class="failed mtMsg">
            {{messageReturn}}
        </p>
    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import navCraiglist from "./navCraiglist"

export default {
    name: "ResponseAdvert",
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
            subject:'',
            msg:'',
        }
    },
    methods:{
        responseToAdvert(){
            let urlAdSelected = `/${this.advertSelected.city.slug}/${this.advertSelected.category.slug}/${this.advertSelected.sub_category.slug}/${this.advertSelected.slug}/response`
            Inertia.visit(urlAdSelected, {
                method: 'post',
                data: {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    mail: this.email,
                    subject: this.subject,
                    message:this.msg,
                    titleAd: this.advertSelected.title,
                    nameUser: this.advertSelected.user.name,
                    emailUserAd:this.advertSelected.user.email
                },
            })
        },
    },
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
