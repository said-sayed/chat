<?php

namespace App\Http\Controllers;

use App\Events\NewMessageSent;
use App\Http\Requests\GetMessageRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatMessageController extends Controller
{

    public function allMessage($chat_id)
    {
        $chat = Chat::find($chat_id);
        $chat->refresh()->load('lastMessage.user', 'participants.user', 'messages');
        return view('chat')->with('chat', $chat);
    }

    // public function index(GetMessageRequest $request): JsonResponse
    // {
    //     $data = $request->validated();
    //     $chatId = $data['chat_id'];
    //     $currentPage = 1;
    //     $pageSize = $data['page_size'] ?? 15;

    //     $messages = ChatMessage::where('chat_id', $chatId)
    //         ->with('user')
    //         ->latest('created_at')
    //         ->simplePaginate(
    //             $pageSize,
    //             ['*'],
    //             'page',
    //             $currentPage
    //         );

    //     return $this->success($messages->getCollection());
    // }


    public function store(StoreMessageRequest $request)
    {
        $auth_user_id = auth()->user()->id;
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $chatMessage = ChatMessage::create($data);
        $chatMessage->load('user');
        event(new NewMessageSent($chatMessage));
        // $auth_firstChar_name = substr(auth()->user()->username, 0, 1);
        // $messageUser_firstChar_name = substr($chatMessage->user->username, 0, 1);
        // return ["chat_id" => $chatMessage->chat_id, "message_user_id" => $chatMessage->user_id,'auth_firstChar_name' => $auth_firstChar_name, 'messageUser_firstChar_name' => $messageUser_firstChar_name, 'auth_user_id' => $auth_user_id];
        /// TODO send broadcast event to pusher and send notification to onesignal services
        // $this->sendNotificationToOther($chatMessage);
        // return redirect("allMessage/$chatMessage->chat_id");
        // return $this->success($chatMessage, 'Message has been sent successfully.');
    }

    /**
     * Send notification to other users
     *
     * @param ChatMessage $chatMessage
     */
    private function sendNotificationToOther(ChatMessage $chatMessage): void
    {

        // TODO move this event broadcast to observer
        broadcast(new NewMessageSent($chatMessage))->toOthers();
        $user = auth()->user();
        $userId = $user->id;

        $chat = Chat::where('id', $chatMessage->chat_id)
            ->with(['participants' => function ($query) use ($userId) {
                $query->where('user_id', '!=', $userId);
            }])
            ->first();
        if (count($chat->participants) > 0) {
            $otherUserId = $chat->participants[0]->user_id;

            $otherUser = User::where('id', $otherUserId)->first();
            $otherUser->sendNewMessageNotification([
                'messageData' => [
                    'senderName' => $user->username,
                    'message' => $chatMessage->message,
                    'chatId' => $chatMessage->chat_id
                ]
            ]);
        }
    }
}
