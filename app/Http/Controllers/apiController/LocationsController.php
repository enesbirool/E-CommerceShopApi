<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function store(Request $request){
        $request->validate([

            'street'=>'required',
            'building'=>'required',
            'area'=>'required',
        ]);

        $location=new Location();
        $location->user_id=Auth::id();
        $location->street=$request->street;
        $location->area=$request->area;
        $location->building=$request->building;
        $location->save();
        return response()->json(['message'=>'Location Added'],201);
    }

    public function update(Request $request,$id)
    {
        $request->validate([

            'street'=>'required',
            'building'=>'required',
            'area'=>'required',
        ]);
        $location=Location::find($id);

        if ($location){
            $location->street=$request->street;
            $location->building=$request->building;
            $location->area=$request->area;
            $location->save();
            return response()->json(['message'=>'Location Updated'],201);
        }
        else return response()->json(['message'=>'Location Not Found']);
    }

    public function destroy($id){
        $location=Location::find($id);

        if ($location){
            $location->delete();
            return response()->json(['message'=>'Location Deleted'],200);
        }
        else return response()->json(['message'=>'Location Not Found']);


    }

}
