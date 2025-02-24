@extends('back.layouts.master')
@section('style')
    <link href="{{asset('back/assets/plugins/persian-datepicker/css/persian-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('back/assets/plugins/charts/apexcharts.css')}}" rel="stylesheet">
    <link href="{{asset('back/assets/css/appointment.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <!-- BEGIN BREADCRUMB -->
        <div class="col-md-12">
            <div class="breadcrumb-box shadow">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.dashboard')}}">{{ __('container.dashboard') }}</a></li>
                    <li><a href="{{route('admin.users.index')}}">{{ __('container.users') }}</a></li>
                    <li><a>{{ __('container.User show') }}</a></li>
                </ul>
            </div>

        </div><!-- /.col-md-12 -->
        <!-- END BREADCRUMB -->


        <div class="col-md-12" id="reservation-fanweb-tbs">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="stat-box use-cyan shadow">
                        <a href="#">
                            <div class="stat">
                                <div class="counter-down" data-value="512"></div>
                                <div class="h3">{{__('container.Confirmed times')}}</div>
                                <div class="counter-down" >{{count($reserves_approved)}}</div>
                            </div><!-- /.stat -->
                            <div class="visual">
                                <i class=" far fa-calendar-check"></i>
                            </div><!-- /.visual -->
                        </a>
                    </div><!-- /.stat-box -->
                </div><!-- /.col-lg-3 -->
                <div class="col-lg-3 col-6">
                    <div class="stat-box use-blue shadow">
                        <a href="#">
                            <div class="stat">
                                <div class="counter-down" data-value="512"></div>
                                <div class="h3">{{__('container.Waiting times')}}</div>
                                <div class="counter-down" >{{count($reserves_pending)}}</div>
                            </div><!-- /.stat -->
                            <div class="visual">
                                <i class=" far fa-hourglass-half"></i>
                            </div><!-- /.visual -->
                        </a>
                    </div><!-- /.stat-box -->
                </div><!-- /.col-lg-3 -->
                <div class="col-lg-3 col-6">
                    <div class="stat-box use-green shadow">
                        <a href="#">
                            <div class="stat">
                                <div class="counter-down" data-value="512"></div>
                                <div class="h3">{{__('container.The entire appointment')}}</div>
                                <div class="counter-down" ><small>{{count($reserves)}}</small></div>
                            </div><!-- /.stat -->
                            <div class="visual">
                                <i class="icon-calendar"></i>
                            </div><!-- /.visual -->
                        </a>
                    </div><!-- /.stat-box -->
                </div><!-- /.col-lg-3 -->
                @if($user->isAcceptor())
                <div class="col-lg-3 col-6">
                    <div class="stat-box use-lime shadow">
                        <a href="#">
                            <div class="stat">
                                <div class="counter-down" data-value="512"></div>
                                <div class="h3">{{__('container.Income')}}</div>
                                <div class="counter-down" style="direction: rtl"><small>{{numberFormat($reserves_price->sum()) . ' ' . get_currency($user->id)}}</small></div>
                            </div><!-- /.stat -->
                            <div class="visual">
                                <i class="icon-wallet"></i>
                            </div><!-- /.visual -->
                        </a>
                    </div><!-- /.stat-box -->
                </div><!-- /.col-lg-3 -->
                @endif
            </div><!-- /.row -->
            <div class="col-12">
                <div class="portlet box shadow">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h3 class="title">
                                <i class="icon-note"></i>
                                {{__('container.User profile')}}
                            </h3>
                        </div><!-- /.portlet-title -->
                    </div><!-- /.portlet-heading -->
                    <div class="portlet-body">
                        <section class="page-users-view">
                            <div class="row">
                                <!-- account start -->
                                <div class="col-12">
                                    <div class="card mb-0">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="users-view-image d-flex justify-content-sm-between">
                                                    <img width="55px" height="55px"  src="{{ $user->avatar ? asset($user->avatar) : asset('back/assets/images/avatar-empty.png') }}" class="users-avatar-shadow rounded mb-2 pr-2 ml-1" alt="avatar">
                                                    @if($user->isAcceptor())
                                                    <a class="btn" data-bs-toggle="modal" data-bs-target="#invitation-link-user-acceptor-modal">
                                                        <i class="fas fa-barcode"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                                <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <td class="fw-bold pe-2">{{ __('container.fullname') }}</td>
                                                            <td>{{$user->name}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="fw-bold">{{ __('container.email') }}</td>
                                                            <td>{{$user->email}}</td>
                                                        </tr>

                                                        <tr>
                                                            <td class="fw-bold">{{ __('container.type') }}</td>
                                                            <td>
                                                                @if($user->type=="user")
                                                                    <span class="label label-default">{{ __('container.User') }}</span>
                                                                @elseif($user->type=="staff")
                                                                    <span class="label label-default">{{ __('container.Staff') }}</span>

                                                                @elseif($user->type=="acceptor")
                                                                    <span class="label label-default">{{ __('container.Acceptor') }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>



                                                        </tbody></table>
                                                </div>
                                                <div class="col-12 col-md-12 col-lg-5">
                                                    <table class="ml-0 ml-sm-0 ml-lg-0">
                                                        <tbody>
                                                        <tr>
                                                            <td class="fw-bold ">{{ __('container.Id') }}</td>
                                                            <td>{{$user->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">{{ __('container.mobile') }}</td>
                                                            <td>{{$user->mobile}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold">{{__('container.Date of registration')}}</td>
                                                            <td>
                                                                <abbr title="{{ convertTime($user->created_at) }}">{{ convertTime($user->created_at) }}</abbr>
                                                            </td>
                                                        </tr>

                                                        </tbody></table>
                                                </div>
                                                <div class="col-md-10 offset-md-1 mt-2">
                                                    <a href="{{route('admin.users.edit',$user)}}" class="btn btn-warning mr-1 waves-effect waves-light"><i class="feather icon-edit-1"></i> {{ __('container.Edit') }}</a>



                                                    <button data-bs-toggle="modal" data-bs-target="#delete-modal" data-action="{{route('admin.users.destroy',['user'=>$user])}}" class="btn btn-danger delete-modal">{{ __('container.Delete') }}<div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- account end -->

                            </div>
                        </section>
                    </div><!-- /.portlet-body -->
                </div><!-- /.portlet -->
            </div>

            @if($user->isAcceptor())
                <div class="row">
                    <div class="col-lg-12" id="statistics-card">
                        <div class="portlet box shadow">
                            <div class="portlet-heading">
                                <div class="portlet-title">
                                    <h3 class="title">
                                        <i class="icon-graph"></i>
                                        {{__('container.General Report')}}
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
                            <div class="portlet-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="order-values" role="tabpanel" aria-labelledby="value">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul data-default-period="monthly" class="nav nav-pills statics-tab statistics-period" >
                                                    <li class="nav-link active" data-period="daily"> {{__('container.Daily')}}</li>
                                                    <li class="nav-link" data-period="weekly">{{__('container.weekly')}}</li>
                                                    <li class="nav-link" data-period="monthly">{{__('container.monthly')}}</li>
                                                    <li class="nav-link" data-period="yearly">{{__('container.yearly')}}</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mx-0 form-group align-items-baseline">
                                                    <div class="col-md-6 px-0 d-flex align-items-baseline">
                                                        <label class="pre-space ms-3" for="from"><?= __('container.from') ?> : </label>
                                                        <input class="form-control persian_date_picker" name="from_date" type="text" autocomplete="off">
                                                        <i class="fa fa-calendar in-calendar"></i>
                                                    </div>
                                                    <div class="col-md-6 px-0 d-flex align-items-baseline">
                                                        <label class="pre-space ms-3" for="until"><?= __('container.Up to date') ?> : </label>
                                                        <input class="form-control persian_date_picker" type="text" name="to_date" autocomplete="off">
                                                        <i class="fa fa-calendar in-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="reserve-values-chart" class="chart-area" style="min-height: 445px;" data-min-height="445px" data-action="{{ route('admin.users.statistics.reservedValues',$user) }}"></div>

                                        <div class="col-12 p-0">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span class="border-bottom">{{__('container.All payments')}} : <span class="orders-total"></span></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="border-bottom">{{__('container.Average')}} : <span class="orders-avg"></span></span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="border-bottom"> {{__('container.Successful payments')}}: <span class="orders-success"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.portlet-body -->
                        </div><!-- /.portlet -->
                    </div><!-- /.col-lg-12 -->
                </div>
            @endif

                <div class="col-lg-12">
                    <div class="portlet box shadow">
                        <div class="portlet-heading">
                            <div class="portlet-title">
                                <h3 class="title">
                                    <i class="icon-frane"></i>
                                    {{ __('container.Appointments') }}
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


                        <div class="mb-2 datatable-actions collapse " style="">
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold text-danger mr-3"><span id="datatable-selected-rows">0</span> {{__('container.Selected item')}}: </div>

                                <button class="btn btn-danger multiple-delete-modal" data-action="{{route('admin.appointment.reserved.multipleDestroy')}}" type="button" data-bs-toggle="modal" data-bs-target="#multiple-delete-modal">{{__('container.Remove all')}}</button>
                            </div>
                        </div>

                        <form method="get" class="filters">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>  {{ __('container.Customer Name') }}</label>
                                        <div class="input-group">
                                            <input name="search" type="text" value="{{request('search')}}" class="form-control">
                                        </div><!-- /.input-group -->
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>  {{ __('container.staff') }}</label>
                                        <select class="form-control select2" name="staff">
                                            <option value="">{{__('container.All')}}</option>
                                            @foreach($staffs as $staff)
                                                <option {{request('staff')==$staff->id ? "selected" : ""}} value="{{$staff->id}}">{{$staff->user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>  {{ __('container.from') }}</label>
                                        <div class="input-group">
                                            <input name="from_date" type="text"  value="{{request('from_date')}}" class="form-control persian_date_picker" autocomplete="off">
                                            <i class="fa fa-calendar in-calendar position-absolute" style="left: 8px;top: 12px"></i>
                                        </div><!-- /.input-group -->
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>  {{ __('container.Up to date') }}</label>
                                        <div class="input-group">
                                            <input name="to_date" value="{{request('to_date')}}" type="text" class="form-control persian_date_picker" autocomplete="off">
                                            <i class="fa fa-calendar in-calendar position-absolute" style="left: 8px;top: 12px"></i>
                                        </div><!-- /.input-group -->
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>  {{ __('container.Status') }}</label>
                                        <select class="form-control " name="status">
                                            <option  value="">{{__('container.All')}}</option>
                                            <option {{request('status')=="pending" ? "selected" : ""}} value="pending"><?= __('container.Pending'); ?></option>
                                            <option {{request('status')=="rejected" ? "selected" : ""}}  value="rejected"><?= __('container.Rejected'); ?></option>
                                            <option {{request('status')=="cancelled" ? "selected" : ""}}  value="cancelled"><?= __('container.Cancelled'); ?></option>
                                            <option {{request('status')=="approved" ? "selected" : ""}}  value="approved"><?= __('container.Approved'); ?></option>
                                            <option {{request('status')=="done" ? "selected" : ""}}  value="done"><?= __('container.Done'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-secondary btn-icon curve mt-4"><i class="icon-magnifier"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th style="width:20px"><input type="checkbox" id="btn-check-all-toggle"></th>
                                        <th style="width: 70px"><i class="icon-energy"></i></th>
                                        <th> {{ __('container.Appointment date') }}</th>
                                        <th> {{ __('container.staff') }}</th>
                                        <th>{{ __('container.Customer Name') }}</th>
                                        <th>{{ __('container.Customer phone') }}</th>
                                        <th>{{ __('container.Time') }}</th>
                                        <th>{{ __('container.Price') }}</th>
                                        <th>{{ __('container.Status') }}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($reserveds))
                                        @foreach($reserveds as $item)
                                            @php
                                                $start_time = $item->start_time;
                                                $end_time = $item->end_time;
                                                $start_datetime = new DateTime($start_time);
                                                $end_datetime = new DateTime($end_time);
                                                $interval = $start_datetime->diff($end_datetime);
                                                $diff_in_hours = $interval->h;
                                                $diff_in_minutes = $interval->i;
                                            @endphp
                                            <tr>
                                                <td><input class="item-checked" type="checkbox" value="{{$item->id}}"></td>
                                                <td><small>{{$item->id}}</small></td>
                                                <td>{{convertTime($item->date)}}</td>
                                                <td>{{@$item->staff->user->name ?: __('container.Deleted')}}</td>
                                                <td>{{$item->user->name}}</td>
                                                <td>{{$item->user->mobile}}</td>
                                                <td>
                                                    @if ($diff_in_hours>0)
                                                        {{$diff_in_hours.' '. __('container.hour')}}
                                                    @else
                                                        @if ($diff_in_minutes>0)
                                                            {{$diff_in_minutes.' '. __('container.minutes')}}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{numberFormat($item->price).' '.@get_currency(@$item->staff->user->user_id)}}</td>
                                                <td>
                                                    <small class="d-flex flex-column status-column" style="max-width: fit-content">


                                                        @if ($item->status_payment=="paid")
                                                            <span class="badge badge-success text-center"><?= __('container.Paid'); ?></span>
                                                        @elseif($item->status_payment=="unpaid")
                                                            <span class="badge badge-danger text-center"><?= __('container.Unpaid'); ?></span>
                                                        @elseif($item->status_payment=="afterPay")
                                                            <span class="badge badge-info text-center"><?= __('container.after payment'); ?></span>
                                                        @endif

                                                        @if ($item->status_payment!="unpaid")
                                                            @if ($item->status=="done")
                                                                <span class="badge badge-success mt-1 text-center status"><?= __('container.Done'); ?></span>
                                                            @elseif($item->status=="approved")
                                                                <span class="badge badge-success mt-1 text-center status"><?= __('container.Approved'); ?></span>
                                                            @elseif($item->status=="cancelled")
                                                                <span class="badge badge-danger mt-1 text-center status"><?= __('container.Cancelled'); ?></span>
                                                            @elseif($item->status=="rejected")
                                                                <span class="badge badge-danger mt-1 text-center status"><?= __('container.Rejected'); ?></span>
                                                            @elseif($item->status=="pending")
                                                                <span class="badge badge-warning mt-1 text-center status"><?= __('container.Pending'); ?></span>
                                                            @endif
                                                        @endif

                                                    </small>
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.appointment.reserved.show',$item)}}" class="btn btn-info">{{ __('container.Show') }}<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00256;"></div><div class="paper-ripple__waves"></div></div></a>
                                                    <button data-bs-toggle="modal" data-bs-target="#delete-modal" data-action="{{route('admin.appointment.reserved.destroy',['reserved'=>$item])}}" class="btn btn-danger delete-modal">{{ __('container.Delete') }}<div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="10">{{__('container.emptyTable')}}</td>
                                        </tr>
                                    @endif


                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->

                        </div><!-- /.portlet-body -->

                    </div><!-- /.portlet -->
                </div>

            @if($user->isAcceptor())
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

                                    <button class="btn btn-danger multiple-delete-modal" data-action="{{route('admin.users.multipleDestroy')}}" type="button" data-bs-toggle="modal" data-bs-target="#multiple-delete-modal">{{__('container.Remove all')}}</button>
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
                                    @if(count($normalUsers))
                                        @foreach($normalUsers as $item)
                                            <tr>
                                                <td><input class="item-checked" type="checkbox" value="{{$item->id}}"></td>
                                                <td  class="text-center">
                                                    <img class="image-thumb-index btn-round" width="55px" height="55px" src="{{ $item->avatar ? asset($item->avatar) : asset('back/assets/images/avatar-empty.png') }}" alt="image">
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
                                                        <a href="{{route('admin.users.show',['user'=>$item])}}">
                                                            <button class="btn btn-warning">{{__('container.Show')}}<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00736;"></div><div class="paper-ripple__waves"></div></div></button>
                                                        </a>
                                                    @endcan
                                                    @can('users.update')
                                                        <a href="{{route('admin.users.edit',['user'=>$item])}}" class="btn btn-info">{{ __('container.Edit') }}<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00256;"></div><div class="paper-ripple__waves"></div></div></a>
                                                    @endcan
                                                    @can('users.delete')
                                                        <button data-bs-toggle="modal" data-bs-target="#delete-modal" data-action="{{route('admin.users.destroy',['user'=>$item])}}" class="btn btn-danger delete-modal">{{ __('container.Delete') }}<div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></button>
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


                <div class="col-lg-12">
                    <div class="portlet box shadow">
                        <div class="portlet-heading">
                            <div class="portlet-title">
                                <h3 class="title">
                                    <i class="icon-frane"></i>
                                    {{ __('container.Staffs') }}
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

                                    <button class="btn btn-danger multiple-delete-modal" data-action="{{route('admin.users.multipleDestroy')}}" type="button" data-bs-toggle="modal" data-bs-target="#multiple-delete-modal">{{__('container.Remove all')}}</button>
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
                                    @if(count($staffUsers))
                                        @foreach($staffUsers as $item)
                                            <tr>
                                                <td><input class="item-checked" type="checkbox" value="{{$item->id}}"></td>
                                                <td  class="text-center">
                                                    <img class="image-thumb-index btn-round" width="55px" height="55px" src="{{ $item->avatar ? asset($item->avatar) : asset('back/assets/images/avatar-empty.png') }}" alt="image">
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
                                                    @can('appointments.staff.timing')
                                                        <a href="{{route('admin.appointment.staffs-timing.index',['staff'=>$item->staff()])}}" class="btn btn btn-success">{{ __('container.Timing') }}<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00256;"></div><div class="paper-ripple__waves"></div></div></a>
                                                    @endcan
                                                    @can('users.show')
                                                        <a href="{{route('admin.users.show',['user'=>$item])}}">
                                                            <button class="btn btn-warning">{{__('container.Show')}}<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00736;"></div><div class="paper-ripple__waves"></div></div></button>
                                                        </a>
                                                    @endcan
                                                    @can('users.update')
                                                        <a href="{{route('admin.users.edit',['user'=>$item])}}" class="btn btn-info">{{ __('container.Edit') }}<div class="paper-ripple"><div class="paper-ripple__background" style="opacity: 0.00256;"></div><div class="paper-ripple__waves"></div></div></a>
                                                    @endcan
                                                    @can('users.delete')
                                                        <button data-bs-toggle="modal" data-bs-target="#delete-modal" data-action="{{route('admin.users.destroy',['user'=>$item])}}" class="btn btn-danger delete-modal">{{ __('container.Delete') }}<div class="paper-ripple"><div class="paper-ripple__background"></div><div class="paper-ripple__waves"></div></div></button>
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
            @endif


        </div>

    </div>
    <div id="invitation-link-user-acceptor-modal" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{__('container.Your invitation link')}}</h4>
                </div><!-- /.modal-header -->
                <div class="modal-body">
                    <div class="form-body mb-4">
                        {{--  <a download="" class="btn btn-primary" href="data:image/png;base64,{!! base64_encode(QrCode::format('png')->margin(3)->backgroundColor(255, 255, 255)->size(250)->generate(route('register').'?refid='.Auth::id()) ) !!}">
                              <i class=" fas fa-download"></i>
                          </a>--}}

                        <div class="visible-print text-center">
                            {!! QrCode::size(150)->generate(route('register').'?refid='.$user->id); !!}
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="input-group round">
                            <input type="text" name="invitation-link-acceptor" class="form-control" value="{{route('register').'?refid='.$user->id}}">
                            <span class="input-group-btn">
                         <button id="invitation-link-acceptor-copy-btn" class="btn btn-warning" type="button">{{__('container.Copy')}}</button>
                    </span>


                        </div><!-- ./input-group -->
                    </div>
                </div><!-- /.modal-body -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        <script>
            var copy_link_text='{{__('container.The link was copied')}}';
        </script>
    </div>
@include('back.partials.delete-modal',['text_body'=>__('container.By deleting the user, you will not be able to recover it.')])

@endsection
@section('scripts')

    <script>
        var successOrdersText='{{__('container.Paid')}}';
        var failOrdersText='{{__('container.Unpaid')}}';
        var ViewerChartData = ['دوشنبه', 'یکشنبه', 'شنبه', 'جمعه', 'پنج‌شنبه', 'چهارشنبه', 'سه‌شنبه'];
    </script>
    <script src="{{asset('back/assets/plugins/persian-date/persian-date.min.js')}}"></script>
    <script src="{{asset('back/assets/plugins/charts/apexcharts.min.js')}}"></script>
    <script src="{{asset('back/assets/plugins/persian-datepicker/js/persian-datepicker.min.js')}}"></script>

    <script src="{{asset('back/app-assets/js/pages/appointments/dashboard/index.js')}}"></script>

@endsection

