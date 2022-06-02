<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TicketMessageRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketStaffMessageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TicketMessage::class, 'message');
    }

    public function store(Ticket $ticket, TicketMessageRequest $request): Response
    {
        $validatedData = $request->safe();

        TicketMessage::create([
            'answer'    => $validatedData['answer'],
            'user_id'   => auth('sanctum')->user()->id,
            'ticket_id' => $ticket->id,
        ]);

        if ($ticket->support_id === null)
        {
            $ticket->fill([
                'support_id' => auth('sanctum')->user()->id
            ])->save();
        }

        return response(['message' => 'Message has been sent.'], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Ticket $ticket
     * @param TicketMessageRequest $request
     * @param TicketMessage $message
     * @return Response
     */
    public function update(Ticket $ticket, TicketMessageRequest $request, TicketMessage $message): Response
    {
        if ($message->user_id !== auth('sanctum')->user()->id)
        {
            return response(['message' => 'You are not allow to update that message.'], 403);
        }

        $validatedData = $request->validated();
        $message->fill($validatedData)->save();

        return response(['message' => 'Message has been updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TicketMessage $message
     * @return Response
     */
    public function destroy(Ticket $ticket, TicketMessage $message): Response
    {
        $message->delete();

        return response(['message' => 'Message has been deleted.'], 200);
    }
}
