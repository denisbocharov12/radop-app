@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <x-sf-page>
                <style>
                    .privacy-table{width:100%;border-collapse:collapse;margin:1em 0;font-size:14px;}
                    .privacy-table th,.privacy-table td{border:1px solid #e2e6ee;padding:8px 10px;text-align:left;vertical-align:top;}
                    .privacy-table thead th{background:#f5f7fa;font-weight:600;}
                    .table-responsive{overflow-x:auto;}
                </style>
                <h1>{{ __('privacy-policy.title') }}</h1>
                <p class="privacy-updated"><em>{{ __('privacy-policy.updated') }}</em></p>
                <p>{!! __('privacy-policy.intro-1') !!}</p>
                <p>{!! __('privacy-policy.intro-2') !!}</p>

                <h2>1. {{ __('privacy-policy.s1-title') }}</h2>
                <p>{{ __('privacy-policy.s1-1') }}</p>
                <p><strong>{{ __('privacy-policy.s1-name') }}</strong></p>
                <p>{{ __('privacy-policy.s1-address') }}</p>
                <p>{{ __('privacy-policy.s1-idno') }}</p>
                <p>{{ __('privacy-policy.s1-email') }}</p>
                <p>{{ __('privacy-policy.s1-phone') }}</p>
                <p>{!! __('privacy-policy.s1-2') !!}</p>

                <h2>2. {{ __('privacy-policy.s2-title') }}</h2>
                <p>{{ __('privacy-policy.s2-1') }}</p>

                <h2>3. {{ __('privacy-policy.s3-title') }}</h2>
                <p>{{ __('privacy-policy.s3-intro') }}</p>
                <p>{!! __('privacy-policy.s3-account') !!}</p>
                <p>{!! __('privacy-policy.s3-order') !!}</p>
                <p>{!! __('privacy-policy.s3-comm') !!}</p>
                <p>{!! __('privacy-policy.s3-tech') !!}</p>

                <h2>4. {{ __('privacy-policy.s4-title') }}</h2>
                <p>{{ __('privacy-policy.s4-intro') }}</p>
                <div class="table-responsive">
                    <table class="privacy-table">
                        <thead>
                            <tr>
                                <th>{{ __('privacy-policy.s4-th-purpose') }}</th>
                                <th>{{ __('privacy-policy.s4-th-data') }}</th>
                                <th>{{ __('privacy-policy.s4-th-basis') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (range(1, 7) as $i)
                                <tr>
                                    <td>{{ __('privacy-policy.s4-r' . $i . '-p') }}</td>
                                    <td>{{ __('privacy-policy.s4-r' . $i . '-d') }}</td>
                                    <td>{{ __('privacy-policy.s4-r' . $i . '-b') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p>{{ __('privacy-policy.s4-note') }}</p>

                <h2>5. {{ __('privacy-policy.s5-title') }}</h2>
                <p>{{ __('privacy-policy.s5-intro') }}</p>
                <ul>
                    <li><p>{!! __('privacy-policy.s5-1') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s5-2') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s5-3') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s5-4') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s5-5') !!}</p></li>
                </ul>
                <p>{{ __('privacy-policy.s5-note') }}</p>

                <h2>6. {{ __('privacy-policy.s6-title') }}</h2>
                <p>{{ __('privacy-policy.s6-1') }}</p>
                <p>{{ __('privacy-policy.s6-2') }}</p>

                <h2>7. {{ __('privacy-policy.s7-title') }}</h2>
                <p>{{ __('privacy-policy.s7-intro') }}</p>
                <ul>
                    <li><p>{!! __('privacy-policy.s7-1') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s7-2') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s7-3') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s7-4') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s7-5') !!}</p></li>
                </ul>

                <h2>8. {{ __('privacy-policy.s8-title') }}</h2>
                <p>{!! __('privacy-policy.s8-1', ['url' => route('theme.cookie.index')]) !!}</p>

                <h2>9. {{ __('privacy-policy.s9-title') }}</h2>
                <p>{{ __('privacy-policy.s9-1') }}</p>

                <h2>10. {{ __('privacy-policy.s10-title') }}</h2>
                <p>{{ __('privacy-policy.s10-intro') }}</p>
                <ul>
                    <li><p>{!! __('privacy-policy.s10-access') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s10-rectify') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s10-erase') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s10-restrict') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s10-object') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s10-portability') !!}</p></li>
                    <li><p>{!! __('privacy-policy.s10-withdraw') !!}</p></li>
                </ul>
                <p>{!! __('privacy-policy.s10-how') !!}</p>

                <h2>11. {{ __('privacy-policy.s11-title') }}</h2>
                <p>{!! __('privacy-policy.s11-1') !!}</p>
                <p>{{ __('privacy-policy.s11-address') }}</p>
                <p>{{ __('privacy-policy.s11-contacts') }}</p>

                <h2>12. {{ __('privacy-policy.s12-title') }}</h2>
                <p>{{ __('privacy-policy.s12-1') }}</p>

                <h2>13. {{ __('privacy-policy.s13-title') }}</h2>
                <p>{{ __('privacy-policy.s13-1') }}</p>

                <h2>14. {{ __('privacy-policy.s14-title') }}</h2>
                <p>{!! __('privacy-policy.s14-1') !!}</p>
    </x-sf-page>
@endsection
