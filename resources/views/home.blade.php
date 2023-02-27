@extends('layouts.app')
@section('title', __('homepage.title'))
@section('content')
<div id="user">
  <div class="uk-grid-match uk-grid-small uk-flex-center" uk-grid>
    <div class="uk-width-3-4@m uk-width-1-1@s">
      <div class="uk-card">
        <div class="uk-card-body uk-padding-remove">
          <div class="uk-grid-collapse uk-flex-middle uk-text-center uk-grid-match uk-child-width-1-2" uk-grid>
            <div>
              <div class=" uk-text-center">
                <h4 class=" uk-margin-small-bottom uk-margin-small-top green-text text-accent-2 uk-text-bold">
                  {{__('homepage.wallet')}}
                </h4>
                <hr class="uk-divider-icon uk-margin-remove">
                <h4 class="uk-margin-small-bottom uk-margin-small-top uk-text-bold green-text text-accent-2">
                  {{intVal(Auth::User()->wallet_amount)}}</h4>
              </div>
            </div>
            <div>
              <div class=" uk-text-center">
                <h4 class=" uk-margin-small-bottom uk-margin-small-top orange-text text-accent-2 uk-text-bold">
                  {{__('homepage.bonus')}}
                </h4>
                <hr class="uk-divider-icon uk-margin-remove">
                <h4 class="uk-margin-small-bottom uk-margin-small-top uk-text-bold orange-text text-accent-2">
                  {{intVal(Auth::User()->bonus_amount)}}</h4>
              </div>
            </div>
          </div>
        </div>
        <pending-investment-transactions></pending-investment-transactions>
        <pending-cashout-transactions></pending-cashout-transactions>
        @if(isset($pending_roi))
        <div class="uk-card-header">
          <div class="uk-width-expand">
          <h4 class="uk-card-title uk-text-center uk-margin-remove-bottom uk-text-bold">{{__('homepage.awaiting cashout')}}</h4>
          </div>
        </div>
        <div class="uk-card-body uk-padding-remove">
          <table class="uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <thead>
              <tr>
                <th class="uk-text-left">#</th>
                <th class="uk-text-right">{{__('homepage.time')}}</th>
                <th class="uk-text-right">{{__('homepage.amount')}}</th>
              </tr>
            </thead>
            <tbody>
            <tbody>
              @foreach ($pending_roi as $roi_investment)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td class="uk-text-right">
                  <div class="uk-grid-small uk-child-width-auto uk-flex-inline" uk-grid
                    uk-countdown="date: {{$roi_investment->updated_at->addDays(5)->format('Y-m-d\TH:i:sP')}}">
                    <div class="uk-text-small">
                      <div class="uk-countdown-days uk-text-center uk-text-bold"></div>
                      <div class="uk-countdown-label uk-margin-remove-top uk-margin-small uk-text-center uk-visible@s">
                        {{__('homepage.days')}}
                      </div>
                    </div>
                    <div class="uk-countdown-separator uk-text-small" style="padding-left:5px;">
                      :
                    </div>
                    <div class="uk-text-small" style="padding-left:5px;">
                      <div class="uk-countdown-hours uk-text-center uk-text-bold"></div>
                      <div class="uk-countdown-label uk-margin-remove-top uk-margin-small uk-text-center uk-visible@s">
                        {{__('homepage.hours')}}
                      </div>
                    </div>
                    <div class="uk-countdown-separator uk-text-small" style="padding-left:5px;">
                      :
                    </div>
                    <div class="uk-text-small" style="padding-left:5px;">
                      <div class="uk-countdown-minutes uk-text-center uk-text-bold"></div>
                      <div class="uk-countdown-label uk-margin-remove-top uk-margin-small uk-text-center uk-visible@s">
                        {{__('homepage.minutes')}}
                      </div>
                    </div>
                    <div class="uk-countdown-separator uk-text-small" style="padding-left:5px;">
                      :
                    </div>
                    <div class="uk-text-small" style="padding-left:5px;">
                      <div class="uk-countdown-seconds uk-text-center uk-text-bold"></div>
                      <div class="uk-countdown-label uk-margin-remove-top uk-margin-small uk-text-center uk-visible@s">
                        {{__('homepage.seconds')}}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="uk-text-right">{{$roi_investment->total_amount}}</td>
              </tr>
              @endforeach
            </tbody>
            </tbody>
          </table>
        </div>
        @endif
        @if ($pending_roi->hasPages())
        <div class="uk-text-center uk-card-footer">
          {!! $pending_roi->links() !!}
        </div>
        @endif
        @if(isset($latest_post))
        <div class="uk-card-header">
          <div class="uk-width-expand">
            <h4 class="uk-card-title uk-text-center uk-margin-remove-bottom uk-text-bold">
              {{__('homepage.latest information')}}</h4>
          </div>
        </div>
        <div class="uk-card-body uk-padding-remove">
          <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin uk-grid-collapse" uk-grid>
            <div class="">
              <img src="/image/post/{{$latest_post->image}}" style="max-height:60vh;width:100%;object-fit:cover;"
                alt="{{$latest_post->title}}">
            </div>
            <div class="">
              <div class="uk-card-body uk-padding-small">
                <h5 class="uk-card-title uk-text-center uk-text-capitalize">{{$latest_post->title}}</h5>
                <p class="uk-padding-remove">{{$latest_post->content}}</p>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
