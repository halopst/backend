<?php
namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Services\BpsService;
use Illuminate\Http\Request;

class BpsController extends Controller
{
    protected $bpsService;

    public function __construct(BpsService $bpsService)
    {
        $this->bpsService = $bpsService;
    }

    public function getPegawaiByUsername(Request $request, $username)
    {
        try {
            $data = $this->bpsService->getPegawaiByUsername($username);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
