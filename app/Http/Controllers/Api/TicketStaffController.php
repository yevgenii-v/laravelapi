<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TicketStaffStoreRequest;
use App\Http\Requests\Api\TicketStaffUpdateRequest;
use App\Http\Resources\TicketStaffDialogResource;
use App\Http\Resources\TicketResource;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TicketStaffController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Ticket::class, 'ticket');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        if (auth('sanctum')->user()->roles->containsStrict('id', Role::IS_ADMIN))
        {
            return TicketResource::collection(Ticket::paginate(25));
        }

        return TicketResource::collection(
            Ticket::where('support_id', '=', auth('sanctum')->user()->id)
                ->orWhere('support_id', '=', null)
                ->paginate(25)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketStaffStoreRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function store(TicketStaffStoreRequest $request)
    {
        $validatedData = $request->safe();

        //Find user's id by email.
        $user_id = User::where('email', $validatedData['email'])->value('id');

        Ticket::create([
            'title'         => $validatedData['title'],
            'message'       => $validatedData['message'],
            'user_id'       => $user_id,
            'support_id'    => auth('sanctum')->user()->id,
        ]);

        $response = ['message' => 'Ticket has been created.'];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @return TicketStaffDialogResource
     */
    public function show(Ticket $ticket): TicketStaffDialogResource
    {
        $ticket['staffList'] = User::whereHas('roles', function ($query) {
            $query->where('role_id', Role::IS_ADMIN)->orWhere('role_id', Role::IS_SUPPORT);
        })->get();

        return new TicketStaffDialogResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketStaffUpdateRequest $request
     * @param Ticket $ticket
     * @return Response
     */
    public function update(TicketStaffUpdateRequest $request, Ticket $ticket): Response
    {
        $validatedData = $request->safe();

        if (isset($validatedData['support_id']))
        {
            $user = User::where('id', $validatedData['support_id'])->first();

            if (!$user->hasAnyRoles(['Administrator', 'Support']))
            {
                return response(['message' => 'This user is not Staff Member.']);
            }
        }

        $ticket->fill($request->validated())->save();

        $response = [
            'message' => "Ticket has been updated.",
        ];

        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     * @return Response
     */
    public function destroy(Ticket $ticket): Response
    {
        $ticket->delete();

        $response = [
            'message' => "Ticket has been deleted.",
        ];

        return response($response, 200);
    }
}
