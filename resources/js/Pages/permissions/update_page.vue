<template>
    <app-layout>
        <transition>
        <div class="col-lg-8 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <h2 class="m-auto mx-5">Creation de Permission</h2><br><br>
                        <div class="col-lg-12 col-12 mx-auto">
                            <form  @submit.prevent="update(edit)" id="role" method="POST">
                                <div class="form-group">
                                    <jet-validation-errors class="text-center mb-4" />
                                    <jet-validation-Success class="text-center mb-4" />

                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Permissions</p>
                                                <label for="name" class="sr-only">Role</label>
                                                <input id="name" type="text" placeholder="Enter un role ici !" class="form-control" name="name" v-model="edit.name" >
                                            </div>
                                        </div>
                                    </div><br/><!-- end 1-->




                                    <div class="row">
                                            <!--<button class="Btn btn-primary" type="submit">Enregistrer</button>-->
                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="update(edit)">
                                       Valider
                                    </jet-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </transition>
    </app-layout>
 </template>


 <script>
     import { Head, Link } from '@inertiajs/inertia-vue3'
     import AppLayout from '@/Layouts/AppLayout.vue'
     import JetButton from '@/Jetstream/Button.vue'
     import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
     import JetValidationSuccess from '@/Jetstream/ValidationSuccess.vue'


     export default{
        components:{
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors,
            JetValidationSuccess
        },
        props: ['edit'],
        data()
        {
            return {
                form:{
                    name:'',
                }
            }
        },
        methods:{
            update(edit)
            {
                this.$inertia.patch('/permission/update/'+edit.id,edit);
            },

        }
    }
 </script>
