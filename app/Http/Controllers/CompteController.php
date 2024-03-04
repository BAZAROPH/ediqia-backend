<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Compte;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class CompteController extends Controller
{

    function __construct()
    {
        //    les permissions
        //    $this->middleware('permission:index-compte', ['only' => ['index']]);  //  
        //    $this->middleware('permission:show-compte', ['only' => ['index']]);
        //    $this->middleware('permission:create-compte', ['only' => ['store']]);
        //    $this->middleware('permission:update-compte', ['only' => ['update']]);
        //    $this->middleware('permission:delete-compte', ['only' => ['destroy']]);


            // les roles
         //  $this->middleware('role:gestionnaire', ['only' => ['store','index','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $auth = Auth::user()->entreprise_id;
        $comptes = Compte::where('entreprise_id',Auth::user()->entreprise_id)->get();


        activity()
        //->performedOn($web)
       ->log('Compte-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
           $comptes,
            // 'comptes_edits'=>$comptes,
           'Compte collecté avec success',
        ]);

        //$comptes = DB::table('comptes')->get();
        //dd($comptes);

        // return Inertia::render('Comptes/Compte/compte_home')->with(['comptes'=> $comptes,'comptes_edits'=> $comptes]);
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
        $comptes = Compte::all();


        activity()
        //->performedOn($web)
       ->log('Compte-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'comptes'=>$comptes,
            'comptes_edits'=>$comptes,
            'message' => 'Compte collecté avec success',
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
        
        //dd($request->all());
          $request->validate([
            'numero_compte' => 'required',
            'libelle' => 'required',
            // 'description' => ['required'],
            'solde'  =>['required']
        ]);
        $auth = Auth::user()->entreprise_id;
        //$similaire = Compte::where('libelle',$request->libelle)->first();

        // if(!$similaire)
        // {
           $compte = Compte::create([
                'numero_compte' => $request->numero_compte,
                'libelle' => $request->libelle,
                'description'=> $request->description,
                'solde'=> $request->solde,
                'entreprise_id'=>$auth,
            ]);


            activity()
            //->performedOn($web)
            ->log('Compte-Store')
            // ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

            return response()->json([
                'compte'=>$compte,
                'message' => 'Compte enregistrer avec success',
            ]);
        // }
        //return back()->with('message', 'Enregistrement effectué avec success.');

       // return Inertia::render('Comptes/Compte/compte_home')->with('message', 'Enregistrement effectué avec success.');






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
        $edit =  Compte::find($request->id);

        activity()
        //->performedOn($web)
       ->log('Compte-Form-Edit')
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
            'numero_compte' => ['required'],
            'libelle' => 'required',
            // 'description' => ['required'],
            'solde' => ['required','regex:/^\d+(\.\d{1,2})?$/',]
        ]);

        Compte::find($request->id)->update([
            'numero_compte'=>$request->numero_compte,
            'libelle'=>$request->libelle,
            'solde'=>$request->solde,
            'description'=>$request->description,
           // 'entreprise_id'=>$auth,
            //'facture_id'=>$request->date,
        ]);


        activity()
        //->performedOn($web)
       ->log('Compte-Update')
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
        $facture=Compte::find($request->id)->delete();

        activity()
        //->performedOn($web)
        ->log('Compte-destroy')
        // ->causedBy(Auth::user()->id)
        ->subject(2)
        ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Compte Supprimé avec success',
        ]);

        // return back()-> with( 'message' , 'Compte supprimé avec success' );

    }
}
