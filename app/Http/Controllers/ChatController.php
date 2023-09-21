<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetChatRequest;
use App\Http\Requests\StoreChatRequest;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ChatController extends Controller
{

    public function showChat($chat_id)
    {
        $chat = Chat::find($chat_id);

        $chat = $chat->refresh()->load('lastMessage.user', 'participants.user', 'messages');
        if ($chat->participants[0]->user->id == auth()->user()->id) {
            $other_user_name = $chat->participants[1]->user->username;
        } else {
            $other_user_name = $chat->participants[0]->user->username;
        }
        // dd( $chat->last_message);
        return view('chat')->with(['chat' => $chat, 'other_user_name' => $other_user_name]);
    }

    public function index(GetChatRequest $request)
    {
        $data = $request->validated();
        $isPrivate = 1;
        if ($request->has('is_private')) {
            $isPrivate = (int)$data['is_private'];
        }

        $chats = Chat::where('is_private', $isPrivate)
            ->hasParticipant(auth()->user()->id)
            ->whereHas('messages')
            ->with('participants.user')
            ->latest('updated_at')
            ->get();
        // return $chats;
        return view('contacts')->with('chats', $chats);
    }



    public function store(StoreChatRequest $request)
    {
        $data = $this->prepareStoreData($request);
        if ($data['userId'] === $data['otherUserId']) {
            return redirect('/contacts')->with('error', 'You can not create a chat with your own!');
        }

        $previousChat = $this->getPreviousChat($data['otherUserId']);

        if ($previousChat === null) {
            $chat = Chat::create($data['data']);
            $chat->participants()->createMany([
                [
                    'user_id' => $data['userId']
                ],
                [
                    'user_id' => $data['otherUserId']
                ]
            ]);
            return redirect("showChat/$chat->id");
        }

        return redirect("showChat/$previousChat->id");
    }

    /**
     * Check if user and other user has previous chat or not
     *
     * @param int $otherUserId
     * @return mixed
     */
    private function getPreviousChat(int $otherUserId): mixed
    {

        $userId = auth()->user()->id;

        return Chat::where('is_private', true)
            ->whereHas('participants', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->whereHas('participants', function ($query) use ($otherUserId) {
                $query->where('user_id', $otherUserId);
            })
            ->first();
    }


    /**
     * Prepares data for store a chat
     *
     * @param StoreChatRequest $request
     * @return array
     */
    private function prepareStoreData(StoreChatRequest $request): array
    {
        $data = $request->validated();
        $otherUserId = (int)$data['user_id'];
        unset($data['user_id']);
        $data['created_by'] = auth()->user()->id;

        return [
            'otherUserId' => $otherUserId,
            'userId' => auth()->user()->id,
            'data' => $data,
        ];
    }


    public function show(Chat $chat)
    {
        // $chat->load('lastMessage.user', 'participants.user');
        // return $this->success($chat);
    }
}
