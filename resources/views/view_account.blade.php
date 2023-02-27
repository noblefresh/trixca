@extends('layouts.app')
@section('title', __('view_account_page.title'))
@push('scripts_bottom')
<?php
use Carbon\Carbon;
?>
<script>
  function copyToClipboard(id) {
    var range = document.createRange();
        range.selectNode(document.getElementById(id));
        window.getSelection().removeAllRanges(); // clear current selection
        window.getSelection().addRange(range); // to select text
        document.execCommand("copy");
        window.getSelection().removeAllRanges();// to deselect
        UIkit.notification({message: '<span uk-icon=\'icon: check\'></span> Copied', status: 'success'})
    }
</script>
@endpush
@section('content')
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('user_dashboard') }}">{{__('view_account_page.home')}}</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('make_investment') }}">{{__('view_account_page.invest')}}</a></li>
    </ul>
  </div>
</nav>
<div class="uk-grid-match uk-grid-small uk-flex-center uk-child-width-1-2@xl uk-child-width-1-2@l uk-child-width-1-1@s"
  uk-grid>
  <div class="">
    <div class="uk-card uk-card-default">
      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom uk-text-bold">{{__('view_account_page.title')}}</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <ul uk-accordion>
          <li class="uk-open">
            <a class="uk-accordion-title uk-padding-small" href="#">
              {{__('view_account_page.user details')}}
            </a>
            <div class="uk-accordion-content uk-padding-remove uk-padding-remove-top">
              <ul class="uk-list uk-list-divider uk-list-striped">
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">{{__('view_account_page.name')}}: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{Auth::User()->last_name." ".Auth::User()->first_name}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">{{__('view_account_page.username')}}: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{Auth::User()->username}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">{{__('view_account_page.email')}}: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{Auth::User()->email}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">{{__('view_account_page.phone')}}: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{Auth::User()->phone}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">{{__('view_account_page.joined')}}: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{ Auth::User()->created_at }} </h5>
                          {{-- <h5>{{ Carbon::parse(Auth::User()->created_at->toDateTimeString())->diffForHumans() }} </h5> --}}
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">{{__('view_account_page.last login')}}: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{ Carbon::parse(Auth::User()->updated_at->toDateTimeString())->diffForHumans() }} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <a href="{{route('edit_profile')}}"
                    class="uk-button green-text green accent-2 uk-float-right">{{__('view_account_page.edit profile details')}}</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="uk-margin-remove-top">
            <a class="uk-accordion-title uk-padding-small" href="#">
              Bank details
            </a>
            <div class="uk-accordion-content uk-padding-remove uk-padding-remove-top">
              <ul class="uk-list uk-list-divider uk-list-striped">
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">{{__('view_account_page.wallet')}}: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>₦{{Auth::User()->wallet_amount}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">{{__('view_account_page.bonus')}}: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>₦{{Auth::User()->bonus_amount}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">Bank name: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{Auth::User()->momo_service_name}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">Account name: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{Auth::User()->momo_name}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <div class="uk-grid-small uk-margin-small-top uk-text-center uk-grid-match" uk-grid>
                    <div class="uk-width-1-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5 class="uk-text-bold">Account number: </h5>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-2-3">
                      <div class="uk-grid-small uk-flex-middle uk-text-left" uk-grid>
                        <div class="uk-width-expand">
                          <h5>{{Auth::User()->momo_number}} </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="uk-padding-small">
                  <a href="{{route('edit_momo')}}"
                    class="uk-button grey-text green accent-2 uk-float-right">Edit Account details</a>
                </li>
              </ul>
            </div>
        </ul>

      </div>

      <div class="uk-card-header">
        <div class="uk-width-expand">
          <h3 class="uk-card-title uk-margin-remove-bottom uk-text-bold">{{__('view_account_page.referal link')}}</h3>
        </div>
      </div>
      <div class="uk-card-body uk-padding-small">
        <div class="uk-inline">
          <span class="uk-text-break"
            id="referal_link">{{sprintf('%s/%s',route('register_with_referer'), Auth::User()->username)}}</span>
          <button type="button" onclick="copyToClipboard('referal_link')" class="" uk-icon="icon: copy"></button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
