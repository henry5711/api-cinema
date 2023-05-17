<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Http\Requests\StoreGenderRequest;
use App\Http\Requests\UpdateGenderRequest;
use App\Http\Resources\GenderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            DB::beginTransaction();
            $gender = Gender::get();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => 'messages.GenderController.index.index.internal_error',
                    'errors' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

            return response()->json([
                "message"       => "genders",
                "response"      => GenderResource::collection($gender),
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGenderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGenderRequest $request)
    {
        try {
            DB::beginTransaction();
            $id =  $this->creategender($request);

            $response = Gender::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.gender.store.store.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "Se registro una nuevo gendere",
            "response"      => genderResource::make($response),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            DB::beginTransaction();

            $gender = Gender::where('id', $id)->get();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.gender.show.show.internal_error')],
                    'errors' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "detalle de gendere",
            "response"      => genderResource::make($gender),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGenderRequest  $request
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGenderRequest $request,$id)
    {
        try {
            DB::beginTransaction();

            $gender = Gender::findOrFail($id);
            $this->updategender($gender, $request);

            $response = Gender::where('id', $id)->first();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.gender.update.update.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message"       => "gender actulizado",
            "response"      => genderResource::make($response),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $gender = Gender::where('id', $id)->first();
            if ($gender) {
                $gender->delete();
            } else {
                return response()->json([
                    "errors" => [
                        "message"       =>  ["no es posible realizar eliminar este gendere"],
                    ]
                ], 422);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.gender.delete.delete.internal_error')],
                    'errors' => $e->getMessage(),
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            "message"       => "gender Eliminado",
        ]);
    }

    public function filter(Request $request)
    {
        try {
            DB::beginTransaction();
            $gender = Gender::filtro($request)->get();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'data' => [
                    'code'   => $e->getCode(),
                    'title'  => [__('messages.gender.filter.filter.internal_error')],
                    'errors' => $e->getMessage()
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


            return response()->json([
                "message"       => "filtro gender",
                "response"      => genderResource::collection($gender),
            ]);

    }
}
