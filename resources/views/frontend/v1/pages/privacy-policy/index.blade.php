@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="section-page">
        <div class="privacy-policy-section">
            <div class="container">
                <h1>{{ __('privacy-policy.title') }}</h1>
                <p class="privacy-updated"><em>{{ __('privacy-policy.updated') }}</em></p>
                <p>{!! __('privacy-policy.intro-1') !!}</p>
                <p>{!! __('privacy-policy.intro-2') !!}</p>

                <h2>1. {{ __('privacy-policy.s1-title') }}</h2>
                <p>{!! __('privacy-policy.s1-1') !!}</p>
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
                    <li>{!! __('privacy-policy.s5-1') !!}</li>
                    <li>{!! __('privacy-policy.s5-2') !!}</li>
                    <li>{!! __('privacy-policy.s5-3') !!}</li>
                    <li>{!! __('privacy-policy.s5-4') !!}</li>
                    <li>{!! __('privacy-policy.s5-5') !!}</li>
                </ul>
                <p>{{ __('privacy-policy.s5-note') }}</p>

                <h2>6. {{ __('privacy-policy.s6-title') }}</h2>
                <p>{{ __('privacy-policy.s6-1') }}</p>
                <p>{{ __('privacy-policy.s6-2') }}</p>

                <h2>7. {{ __('privacy-policy.s7-title') }}</h2>
                <p>{{ __('privacy-policy.s7-intro') }}</p>
                <ul>
                    <li>{!! __('privacy-policy.s7-1') !!}</li>
                    <li>{!! __('privacy-policy.s7-2') !!}</li>
                    <li>{!! __('privacy-policy.s7-3') !!}</li>
                    <li>{!! __('privacy-policy.s7-4') !!}</li>
                    <li>{!! __('privacy-policy.s7-5') !!}</li>
                </ul>

                <h2>8. {{ __('privacy-policy.s8-title') }}</h2>
                <p>{!! __('privacy-policy.s8-1', ['url' => route('theme.cookie.index')]) !!}</p>

                <h2>9. {{ __('privacy-policy.s9-title') }}</h2>
                <p>{{ __('privacy-policy.s9-1') }}</p>

                <h2>10. {{ __('privacy-policy.s10-title') }}</h2>
                <p>{{ __('privacy-policy.s10-intro') }}</p>
                <ul>
                    <li>{!! __('privacy-policy.s10-access') !!}</li>
                    <li>{!! __('privacy-policy.s10-rectify') !!}</li>
                    <li>{!! __('privacy-policy.s10-erase') !!}</li>
                    <li>{!! __('privacy-policy.s10-restrict') !!}</li>
                    <li>{!! __('privacy-policy.s10-object') !!}</li>
                    <li>{!! __('privacy-policy.s10-portability') !!}</li>
                    <li>{!! __('privacy-policy.s10-withdraw') !!}</li>
                </ul>
                <p>{!! __('privacy-policy.s10-how') !!}</p>

                <h2>11. {{ __('privacy-policy.s11-title') }}</h2>
                <p>{!! __('privacy-policy.s11-1') !!}</p>

                <h2>12. {{ __('privacy-policy.s12-title') }}</h2>
                <p>{{ __('privacy-policy.s12-1') }}</p>

                <h2>13. {{ __('privacy-policy.s13-title') }}</h2>
                <p>{{ __('privacy-policy.s13-1') }}</p>

                <h2>14. {{ __('privacy-policy.s14-title') }}</h2>
                <p>{!! __('privacy-policy.s14-1') !!}</p>
            </div>
        </div>
    </section>
@endsection
