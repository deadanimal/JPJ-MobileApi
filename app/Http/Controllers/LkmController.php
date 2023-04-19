<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\LkmService;
use Illuminate\Support\Facades\Validator;

class LkmController extends Controller
{
    public function __construct(
        LkmService $lkmService,
    ) {
        $this->lkmService = $lkmService;
    }
    /**
     * @OA\Get(
     *
     *	path="/api/getLkmTempohPembaharuan",
     *	operationId="getLkmTempohPembaharuan",
     *	tags={"Lkm"},
     *	summary="Get lkm tempoh pembaharuan",
     *	@OA\Response(
     *		response=200,
     *		description="Success",
     *		@OA\JsonContent()
     *	),
     *	@OA\Response(response=400, description="Bad request"),
     *	@OA\Response(response=404, description="Resource Not Found"),
     *	@OA\Response(response=422, description="Unprocessable Entity"),
     *	@OA\Response(response=500, description="Internal Server Error"),
     * )
     */
    public function getLkmTempohPembaharuan()
    {
        $result = $this->lkmService->getLkmTempohPembaharuan();

        return response()->json([
            'status' => 200,
            'message' => "Success: Get Lkm Tempoh Pembaharuan.",
            'result' => $result,
        ]);
    }

    /**
     * @OA\Post(
     *
     *	path="/api/getLkmMaklumatKenderaan",
     *	operationId="getLkmMaklumatKenderaan",
     *	tags={"Lkm"},
     *	summary="Get lkm maklumat kenderaan",
     *	@OA\Parameter(
     *		name="module",
     *		description="module",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="Vel"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="channel",
     *		description="channel",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="04"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="agency",
     *		description="agency",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="JPJ"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="branch",
     *		description="branch (required)",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="0116103"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="pcid",
     *		description="pcid",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="xxx"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="userId",
     *		description="userId",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="MyJPJ"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="transCode",
     *		description="transCode",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="VEL02910"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="currDate",
     *		description="currDate",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="20221205",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="currTime",
     *		description="currTime",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="154120",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="deviceId",
     *		description="deviceId",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="001",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="regnNo",
     *		description="regnNo (required)",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="BKD1300",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="idNo",
     *		description="idNo (required)",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="710615045202",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="idCategory",
     *		description="idCategory",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="1",
     *		)
     *	),
     *	@OA\Response(
     *		response=200,
     *		description="Success",
     *		@OA\JsonContent()
     *	),
     *	@OA\Response(response=400, description="Bad request"),
     *	@OA\Response(response=404, description="Resource Not Found"),
     *	@OA\Response(response=422, description="Unprocessable Entity"),
     *	@OA\Response(response=500, description="Internal Server Error"),
     * )
     */
    public function getLkmMaklumatKenderaan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'regnNo' => 'required',
            'idNo' => 'required',
            'branch' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => "Error", 'error' => $validator->errors()]);
        } else {
            $result = $this->lkmService->getLkmMaklumatKenderaan($request);
            if ($result) {
                return response()->json([
                    'status' => 200,
                    'message' => "Success: Get Lkm Maklumat Kenderaan.",
                    'result' => $result,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Error: Record not found.",
                ]);
            }
        }
    }

    /**
     * @OA\Post(
     *
     *	path="/api/getLkmAmaunBayaran",
     *	operationId="getLkmAmaunBayaran",
     *	tags={"Lkm"},
     *	summary="Get lkm amaun bayaran",
     *	@OA\Parameter(
     *		name="module",
     *		description="module",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="Vel"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="channel",
     *		description="channel",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="04"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="agency",
     *		description="agency",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="JPJ"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="branch",
     *		description="branch (required)",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="0116103"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="pcid",
     *		description="pcid",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="xxxx"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="userId",
     *		description="userId",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="MyJPJ"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="transCode",
     *		description="transCode",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="VEL02910"
     *		)
     *	),
     *	@OA\Parameter(
     *		name="currDate",
     *		description="currDate",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="20221205",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="currTime",
     *		description="currTime",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="154120",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="deviceId",
     *		description="deviceId",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="001",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="regnNo",
     *		description="regnNo (required)",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="BKD1300",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="idNo",
     *		description="idNo (required)",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="710615045202",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="idCategory",
     *		description="idCategory",
     *		in="query",
     *		@OA\Schema(
     *			type="string",
     *			default="1",
     *		)
     *	),
     *	@OA\Parameter(
     *		name="lkmDuration",
     *		description="lkmDuration (6 or 12) (required)",
     *		in="query",
     *		@OA\Schema(
     *			type="integer",
     *			default="6",
     *		)
     *	),
     *	@OA\Response(
     *		response=200,
     *		description="Success",
     *		@OA\JsonContent()
     *	),
     *	@OA\Response(response=400, description="Bad request"),
     *	@OA\Response(response=404, description="Resource Not Found"),
     *	@OA\Response(response=422, description="Unprocessable Entity"),
     *	@OA\Response(response=500, description="Internal Server Error"),
     * )
     */
    public function getLkmAmaunBayaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch' => 'required',
            'regnNo' => 'required',
            'idNo' => 'required',
            'lkmDuration' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => "Error", 'error' => $validator->errors()]);
        } else {
            $result = $this->lkmService->getLkmAmaunBayaran($request);
            if ($result) {
                return response()->json([
                    'status' => 200,
                    'message' => "Success: Get Lkm Amaun Bayaran.",
                    'result' => $result,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Error: Record not found.",
                ]);
            }
        }
    }

    /**
     * @OA\Get(
     *
     *	path="/api/getModBayaran",
     *	operationId="getModBayaran",
     *	tags={"Shared API"},
     *	summary="Get Mod Bayaran",
     *	@OA\Response(
     *		response=200,
     *		description="Success",
     *		@OA\JsonContent()
     *	),
     *	@OA\Response(response=400, description="Bad request"),
     *	@OA\Response(response=404, description="Resource Not Found"),
     *	@OA\Response(response=422, description="Unprocessable Entity"),
     *	@OA\Response(response=500, description="Internal Server Error"),
     * )
     */
    public function getModBayaran()
    {
        $result = $this->lkmService->getModBayaran();

        return response()->json([
            'status' => 200,
            'message' => "Success: Get Lkm Mod Bayaran.",
            'result' => $result,
        ]);
    }

    /**
     * @OA\Get(
     *
     *	path="/api/getJenisKad",
     *	operationId="getJenisKad",
     *	tags={"Shared API"},
     *	summary="Get Jenis Kad",
     *	@OA\Response(
     *		response=200,
     *		description="Success",
     *		@OA\JsonContent()
     *	),
     *	@OA\Response(response=400, description="Bad request"),
     *	@OA\Response(response=404, description="Resource Not Found"),
     *	@OA\Response(response=422, description="Unprocessable Entity"),
     *	@OA\Response(response=500, description="Internal Server Error"),
     * )
     */
    public function getJenisKad()
    {
        $result = $this->lkmService->getJenisKad();

        return response()->json([
            'status' => 200,
            'message' => "Success: Get Jenis Kad.",
            'result' => $result,
        ]);
    }
}
