<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreXbrlMessageRequest;
use App\Models\XbrlMessage;
use App\XbrlMessageStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XbrlMessageController extends Controller
{
    public function store(StoreXbrlMessageRequest $request): JsonResponse
    {
        Log::info('Storing XBRL message', ['request' => $request->all()]);

        /** @var \App\Models\User $user */
        $user = $request->user();
        Log::info('User: ' . $user->email);
        Log::info('Message UUID: ' . $request->validated()['message_uuid']);
        Log::info('Message Type: ' . $request->validated()['message_type']);
        Log::info('Message Content: ' . $request->validated()['message_content']);

        $xbrlMessage = XbrlMessage::create([
            'user_id' => $user->id,
            'message_uuid' => $request->validated()['message_uuid'],
            'message_type' => $request->validated()['message_type'] ?? null,
            'message_status' => XbrlMessageStatus::Pending->value,
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
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Ensure user can only access their own messages
        if ($xbrlMessage->user_id !== $user->id) {
            abort(403, 'Je hebt geen toegang tot dit bericht.');
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
        /** @var \App\Models\User $user */
        $user = $request->user();

        $xbrlMessages = $user->xbrlMessages()
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($xbrlMessages);
    }
}
