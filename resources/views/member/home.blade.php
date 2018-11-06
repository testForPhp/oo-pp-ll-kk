@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">会员信息</div>
                <div class="card-body list-group p-0">
                    <li class="list-group-item">用户名：{{ Auth::user()->name }}</li>
                    <li class="list-group-item">用户邮箱：{{ Auth::user()->email }}</li>
                    <li class="list-group-item">用户点数：{{ Auth::user()->point }}</li>
                </div>
            </div>
        </div>
        <div class="col-md-10 mt-3">
            <div class="card">
                <div class="card-header">讯息</div>
                <div class="card-body ">
                    {!! Cache::get('system')->member_notice !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
