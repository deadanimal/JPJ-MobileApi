<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\LmmService;
use Illuminate\Support\Facades\Validator;

class LmmController extends Controller
{
    public function __construct(
        LmmService $lmmService,
    ) {
        $this->lmmService = $lmmService;
    }

    /**
     * @OA\Get(
     *
     *	path="/api/getLmmTempohPembaharuan",
     *	operationId="getLmmTempohPembaharuan",
     *	tags={"Lmm"},
     *	summary="Get lmm tempoh pembaharuan",
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
    public function getLmmTempohPembaharuan()
    {
        $result = $this->lmmService->getLmmTempohPembaharuan();

        return response()->json([
            'status' => 200,
            'message' => "Success: Get Lmm Tempoh Pembaharuan.",
            'result' => $result,
        ]);
    }

    /**
     * @OA\Get(
     *
     *	path="/api/getJenisLesen",
     *	operationId="getJenisLesen",
     *	tags={"Lmm"},
     *	summary="Get jenis lesen",
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

    public function getJenisLesen()
    {
        $result = $this->lmmService->getJenisLesen();

        return response()->json([
            'status' => 200,
            'message' => "Success: Get Jenis Lesen.",
            'result' => $result,
        ]);
    }
}
