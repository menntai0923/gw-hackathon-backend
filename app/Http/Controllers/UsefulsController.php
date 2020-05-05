<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Useful;

class UsefulsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usefuls = Useful::all();
        
        return $usefuls;
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
        $useful = new Useful;
        $useful->post_id = $request->post_id;
        $useful->user_id = $request->user_id;
        $useful->save();

        // jsonに変換
        return json_encode(
            array(
                "id" => $useful->id,
                "post_id" => $useful->post_id,
                "user_id" => $useful->user_id,
                "created_at" => $useful->created_at,
            )
        ); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $useful = Useful::find($id);

        return json_encode(
            array("id" => $useful->id,
                  "post_id" => $useful->post_id,
                  "user_id" => $useful->user_id,
                  "created_at" => $useful->created_at,
            )

        );
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
        $useful = Useful::find($id);

        if(empty($useful))
        {
            return response("ステータスコード400", 400);
        }
        else
        {
            Useful::destroy($id);
            return response("ステータスコード200", 200);
        }
    }
}
