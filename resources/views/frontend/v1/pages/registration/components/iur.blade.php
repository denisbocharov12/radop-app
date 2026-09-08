<div class="tabContent {{old('type_id')  === "2" || old('type_id') === null ? 'show' : 'hide'}}">
    <form id="form-iur-submit" action="{{route('user.registration.store')}}" method="POST">
        @csrf
        @php
            $userTypeIur = \App\Models\UserType::where('key_name', 'iur')->first();
        @endphp
        <input type="hidden" name="type_id" value="{{$userTypeIur->id}}">
        <div class="form-content">
            <div class="form-control form-control-direction">
                <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                    <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v12h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm9 12V2H4v12h2v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h2zm-3 0v-3H7v3h2zm-4-9h1V4H5v1zm0 2h1V6H5v1zm0 2h1V8H5v1zm6-4h-1V4h1v1zm-1 2h1V6h-1v1zm1 2h-1V8h1v1z"/>
                </svg>
                <input
                    class="@error('organization_name') input-error-validation @enderror"
                    type="text"
                    name="organization_name"
                    id="organization_name"
                    value="{{old('organization_name')}}"
                    placeholder="{{__('theme.company-name')}}"
                    required
                />
                @error('organization_name')
                <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-control form-control-direction">
                <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                    <path d="M14.5 2h-13A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zM1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v.4L8 8.2 1 3.9v-.4zm13 9H1.5a.5.5 0 0 1-.5-.5V5.2l7 4.4 7-4.4v6.8a.5.5 0 0 1-.5.5z"/>
                </svg>
                <input
                    type="email"
                    class="@error('email_iur') input-error-validation @enderror"
                    name="email_iur"
                    id="email_iur"
                    placeholder="Email"
                    value="{{old('email_iur')}}"
                    required
                />
                @error('email_iur')
                <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-control form-control-direction select2-registration-wrap">
                <svg class="icon-style"  width="16" height="16" viewBox="0 0 16 16" fill="gray" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.6649 1.52947H11.3099C11.1339 1.52947 10.9912 1.67216 10.9912 1.84819V7.71528H8.80447V5.11103V0.318719C8.80447 0.142688 8.66175 0 8.48575 0H6.5685C6.3925 0 6.24978 0.142688 6.24978 0.318719V4.79228H5.54547V3.02787C5.54547 2.85184 5.40275 2.70916 5.22675 2.70916C5.05075 2.70916 4.90803 2.85184 4.90803 3.02787V4.79228H4.56322C4.38722 4.79228 4.2445 4.93497 4.2445 5.111V6.66159H2.61319V5.48206C2.61319 5.30603 2.47047 5.16334 2.29447 5.16334C2.11847 5.16334 1.97575 5.30603 1.97575 5.48206V6.66162H1.33434C1.15834 6.66162 1.01562 6.80431 1.01562 6.98034V15.6812C1.01562 15.8573 1.15834 16 1.33434 16H14.6649C14.8409 16 14.9836 15.8573 14.9836 15.6812V1.84819C14.9836 1.67216 14.8409 1.52947 14.6649 1.52947ZM4.24447 15.3626H1.65306V7.29909H4.24447V15.3626ZM8.16703 15.3626H4.88191V5.42975H8.167V15.3626H8.16703ZM8.16703 4.79228H6.88722V0.637438H8.16703V4.79228ZM10.991 15.3626H8.80447V8.35269H10.991V15.3626ZM14.3462 15.3626H11.6287V2.16691H14.3462V15.3626Z" fill="black"/>
                    <path d="M5.82263 6.21875C5.64663 6.21875 5.50391 6.36144 5.50391 6.53747V6.96066C5.50391 7.13669 5.64659 7.27938 5.82263 7.27938C5.99863 7.27938 6.14134 7.13669 6.14134 6.96066V6.53747C6.14134 6.36147 5.99863 6.21875 5.82263 6.21875Z" fill="black"/>
                    <path d="M7.182 6.21875C7.006 6.21875 6.86328 6.36144 6.86328 6.53747V6.96066C6.86328 7.13669 7.006 7.27938 7.182 7.27938C7.358 7.27938 7.50072 7.13669 7.50072 6.96066V6.53747C7.50072 6.36147 7.358 6.21875 7.182 6.21875Z" fill="black"/>
                    <path d="M7.52184 3.29688C7.34584 3.29688 7.20312 3.43956 7.20312 3.61559V4.03878C7.20312 4.21481 7.34584 4.3575 7.52184 4.3575C7.69784 4.3575 7.84056 4.21481 7.84056 4.03878V3.61559C7.84059 3.43956 7.69788 3.29688 7.52184 3.29688Z" fill="black"/>
                    <path d="M7.52184 1.63281C7.34584 1.63281 7.20312 1.7755 7.20312 1.95153V2.37472C7.20312 2.55075 7.34584 2.69344 7.52184 2.69344C7.69784 2.69344 7.84056 2.55075 7.84056 2.37472V1.95153C7.84059 1.7755 7.69788 1.63281 7.52184 1.63281Z" fill="black"/>
                    <path d="M5.82263 8.07812C5.64663 8.07812 5.50391 8.22081 5.50391 8.39684V8.82003C5.50391 8.99606 5.64659 9.13875 5.82263 9.13875C5.99863 9.13875 6.14134 8.99606 6.14134 8.82003V8.39684C6.14134 8.22081 5.99863 8.07812 5.82263 8.07812Z" fill="black"/>
                    <path d="M7.182 8.07812C7.006 8.07812 6.86328 8.22081 6.86328 8.39684V8.82003C6.86328 8.99606 7.006 9.13875 7.182 9.13875C7.358 9.13875 7.50072 8.99606 7.50072 8.82003V8.39684C7.50072 8.22081 7.358 8.07812 7.182 8.07812Z" fill="black"/>
                    <path d="M5.82263 9.79688C5.64663 9.79688 5.50391 9.93956 5.50391 10.1156V10.5388C5.50391 10.7148 5.64659 10.8575 5.82263 10.8575C5.99863 10.8575 6.14134 10.7148 6.14134 10.5388V10.1156C6.14134 9.93959 5.99863 9.79688 5.82263 9.79688Z" fill="black"/>
                    <path d="M7.182 9.79688C7.006 9.79688 6.86328 9.93956 6.86328 10.1156V10.5388C6.86328 10.7148 7.006 10.8575 7.182 10.8575C7.358 10.8575 7.50072 10.7148 7.50072 10.5388V10.1156C7.50072 9.93959 7.358 9.79688 7.182 9.79688Z" fill="black"/>
                    <path d="M5.82263 11.6562C5.64663 11.6562 5.50391 11.7989 5.50391 11.975V12.3982C5.50391 12.5742 5.64659 12.7169 5.82263 12.7169C5.99863 12.7169 6.14134 12.5742 6.14134 12.3982V11.975C6.14134 11.7989 5.99863 11.6562 5.82263 11.6562Z" fill="black"/>
                    <path d="M7.182 11.6562C7.006 11.6562 6.86328 11.7989 6.86328 11.975V12.3982C6.86328 12.5742 7.006 12.7169 7.182 12.7169C7.358 12.7169 7.50072 12.5742 7.50072 12.3982V11.975C7.50072 11.7989 7.358 11.6562 7.182 11.6562Z" fill="black"/>
                    <path d="M5.82263 13.5156C5.64663 13.5156 5.50391 13.6583 5.50391 13.8343V14.2576C5.50391 14.4336 5.64659 14.5763 5.82263 14.5763C5.99863 14.5763 6.14134 14.4336 6.14134 14.2576V13.8344C6.14134 13.6583 5.99863 13.5156 5.82263 13.5156Z" fill="black"/>
                    <path d="M7.182 13.5156C7.006 13.5156 6.86328 13.6583 6.86328 13.8343V14.2576C6.86328 14.4336 7.006 14.5763 7.182 14.5763C7.358 14.5763 7.50072 14.4336 7.50072 14.2576V13.8344C7.50072 13.6583 7.358 13.5156 7.182 13.5156Z" fill="black"/>
                    <path d="M12.4476 6.21875C12.2716 6.21875 12.1289 6.36144 12.1289 6.53747V6.96066C12.1289 7.13669 12.2716 7.27938 12.4476 7.27938C12.6236 7.27938 12.7663 7.13669 12.7663 6.96066V6.53747C12.7663 6.36147 12.6236 6.21875 12.4476 6.21875Z" fill="black"/>
                    <path d="M13.639 6.21875C13.463 6.21875 13.3203 6.36144 13.3203 6.53747V6.96066C13.3203 7.13669 13.463 7.27938 13.639 7.27938C13.815 7.27938 13.9578 7.13669 13.9578 6.96066V6.53747C13.9578 6.36147 13.815 6.21875 13.639 6.21875Z" fill="black"/>
                    <path d="M12.4476 8.07812C12.2716 8.07812 12.1289 8.22081 12.1289 8.39684V8.82003C12.1289 8.99606 12.2716 9.13875 12.4476 9.13875C12.6236 9.13875 12.7663 8.99606 12.7663 8.82003V8.39684C12.7663 8.22081 12.6236 8.07812 12.4476 8.07812Z" fill="black"/>
                    <path d="M13.639 8.07812C13.463 8.07812 13.3203 8.22081 13.3203 8.39684V8.82003C13.3203 8.99606 13.463 9.13875 13.639 9.13875C13.815 9.13875 13.9578 8.99606 13.9578 8.82003V8.39684C13.9578 8.22081 13.815 8.07812 13.639 8.07812Z" fill="black"/>
                    <path d="M12.4476 9.79688C12.2716 9.79688 12.1289 9.93956 12.1289 10.1156V10.5388C12.1289 10.7148 12.2716 10.8575 12.4476 10.8575C12.6236 10.8575 12.7663 10.7148 12.7663 10.5388V10.1156C12.7663 9.93959 12.6236 9.79688 12.4476 9.79688Z" fill="black"/>
                    <path d="M13.639 9.79688C13.463 9.79688 13.3203 9.93956 13.3203 10.1156V10.5388C13.3203 10.7148 13.463 10.8575 13.639 10.8575C13.815 10.8575 13.9578 10.7148 13.9578 10.5388V10.1156C13.9578 9.93959 13.815 9.79688 13.639 9.79688Z" fill="black"/>
                    <path d="M12.4476 2.67969C12.2716 2.67969 12.1289 2.82237 12.1289 2.99841V3.42162C12.1289 3.59766 12.2716 3.74034 12.4476 3.74034C12.6236 3.74034 12.7663 3.59766 12.7663 3.42162V2.99841C12.7663 2.82237 12.6236 2.67969 12.4476 2.67969Z" fill="black"/>
                    <path d="M13.639 2.67969C13.463 2.67969 13.3203 2.82237 13.3203 2.99841V3.42162C13.3203 3.59766 13.463 3.74034 13.639 3.74034C13.815 3.74034 13.9578 3.59766 13.9578 3.42162V2.99841C13.9578 2.82237 13.815 2.67969 13.639 2.67969Z" fill="black"/>
                    <path d="M12.4476 4.40625C12.2716 4.40625 12.1289 4.54894 12.1289 4.72497V5.14816C12.1289 5.32419 12.2716 5.46688 12.4476 5.46688C12.6236 5.46688 12.7663 5.32419 12.7663 5.14816V4.72497C12.7663 4.54894 12.6236 4.40625 12.4476 4.40625Z" fill="black"/>
                    <path d="M13.639 4.40625C13.463 4.40625 13.3203 4.54894 13.3203 4.72497V5.14816C13.3203 5.32419 13.463 5.46688 13.639 5.46688C13.815 5.46688 13.9578 5.32419 13.9578 5.14816V4.72497C13.9578 4.54894 13.815 4.40625 13.639 4.40625Z" fill="black"/>
                    <path d="M12.4476 11.6562C12.2716 11.6562 12.1289 11.7989 12.1289 11.975V12.3982C12.1289 12.5742 12.2716 12.7169 12.4476 12.7169C12.6236 12.7169 12.7663 12.5742 12.7663 12.3982V11.975C12.7663 11.7989 12.6236 11.6562 12.4476 11.6562Z" fill="black"/>
                    <path d="M13.639 11.6562C13.463 11.6562 13.3203 11.7989 13.3203 11.975V12.3982C13.3203 12.5742 13.463 12.7169 13.639 12.7169C13.815 12.7169 13.9578 12.5742 13.9578 12.3982V11.975C13.9578 11.7989 13.815 11.6562 13.639 11.6562Z" fill="black"/>
                    <path d="M12.4476 13.5156C12.2716 13.5156 12.1289 13.6583 12.1289 13.8343V14.2576C12.1289 14.4336 12.2716 14.5763 12.4476 14.5763C12.6236 14.5763 12.7663 14.4336 12.7663 14.2576V13.8344C12.7663 13.6583 12.6236 13.5156 12.4476 13.5156Z" fill="black"/>
                    <path d="M13.639 13.5156C13.463 13.5156 13.3203 13.6583 13.3203 13.8343V14.2576C13.3203 14.4336 13.463 14.5763 13.639 14.5763C13.815 14.5763 13.9578 14.4336 13.9578 14.2576V13.8344C13.9578 13.6583 13.815 13.5156 13.639 13.5156Z" fill="black"/>
                    <path d="M3.54456 7.92188H2.38903C2.21303 7.92188 2.07031 8.06456 2.07031 8.24059C2.07031 8.41663 2.21303 8.55931 2.38903 8.55931H3.54459C3.72059 8.55931 3.86331 8.41663 3.86331 8.24059C3.86331 8.06456 3.72059 7.92188 3.54456 7.92188Z" fill="black"/>
                    <path d="M3.54456 9.15625H2.38903C2.21303 9.15625 2.07031 9.29894 2.07031 9.47497C2.07031 9.651 2.21303 9.79369 2.38903 9.79369H3.54459C3.72059 9.79369 3.86331 9.651 3.86331 9.47497C3.86331 9.29894 3.72059 9.15625 3.54456 9.15625Z" fill="black"/>
                    <path d="M3.54456 10.4297H2.38903C2.21303 10.4297 2.07031 10.5724 2.07031 10.7484C2.07031 10.9244 2.21303 11.0671 2.38903 11.0671H3.54459C3.72059 11.0671 3.86331 10.9244 3.86331 10.7484C3.86331 10.5724 3.72059 10.4297 3.54456 10.4297Z" fill="black"/>
                    <path d="M3.54456 11.6641H2.38903C2.21303 11.6641 2.07031 11.8068 2.07031 11.9828C2.07031 12.1588 2.21303 12.3015 2.38903 12.3015H3.54459C3.72059 12.3015 3.86331 12.1588 3.86331 11.9828C3.86331 11.8068 3.72059 11.6641 3.54456 11.6641Z" fill="black"/>
                    <path d="M3.54456 12.9375H2.38903C2.21303 12.9375 2.07031 13.0802 2.07031 13.2562C2.07031 13.4323 2.21303 13.5749 2.38903 13.5749H3.54459C3.72059 13.5749 3.86331 13.4323 3.86331 13.2562C3.86331 13.0802 3.72059 12.9375 3.54456 12.9375Z" fill="black"/>
                    <path d="M3.54456 14.1719H2.38903C2.21303 14.1719 2.07031 14.3146 2.07031 14.4906C2.07031 14.6666 2.21303 14.8093 2.38903 14.8093H3.54459C3.72059 14.8093 3.86331 14.6666 3.86331 14.4906C3.86331 14.3146 3.72059 14.1719 3.54456 14.1719Z" fill="black"/>
                    <path d="M10.2751 8.80469H9.45934C9.28334 8.80469 9.14062 8.94738 9.14062 9.12341C9.14062 9.29944 9.28334 9.44213 9.45934 9.44213H10.2751C10.4511 9.44213 10.5938 9.29944 10.5938 9.12341C10.5938 8.94738 10.4511 8.80469 10.2751 8.80469Z" fill="black"/>
                    <path d="M10.2751 10.2969H9.45934C9.28334 10.2969 9.14062 10.4396 9.14062 10.6156C9.14062 10.7916 9.28334 10.9343 9.45934 10.9343H10.2751C10.4511 10.9343 10.5938 10.7916 10.5938 10.6156C10.5938 10.4396 10.4511 10.2969 10.2751 10.2969Z" fill="black"/>
                    <path d="M10.2751 11.8281H9.45934C9.28334 11.8281 9.14062 11.9708 9.14062 12.1468C9.14062 12.3229 9.28334 12.4656 9.45934 12.4656H10.2751C10.4511 12.4656 10.5938 12.3229 10.5938 12.1468C10.5938 11.9708 10.4511 11.8281 10.2751 11.8281Z" fill="black"/>
                    <path d="M10.2751 13.3906H9.45934C9.28334 13.3906 9.14062 13.5333 9.14062 13.7093C9.14062 13.8854 9.28334 14.0281 9.45934 14.0281H10.2751C10.4511 14.0281 10.5938 13.8854 10.5938 13.7093C10.5938 13.5333 10.4511 13.3906 10.2751 13.3906Z" fill="black"/>
                    <path d="M5.22888 1.36719C5.05288 1.36719 4.91016 1.50988 4.91016 1.68591V2.06837C4.91016 2.24441 5.05288 2.38709 5.22888 2.38709C5.40488 2.38709 5.54759 2.24441 5.54759 2.06837V1.68591C5.54759 1.50988 5.40488 1.36719 5.22888 1.36719Z" fill="black"/>
                </svg>
                <select name="city_id_iur" id="city_id_iur" class="select2-registration">
                    <option value="0" selected >{{ __('theme.select-city') }}</option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
                @error('city_id_iur')
                <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-control form-control-direction">
                <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" viewBox="0 0 16 16">
                    <path d="M3.654 1.328a.678.678 0 0 1 .724-.166l2.59.969c.28.105.471.35.515.646l.417 2.974a.678.678 0 0 1-.19.562l-1.099 1.1a10.97 10.97 0 0 0 4.797 4.797l1.1-1.1a.678.678 0 0 1 .562-.19l2.974.417c.297.044.54.235.646.515l.969 2.59a.678.678 0 0 1-.166.724l-2.086 2.087a.678.678 0 0 1-.67.164c-2.017-.601-5.043-2.116-7.519-4.593S1.503 6.361.902 4.344a.678.678 0 0 1 .164-.67L3.654 1.328z"/>
                </svg>
                <input
                    class="@error('phone_iur') input-error-validation @enderror"
                    type="text"
                    name="phone_iur"
                    id="phone_iur"
                    value="{{old('phone_iur')}}"
                    placeholder="{{__('theme.phone-number')}}"
                    required
                />
                @error('phone_iur')
                <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-control form-control-direction">
                <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                    <path d="M1 4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h12V4a1 1 0 0 0-1-1H3zm12 3H2v6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V6zM3 10h2v2H3v-2zm4 0h2v2H7v-2zm4 0h2v2h-2v-2z"/>
                </svg>
                <input
                    class="@error('cod_fiscal') input-error-validation @enderror"
                    type="text"
                    name="cod_fiscal"
                    id="cod_fiscal"
                    value="{{old('cod_fiscal')}}"
                    placeholder="{{__('theme.fiscal-code')}}"
                    required
                />
                @error('cod_fiscal')
                <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-control form-control-direction">
                <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                    <path d="M8 16s6-5.33 6-10A6 6 0 0 0 2 6c0 4.67 6 10 6 10zm0-12a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/>
                </svg>
                <input
                    class="@error('address_iur') input-error-validation @enderror"
                    type="text"
                    name="address_iur"
                    id="address_iur"
                    value="{{old('address_iur')}}"
                    placeholder="{{__('theme.address')}}"
                    required
                />
                @error('address_iur')
                <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-control form-password form-control-direction">
                <a href="#" class="qu eye eye_iur"><i class="fa fa-eye-slash"></i></a>
                <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                    <path d="M8 1a3 3 0 0 1 3 3v2h1a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h1V4a3 3 0 0 1 3-3zm0 2a1 1 0 0 0-1 1v2h2V4a1 1 0 0 0-1-1zm4 5H4v5h8V8z"/>
                </svg>
                <input
                    class="password @error('password_iur') input-error-validation @enderror"
                    type="password"
                    name="password_iur"
                    id="password_iur"
                    value="{{old('password_iur')}}"
                    placeholder="{{__('theme.password')}}"
                    required
                />
                @error('password_iur')
                <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-control form-password form-control-direction">
                <a href="#" class="qu eye eye_iur_confirm"><i class="fa fa-eye-slash"></i></a>
                <svg class="icon-style" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="gray">
                    <path d="M8 1a3 3 0 0 1 3 3v2h1a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h1V4a3 3 0 0 1 3-3zm0 2a1 1 0 0 0-1 1v2h2V4a1 1 0 0 0-1-1zm4 5H4v5h8V8z"/>
                </svg>
                <input
                    class="password @error('password_confirmation_iur') input-error-validation @enderror"
                    type="password"
                    name="password_confirmation_iur"
                    id="password_confirmation_iur"
                    value="{{old('password_confirmation_iur')}}"
                    placeholder="{{__('theme.password_confirmation')}}"
                    required
                />
                @error('password_confirmation_iur')
                <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="center">
            <div class="form-control form-control-direction" style="text-align: center">
                <ul class="password-rules">
                    <li id="length-rule-iur" class="rule">❌ {{__('theme.password-rule-length')}}</li>
                </ul>
                <div class="wrap">
                    <input
                        type="checkbox"
                        class="custom-checkbox rule-checkbox rule-checkbox-iur rule-checkbox-iur"
                        id="terms_iur"
                        name="terms_iur"
                        value="1"
                    />
                    <label for="terms_iur">
                        {{__('theme.agree-with')}}
                        <span class="text-wrap">
                            <a
                                data-fancybox
                                data-src="#rules-register-page"
                                data-touch="false"
                                href="javascript:;"
                            >
                                {{__('theme.terms-of-use')}}
                            </a>
                            <p>{{__('theme.and')}}</p>
                            <a
                                data-fancybox
                                data-src="#rules-register-page"
                                data-touch="false"
                                href="javascript:;"
                            >
                                {{__('theme.refund-policy')}}
                            </a>
                        </span>
                    </label>
                </div>
                @error('rule_iur')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <p class="registration-privacy-notice">{!! __('theme.registration-privacy-notice', ['url' => route('theme.privacy-policy.index')]) !!}</p>
            </div>
        </div>
        <div class="block-botton">
            <button id="form_submit_iur" type="submit" class="btn">
                {{__('theme.sign-up')}}
            </button>
        </div>
    </form>
</div>
