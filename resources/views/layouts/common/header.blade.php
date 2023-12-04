@php
    /**
     * @var User $user
     */
    $user = Auth::user();

    $languages = ['en' => __('site.language.en'), 'uk' => __('site.language.ua')];
    $appLocale = app()->getLocale();
@endphp
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">{{__('site.navbar.home')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('surveys.index') }}">{{__('site.navbar.surveys')}}</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" href="{{ route('voting.index') }}">{{__('site.navbar.voting')}}</a>
                </li>


            </ul>

        </div>
        <div>
            {{-- <div class="navbar-text d-flex align-items-center mx-2">
                <select class="form-select language-change" aria-label="Language">
                    @foreach ($languages as $key => $language)
                        <option {{ $appLocale === $key ? 'selected' : null }} value="{{ $key }}">
                            {{ $language }}</option>
                    @endforeach
                </select>
            </div> --}}
            {{-- <div>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Language
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            @foreach ($languages as $key => $language)
                            <li><a class="dropdown-item" href="#">{{ $language }}</a></li>

                                <option {{ $appLocale === $key ? 'selected' : null }} value="{{ $key }}">
                                    {{ $language }}</option>
                            @endforeach

                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div> --}}
            <div class="d-flex">
                @guest
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                @endguest
            </div>
            <div class="navbar-text d-flex align-items-center mx-2 gap-1">
                <select class="form-select language-change bg-dark text-light form-select-sm" aria-label="Language">
                    @foreach ($languages as $key => $language)
                        <option {{ $appLocale === $key ? 'selected' : null }} value="{{ $key }}">
                            {{ $language }}</option>
                    @endforeach
                </select>
                @auth
                    <div>
                        {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mx-2">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('scripts')
    <script>
        $('.language-change').on('change', (e) => {
            let selected = $(e.target).val();
            console.log(selected);
            fetch(`/change-language/${selected}`)
                .then(r => r.json())
                .then(data => {
                    console.log(data);
                    if (data.ok && data.language !== '{{ $appLocale }}') {
                        window.location.reload();
                    }
                })
        })
    </script>
@endpush
