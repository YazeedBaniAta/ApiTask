<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServicesResource;
use App\Models\Images;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(){
        $services = ServicesResource::collection(Services::all());

        if (count($services) > 0){
            $array = [
                'data'=>$services,
                'mes'=>'OK',
                'status'=>200
            ];

            return response($array);
        }else{
            $array = [
                'data'=>null,
                'mes'=>'no services',
                'status'=>404
            ];
            return response($array);
        }

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'descriptions' => 'required|string',
            'category' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $service = Services::create($request->all());
        if ($service) {
            if($request->hasfile('images')) {
                $allowedfileExtension=['jpg','png'];
                foreach($request->file('images') as $file) {

                    $name = $file->getClientOriginalExtension();
                    $check = in_array($name,$allowedfileExtension);
                    if($check) {
                        $new_name = rand().'.'.$file->getClientOriginalName();
                        $file->move(public_path('/uploads/images'),$new_name);

                        // insert in image_table
                        $images= new Images();
                        $images->filename=$file->getClientOriginalName();;
                        $images->imageable_id= $service->id;
                        $images->imageable_type = 'App\Models\Services';
                        $images->save();
                    }
                }
            }

            $array = [
                'data' => new ServicesResource($service),
                'mes' => 'The service add successfully',
                'status' => 201
            ];
            return response($array);
        } else {
            $array = [
                'data' => null,
                'mes' => 'no service add',
                'status' => 400
            ];
            return response($array);
        }

    }
}
