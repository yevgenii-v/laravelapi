<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TicketMessageRequest;
use App\Http\Requests\Api\TicketUserStoreRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketUserMessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Ticket $ticket
     * @param TicketMessageRequest $request
     * @return Response
     */
    public function store(Ticket $ticket, TicketMessageRequest $request): Response
    {
        if ($ticket->user_id !== auth('sanctum')->user()->id) {
            return response(['message' => 'Ticket do not exists.'], 404);
        }

        $validatedData = $request->safe();

        TicketMessage::create([
            'answer'    => $validatedData['answer'],
            'user_id'   => auth('sanctum')->user()->id,
            'ticket_id' => $ticket->id,
        ]);

        return response(['message' => 'Message has been sent.'], 201);
    }
}
