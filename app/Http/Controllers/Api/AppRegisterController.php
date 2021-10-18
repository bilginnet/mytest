<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Contracts\Validation\Validator as ValidatorContracts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppRegisterController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $validation = $this->validator($request->all());

        if ($validation->fails()) {
            return response()->json($validation->getMessageBag());
        }

        Device::query()->updateOrCreate([
            'uuid' => $request->uuid,
            'app_id' => $request->app_id,
            'os' => $request->os,
        ], [
            'uuid' => $request->uuid,
            'app_id' => $request->app_id,
            'os' => $request->os,
            'language' => $request->header('Lang') ?? 'tr',
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data): ValidatorContracts
    {
        return Validator::make($data, [
            'uuid' => ['required', 'string'],
            'app_id' => ['required', 'string'],
            'os' => ['required', 'string'],
        ]);
    }
}
