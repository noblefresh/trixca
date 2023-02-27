@extends('layouts.app')
@section('title', 'Refered Users')
@section('content')
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('admin_dashboard') }}">{{__('refered_users_page.home')}}</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      @if(Auth()->user()->bonus_amount >= 500)
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('cashout_bonus') }}">{{ __('refered_users_page.home')}}</a>
      </li>
      @endif
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('make_investment') }}">{{ __('refered_users_page.invest')}}</a></li>
    </ul>
  </div>
</nav>
<div class="uk-grid-match uk-grid-small uk-flex-center" uk-grid>
  @if(Auth::User()->is_admin() && isset($user_investments))
  <div class="uk-width-1-2@xl uk-width-1-2@l  uk-width-3-4@m uk-width-1-1@s">
    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">{{ __('refered_users_page.account details')}}</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <ul class="uk-list uk-list-divider">
          <li class="uk-padding-small">
            <div class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match" uk-grid>
              <div class="uk-width-1-3">
                <div class="uk-grid-small uk-flex-middle uk-text-right" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">{{ __('refered_users_page.name')}}</h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-2-3">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>{{$user_data->last_name." ".$user_data->first_name}} </h5>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="uk-padding-small">
            <div class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match" uk-grid>
              <div class="uk-width-1-3">
                <div class="uk-grid-small uk-flex-middle uk-text-right" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">{{ __('refered_users_page.username')}}</h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-2-3">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>{{$user_data->username}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="uk-padding-small">
            <div class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match" uk-grid>
              <div class="uk-width-1-3">
                <div class="uk-grid-small uk-flex-middle uk-text-right" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">{{ __('refered_users_page.joined')}}</h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-2-3">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>{{ Carbon::parse($user_data->created_at->toDateTimeString())->diffForHumans() }}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="uk-padding-small">
            <div class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match" uk-grid>
              <div class="uk-width-1-3">
                <div class="uk-grid-small uk-flex-middle uk-text-right" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">{{ __('refered_users_page.last login')}}</h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-2-3">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>{{ Carbon::parse($user_data->updated_at->toDateTimeString())->diffForHumans() }}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="uk-padding-small">
            <div class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match" uk-grid>
              <div class="uk-width-1-3">
                <div class="uk-grid-small uk-flex-middle uk-text-right" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">{{ __('refered_users_page.wallet')}}</h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-2-3">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>{{$user_data->wallet_amount}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="uk-padding-small">
            <div class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match" uk-grid>
              <div class="uk-width-1-3">
                <div class="uk-grid-small uk-flex-middle uk-text-right" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">{{ __('refered_users_page.bonus')}}</h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-2-3">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>{{$user_data->bonus_amount}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="uk-padding-small">
            <div class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match" uk-grid>
              <div class="uk-width-1-3">
                <div class="uk-grid-small uk-flex-middle uk-text-right" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">{{ __('refered_users_page.email')}}</h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-2-3">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>{{$user_data->email}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="uk-padding-small">
            <div class="uk-grid-collapse uk-margin-small-top uk-grid-divider uk-text-center uk-grid-match" uk-grid>
              <div class="uk-width-1-3">
                <div class="uk-grid-small uk-flex-middle uk-text-right" uk-grid>
                  <div class="uk-width-expand">
                    <h5 class="uk-text-bold">{{ __('refered_users_page.phone')}}</h5>
                  </div>
                </div>
              </div>
              <div class="uk-width-2-3">
                <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                  <div class="uk-width-expand">
                    <h5>{{$user_data->phone}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <hr class="uk-margin-remove">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">{{ __('refered_users_page.sponsorship link')}}</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-small">
        <div class="uk-inline">
          <span class="uk-text-break"
            id="sponor_link">{{sprintf('%s/%s',route('register_with_referer'), $user_data->username)}}</span>
          <button type="button" onclick="copyToClipboard('sponor_link')" class="" uk-icon="icon: copy"></button>
        </div>
      </div>
    </div>
  </div>
  @endif
  <div class="uk-width-1-2@xl uk-width-1-2@l  uk-width-3-4@m uk-width-1-1@s">
    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">@if($user_data->id == Auth::User()->id)
            {{ __('refered_users_page.your')}} @else
            {{$user_data->last_name." ".$user_data->first_name}} @endif
            {{ __('refered_users_page.level')}}:{{$next_ref_level-1}} {{ __('refered_users_page.referals')}}
            @if(Request::route('level') >1) from: {{Request::route('ref_name')}} @endif</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
          <thead>
            <tr>
              <th class="uk-text-left">#</th>
              <th class="uk-text-right">{{ __('refered_users_page.name')}}</th>
              <th class="uk-text-right">{{ __('refered_users_page.earning')}}</th>
              <th class="uk-text-right">{{ __('refered_users_page.time')}}</th>
              {{-- <th class="uk-text-right">Time</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($refered_users as $ref)
            <tr>
              <td class="uk-table-link">@if($next_ref_level != 0 && $next_ref_level < 2)<a
                  href="{{route('refered_users',['referer_id'=>$ref->id,'level'=>$next_ref_level,'ref_name'=>$ref->last_name." ".$ref->first_name])}}"
                  class="uk-link-reset">@endif{{$loop->iteration}}@if($next_ref_level != 0 && $next_ref_level < 2) </a>
                    @endif</td> <td class="uk-text-right">@if($next_ref_level != 0 && $next_ref_level < 2)<a
                      href="{{route('refered_users',['referer_id'=>$ref->id,'level'=>$next_ref_level,'ref_name'=>$ref->last_name." ".$ref->first_name])}}"
                      class="uk-link-reset">@endif{{$ref->last_name." ".$ref->first_name}}@if($next_ref_level != 0 &&
                      $next_ref_level < 2) </a> @endif</td> <td class="uk-text-right">@if($next_ref_level != 0 &&
                        $next_ref_level < 2)<a
                          href="{{route('refered_users',['referer_id'=>$ref->id,'level'=>$next_ref_level,'ref_name'=>$ref->last_name." ".$ref->first_name])}}"
                          class="uk-link-reset">@endif${{($ref->total_amount * $bonus_multiplier)}}@if($next_ref_level
                          != 0 && $next_ref_level < 2) </a> @endif</td> <td class="uk-text-right">@if($next_ref_level !=
                            0 && $next_ref_level < 2)<a
                              href="{{route('refered_users',['referer_id'=>$ref->id,'level'=>$next_ref_level,'ref_name'=>$ref->last_name." ".$ref->first_name])}}"
                              class="uk-link-reset">@endif
                              {{ Carbon::parse(Carbon::create("{$ref->created_at}")->toDateTimeString())->diffForHumans() }}
                              @if($next_ref_level != 0 && $next_ref_level < 2) </a> @endif</td> </tr> @endforeach
                                </tbody> </table> </div> @if ($refered_users->hasPages())
                                <div class="uk-text-center uk-card-footer">
                                  {!! $refered_users->links() !!}
                                </div>
                                @endif
      </div>
    </div>
  </div>
  @if(Auth::User()->is_admin() && isset($user_investments))
  <div class="uk-margin-small uk-width-1-1">
    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom">@if($user_data->id == Auth::User()->id) Your @else
            {{$user_data->last_name." ".$user_data->first_name}} @endif {{ __('refered_users_page.investments')}}</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
          <thead>
            <tr>
              <th class="uk-text-left">#</th>
              <th class="uk-text-right">{{ __('refered_users_page.amount')}}</th>
              <th class="uk-text-right">{{ __('refered_users_page.status')}}</th>
            </tr>
          </thead>
          <tbody>
          <tbody>
            @foreach ($user_investments as $investment)
            <tr>
              <td><a class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">{{$loop->iteration}}</a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">{{$investment->total_amount}}</a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">
                  {{ Carbon::parse(Carbon::create("{$investment->created_at}")->toDateTimeString())->diffForHumans() }}
                </a></td>
              <td class="uk-text-right"><a tabindex="-1" class="uk-link-text"
                  href="{{route('show_investment',['id'=>$investment->id])}}">
                  @switch($investment->status)
                  @case('created')
                  <span class="blue-text mdi mdi-18px mdi-pencil-plus"></span>
                  @break
                  @case('pending')
                  <span class="orange-text mdi mdi-18px mdi-circle-outline"></span>
                  @break
                  @case('failed')
                  <span class="red-text mdi mdi-18px mdi-close"></span>
                  @break
                  @case('completed')
                  <span class="green-text mdi mdi-18px mdi-check"></span>
                  @break
                  @endswitch
                </a></td>
            </tr>
            @endforeach
          </tbody>
          </tbody>
        </table>
      </div>
      @if ($user_investments->hasPages())
      <div class="uk-text-center uk-card-footer">
        {!! $user_investments->links() !!}
      </div>
      @endif
    </div>
  </div>
  @endif
  @endsection
