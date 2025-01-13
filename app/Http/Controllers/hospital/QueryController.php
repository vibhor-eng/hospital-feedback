<?php

namespace App\Http\Controllers\hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Query;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;


class queryController extends Controller
{

    public function queryList(Request $request)
    {

        $query_list = Query::select('id','name')->where(['is_deleted' => 0])->orderBy('id','desc')->get()->toArray();
        
        return view('hospital.query.list',compact('query_list'));
    }

    public function Addquery(Request $request){

        if($request->isMethod('post')){

            try
            {

                $this->validate($request, [
                    'name' => 'required',
                ]);

                $query = Query::create($request->all());

                return response()->json(['msg' => 'query has been added successfully.','status' => true]);

            }catch(\Exception $e){
               
                return response()->json(['msg' => $e->getMessage(),'status' => false]);

            }

        }

        return view('hospital.query.create');

    }


    public function Deletequery(Request $request){

        try
            {

                $query_id = $request->id;

                $update = Query::where(['id' => $query_id])->update(['is_deleted' => 1,'deleted_at' => date('Y-m-d H:i:s')]);

                

                return response()->json(['msg' => 'query has been deleted successfully.','status' => true]);

            }catch(\Exception $e){
               
                return response()->json(['msg' => $e->getMessage(),'status' => false]);

            }


    }


    public function Updatequery(Request $request){

        try
            {

                $query_id = $request->query_id;
                $query_name = $request->query_name;

                $update = Query::where(['id' => $query_id])->update(['name' => $query_name]);

                

                return response()->json(['msg' => 'query has been updated successfully.','status' => true]);

            }catch(\Exception $e){
               
                return response()->json(['msg' => $e->getMessage(),'status' => false]);

            }


    }



}