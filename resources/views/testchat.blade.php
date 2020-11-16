@extends('layouts.app')

@section('custom-js')
    <script type="text/javascript">window.roomId = '{{ $id }}';</script>
    <script type="text/javascript" src="{{ asset('js/chat.js') }}" defer></script>
@endsection

@section('content')
<div class="container-fluid">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col">
                <div class="ibox chat-view">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="chat-users">
                                    <div id="users-list" class="users-list">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 ">
                                <div id="chat-discussion" class="chat-discussion">

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="chat-message-form">
                                    <div class="form-row align-items-center">
                                        <div class="col-auto flex-fill">
                                            <textarea class="form-control input-lg" id="inputMsg" name="message" placeholder="Entrez un message et appuyez sur Entrer"></textarea>
                                        </div>
                                        <div class="col-auto">
                                            <button id="sendMsgBtn" type="submit" class="btn btn-block btn-primary flex-grow-5">Envoyer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-head')
    <style type="text/css">
        /* WRAPPERS */
        #wrapper {
            width: 100%;
            overflow-x: hidden;
        }
        .wrapper {
            padding: 0 20px;
        }
        .wrapper-content {
            padding: 20px 10px 40px;
        }
        #page-wrapper {
            padding: 0 15px;
            min-height: 568px;
            position: relative !important;
        }
        @media (min-width: 768px) {
            #page-wrapper {
                position: inherit;
                margin: 0 0 0 240px;
                min-height: 2002px;
            }
        }


        .message-input {
            height: 90px !important;
        }
        .chat-avatar {
            white: 36px;
            height: 36px;
            float: left;
            margin-right: 10px;
        }
        .chat-user-name {
            padding: 5px 5px 5px 10px;
        }
        .chat-user {
            padding: 8px 10px;
            border-bottom: 1px solid #e7eaec;
        }
        .chat-user a {
            color: inherit;
        }
        .chat-view {
            z-index: 20012;
        }
        .chat-users,
        .chat-statistic {
        }
        @media (max-width: 992px) {
            .chat-users,
            .chat-statistic {
                margin-left: 0;
            }
        }
        .chat-view .ibox-content {
            padding: 0;
        }
        .chat-message {
            padding: 10px 20px;
        }
        .message-avatar {
            height: 48px;
            width: 48px;
            border: 1px solid #e7eaec;
            border-radius: 4px;
            margin-top: 1px;
        }
        .chat-discussion .chat-message.left .message-avatar {
            float: left;
            margin-right: 10px;
        }
        .chat-discussion .chat-message.right .message-avatar {
            float: right;
            margin-left: 10px;
        }
        .message {
            background-color: #fff;
            border: 1px solid #e7eaec;
            text-align: left;
            display: block;
            padding: 10px 20px;
            position: relative;
            border-radius: 4px;
        }
        .chat-discussion .chat-message.left .message-date {
            float: left;
        }
        .chat-discussion .chat-message.right .message-date {
            float: right;
        }
        .chat-discussion .chat-message.left .message {
            text-align: right;
            margin-left: 55px;
        }
        .chat-discussion .chat-message.right .message {
            text-align: left;
            margin-right: 55px;
        }
        .message-date {
            font-size: 10px;
            color: #888888;
        }
        .message-content {
            display: block;
        }
        .chat-discussion {
            background: #eee;
            padding: 15px;
            height: 400px;
            overflow-y: auto;
        }
        .chat-users {
            overflow-y: auto;
            height: 400px;
        }
        .chat-message-form .form-group {
            margin-bottom: 0;
        }
        .ibox {
            clear: both;
            margin-bottom: 25px;
            margin-top: 0;
            padding: 0;
        }
        .ibox.collapsed .ibox-content {
            display: none;
        }
        .ibox.collapsed .fa.fa-chevron-up:before {
            content: "\f078";
        }
        .ibox.collapsed .fa.fa-chevron-down:before {
            content: "\f077";
        }
        .ibox:after,
        .ibox:before {
            display: table;
        }
        .ibox-title {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            background-color: #ffffff;
            border-color: #e7eaec;
            border-image: none;
            border-style: solid solid none;
            border-width: 3px 0 0;
            color: inherit;
            margin-bottom: 0;
            padding: 14px 15px 7px;
            min-height: 48px;
        }
        .ibox-content {
            background-color: #ffffff;
            color: inherit;
            padding: 15px 20px 20px 20px;
            border-color: #e7eaec;
            border-image: none;
            border-style: solid solid none;
            border-width: 1px 0;
        }
        .ibox-footer {
            color: inherit;
            border-top: 1px solid #e7eaec;
            font-size: 90%;
            background: #ffffff;
            padding: 10px 15px;
        }

        .message-input {
            height: 90px !important;
        }

    </style>
@endsection
