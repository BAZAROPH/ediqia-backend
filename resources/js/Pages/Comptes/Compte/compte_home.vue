<template>
    <app-layout>

        <div class="col-lg-10 layout-spacing mx-auto mt-3">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="row">
                        <div class="col-lg-12 col-12 mx-auto">
                            
                                <jet-validation-errors class="text-center mb-4" />

                                <div class="container">

                              <div class="title-box">
                                    <h2>Comptes</h2>
                               </div>
                               <form @submit.prevent="createtype" id="compte" >
                                     <button type="button" class="btn btn-primary float-right mb-6" data-toggle="modal" data-target="#myModal"><b>+</b>  Creer </button>
                             </form>

                                <!-- <Link class="btn btn-primary btn-nueva float-right mb-3" :href="route('typeparametre.create')"><b>+</b> Creer </Link><br/> -->

                                <table class="table table-bordered grocery-crud-table table-hover mt-3">
                                    <thead>
                                    <tr>
                                        <th>N0 </th>
                                        <th>N° de compte</th>
                                        <th>Libelle</th>
                                        <th>Sold</th>
                                        <th>Description</th>
                                        <th colspan="2">  </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(datas,i) in comptes" :key="datas.id" >
                                            <td>{{ ++i }}  </td>
                                             <td>{{ datas.numero_compte }}</td>
                                             <td>{{ datas.libelle }}</td>
                                             <td>{{ datas.solde }}</td>
                                             <td>{{ datas.description }}</td>

                                             <td class="text-center">

                                                 <!-- <button type="button" class="btn btn-outline-success float-left" data-toggle="modal" :data-target="'#Editer'+data.id"> <i class="icofont-edit"> </i></button> -->
                                                   <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#edit'+datas.id" ><b>+</b> <i class="icofont-edit bg-succes"> </i>  </button>
                                                  



                                                 <!-- <Link class="btn btn-default btn-outline-dark mr-3" :href="'/type-parametre/edit/'+datas.id"><i class="icofont-edit bg-succes"> </i> </Link> -->
                                                 </td>
                                             <td class="text-center"> <button @click="destroy(datas.id)" class="btn btn-default btn-outline-dark btn-danger"><i class="icofont-ui-delete bg-danger"></i> </button></td>
                                            <!--<td class="text-center"> <Link class="btn btn-default btn-outline-dark btn-danger" :href="'/type-parametre/destroy/'+datas.id "> <i class="icofont-ui-delete bg-danger"></i></Link> </td>-->
                                        </tr>

                                    </tbody>
                                    
                                </table>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>




            <!-- The Modal creer    -->
                <!-- CREER -->
                    <div class="modal" id="myModal" >
                        <div class="modal-dialog  modal-xl">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                            <h3 class="text-white"><center>Ajouter un echeancier</center></h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form refs="anyName" @submit.prevent="createtype" >

                                    <jet-validation-errors class="text-center mb-4" />
                                    <jet-validation-Success class="text-center mb-4" />

                                    <div class="form-group">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>N° de Compte </p>
                                                <label for="e-text" class="sr-only">N° de Compte</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="libelle" v-model="form.numero_compte" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Libelle<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only"></label>
                                                <input type="text" class="form-control" name="libelle" id="icon" placeholder="fa fa-home" v-model="form.libelle ">
                                            </div>
                                        </div>
                                    </div><!-- end 1-->
                                     <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Solde</p>
                                                <label for="e-text" class="sr-only">Date</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="date" v-model="form.solde" >
                                            </div>
                                        </div>
                                    </div><!-- end 2-->
                                    <div>
                                        <p>Description<span class="text-danger">*</span></p>
                                        <label for="comment" class="sr-only">Description</label>
                                        <div class="form-group" >
                                            <textarea class="form-control" rows="5" id="description" name="description" v-model="form.description"></textarea>
                                        </div>
                                    </div><!-- end 2-->
                                    <div class="row">
                                            <!--<button class="Btn btn-primary" type="submit">Enregistrer</button>-->
                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                       Valider
                                    </jet-button>
                                    </div>
                                </div>


                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                        </div>
                    </div>
                    <!-- The Modal CREER  -->
                <!-- CREER -->





                <!-- The Modal  editer -->
                <!-- editer -->
                
                    <div class="modal" :id="'edit'+edits.id" v-for="edits in comptes_edits" :key="edits.id">
                        <div class="modal-dialog  modal-xl">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header modal-header-border-bottom text-lavande bg-indigo">
                            <h3 class="text-white"><center>Editer Compte </center></h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form refs="anyName" @submit.prevent="update(edits)">

                                    <jet-validation-errors class="text-center mb-4" />
                                    <jet-validation-Success class="text-center mb-4" />

                                     <div class="form-group">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p>N° de Compte  1</p>
                                                <label for="e-text" class="sr-only">N° de Compte </label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="libelle" v-model="edits.numero_compte" >
                                            </div>
                                            <div class="col-lg-6">
                                                <p>Lielle<span class="text-danger">*</span></p>
                                                <label for="e-text" class="sr-only"></label>
                                                <input type="text" class="form-control" name="icon" id="icon" placeholder="fa fa-home" v-model="edits.libelle">
                                            </div>
                                        </div>
                                    </div><!-- end 1-->
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>Solde</p>
                                                <label for="e-text" class="sr-only">Solde</label>
                                                <input id="libelle" type="text" placeholder="" class="form-control" name="date" v-model="edits.solde" >
                                            </div>
                                        </div>
                                    </div><!-- end 2-->
                                    <div>
                                        <p>Description<span class="text-danger">*</span></p>
                                        <label for="comment" class="sr-only">Description</label>
                                        <div class="form-group" >
                                            <textarea class="form-control" rows="5" id="description" name="description" v-model="edits.description"></textarea>
                                        </div>
                                    </div><!-- end 2-->
                                    <div class="row">
                                            <!--<button class="Btn btn-primary" type="submit">Enregistrer</button>-->
                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                       Valider
                                    </jet-button>
                                    </div>
                                </div>



                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                        </div>
                    </div>
                    <!-- The Modal EDITER -->
                <!-- Editer -->



      


























    </app-layout>
 </template>


 <script>
     import { Head, Link } from '@inertiajs/inertia-vue3'
     import AppLayout from '@/Layouts/AppLayout.vue'
     import JetButton from '@/Jetstream/Button.vue'
     import JetValidationSuccess from '@/Jetstream/ValidationSuccess.vue'
     import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'


    export default{
        components:{
            Link,
            AppLayout,
            JetButton,
            JetValidationErrors,
            JetValidationSuccess,

        },
         mounted(){console.log(data1)}, 

        props: ['compte','comptes','comptes_edits'],
        data()
        {
            return {
                form:{
                    libelle:'',
                    description:'',
                    icon:'',
                    date:'',
                    montant:'',



                },
                 i:1,
            }
        },

         methods:{
            createtype()
            {
               
                this.$inertia.post(this.route('compte.store'),this.form);
            },

            destroyrf(id){
                this.$inertia.delete('/compte/destroy/'+id);
            },

            update(comptes_edits){
               
                 this.$inertia.patch('/compte/update/{id}'+comptes_edits.id,comptes_edits);
                  console.log(echeancier);
            },
            destroy(id) {
                Swal.fire({
                    title: "Es-tu sûr?",
                    text: "Vous ne pourrez pas revenir en arrière !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085D6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, supprimez-le !",
                    cancelButtonText: "Annuler",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.delete('/compte/destroy/'+id);
                        Swal.fire("Votre fichier a été supprimé.", "Succès");
                    }
                });
            },

        
        }
    }
 </script>
