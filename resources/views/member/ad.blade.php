@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary btn-sm btn-show-ad">添加图片广告</button>
                        <span class="float-right">剩余广告位:{{ $yu }}</span>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">图片</th>
                                <th scope="col">链接</th>
                                <th scope="col">状态</th>
                                <th scope="col">到期时间</th>
                                <th scope="col">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ad as $key=>$value)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td><img src="{{ $value->img }}" alt="" height="60" style="max-width: 520px;"></td>
                                <td>{{ $value->link }}</td>
                                <td>
                                    @if($value->status == 0)
                                        正常
                                        @elseif($value->status ==1)
                                        到期
                                        @endif
                                </td>
                                <td>@if(isset($value->activeLog->end_date))
                                    {{ date('Y-m-d',$value->activeLog->end_date) }}
                                        @else
                                    --
                                        @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm put-ad-renew" data-id="{{ $value->id }}">续费</button>
                                    <button type="button" class="btn btn-info btn-sm btn-ad-edit-show" data-id="{{ $value->id }}">编辑</button>
                                    <button type="button" class="btn btn-danger btn-sm put-ad-delete" data-id="{{ $value->id }}" >删除</button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        说明
                    </div>
                    <div class="card-body">
                        <p class="text-primary">1、本站只提供<strong>{{ $feeCache->img_num }}</strong>个广告位，所有广告位均为头部横幅类型！</p>
                        <p class="text-danger">2、本站广告位只设置包月，价格为：{{ $feeCache->img }}/月!</p>
                        <p>3、广告规格为：1024*60px</p>
                        <p>4、因为网站使用缓存，所以所有增值服务申请后均将在一小时内生效，请稍等！</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">图片广告</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="imgForm">
                        <div class="form-group row">
                            <label for="staticImg" class="col-sm-2 col-form-label">图片</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="staticImg" value="" placeholder="请输入广告图片链接">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputLink" class="col-sm-2 col-form-label">链接</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputLink" placeholder="请输入广告跳转链接">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" data-id="" class="btn btn-primary put-ad-sub">提交</button>
                </div>
            </div>
        </div>
    </div>
@endsection
