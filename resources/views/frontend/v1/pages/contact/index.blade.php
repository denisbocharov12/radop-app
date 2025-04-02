@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="section-page">
        <div class="contact-section">
            <div class="container">
                <h1 class="store-title">{{ __('contact.our_contacts') }}</h1>
                <div class="divider"></div>
                <div class="contact-blocks">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="contact-block">
                                <h3 class="contact-block-title">{{ __('contact.online_store') }}</h3>
                                <div class="contact-block-content">
                                    <p>
                                        {{ __('contact.phone') }} <a href="tel:37322782112">0
                                            (22) 78 21 12</a>
                                    </p>
                                    <p>
                                        {{ __('contact.gsm') }} <a href="tel:37379782112">079
                                            78 21 12</a>
                                    </p>
                                    <p>
                                        {{ __('contact.email') }} <a
                                                href="mailto:support@radop.md">support@radop.md</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-block">
                                <h3 class="contact-block-title">{{ __('contact.wholesale_clients') }}</h3>
                                <div class="contact-block-content">
                                    <p>
                                        {{ __('contact.phone') }} <a href="tel:37322782100">0
                                            (22) 78 21 00</a>
                                    </p>
                                    <p>
                                        {{ __('contact.gsm') }} <a href="tel:37360908820">060
                                            90 88 20</a>
                                    </p>
                                    <p>
                                        {{ __('contact.email') }} <a
                                                href="mailto:sales@radop.md">sales@radop.md</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-block">
                                <h3 class="contact-block-title">{{ __('contact.corporate_clients') }}</h3>
                                <div class="contact-block-content">
                                    <p>
                                        {{ __('contact.phone') }} <a href="tel:37322782101">0
                                            (22) 78 21 01</a>
                                    </p>
                                    <p>
                                        {{ __('contact.gsm') }} <a href="tel:37360908822">060
                                            90 88 22</a>
                                    </p>
                                    <p>
                                        {{ __('contact.email') }} <a
                                                href="mailto:sales@radop.md">sales@radop.md</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="address-section">
                            <p>
                                {{ __('contact.phone') }} <a href="tel:37322782111">0 (22)
                                    78 21 11</a>
                            </p>
                            <p>
                                {{ __('contact.email') }} <a
                                        href="mailto:contextlux@yandex.ru">contextlux@yandex.ru</a>
                            </p>
                            <p>
                                <span class="theme-bold">{{ __('contact.address') }}</span> {{ __('contact.chisinau') }} {{ __('contact.street_sarmizegetusa') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="work-hours">
                            <h3>{{ __('contact.work_hours') }}</h3>
                            <p>
                                {{ __('contact.monday_friday') }} {{ __('contact.time_0800_1700') }}
                            </p>
                            <p>
                                {{ __('contact.saturday') }}, {{ __('contact.sunday') }} {{ __('contact.weekends') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="store-title">{{ __('contact.brand_store') }}</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="address-section">
                            <p>
                                {{ __('contact.phone') }} <a href="tel:37322782111">0 (22)
                                    78 21 11</a>
                            </p>
                            <p>
                                {{ __('contact.email') }} <a
                                        href="mailto:contextlux@yandex.ru">contextlux@yandex.ru</a>
                            </p>
                            <p>
                                <span class="theme-bold">{{ __('contact.address') }}</span> {{ __('contact.chisinau') }} {{ __('contact.street_sarmizegetusa') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="work-hours">
                            <h3>{{ __('contact.work_hours') }}</h3>
                            <p>
                                {{ __('contact.monday_friday') }} {{ __('contact.time_0830_1930') }}
                            </p>
                            <p>
                                {{ __('contact.saturday') }}: {{ __('contact.time_0830_1700') }}
                            </p>
                            <p>
                                {{ __('contact.sunday') }} {{ __('contact.weekend') }}
                            </p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2721.3464825991464!2d28.8620954763489!3d46.994169330068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c979000d7b986b%3A0xd6b10473ab164368!2sRadop!5e0!3m2!1sru!2s!4v1743005622222!5m2!1sru!2s"
                        width="50%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="divider"></div>
                <div class="store-title">{{ __('contact.warehouse') }}</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="address-section">
                            <p>{{ __('contact.phone') }} <a href="tel:37322249064">0 (22) 24
                                    90 64</a></p>
                            <p><span class="theme-bold">{{ __('contact.address') }}</span> {{ __('contact.chisinau') }} {{ __('contact.street_muncheshti') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="work-hours">
                            <h3>{{ __('contact.work_hours') }}</h3>
                            <p>
                                {{ __('contact.monday_friday') }} {{ __('contact.time_0800_1700') }}
                            </p>
                            <p>
                                {{ __('contact.saturday') }}, {{ __('contact.sunday') }} {{ __('contact.weekends') }}
                            </p>
                        </div>
                    </div>
                </div>

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d170.24848621149485!2d28.94449634901965!3d46.942515138919404!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c9796f2e9660e1%3A0x1f8453d8712be44e!2sDepozit%20R%C4%83dop!5e0!3m2!1sru!2s!4v1742989945593!5m2!1sru!2s"
                        width="50%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>

                <div class="divider"></div>

                <div class="store-title">{{ __('contact.support_service') }}</div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="address-section">
                            <p>
                                {{ __('contact.support_text_1') }}
                            </p>
                            <p>
                                {{ __('contact.support_text_2') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="address-section">
                            <p>{{ __('contact.phone') }} <a href="tel:37322782112">022 78
                                    21 12</a>
                            </p>
                            <p>
                                {{ __('contact.gsm') }} <a href="tel:37379782112">079 78 21
                                    12</a>
                            </p>
                            <p>
                                {{ __('contact.email') }} <a
                                        href="mailto:support@radop.md">support@radop.md</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
