@extends('layouts.general')

@section('title', 'Identify Account')

@section('general-body-border')
    <div class="ui segment override wrapper general-parts general-body">
        <div class="ui segment override header">
            <div class="header-title">
                <i class="search icon"></i>
                <div class="title">Find your account</div>
            </div>
            <div class="header-actions"></div>
        </div>
        <div class="general-body-content">
            <div class="gen-body ui segment loaders">
                <div class="ui form">
                    <div class="field">
                        <label class="override">Email Address or Username</label>
                        <div class="ui left icon input override">
                            <input type="text" placeholder="Email or Username">
                            <i class="mail icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gen-footer">
                <div class="ui checkbox override"></div>
                <div>
                    <button class="ui labeled icon tiny teal button override">
                        <i class="search icon"></i>
                        Search
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