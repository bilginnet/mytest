<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Purchase;
use App\Notifications\PurchaseStatusChanged;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator as ValidatorContracts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validation = $this->validator($request->all());

        if ($validation->fails()) {
            return response()->json($validation->getMessageBag());
        }

        $application = Application::findOrFail($request->application_id);

        $purchase = Purchase::create([
            'user_id' => $request->user()->id,
            'application_id' => $application->id,
            'last_using_date' => Carbon::now()->addDays($application->countdwon),
            'status' => 'started',
        ]);

        return response()->json([
           'status' => 'ok'
        ]);
    }

    public function checkSubscriptions(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = Purchase::with('application')
            ->where('user_id', $request->user()->id)
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->get();

        return response()->json([
            'status' => 'ok',
            'data' => $result
        ]);
    }

    public function renew(Request $request)
    {
        $validation = $this->validator($request->all());

        if ($validation->fails()) {
            return response()->json($validation->getMessageBag());
        }

        $application = Application::findOrFail($request->application_id);
        $purchase = Purchase::query()->where('user_id', $request->user()->id)->where('application_id', $application->id)->firstOrFail();

        if ($purchase->last_using_date < now()) {
            $purchase->update([
                'status' => 'renewed',
            ]);
        }
    }

    public function cancel(Request $request)
    {
        $validation = $this->validator($request->all());

        if ($validation->fails()) {
            return response()->json($validation->getMessageBag());
        }

        $application = Application::findOrFail($request->application_id);
        $purchase = Purchase::query()->where('user_id', $request->user()->id)->where('application_id', $application->id)->firstOrFail();

        $purchase->update([
            'status' => 'canceled',
        ]);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data): ValidatorContracts
    {
        return Validator::make($data, [
            'application_id' => ['required', 'string'],
        ]);
    }
}
