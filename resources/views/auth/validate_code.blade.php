<x-app>
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <a href="{{ route('login') }}" class="text-nowrap logo-img text-center d-block py-3 mb-2 w-100">
                            <img src="{{ asset('images/logos/logo-kawan-kerja.png') }}" width="180" alt="">
                        </a>
                        <form method="POST" action="{{ route('register.code') }}">
                            @csrf
                            <div class="mb-3">
                                <x-label-input id="inputCode">Exclusive Code</x-label-input>
                                <x-text-input name="code" id="inputCode" type="number"
                                    value="{{ old('code') }}" />
                            </div>
                            <button type="submit"
                                class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Register</button>
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="fs-4 mb-0 fw-bold">Has account?</p>
                                <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app>
