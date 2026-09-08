@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <x-sf-page>
                <h1>{{ __('cookie.title') }}</h1>
                <p class="cookie-updated"><em>{{ __('cookie.updated') }}</em></p>
                <p>{!! __('cookie.intro-1') !!}</p>

                <h2>1. {{ __('cookie.what-title') }}</h2>
                <p>{{ __('cookie.what-1') }}</p>

                <h2>2. {{ __('cookie.why-title') }}</h2>
                <p>{{ __('cookie.why-1') }}</p>

                <h2>3. {{ __('cookie.types-title') }}</h2>
                <p>{{ __('cookie.types-intro') }}</p>
                <div class="table-responsive">
                    <table class="cookie-table">
                        <thead>
                            <tr>
                                <th>{{ __('cookie.th-name') }}</th>
                                <th>{{ __('cookie.th-provider') }}</th>
                                <th>{{ __('cookie.th-purpose') }}</th>
                                <th>{{ __('cookie.th-category') }}</th>
                                <th>{{ __('cookie.th-duration') }}</th>
                                <th>{{ __('cookie.th-type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (range(1, 6) as $i)
                                <tr>
                                    <td>{{ __('cookie.reg-r' . $i . '-name') }}</td>
                                    <td>{{ __('cookie.reg-r' . $i . '-provider') }}</td>
                                    <td>{{ __('cookie.reg-r' . $i . '-purpose') }}</td>
                                    <td>{{ __('cookie.reg-r' . $i . '-category') }}</td>
                                    <td>{{ __('cookie.reg-r' . $i . '-duration') }}</td>
                                    <td>{{ __('cookie.reg-r' . $i . '-type') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h2>4. {{ __('cookie.personal-title') }}</h2>
                <p>{{ __('cookie.personal-1') }}</p>

                <h2>5. {{ __('cookie.consent-title') }}</h2>
                <p>{{ __('cookie.consent-1') }}</p>
                <p>{{ __('cookie.consent-2') }}</p>

                <h2>6. {{ __('cookie.block-title') }}</h2>
                <p>{{ __('cookie.block-1') }}</p>
                <p>{{ __('cookie.block-2') }}</p>

                <h2>7. {{ __('cookie.changes-title') }}</h2>
                <p>{!! __('cookie.changes-1', ['url' => route('theme.privacy-policy.index')]) !!}</p>
    </x-sf-page>
@endsection
