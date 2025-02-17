@extends('back.layouts.master')

@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{route('back.dashboard')}}">{{ __('container.dashboard') }}</a></li>
                    <li><a>{{ __('container.usersList') }}</a></li>
                </ul>
            </div>

        </div><!-- /.col-md-12 -->
        <!-- END BREADCRUMB -->

        <div class="col-lg-12">
            <div class="portlet box shadow">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h3 class="title">
                            <i class="icon-frane"></i>
                            {{ __('container.usersList') }}
                        </h3>
                    </div><!-- /.portlet-title -->
                    <div class="buttons-box">
                        <a class="btn btn-sm btn-default btn-round btn-fullscreen" rel="tooltip" href="#" aria-label="{{ __('container.fullscreen') }}" data-bs-original-title="{{ __('container.fullscreen') }}">
                            <i class="icon-size-fullscreen"></i>
                            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
                        <a class="btn btn-sm btn-default btn-round btn-collapse" rel="tooltip" href="#" aria-label="{{ __('container.Miniaturize') }}" data-bs-original-title="{{ __('container.Miniaturize') }}">
                            <i class="icon-arrow-up"></i>
                            <div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></a>
                    </div><!-- /.buttons-box -->
                </div><!-- /.portlet-heading -->

                @can('users.delete')
                <div class="mb-2 datatable-actions collapse " style="">
                    <div class="d-flex align-items-center">
                        <div class="font-weight-bold text-danger mr-3"><span id="datatable-selected-rows">0</span> {{__('container.Selected item')}}: </div>

                        <button class="btn btn-danger multiple-delete-modal" data-action="{{route('back.users.multipleDestroy')}}" type="button" data-bs-toggle="modal" data-bs-target="#multiple-delete-modal">{{__('container.Remove all')}}</button>
                    </div>
                </div>
                @endcan

                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width:20px"><input type="checkbox" id="btn-check-all-toggle"></th>
                                <th class="text-center"> {{ __('container.Image') }}</th>
                                <th  style="width: 70px"><i class="icon-energy"></i></th>

                                <th> {{ __('container.type') }}</th>
                                <th> {{ __('container.fullname') }}</th>
                                <th> {{ __('container.mobile') }}</th>
                                <th>{{ __('container.email') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($users))
                                @foreach($users as $item)
                                    <tr>
                                        <td><input class="item-checked" type="checkbox" value="{{$item->id}}"></td>
                                        <td  class="text-center">
                                            <img class="image-thumb-index" @if(!$item->avatar) style="width: 50px;" @endif src="{{ $item->avatar ? asset($item->avatar) : asset('back/assets/images/avatar-empty.png') }}" alt="image">
                                        </td>
                                        <td><small>{{$item->id}}</small></td>
                                        <td>
                                            @if($item->type=="user")
                                                <span class="label label-default">{{ __('container.User') }}</span>
                                            @elseif($item->type=="staff")
                                                <span class="label label-default">{{ __('container.Staff') }}</span>

                                            @elseif($item->type=="acceptor")
                                                <span class="label label-default">{{ __('container.Acceptor') }}</span>
                                            @endif

                                        </td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->mobile}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>
                                            @can('users.show')
                                            <a href="{{route('back.users.show',['user'=>$item])}}">
                                                <button class="btn btn-warning">{{__('container.Show')}}<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00736;"></div><div class="paper-ripple__waves"></div></div></button>
                                            </a>
                                            @endcan
                                                @can('users.update')
                                            <a href="{{route('back.users.edit',['user'=>$item])}}" class="btn btn-info">{{ __('container.Edit') }}<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00256;"></div><div class="paper-ripple__waves"></div></div></a>
                                                @endcan
                                                @can('users.delete')
                                                <button data-bs-toggle="modal" data-bs-target="#delete-modal" data-action="{{route('back.users.destroy',['user'=>$item])}}" class="btn btn-danger delete-modal">{{ __('container.Delete') }}<div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></button>
                                                @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="9">{{__('container.emptyTable')}}</td>
                                </tr>
                            @endif


                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /.portlet-body -->
            </div><!-- /.portlet -->
        </div>

    </div>

    @can('users.delete')
@include('back.partials.delete-modal',['text_body'=>__('container.By deleting the user, you will not be able to recover it.')])
@include('back.partials.multiple-delete-modal',['text_body'=>__('container.By deleting other users, you will not be able to recover them.')])
    @endcan
@endsection
