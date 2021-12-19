<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TerimaOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->query('id');
        $data = DB::table('tb_kriteria_pengecekan')->where('id_kriteria', $id)->first();
        $data = DB::table('tb_jenis_pengecekan')
        ->select(
            'tb_jenis_pengecekan.id_jenis_pengecekan',
            'tb_kriteria_pengecekan.nama_kriteria',
            'tb_jenis_pengecekan.jenis_pengecekan',
            'tb_jenis_pengecekan.status'
        )
    
        ->leftJoin('tb_kriteria_pengecekan', 'tb_kriteria_pengecekan.id_kriteria', '=', 'tb_jenis_pengecekan.id_kriteria')
        ->where('tb_kriteria_pengecekan.id_kriteria', $id)
        ->get();

        // Return $oyo = [
        //     "Kty" => [$data, "jns" => $data1], 
        //     // "Jns" => [$data1]
            
        // ];

        return $data;

        
    //     $cards = DB::select("SELECT
    //     cards.id_card,
    //     cards.hash_card,
    //     cards.`table`,
    //     users.name,
    //     0 as total,
    //     cards.card_status,
    //     cards.created_at as last_update
    // FROM cards
    // LEFT JOIN users
    // ON users.id_user = cards.id_user
    // WHERE hash_card NOT IN ( SELECT orders.hash_card FROM orders )
    // UNION
    // SELECT
    //     cards.id_card,
    //     orders.hash_card,
    //     cards.`table`,
    //     users.name,
    //     sum(orders.quantity*orders.product_price) as total, 
    //     cards.card_status, 
    //     max(orders.created_at) last_update 
    // FROM menu.orders
    // LEFT JOIN cards
    // ON cards.hash_card = orders.hash_card
    // LEFT JOIN users
    // ON users.id_user = cards.id_user
    // GROUP BY hash_card
    // ORDER BY id_card ASC");

        // $items = $data->merge($data1);
        // return $items;

     
    
        
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $data = User::where('id', $id)->first();
        if ($data) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Data!',
                'data'      => $data
            ], 200);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak ditemukan',
            ], 404);
        }
    
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