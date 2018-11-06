@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">个人增值服务记录</div>
                    <div class="card-body p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">网站名称</th>
                                <th scope="col">类型</th>
                                <th scope="col">到期时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($feelog as $key=>$value)
                            <tr>
                                <th scope="row">{{ $key }}</th>
                                <td>@if(isset($value->link->title))
                                    {{ $value->link->title }}
                                        @else
                                    已删除
                                        @endif
                                </td>
                                <td>
                                    @if($value->type == 'recommend')
                                        精品推荐
                                        @elseif($value->type == 'rank')
                                        分类排名
                                        @elseif($value->type == 'color')
                                        颜色推荐
                                        @endif
                                </td>
                                <td>
                                    {{ date('Y-m-d',$value->end_date) }}
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                       {{ $feelog->links() }}
                    </ul>
                </nav>
            </div>

        </div>
    </div>
@endsection
