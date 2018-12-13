@extends('admin.comments.layout')

@section('page_subtitle')
    <div class="m-portlet__head-caption">
        <i class="glyphicon glyphicon-comment"></i> {{ trans('admin.comments.title') }}
    </div>
@stop

@section('comment_content')
    <table class="table_sort2 table table-striped2 table-hover2 table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>{{ trans('admin.base.user') }}</th>
            <th style="width: 100%">{{ trans('admin.base.body') }}</th>
            {{--<th>Approved</th>--}}
            <th>{{ trans('admin.base.created') }}</th>
            <th class="text-right">{{ trans('admin.base.option') }}</th>
        </tr>
        </thead>


        <tbody>
        @forelse($comments as $comment)
            <tr class="{{ $comment->approved ? 'approved' : '' }}">
                <td>
                    {{ $comment->id }}
                </td>
                <td>
                    @if($comment->user)
                        {{ $comment->user->full_name }}
                    @endif
                </td>
                <td>
                    <h4 style="margin-top: 0">
                        @if($comment->commentable->getUrl())
                            <a href="{{ $comment->commentable->getUrl() }}" target="_blank">
                                {{ $comment->commentable->name }}
                            </a>
                        @else
                            {{ $comment->commentable->name }}
                        @endif
                    </h4>

                    @if($comment->parent)
                        <div style="opacity: 0.4; margin-bottom: 5px;">
                            {{ $comment->parent->body }}
                        </div>
                    @endif

                    <div class="comment__body">
                        {{ $comment->body }}
                    </div>

                    @if($comment->children->count())
                        <div class="bold" style="margin-top: 5px;">
                            {{ trans('admin.comments.nested') }} {{ $comment->children->count() }}
                        </div>
                    @endif
                </td>
                {{--<td>--}}
                    {{--{{ $comment->approved }}--}}
                {{--</td>--}}
                <td>
                    <div class="text-nowrap">
                        {{ Carbon::parse($comment->created_at)->format('d.m.Y') }}
                    </div>
                    <div class="text-nowrap">
                        {{ Carbon::parse($comment->created_at)->format('H:i') }}
                    </div>
                </td>

                <td class="text-right">
                    {{--@role('superadmin')--}}
                        {{--@if(Auth::user()->id != $user->id)--}}
                            {{--<a class="btn btn-warning btn-xs " href="{{ route('user.login_as', $user->id) }}">Login as user <span class="glyphicon glyphicon-new-window"></span></a>--}}
                        {{--@endif--}}
                    {{--@endrole--}}

                    {{--<a class="btn btn-brand m-btn m-btn--icon m-btn--pill m-btn--air btn-xs" href="{{ route('admin.user.edit', $user->id) }}"><i class="fa fa-pencil"></i> View</a>&nbsp;--}}
                    {{--<a class="btn btn-warning btn-xs " href="{{ route('admin.user.edit', $user->id) }}">{{ trans('admin.base.edit') }}</a>--}}

                    @if(!$comment->approved)
                         <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" style="display: inline-block; width: 100%; margin-bottom: 10px;"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button class="btn btn-success btn-xs" type="submit" style="width: 100%"><i class="fa fa-check"></i> Approve</button></form>
                    @endif
                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display: inline-block; width: 100%;"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button class="btn btn-danger btn-xs" type="submit" style="width: 100%"><i class="fa fa-trash-o"></i> {{ trans('admin.base.delete') }}</button></form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10">
                    <div class="empty">
                        {{ trans('admin.comments.empty') }}
                    </div>
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

    {!! $comments->render() !!}
@stop