<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Compte;
use App\Models\Emprunt;
use App\Models\Parametre;
use Illuminate\Http\Request;
use App\Models\Remboursement;
use App\Models\TypeParametre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmpruntController extends Controller
{
    function __construct()
    {
        //    //les permissions
        //    $this->middleware('permission:index-emprunt', ['only' => ['index']]);  //  
        //    $this->middleware('permission:show-emprunt', ['only' => ['index']]);
        //    $this->middleware('permission:create-emprunt', ['only' => ['store']]);
        //    $this->middleware('permission:update-emprunt', ['only' => ['update']]);
        //    $this->middleware('permission:delete-emprunt', ['only' => ['destroy']]);

        //     //les roles
        //    $this->middleware('role:gestionnaire', ['only' => ['store','index','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
        $emprunt = Emprunt::with([
            'remboursements',
        ])
        ->where('entreprise_id',Auth::user()->entreprise_id)->get();

        $remboursements = Remboursement::with([
            'emprunt',
        ])
        ->where('entreprise_id',Auth::user()->entreprise_id)->get();

        // $emprunt1 = DB::table('emprunts')
        // ->join('remboursements', 'emprunts.id', '=', 'remboursements.emprunt_id')
        // //->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        // ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        // ->select('emprunts.,remboursements.')
        // ->get();


        $user = DB::table('users')
        ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
        ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        ->select('users.*',)
        ->get();





        $auth = Auth::user()->entreprise_id;
        $comptes = Compte::where("entreprise_id",$auth)->get();
        //$users = User::where("entreprise_id",$auth)->get();
        $creanciers = User::whereNotNull('creancier_id')
                    ->where('entreprise_id',$auth );

        //  $type_creancier = Parametre::where('type_parametre_id',11)->get();

        // $type_creancier= TypeParametre::where('libelle',"TypeCreancier")
        // ->first();
        // $id_typecreancier=$type_creancier->id;
        // $type_creancier= Parametre::where("type_parametre_id",$id_typecreancier)->get();

        $TypeCreancier = TypeParametre::whereLibelle('type creancier')->first();
        $TypeCreancierId = $TypeCreancier->id;

        $creancierList = Parametre::where('type_parametre_id',$TypeCreancierId)
        ->whereStatus('admin')
        // ->orWhere('entreprise_id',Auth::user()->entreprise_id,)
        ->get();

        //  $creanciers = DB::table('users')
        //     ->join('entreprise_user', 'entreprise_user.user_id', '=', 'users.id')
        //     ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        //     ->where('entreprises.id',Auth::user()->entreprise_id)
        //     ->whereNotNull('users.type_user_creancier')
        //     ->select('users.*')
        //     ->get();

            $emprunt = DB::table('emprunts')->where('entreprise_id',Auth::user()->entreprise_id)->get();


        activity()
        //->performedOn($web)
       ->log('Emprunt-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
           'entreprise_connecte'=> Auth::user()->entreprise_id,
            'remboursements'=>$remboursements,
            // 'emprunt'=>$emprunt,
            'user'=>$user,
            'creanciers'=>$creanciers,
            'type_creancier'=>$creancierList,
            'auth'=>$auth,
            'compte'=>$comptes,
            // 'users'=>$users,
            'emprunts'=>$emprunt,
            'message' => 'Emprunts collecté avec success',
        ]);

       // return Inertia::render('Comptes/Emprunts/Emprunt');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $auth = Auth::user()->entreprise_id;
        $cmpt = Compte::where("entreprise_id",$auth)->get();
        $emprunts = Emprunt::all();

        $TypeCreancier = TypeParametre::whereLibelle('type creancier')->first();
        $TypeCreancierId = $TypeCreancier->id;

        $creancierList = Parametre::where('type_parametre_id',$TypeCreancierId)
        ->whereStatus('admin')
        // ->orWhere('entreprise_id',Auth::user()->entreprise_id,)
        ->get();

        activity()
        //->performedOn($web)
       ->log('Emprunt-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            Auth::user()->entreprise_id,
            'creancierList'=>$creancierList,
            'compte'=>$cmpt,
            'auth'=>$auth,
            'emprunts'=>$emprunts,
            'message' => 'Emprunts collecté avec success',
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation emprunt
        $request->validate([
            'libelle' => ['required'],
            'montant' => ['required'],
            'taux' => ['required'],
            // 'delai' => ['required'],
            'date_emprunt' => ['required'],
            'date_remboursement' => ['required'],
            'creancier_id'  => ['required'],
            'entreprise_id'  => ['required'],
            'compte_id'  => ['required']
        ]);

        $emprunt = Emprunt::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'montant'=> $request->montant,
            'taux'=> $request->taux,
            'delai'=> $request->delai,
            // 'versements_empr'=>$request->versements_empr,
            'date_emprunt'=>$request->date_emprunt,
            'date_remboursement'=>$request->date_remboursement,
            'creancier_id'  => $request->creancier_id,
            'entreprise_id'  =>Auth::user()->entreprise_id,
            'compte_id'  => $request->compte_id,
            'status'  => $request->status,
        ]);

        for($i=0;$i<$request->count;$i++)
        {
            Remboursement::Create([
                // 'libelle' => $request->libelle_remboursement[$i],
                // 'description' => $request->description_remboursement,

                'montant_remboursement'=> $request->item[$i]['montant'],
                // 'montant_verse'=> $request->montant_verse,
                'date_rembourement'=>$request->item[$i]['date'],
                'status'=>$request->item[$i]['status'],

                'emprunt_id'=> $emprunt->id,
                'entreprise_id'  => Auth::user()->entreprise_id,
            ]);
        }






        // $auth = Auth::user()->entreprise_id;
        // $cmpt = Compte::where("entreprise_id",$auth)->get();

        //if creancier and compte is already created   1==>(Emprunt)
        //00000000000000000000000000000000000
        // if($request->status == 1){

        //     Emprunt::create([
        //         'libelle' => $request->libelle,
        //         'description' => $request->description,
        //         'montant'=> $request->montant,
        //         'taux'=> $request->taux,
        //         'delai'=> $request->delai,
        //         'date_emprunt'=>$request->date_emprunt,
        //         'date_remboursement'=>$request->date_remboursement,
        //         'creancier_id'  => $request->creancier_id,
        //         'entreprise_id'  => Auth::user()->entreprise_id,
        //         'compte_id'  => $request->compte_id,
        //     ]);

        // }elseif($request->status == 2 ){
        //     //if creancier does not exist 1 ==>(Emprunt,Creancier)
        //         $request->validate([
        //             'nom' => ['required'],
        //             'premons' => ['required'],
        //             'contact' => 'required',
        //             //'ville' => [''],
        //         ]);

        //           //store
        //         $creancier = User::create([
        //             'nom'=> $request->nom,
        //             'premons' => $request->prenoms,
        //             'contact'=> $request->contact,
        //             'ville'=> $request->ville,
        //             'type_user_creancier'=>'creancier',
        //             'type_user '=>3,//creancier
        //         ]);

        //         //$creancier->entreprises()->detach([$creancier->id]);
        //         DB::table('entreprise_user')->insert([
        //             'entreprise_id'=> Auth::user()->entreprise_id,
        //             'user_id'=> $creancier->id,
        //         ]);

        //         // $creancier =User::create([
        //         //     'libelle' => $request->libelle,
        //         //     'description' => $request->description,
        //         //     'montant'=> $request->montant,
        //         //     'taux'=> $request->taux,
        //         //     'delai'=> $request->delai,
        //         //     'date_emprunt'=>$request->date_emprunt,
        //         //     'date_remboursement'=>$request->date_remboursement,
        //         //     'creancier_id'  => $creancier->id,
        //         //     'entreprise_id'  => Auth::user()->entreprise_id,
        //         //     //'compte_id'  => $request->compte_id
        //         // ]);

        //         Emprunt::create([
        //             'libelle' => $request->libelle,
        //             'description' => $request->description,
        //             'montant'=> $request->montant,
        //             'taux'=> $request->taux,
        //             'delai'=> $request->delai,
        //             'date_emprunt'=>$request->date_emprunt,
        //             'date_remboursement'=>$request->date_remboursement,
        //             'creancier_id'  =>$creancier->id,
        //             'entreprise_id'  => Auth::user()->entreprise_id,
        //             'compte_id'  => $request->compte_id,
        //         ]);


        // }elseif($request->status == 3 ){
        //     //if compte does not exist 2  ==>(Emprunt,compte)

        //     $request->validate([
        //         'numero_compte' => ['required'],
        //         'libelle' => 'required|unique:comptes',
        //         'description' => ['required'],
        //         'solde'  =>['required','regex:/^\d+(\.\d{1,2})?$/',]
        //     ]);


        //     $compte = Compte::create([
        //         'numero_compte' => $request->numero_compte,
        //         'libelle' => $request->libelle,
        //         'description'=> $request->description,
        //         'solde'=> $request->solde,
        //         'entreprise_id'=>Auth::user()->entreprise_id,
        //     ]);



        //     // $creancier=User::create([
        //     //     'libelle' => $request->libelle,
        //     //     'description' => $request->description,
        //     //     'montant'=> $request->montant,
        //     //     'taux'=> $request->taux,
        //     //     'delai'=> $request->delai,
        //     //     'date_emprunt'=>$request->date_emprunt,
        //     //     'date_remboursement'=>$request->date_remboursement,
        //     //     'creancier_id'  => $request->creancier_id,
        //     //     'entreprise_id'  => Auth::user()->entreprise_id,
        //     //     'compte_id'  => $compte->id
        //     // ]);

        //     Emprunt::create([
        //         'libelle' => $request->libelle,
        //         'description' => $request->description,
        //         'montant'=> $request->montant,
        //         'taux'=> $request->taux,
        //         'delai'=> $request->delai,
        //         'date_emprunt'=>$request->date_emprunt,
        //         'date_remboursement'=>$request->date_remboursement,
        //         'creancier_id'  =>$request->id,
        //         'entreprise_id'  => Auth::user()->entreprise_id,
        //         'compte_id'  => $compte->id,
        //     ]);
        // }elseif($request->status == 4 ){
        //     //if compte does not exist 2  ==>(Emprunt,compte,creancier)

        //     $request->validate([
        //         'numero_compte' => ['required'],
        //         'libelle' => 'required|unique:comptes',
        //         'description' => ['required'],
        //         'solde'  =>['required','regex:/^\d+(\.\d{1,2})?$/',]
        //     ]);


        //     $compte = Compte::create([
        //         'numero_compte' => $request->numero_compte,
        //         'libelle' => $request->libelle,
        //         'description'=> $request->description,
        //         'solde'=> $request->solde,
        //         'entreprise_id'=>Auth::user()->entreprise_id,
        //     ]);


        //        //store creancier
        //        $creancier = User::create([
        //         'nom'=> $request->nom,
        //         'premons' => $request->prenoms,
        //         'contact'=> $request->contact,
        //         'ville'=> $request->ville,
        //         'type_user_creancier'=>'creancier',
        //         'type_user '=>3,//creancier
        //     ]);

        //     //$creancier->entreprises()->detach([$creancier->id]);
        //     DB::table('entreprise_user')->insert([
        //         'entreprise_id'=> Auth::user()->entreprise_id,
        //         'user_id'=> $creancier->id,
        //     ]);

        //     // $creancier=User::create([
        //     //     'libelle' => $request->libelle,
        //     //     'description' => $request->description,
        //     //     'montant'=> $request->montant,
        //     //     'taux'=> $request->taux,
        //     //     'delai'=> $request->delai,
        //     //     'date_emprunt'=>$request->date_emprunt,
        //     //     'date_remboursement'=>$request->date_remboursement,
        //     //     'creancier_id'  => $request->creancier_id,
        //     //     'entreprise_id'  => Auth::user()->entreprise_id,
        //     //     'compte_id'  => $compte->id
        //     // ]);


        //     Emprunt::create([
        //         'libelle' => $request->libelle,
        //         'description' => $request->description,
        //         'montant'=> $request->montant,
        //         'taux'=> $request->taux,
        //         'delai'=> $request->delai,
        //         'date_emprunt'=>$request->date_emprunt,
        //         'date_remboursement'=>$request->date_remboursement,
        //         'creancier_id'  =>$creancier->id,
        //         'entreprise_id'  => Auth::user()->entreprise_id,
        //         'compte_id'  => $compte->id,
        //     ]);
        // }else{
        //     return response()->json([
        //         'message' => 'Veillez renseigner un status en 1 et 4',
        //     ]);
        // }











        //if compte does not existe  2




        activity()
        //->performedOn($web)
       ->log('Emprunt-Store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Emprunt enregistrer avec success',
        ]);

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $edit =  Emprunt::find($id);

        activity()
        //->performedOn($web)
       ->log('Emprunt-Form-Edit')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'edit' =>  $edit ,
            'message' => 'modifier avec success',
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $request->validate([
            'libelle' => ['required'],
            //'description' => ['required'],
            'montant' => ['required'],
            'taux' => ['required'],
            'delai' => ['required'],
            'date_emprunt' => ['required'],
            'date_remboursement' => ['required'],
            'creancier_id'  => ['required'],
            'entreprise_id'  => ['required'],
            'compte_id'  => ['required']
        ]);

       $emprent= Emprunt::find($request->id)->update([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'montant'=> $request->montant,
            'taux'=> $request->taux,
            'delai'=> $request->duree,
            'date_emprunt'=>$request->date_emprunt,
            'date_remboursement'=>$request->date_rembourssement,
            'creancier_id'  => $request->creancier_id,
            'entreprise_id'  => Auth::user()->entreprise_id,
            'compte_id'  => $request->compte_id,
            'status'  => $request->status,
        ]);

        // for($i=0;$i<$request->count;$i++)
        // {

        //     Remboursement::find($request->remboursement_id[$i])->update([
        //         'libelle' => $request->libelle_remboursement[$i],
        //         'description' => $request->description_remboursement, //remove for test[$i]

        //         'montant_remboursement'=> $request->montant_remboursement,
        //         'montant_verse'=> $request->montant_verse,
        //         'date_rembourement'=>$request->date_rembourement, //[$i],
        //         'status'=>$request->status[$i],// [$i],

        //         //'emprunt_id'=> $emprunt->id,
        //        // 'entreprise_id'  => Auth::user()->entreprise_id,
        //     ]);

        //     // return response()->json([
        //     //     'message' => 'Compte Modifié avec success bbbb',
        //     // ]);


        // }


        // Remboursement::find($emprent->id)->update([
        //     'libelle' => $request->libelle,
        //     'description' => $request->description,

        //     'montant_remboursement'=> $request->montant_remboursement,
        //     'montant_verse'=> $request->montant_verse,
        //     'date_rembourement'=>$request->date_rembourement,

        //     'emprunt_id'=> $request->emprunt_id,
        //     'entreprise_id'  => Auth::user()->entreprise_id,
        // ]);


        activity()
        //->performedOn($web)
       ->log('Emprunt-Update')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Compte Modifié avec success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $emprunts=Emprunt::find($request->id)->delete();

        activity()
        //->performedOn($web)
       ->log('Emprunt-Destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Compte Supprimé avec success',
        ]);
    }
}
