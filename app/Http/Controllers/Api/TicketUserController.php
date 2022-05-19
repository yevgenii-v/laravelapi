<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TicketUserCreateRequest;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketUserDialogResource;
use App\Models\Ticket;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TicketUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $tickets = Ticket::where('user_id', auth('sanctum')->user()->id)->paginate(25);

        return TicketResource::collection($tickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketUserCreateRequest $request
     * @return Response
     */
    public function store(TicketUserCreateRequest $request): Response
    {
        $validatedData = $request->safe();

        Ticket::create([
            'title'         => $validatedData['title'],
            'message'       => $validatedData['message'],
            'user_id'       => auth('sanctum')->user()->id,

        ]);

        $response = ['message' => 'Ticket has been created.'];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @return TicketUserDialogResource|Application|ResponseFactory|Response
     */
    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== auth('sanctum')->user()->id)
        {
            return response(['message' => 'Ticket not found.'], 404);
        }

        return new TicketUserDialogResource($ticket);
    }
}
