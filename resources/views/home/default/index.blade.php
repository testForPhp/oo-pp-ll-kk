@extends('home.default.layout')
@section('content')
        @foreach($ad as $item)
        <div class="adbannersss">
            <a href="{{ $item->link }}" target="_blank">
                <img src="{{ $item->img }}" data-bd-imgshare-binded="1" height="60px" width="100%">
            </a>
        </div>
        @endforeach
    @foreach($sort as $key=>$value)
            <div class="item item-0" id="{{ $value->code }}">
                @if($loop->index == 0)
                    @include('home.default.menu')
                @endif
                <h2><a href="/#{{ $value->code }}">{{ $value->title }}</a></h2>
                <ul class="xoxo blogroll">
                    @foreach($value->whereActionOrderByLink() as $item)
                        <li><a href="{{ $item->link }}" target="_blank">
                                @if(!empty($item->color))
                                    <span style="color:{!! $item->color !!} !important;">{{ $item->title }}</span>
                                @else
                                    {{ $item->title }}
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
    @endforeach
    {{--推荐结束--}}
@endsection
