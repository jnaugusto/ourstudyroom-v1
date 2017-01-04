@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('dashboard-navigation')
	<ul class="navigation">
        <li class="nav-header">
            Navigation
        </li>
        <li>
            <router-link :to="{ name: 'dashboard' }" class="main-menu" @click="setBreadcrumb('Dashboard','dashboard', $event)" data-id="dashboard">
                <div>
                    <i class="dashboard icon"></i>
                    Dashboard
                </div>  
            </router-link>
        </li>
        <li>
            <router-link :to="{ name: 'administrator' }" class="main-menu" @click="setBreadcrumb('Administrator','users', $event)" data-id="administrator">
                <div>
                    <i class="users icon"></i>
                    Administrator
                </div>
            </router-link>
        </li>
    </ul>
@endsection