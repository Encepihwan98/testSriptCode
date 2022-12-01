<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Models\Esprensece;
use App\Models\User;
use DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responses = [];
        $responses['message'] = "Succes Get Data";
        $responses['status'] = true;
        $responses['code'] = 200;
        $data = Users::select('users.id as id_user', 'users.nama as nama_user', 'a.waktu as waktu_masuk', 'b.waktu as waktu_pulang', DB::raw("CASE WHEN a.is_approve IS TRUE THEN 'approved' ELSE 'rejected' END as status_masuk"), DB::raw("CASE WHEN b.is_approve IS TRUE THEN 'approved' ELSE 'rejected' END as status_pulang") )
        ->join('esprenseces as a', function ($join) {
            $join->on('users.id', '=', 'a.id_user')->on('a.type', '=', DB::raw("'IN'"));
        })
        ->join('esprenseces as b', function ($join) {
            $join->on('users.id', '=', 'b.id_user')->on('b.type', '=', DB::raw("'OUT'"));
        })->get();

        $responses['data'] = $data;
        return response()->json($responses, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $responses['message'] = "Succes Post Data";
        $responses['status'] = true;
        $responses['code'] = 200;
        $store = new Users();
        $store->nama = $request->nama;
        $store->email = $request->email;
        $store->password = Hash::make($request->password);
        $store->npp = $request->npp;
        $store->npp_supervisor = $request->npp_supervisor;
        $store->save();

        return response()->json($responses);

    }
    public function storeAbsen(Request $request)
    {
        $responses['message'] = "Succes Abses";
        $responses['status'] = true;
        $responses['code'] = 200;
        $store = new Esprensece();
        $store->id_user = $request->id_user;
        $store->type = $request->type;
        $store->is_approve = false;
        $store->waktu = $request->waktu;
        $store->save();

        return response()->json($responses);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
