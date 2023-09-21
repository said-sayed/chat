@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
@endsection

@section('content')

<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-4 col-xl-3 chat">
            <div class="card mb-sm-3 mb-md-0 contacts_card">
                <div class="card-header">

                    <form action="{{url('search')}}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" placeholder="Search..." name="search" class="form-control search">
                            <div class="input-group-prepend  p-0">
                                <span class="input-group-text search_btn ">
                                    <button class="btn " type="submit">
                                        <i class="fas fa-search search_icon"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body contacts_body">

                    <ui class="contacts">
                        @if( isset( $users))
                        <form action="{{url('chat/store')}}" method="POST">
                            @csrf
                            <ul class="list-unstyled">
                                @foreach($users as $user)

                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <li id="user_id={{$user->id}}">
                                    <button type="submit" class="btn w-100 bg-dark">
                                        <div class=" d-flex">
                                            <div class="img_cont">
                                                <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>{{$user->username}}</span>
                                                <!-- <p>Nargis left 30 mins ago</p> -->
                                            </div>
                                        </div>
                                    </button>
                                </li>

                                @endforeach
                            </ul>
                            @else
                            <li class="list-group-item list-group-item-danger">User Not Found.</li>
                            </button>
                        </form>
                        @endif

                    </ui>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
<script src="script.js"></script>
@endsection