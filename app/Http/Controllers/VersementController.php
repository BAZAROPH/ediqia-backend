<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Compte;
use App\Models\Versement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VersementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user()->entreprise_id;
        $versements = Versement::where('entreprise_id', $auth)->get();
        return response()->json([ $versements,  'versement collectés avec success'], 200);
        $compte = Versement::where('entreprise_id', $auth)->select('compte_id')->get();
            $compte_name=[];

            for ($i=0; $i <count($versements) ; $i++) {
               $id_compte=$versements[$i]->compte_id;
               $libelle = Compte::where('id', $id_compte)->select('id','libelle')->get();
               array_push($compte_name,$libelle);
            }

            activity()
            //->performedOn($web)
           ->log('Versement-Index')
           // ->causedBy(Auth::user()->id)
           ->subject(2)
           ->withProperties(['test' => 'value']);


       return response()->json([ $versements,  $compte_name, 'versement collectés avec success'], 200);

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
        $comptes = Compte::where('entreprise_id', $auth)->get();
        //dd($auth);

        activity()
        //->performedOn($web)
       ->log('Versement-create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

       return response()->json($comptes, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'montant'=>['required'],
            'compte_id'=>['required'],
        ]);

        $versements = Versement::create([
            'montant'=>$request->montant,
            'compte_id'=>$request->compte_id,
            'facture_id'=>$request->facture_id,
            'emprunt_id'=> $request->emprunt,
            'moyen_paiement_id'=> $request->moyen_paiement_id,
            'user_id'=> Auth::user()->id,
            'echeancier_id '=> $request->echeancier_id ,
            'entreprise_id'=> Auth::user()->entreprise_id,
        ]);

        activity()
        //->performedOn($web)
       ->log('Versement-store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);


        return response()->json([$versements,'versement inseré avec success' ],200);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
        activity()
        //->performedOn($web)
       ->log('Versement-show')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        

        $versements = Versement::find($request->id);

        activity()
        //->performedOn($web)
       ->log('Versement-edit')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json($versements, 200);

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
            'montant'=>['required'],
            'facture_id'=>['required'],
            'compte_id'=>['required'],
        ]);

        //$versements = Versement::findOrFail($request->id)->update($request->all());
       // return response()->json([$versements,'modifié avec success'], 200);


        // $versements = Versement::findOrFail($id)->update($request->all());
        $versements = Versement::findOrFail($request->id)->update([
            'montant'=>$request->montant,
            'compte_id'=>$request->N°compte,
            'facture_id'=>$request->facture_id,
            'emprunt_id'=> $request->emprunt_id,
            'moyen_paiement_id'=> $request->moyen_paiement_id,
            'user_id'=> Auth::user()->id,
            'echeancier_id '=> $request->echeancier_id ,
            'entreprise_id'=> Auth::user()->entreprise_id,
        ]);

        activity()
        //->performedOn($web)
       ->log('Versement-store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

       return response()->json([ 'message'=>'Modifier avec success']);



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
        $versement = Versement::find($request->id)->first();

        $versements = Versement::find($request->id)->delete();

       



        activity()
        //->performedOn($web)
       ->log('Versement-destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'versement'=>$versement,
            'message' => 'Compte Supprimé avec success'],
             200);

    }
}
