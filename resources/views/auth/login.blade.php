<x-app>
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
                <div class="card-body">
                    <a href="{{ route('dashboard') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                        <img src="{{ asset('images/logos/logo-kawan-kerja.png') }}" width="200" alt="">
                    </a>
                    <p class="text-center">Login to your account</p>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <x-label-input for="inputEmail">Email</x-label-input>
                            <x-text-input type="email" name="email" class="form-control" id="inputEmail"
                                aria-describedby="emailHelp" value="{{ old('email') }}"
                                placeholder="jhone123@exm.xxx" />
                        </div>
                        <div class="mb-4">
                            <x-label-input for="inputPass">Password</x-label-input>
                            <x-text-input name="password" type="password" id="inputPass" value="{{ old('password') }}"
                                placeholder="xxxxxxxx" />
                        </div>

                        {{-- <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input class="form-check-input primary" type="checkbox" value=""
                                    id="flexCheckChecked" checked>
                                <label class="form-check-label text-dark" for="flexCheckChecked">
                                    Remeber this Device
                                </label>
                            </div>
                            <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                        </div> --}}

                        <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                            In</button>
                        <div class="d-flex align-items-center justify-content-center">
                            <p class="fs-4 mb-0 fw-bold">want to apply for a job?</p>
                            <a class="text-primary fw-bold ms-2" href="./authentication-register.html">Register
                                Now</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
