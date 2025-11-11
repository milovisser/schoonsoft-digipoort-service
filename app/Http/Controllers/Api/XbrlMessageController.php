<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreXbrlMessageRequest;
use App\Models\Tenant;
use App\Models\XbrlMessage;
use App\XbrlMessageStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class XbrlMessageController extends Controller
{
    public function store(StoreXbrlMessageRequest $request): JsonResponse
    {
        /** @var Tenant $tenant */
        $tenant = $request->user();

        $xbrlMessage = $tenant->xbrlMessages()->create([
            'message_uuid' => $request->validated()['message_uuid'],
            'message_type' => $request->validated()['message_type'] ?? null,
            'message_status' => XbrlMessageStatus::Pending,
            'message_content' => $request->validated()['message_content'],
        ]);

        return response()->json([
            'message' => 'XBRL bericht succesvol ontvangen',
            'data' => [
                'id' => $xbrlMessage->id,
                'message_uuid' => $xbrlMessage->message_uuid,
                'status' => $xbrlMessage->message_status,
                'created_at' => $xbrlMessage->created_at,
            ],
        ], 201);
    }

    public function show(Request $request, XbrlMessage $xbrlMessage): JsonResponse
    {
        /** @var Tenant $tenant */
        $tenant = $request->user();

        if ($xbrlMessage->tenant_id !== $tenant->id) {
            abort(404);
        }

        return response()->json([
            'data' => [
                'id' => $xbrlMessage->id,
                'message_uuid' => $xbrlMessage->message_uuid,
                'message_type' => $xbrlMessage->message_type,
                'message_status' => $xbrlMessage->message_status,
                'digipoort_message_id' => $xbrlMessage->digipoort_message_id,
                'sent_at' => $xbrlMessage->sent_at,
                'processed_at' => $xbrlMessage->processed_at,
                'error_message' => $xbrlMessage->error_message,
                'created_at' => $xbrlMessage->created_at,
                'updated_at' => $xbrlMessage->updated_at,
            ],
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        /** @var Tenant $tenant */
        $tenant = $request->user();

        $xbrlMessages = $tenant->xbrlMessages()
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($xbrlMessages);
    }
}
