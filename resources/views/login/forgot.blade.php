@extends('layouts.general')

@section('title', 'Forgot Account')

@section('general-body-border')
    <div class="ui segment override wrapper general-parts general-body">
        <div class="ui segment override header">
            <div class="header-title">
                <i class="refresh icon"></i>
                <div class="title">Reset Password</div>
            </div>
            <div class="header-actions"></div>
        </div>
        <div class="general-body-content">
            <div class="gen-header">
                <img src="{{ asset('images/profile_images/default.png') }}">
                <strong>Jess Noel Augusto</strong>
                <small>jessnoel.augusto@gmail.com</small>
            </div>
            <div class="gen-body ui segment loaders">
                <div class="ui form">
                    <div class="field override margin">
                        <label>*Please enter your new password</label>
                        <div class="ui left icon input override">
                            <input type="password" placeholder="New Password" autofocus>
                            <i class="lock icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input override">
                            <input type="password" placeholder="Confirm Password">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                </div>
                <div class="ui inverted dimmer">
                    <div class="ui text loader">Sending email confirmation</div>
                </div>
                <p></p>
            </div>
            <div class="gen-footer">
                <div class="ui checkbox override"></div>
                <div>
                    <button class="ui tiny teal button override">
                        Reset
                    </button>
                    <a class="ui tiny teal button override" href="{{ url('/') }}">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('general-forgot-pass', '')