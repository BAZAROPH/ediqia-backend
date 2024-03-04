<?php

namespace App\Http\Controllers;

use App\Models\Taxe;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class TaxeController extends Controller
{

    function __construct()
    {
        //    //les permissions
        //    $this->middleware('permission:index-taxe', ['only' => ['index']]);  //  
        //    $this->middleware('permission:show-taxe', ['only' => ['index']]);
        //    $this->middleware('permission:create-taxe', ['only' => ['store']]);
        //    $this->middleware('permission:update-taxe', ['only' => ['update']]);
        //    $this->middleware('permission:delete-taxe', ['only' => ['destroy']]);


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
     
        if( Auth::user()->hasPermissionTo('index-taxe') ){
            $taxes = Taxe::where('entreprise_id',Auth::user()->entreprise_id)->get();
            return response()->json([
                'taxes'=>$taxes,
                'message'=>'collecte avec success'
            ]);
        }
       // $taxes = Taxe::where('entreprise_id',Auth::user()->entreprise_id)->get();

       if(!empty($taxes)){
        return response()->json([
            $taxes ,
            'Collecter avec success',
        ]);
       }else{
        return response()->json([
            "Il n'ya pas de taxe disponible",
        ]);
       }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $taxes = Taxe::where('created_user',Auth::user()->entreprise_id)->get();


        return response()->json([
            'taxes' =>  $taxes ,
            'message' => 'Collecter avec success',
        ]);

        //    $taxes = Taxe::where('created_user',Auth::user()->id)->get();
        // return Inertia::render('Factures/Taxes/taxe');


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
            'libelle'=>['required'],
            'valeur'=>['required'],
        ]);
            $valeur=strval($request->valeur);
            $valeur = str_replace(",", ".", $valeur);
            $valeur=doubleval($valeur);


        $taxe = Taxe::firstOrCreate([
            'libelle'=>$request->libelle,
            'valeur'=>$valeur,
            'created_user'=>$request->user()->id,
            'entreprise_id'=>Auth::user()->entreprise_id
        ]);

        return response()->json([
            'message' => 'Enregistré avec success',
            'entreprise'=>Auth::user()->entreprise_id
        ]);
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
    public function edit($id)
    {
        //
        $taxe =  Taxe::find($id);
        return response()->json([
            'taxe' => $taxe ,
            'message' => 'collecté avec success',
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
        $request->validate([
            'libelle'=>['required'],
            'valeur'=>['required'],
        ]);

        $valeur = $request->valeur;
        if  (strpos($valeur,','))
            {
                $valeur=strval($request->valeur);
                $valeur = str_replace(",", ".", $valeur);
                $valeur=doubleval($valeur);
        }

        Taxe::find($request->id)->update([
            'libelle'=>$request->libelle,
            'valeur'=>$valeur,
            'created_user'=>$request->user()->id
        ]);

        return response()->json([
            'message' => 'Modifié avec success',
        ]);
        // dd($request->all());
        // return back()->with('message','Modifier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $taxe=Taxe::find($request->id)->delete();

        return response()->json([
            'message' => 'Supprimé avec success',
        ]);



    }
}
