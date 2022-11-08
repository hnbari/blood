<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonateRequest;
use App\Http\Resources\DonateResource;
use App\Models\donate_schedual;
use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class DonateSchedualController extends Controller
{
    public function __construct() {
        $this->middleware('bloodcompare')->only('store');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $donate_scheduals= donate_schedual::with('user','blood_type') -> get();
      return response()->json([
        // "message" => "Done",
        "message" => trans('response.test'),
        "data" => DonateResource::collection($donate_scheduals),
    ], JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDonateRequest $request)
    {
        // $request->validate([
        //     "user_id" => "required|exists:users,id",
        //     "amount" => "required|min:1|integer",
        //     "blood_type_id"=> "required|exists:blood_types,id",
        //     "Verified" => "nullable",
        // ]);

        $donate_schedual= donate_schedual::create([
            "user_id" => $request -> user_id,
            "amount" => $request -> amount,
            "blood_type_id" => $request -> blood_type_id,
            "Verified" => false,
        ]);

        
    // $donate_schedual-> log()-> attach($donate_schedual->id);

    operation_fun("+",$request -> amount);

        return response()->json([
            "message" => "Created successfully!",
            "data" => $donate_schedual,
        ], JsonResponse::HTTP_ACCEPTED);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {

        $schedual_id = donate_schedual::where('id',"=", $user_id) -> with ('user','blood_type')->get();
        return response()->json([
            "message" => "Fetch data successfully",
            "data" => $schedual_id,
          ], JsonResponse::HTTP_ACCEPTED);

        dd($schedual_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$donate_schedual)
    {
        $request->validate([
            "amount" => "required|min:1|integer",
            "city" => "string",
            "center" => "string",
        ]);

        $data=[];
        if($request->city){
            $data["city"] = $request->city;
        }

        $data=[];
        if($request->center){
            $data["center"] = $request->center;
        }

        $data=[];
        if($request->amount){
            $data["amount"] = $request->amount;
        }

        donate_schedual::where('id',"=", $donate_schedual)-> with ('user','blood_type')->update($data);
        return response()->json([
            "message" => "data updated successfully",
        ], JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\donate_schedual  $donate_schedual
     * @return \Illuminate\Http\Response
     */
    public function destroy($donate_schedual)
    {
        donate_schedual::where('id',"=", $donate_schedual) ->delete();
    }

    public function log()
    {

    }
}
