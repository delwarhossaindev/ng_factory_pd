<x-app-component>
    <x-page.page-title data="Enable 2-FA" />
    <x-slot name="style">

    </x-slot>
    <x-slot name="content">
        <x-alert.alert-component />
        <h4 class="fw-bold py-3 mb-2">Backup Codes</h4>
        <p>Backup Codes are used to access your account in the event you cannot receive two-factor authentication. For
            security reasons, each code can be used only once.</p>
        <p class="fw-bold">Treat your Backup Codes with the same level of attention as you would your password!</p>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! $qr_code !!}
                    </div>
                    <div class="col-md-6" style="margin-top:32px">
                        <div class="qr-code" style="height:50px;width:50px;">
                            <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 68 76">
                                <defs>
                                    <style>
                                        .cls-1,
                                        .cls-5 {
                                            fill: #fff;
                                        }

                                        .cls-1,
                                        .cls-2,
                                        .cls-3 {
                                            fill-rule: evenodd;
                                        }

                                        .cls-2 {
                                            fill: #ecad66;
                                        }

                                        .cls-4 {
                                            fill: #3473b9;
                                        }
                                    </style>
                                </defs>
                                <title>1</title>
                                <path
                                    d="M23.35,12.54H21.24v2.08h2.11ZM42.44,23h2.12V20.91H42.44Zm0,12.54h2.12V33.44H42.44ZM40.32,18.82h4.24V16.74H40.32ZM27.59,27.16V25.07H25.47v2.09Zm-4.24,4.16h4.24V29.24H25.47V27.16H23.35Zm17-27.12H34v6.25h6.35Zm2.12,29.24V31.36H38.21v2.08ZM19.09,31.32V29.24H21.2V27.16h2.12V25.07h2.12V20.91h6.35V16.7H29.67v2.09H27.55V10.45H25.44V6.29h2.11V0H25.44V4.17H23.32V0H17V4.17h2.12v-2H21.2V6.29h2.12v6.25h2.12v2.08H23.32v4.17H21.2V14.62H19.09V12.54H17V16.7h2.12v2.09H17v6.28h2.12V20.91H21.2v4.16H19.09v2.09H17v6.25H21.2V31.32Zm17,0h2.12V27.16H36.05Zm0,0H33.94V29.24H31.82v4.17H25.47v2.08H29.7v4.17h2.12v2.08h2.12V37.57h8.5V35.49H36.09V31.32Zm-2.11-6.25h4.23v2.09h2.12V20.91H38.17V16.74H36.05V23H29.7v2.08h2.12v2.09h2.12ZM17,8.37H21.2V6.29H17Zm6.38,27.16V33.44H21.24v2.09H17v4.16H21.2v2.09h2.12V37.61h2.12V35.53Zm6.35-8.37v2.08h2.12V27.16ZM2.12,16.74H0V27.19H2.12Zm0,25H12.74V31.32H2.12ZM0,29.24H14.85V43.86H0ZM42.44,2.12H31.82V12.57H42.44ZM44.56,0V14.62H29.7V0ZM10.62,4.2H4.23v6.25h6.35V4.2ZM25.47,37.61v2.08h2.12V37.61ZM4.23,39.69h6.35V33.44H4.23ZM12.74,2.12H2.12V12.57H12.74Zm2.11,12.5H0V0H14.85ZM8.5,18.82V16.74H4.23v4.17H6.35V18.82Zm2.12-2.08v2.08H17V16.74Zm17,27.15H29.7V39.73H27.59Zm8.46,0V41.81H33.94v2.08ZM17,43.89H21.2V41.81H17Zm25.47-2.11h2.12V39.69H42.44ZM12.74,23h2.11V20.91H12.74ZM38.21,41.78h2.11V39.69H38.21ZM10.62,23h2.12v2.08h2.11v2.09H4.23V25.07H6.35V20.91h4.23Z">
                                </path>
                                <path class="cls-1"
                                    d="M57.07,53.65h-27a4.3,4.3,0,0,1-4.32-4.25V10.1a4.3,4.3,0,0,1,4.32-4.25h27a4.29,4.29,0,0,1,4.32,4.25V49.4A4.29,4.29,0,0,1,57.07,53.65Z">
                                </path>
                                <path class="cls-2"
                                    d="M46.4,74.83l9.27-12L31,62.69c-1.42-1.07-3.12-1.36-3.12-3.07L27.6,32.94c-.33-1.14-1.42-2.53-4.83-2.28-.15,8.14-.84,26.14-.84,26.14s-.29,3.71,1.2,5.36a9.56,9.56,0,0,0,3.74,2.39l-2,4.68s2.29,3.89,8.48,5.68a25.65,25.65,0,0,0,12.47.6">
                                </path>
                                <path class="cls-2"
                                    d="M66.87,12c-2.51-2.36-5.13.21-6.07,1.21l-1.52,1.66V25.73l7.26-8.11C67.59,16.37,69.05,14,66.87,12Z">
                                </path>
                                <path class="cls-3"
                                    d="M54.54,7.8H32.6a4.88,4.88,0,0,0-4.88,4.91V58.49A4.87,4.87,0,0,0,32.6,63.4H54.54a4.87,4.87,0,0,0,4.87-4.91V12.68A4.9,4.9,0,0,0,54.54,7.8Z">
                                </path>
                                <rect class="cls-4" x="30.69" y="12.68" width="25.74" height="43.89"></rect>
                                <path class="cls-5"
                                    d="M40.38,29.73a3.67,3.67,0,0,1,1-2.49,3.06,3.06,0,0,1,2.23-1,3,3,0,0,1,2.22,1,3.55,3.55,0,0,1,1,2.49v3.44H40.38ZM50.7,33.21h-1V29.77a6.41,6.41,0,0,0-1.76-4.48,5.94,5.94,0,0,0-8.67,0,6.59,6.59,0,0,0-1.76,4.48v3.44h-1a.78.78,0,0,0-.78.78v9.12a.78.78,0,0,0,.78.78H50.7a.79.79,0,0,0,.79-.78V34A.75.75,0,0,0,50.7,33.21Z">
                                </path>
                                <path class="cls-2"
                                    d="M58.07,27.65l-1.24,1.6c-1,1.3-2.16,3.55-.18,5.51,2.44,2.4,5-.18,5.91-1.23l1.06-1.38c1-1.27,2.44-3.67.32-5.7C61.53,24,59,26.6,58.07,27.65Z">
                                </path>
                                <path class="cls-2"
                                    d="M58.07,38l-1.24,1.59c-1,1.31-2.16,3.56-.18,5.52,2.44,2.4,5-.18,5.91-1.23l1.06-1.38c1-1.27,2.44-3.67.32-5.7C61.53,34.33,59,36.9,58.07,38Z">
                                </path>
                                <path class="cls-2"
                                    d="M58.07,48.15l-1.24,1.6c-1,1.31-2.16,3.56-.18,5.52,2.44,2.39,5-.18,5.91-1.24l1.06-1.37c1-1.27,2.44-3.67.32-5.7C61.53,44.53,59,47.14,58.07,48.15Z">
                                </path>
                            </svg>
                        </div>
                        <p class="fw-bold mt-2">Authentication App (TOTP)</p>
                        <p>To enable app-based 2FA using an authentication app like Google Authenticator or Authy, click
                            enable and scan the QR code with the app on your phone</p>
                        <h6>Enter the six-digit code from the application</h6>
                        <p>After scanning the QR code, the app will display a six-digit code that you can enter below.
                        </p>
                        <form action="{{ route('2fa.code.submit') }}" method="post">
                            @csrf
                            <input type="text" class="form-control" name="code"
                                placeholder="Enter six digit code">
                            <button type="submit" class="btn btn-primary mt-2">Enable</button>
                        </form>
                        <p class="fw-bold mt-5">2-FA Secret Code: {{ $string }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-component>
