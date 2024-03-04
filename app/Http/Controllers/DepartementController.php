<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartementController extends Controller
{

    function __construct()
    {
        //    //les permissions
        //    $this->middleware('permission:index-departement', ['only' => ['index']]);  //  
        //    $this->middleware('permission:show-departement', ['only' => ['index']]);
        //    $this->middleware('permission:create-departement', ['only' => ['store']]);
        //    $this->middleware('permission:update-departement', ['only' => ['update']]);
        //    $this->middleware('permission:delete-departement', ['only' => ['destroy']]);

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

        $auth = Auth::user()->entreprise_id;
        $departement = Departement::where('entreprise_id',$auth )->get();
        //$departement = Departement::all();

        return response()->json([
            $departement,
            'Liste des departements'
        ]);

        //return Inertia::render('Comptes/departements/departement_home')->with(['departements'=> $departement,'departement_edits'=> $departement]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user()->entreprise_id;
        $departement = Departement::where('entreprise_id',$auth )->get();
        //$departement = Departement::all();

        return response()->json([
            'message' => 'Liste des departements',
            'departement' => $departement,

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
        //
        $auth = Auth::user()->entreprise_id;
        $departement = Departement::where('entreprise_id',$auth );

        $request->validate([
            'libelle' => ['required'],
            //'nombre_employe' => ['required'],
            // 'contact' => ['required','min:8','max:15'],
            //'description' => ['required'],
            // 'email' => ['required','unique:entreprises'],
        ]);

        $departement=Departement::create([

            'libelle'=>$request->libelle,
            'nombre_employe'=>$request->nombre_employe,
            'contact'=>$request->contact,
            'email'=>$request->email,
            'description'=>$request->description,
            'entreprise_id' =>  $auth ,

            //'created_user'=>$request->user()->entreprise_id
        ]);

        return response()->json([
            'message' => 'Enregistré avec success',
            'departement' => $departement,
            'entreprise_id' =>  $auth ,

        ]);

        return back()->with('message','Compte crée avec success');
        //Inertia::render('Comptes/departements/departement')->with('message','Compte crée avec success');
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
            //'nombre_employe' => ['required'],
            // 'contact' => ['required','min:8','max:15'],
            //'description' => ['required'],
            // 'email' => ['required'],
        ]);

        Departement::find($request->id)->update([
            'libelle'=>$request->libelle,
            'nombre_employe'=>$request->nombre_employe,
            'contact'=>$request->contact,
            'description'=>$request->description,
           // 'entreprise_id'=>$auth,
            'email'=>$request->email,
        ]);
        return back()-> with( 'message' , 'Departement Modifié avec success' );
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
        Departement::find($request->id)->delete();
        return response()->json([
            'message' => 'Supprimé avec success',
        ]);
        return back()-> with( 'message' , 'Departement supprimé avec success' );
    }
}
