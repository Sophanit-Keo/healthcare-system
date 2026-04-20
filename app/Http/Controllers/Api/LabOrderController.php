<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLabOrderRequest;
use App\Http\Requests\UpdateLabOrderRequest;
use App\Http\Resources\LabOrderResource;
use App\Models\LabOrder;
use App\Models\LabOrderItem;
use App\Models\Patient;
use App\Services\ConsentService;
use App\Services\StaffScopeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LabOrderController extends Controller
{
    public function __construct(
        private readonly ConsentService $consentService,
        private readonly StaffScopeService $staffScopeService,
    )
    {
    }

    
    public function index(Request $request)
    {
        $user = $request->user();

        $query = LabOrder::query()->with('items');

        if ($user->hasRole('patient')) {
            $query->where('patient_id', $user->patient?->id);
        } else {
            abort_unless($user->can('lab_orders.view'), 403);

            if ($request->filled('patient_id')) {
                $query->where('patient_id', $request->integer('patient_id'));
            }
        }

        return LabOrderResource::collection($query->latest()->paginate(10));
    }

    
    public function store(StoreLabOrderRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($user->hasRole('patient')) {
            $patientId = $user->patient?->id;
            if (! $patientId) {
                throw ValidationException::withMessages([
                    'patient' => ['Patient profile not found for this account.'],
                ]);
            }
            $data['patient_id'] = $patientId;
        } else {
            abort_unless($user->can('lab_orders.create'), 403);

            $this->staffScopeService->enforceFacilityScope($user, $data['facility_id'] ?? null);

            if (! empty($data['facility_id'])) {
                $patient = Patient::findOrFail($data['patient_id']);
                if (! $this->consentService->hasActiveFacilityConsent($patient, (int) $data['facility_id'])) {
                    throw ValidationException::withMessages([
                        'facility_id' => ['Patient consent is not granted for this facility.'],
                    ]);
                }
            }
        }

        $items = $data['items'] ?? [];
        unset($data['items']);

        $order = DB::transaction(function () use ($data, $items) {
            $order = LabOrder::create([
                ...$data,
                'ordered_at' => $data['ordered_at'] ?? now(),
            ]);

            foreach ($items as $item) {
                LabOrderItem::create([
                    'lab_order_id' => $order->id,
                    'test_code' => $item['test_code'] ?? null,
                    'test_name' => $item['test_name'],
                    'specimen' => $item['specimen'] ?? null,
                ]);
            }

            return $order;
        });

        return (new LabOrderResource($order->load('items')))
            ->response()
            ->setStatusCode(201);
    }

    
    public function show(Request $request, LabOrder $labOrder)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($labOrder->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('lab_orders.view'), 403);
        }

        return new LabOrderResource($labOrder->load('items'));
    }

    
    public function update(UpdateLabOrderRequest $request, LabOrder $labOrder)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($labOrder->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('lab_orders.update'), 403);
        }

        $data = $request->validated();
        $items = $data['items'] ?? [];
        unset($data['items']);

        DB::transaction(function () use ($labOrder, $data, $items) {
            $labOrder->update($data);

            foreach ($items as $item) {
                LabOrderItem::query()
                    ->where('id', $item['id'])
                    ->where('lab_order_id', $labOrder->id)
                    ->update(collect($item)->except(['id'])->toArray());
            }
        });

        return new LabOrderResource($labOrder->load('items'));
    }

    
    public function destroy(Request $request, LabOrder $labOrder)
    {
        $user = $request->user();
        if ($user->hasRole('patient')) {
            if ($labOrder->patient_id !== $user->patient?->id) {
                abort(403);
            }
        } else {
            abort_unless($user->can('lab_orders.delete'), 403);
        }

        $labOrder->delete();

        return response()->json(['message' => 'Lab order deleted']);
    }
}
