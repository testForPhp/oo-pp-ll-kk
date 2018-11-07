@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <button type="button" class="btn btn-primary add-link-show">增加链接</button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">名称</th>
                            <th scope="col">分类</th>
                            <th scope="col">状态</th>
                            <th scope="col">链接</th>
                            <th scope="col">时间</th>
                            <th scope="col">精品</th>
                            <th scope="col">排名</th>
                            <th scope="col">颜色</th>
                            <th scope="col">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach($links as $key=>$value)
                            <th scope="row">{{ $key }}</th>
                            <td>{{ $value->title }}</td>
                            <td>{{ $value->sort->title }}</td>
                            <td>@if($value->status == 0) 待审核 @elseif($value->status == 1) 正常 @else {{ $value->remark }}@endif</td>
                            <td>{{ $value->link }}</td>
                            <td>{{ $value->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($value->sort_id == Cache::get('fee')->recommend_id)
                                        <button type="button" data-id="{{ $value->id }}" class="btn btn-secondary btn-sm put-recommend">续费</button>
                                    @else
                                        <button type="button" data-id="{{ $value->id }}" class="btn btn-secondary btn-sm put-recommend">申请</button>
                                        @endif
                                </td>
                            <td>
                                    @if($value->type == 0)
                                        <button type="button" class="btn btn-primary btn-sm put-rank-sigin" data-id="{{ $value->id }}">申请</button>
                                    @else
                                    <button type="button" class="btn btn-primary btn-sm put-rank-sigin" data-id="{{ $value->id }}">续费</button>
                                    @endif
                            </td>
                            <td>
                                <button type="button" data-id="{{ $value->id }}" class="btn btn-success btn-sm put-link-color-show">选择</button>
                                @if(isset($value->colorLog->type) && $value->colorLog->type== 'color')
                                    <button type="button" data-id="{{ $value->id }}" class="btn btn-dark btn-sm put-link-color-renew">续费</button>
                                    @endif
                            </td>
                            <td>
                                <button type="button" data-id="{{ $value->id }}" class="btn btn-info btn-sm get-link-edit">编辑</button>
                                <button type="button" data-id="{{ $value->id }}" class="btn btn-danger btn-sm delete-link">删除</button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{ $links->links() }}
                </ul>
            </nav>
            <div class="card mb-3">
                <div class="card-header">
                    说明
                </div>
                <div class="card-body">
                    <p class="text-danger"><span class="text-info font-weight-bold">1、名称：{{ Cache::get('system')->website }};网址：{{ Cache::get('system')->newlink }}; </span>(注：本站友链专用域名，设置本站友链时，请填此域名，填别的域名概不收录，谢谢合作)</p>
                    <p>2、本站免费收录所有站点，但是申请站点需保证有免费资源通道，不收录纯收费站点。申请时请选择网站内容对应的分类，否则本站将不予收录！在贵站首页前五位置处添加本站链接将优先收录。申请后请耐心等待管理审核！</p>
                    <p>3、本站将定期抽查所有网站，如发现链接失效﹑更换本站位置﹑下掉本站链接的情况将立即删除。</p>
                    <p>4、购买增值服务无需等待审核，即时上线！</p>
                    <p class="text-primary">5、因为网站使用缓存，所有新增以及修改均将在5分钟内生效，请耐心等候！</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    增值服务
                </div>
                <div class="card-body">
                    <p class="text-primary">1、精品：网站在"精品推荐"栏目显示并可以自己修改字体颜色.</p>
                    <p class="text-primary">2、排名：置顶至所属分类第一至第七个位置并可以自己修改字体颜色.</p>
                    <p class="text-primary">3、颜色：网站名称自定义颜色.</p>
                    <p class="text-primary">4、请注意，所有的增值服务绑定的是申请时的网站，如果网站被删除，那么服务自动终止。增值服务不能转到别的网站。</p>
                    <p class="text-info font-weight-bold">价格表</p>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">分类名称</th>
                            <th scope="col">数量</th>
                            <th scope="col">剩余数量</th>
                            <th scope="col">价格</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sort as $val)
                        <tr>
                            <th scope="row">
                                @if($val->type == 1)
                                    精品： {{ $val->title }}
                                    @else
                                   排名： {{ $val->title }}
                                @endif
                            </th>
                            <td>
                                @if($val->type == 1)
                                    {{ $fee->recommend_num }}
                                @else
                                    {{ $fee->rank_num }}
                                @endif
                            </td>
                            <td>
                                @if($val->type == 1)
                                {{ $fee->recommend_num - $val->countLink() }}
                                    @else
                                    {{ $fee->rank_num - $val->countLink() }}
                                    @endif
                            </td>
                            <td>
                                @if($val->type == 1)
                                    {{ $fee->recommend }}点/个
                                @else
                                    {{ $fee->rank }}点/个
                                @endif
                            </td>
                        </tr>
                            @endforeach
                        <tr>
                            <th scope="row">颜色</th>
                            <td>-</td>
                            <td>-</td>
                            <td>{{ $fee->color }}点/个</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">链接</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addlink">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">分类</label>
                        <div class="col-sm-10 sort-recommend-from">
                            <select class="form-control" id="exampleFormSort">
                                @foreach($sort as $item)
                                    @if($item->type == 0)
                                <option value="{{ $item->code }}">{{ $item->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div id="recommend-hide" style="display: none;" class="form-control" ></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="exampleFormTitle" placeholder="网站名称最长限制8个字符" name="title">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">链接</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="exampleFormLink" placeholder="网址必须带http://或https://">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" data-id="" class="btn btn-primary put-form">提交</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="colorModel" tabindex="-1" role="dialog" aria-labelledby="colorModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">颜色</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">颜色</label>
                        <div class="col-sm-10 sort-recommend-from">
                            <select class="form-control selectpicker" id="exampleFormColor" multiple>
                                @foreach($color as $item)
                                        <option value="{{ $item->code }}" style="color: {{ $item->color }} !important;">
                                            字体颜色
                                        </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" data-id="" class="btn btn-primary put-link-color">提交</button>
            </div>
        </div>
    </div>
</div>
@endsection
