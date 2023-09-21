@extends('layouts.app')

@section('css')
<style>
    body,
    html {
        height: 100%;
        margin: 0;
        background: #7F7FD5;
        background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
        background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
    }

    .chat {
        margin-top: auto;
        margin-bottom: auto;
    }

    .card {
        height: 500px;
        border-radius: 15px !important;
        background-color: rgba(0, 0, 0, 0.4) !important;
    }

    .contacts_body {
        padding: 0.75rem 0 !important;
        overflow-y: auto;
        white-space: nowrap;
    }

    .msg_card_body {
        overflow-y: auto;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
        border-bottom: 0 !important;
    }

    .card-footer {
        border-radius: 0 0 15px 15px !important;
        border-top: 0 !important;
    }

    .container {
        align-content: center;
    }

    .search {
        border-radius: 15px 0 0 15px !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
    }

    .search:focus {
        box-shadow: none !important;
        outline: 0px !important;
    }

    .type_msg {
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        height: 60px !important;
        overflow-y: auto;
    }

    .type_msg:focus {
        box-shadow: none !important;
        outline: 0px !important;
    }

    .attach_btn {
        border-radius: 15px 0 0 15px !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .send_btn {
        border-radius: 0 15px 15px 0 !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .search_btn {
        border-radius: 0 15px 15px 0 !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        border: 0 !important;
        color: white !important;
        cursor: pointer;
    }

    .contacts {
        list-style: none;
        padding: 0;
    }

    .contacts li {
        width: 100% !important;
        padding: 5px 10px;
        margin-bottom: 15px !important;
    }

    .active {
        background-color: rgba(0, 0, 0, 0.3);
    }

    .user_img {
        height: 70px;
        width: 70px;
        border: 1.5px solid #f5f6fa;

    }

    .user_img_msg {
        height: 40px;
        width: 40px;
        border: 1.5px solid #f5f6fa;

    }

    .img_cont {
        position: relative;
        height: 70px;
        width: 70px;
    }

    .img_cont_msg {
        height: 40px;
        width: 40px;
    }

    .online_icon {
        position: absolute;
        height: 15px;
        width: 15px;
        background-color: #4cd137;
        border-radius: 50%;
        bottom: 0.2em;
        right: 0.4em;
        border: 1.5px solid white;
    }

    .offline {
        background-color: #c23616 !important;
    }

    .user_info {
        margin-top: auto;
        margin-bottom: auto;
        margin-left: 15px;
    }

    .user_info span {
        font-size: 20px;
        color: white;
    }

    .user_info p {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.6);
    }

    .video_cam {
        margin-left: 50px;
        margin-top: 5px;
    }

    .video_cam span {
        color: white;
        font-size: 20px;
        cursor: pointer;
        margin-right: 20px;
    }

    .msg_cotainer {
        margin-top: auto;
        margin-bottom: auto;
        margin-left: 10px;
        border-radius: 25px;
        background-color: #82ccdd;
        padding: 0 10px;
        position: relative;
    }

    .msg_cotainer_send {
        margin-top: auto;
        margin-bottom: auto;
        margin-right: 10px;
        border-radius: 25px;
        background-color: #78e08f;
        padding: 0 10px;
        position: relative;
    }

    .msg_time {
        position: absolute;
        left: 0;
        width: 73px;
        bottom: -20px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 10px;
    }

    .msg_time_send {
        position: absolute;
        right: 0;
        width: 73px;
        bottom: -20px;
        color: rgba(255, 255, 255, 0.5);
        font-size: 10px;
    }

    .msg_head {
        position: relative;
    }

    #action_menu_btn {
        position: absolute;
        right: 10px;
        top: 10px;
        color: white;
        cursor: pointer;
        font-size: 20px;
    }

    .action_menu {
        z-index: 1;
        position: absolute;
        padding: 15px 0;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 15px;
        top: 30px;
        right: 15px;
        display: none;
    }

    .action_menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .action_menu ul li {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 5px;
    }

    .action_menu ul li i {
        padding-right: 10px;

    }

    .action_menu ul li:hover {
        cursor: pointer;
        background-color: rgba(0, 0, 0, 0.2);
    }

    @media(max-width: 576px) {
        .contacts_card {
            margin-bottom: 15px !important;
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">

        <div class="col-md-8 col-xl-6 chat">
            <div class="card">
                <div class="card-header msg_head">
                    <div class="d-flex bd-highlight">
                        @foreach($chat->participants as $participant )
                        @if(auth()->user()->id != $participant->user_id)

                        <div class="img_cont">
                            <div class="rounded-circle text-white bg-secondary p-3 text-center">
                                <p class="h4">{{substr($participant->user->username, 0, 1)}}</p>
                                
                            </div>
                        </div>
                        <div class="user_info">
                            <span>{{$participant->user->username}}</span>

                        </div>
                        <div class="video_cam">
                            <span><i class="fas fa-video"></i></span>
                            <span><i class="fas fa-phone"></i></span>
                        </div>
                        @endif
                        @endforeach
                    </div>

                    <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                    <div class="action_menu">
                        <ul>
                            <li><i class="fas fa-user-circle"></i> View profile</li>
                            <li><i class="fas fa-users"></i> Add to close friends</li>
                            <li><i class="fas fa-plus"></i> Add to group</li>
                            <li><i class="fas fa-ban"></i> Block</li>
                        </ul>
                    </div>
                </div>
                <div class="card-body msg_card_body" id="boxRealMessage">

                    @foreach($chat->messages as $message )
                    @if(auth()->user()->id == $message->user_id)
                    <div class="d-flex justify-content-end mb-4">
                        <div class="msg_cotainer_send">
                            {{$message->message}}

                            <span class="msg_time_send">8:55 AM, Today</span>
                        </div>
                        <div class="img_cont_msg">
                            <div class="rounded-circle text-white bg-secondary  text-center user_img_msg">
                                <p class="pt-1">{{substr(auth()->user()->username, 0, 1)}}</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="d-flex justify-content-start mb-4">
                        <div class="img_cont_msg">
                            <div class="rounded-circle text-white bg-secondary  text-center user_img_msg">
                                <p class="pt-1">{{substr($other_user_name, 0, 1)}}</p>
                            </div>
                        </div>
                        <div class="msg_cotainer">
                            {{$message->message}}
                            <span class="msg_time">8:40 AM, Today</span>
                        </div>
                    </div>
                    @endif

                    @endforeach



                </div>
                <!-- <form action="{{url('message/store')}}" method="POST">
                    @csrf
                    <div class="card-footer">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                            </div>
                            <textarea name="message" class="form-control type_msg" placeholder="Type your message..."></textarea>
                            <input name="chat_id" value="{{$chat->id}}" type="hidden">
                            <div class="input-group-append">
                                <button class="btn input-group-text send_btn" type="submit">
                                    <i class="fas fa-location-arrow"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form> -->
                <div class="card-footer">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
                        </div>
                        <textarea id="message" class="form-control type_msg" placeholder="Type your message..."></textarea>
                        <input id="chat_id" value="{{$chat->id}}" type="hidden">
                        <div class="input-group-append">
                            <button class="btn input-group-text send_btn" id="send" type="submit">
                                <i class="fas fa-location-arrow"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@section('js')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<script>
    var message_user_id;
    $(document).ready(function() {
        $("button").click(function() {
            $.post("/message/store", {
                    message: $("#message").val(),
                    chat_id: $("#chat_id").val(),
                },
                function(data, status) {
                    $("#message").val('');
                });
        });
    });

    Pusher.logToConsole = true;
    var pusher = new Pusher('e9cb090a00d813850650', {
        cluster: 'eu'
    });


    var channel = pusher.subscribe("chat.{{$chat->id}}");
    channel.bind('messageSent', function(data) {
        let divMessage;
        if (data['message']['user_id'] != "{{auth()->user()->id}}") {
            divMessage =

                '<div class="d-flex justify-content-start mb-4">' +



                    '<div class="img_cont_msg">' +
                        '<div class="rounded-circle text-white bg-secondary  text-center user_img_msg">' +
                            '<p class="pt-1" >' + data['message']['user']['username'].charAt(0)+'</p>' +
                        ' </div>' +
                    ' </div>'+
            
                    '<div class="msg_cotainer">' +
                        data['message']['message'] +
                        '<span class="msg_time_send">8:55 AM, Today</span>' +
                    ' </div>' +

                '</div>'
        } else {
            divMessage = ' ' +
                '<div class="d-flex justify-content-end mb-4">' +
                '<div class="msg_cotainer_send">' +
                data['message']['message'] +
                '<span class="msg_time_send">8:55 AM, Today</span>' +
                ' </div>' +

                '<div class="img_cont_msg">' +
                '<div class="rounded-circle text-white bg-secondary  text-center user_img_msg">' +
                '<p class="pt-1" >' +
                data['auth_firstChar_name'] +
                '</p>' +
                '</div>' +
                '</div>' +
                '</div>';
        }
        $("#boxRealMessage").append(divMessage);


        // console.log(JSON.stringify(data));
        // alert(JSON.stringify(data));
    });
</script>


<!-- <script src="script.js"></script> -->
@endsection
</body>

</html>
@endsection