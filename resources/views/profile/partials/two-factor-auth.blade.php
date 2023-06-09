<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Two Factor Authentication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update the accounts' login settings.") }}
        </p>
    </header>
    @if (session('status') == 'two-factor-authentication-enabled')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600 dark:text-gray-400"
        >{{ __('Two factor authentication confirmed and enabled successfully.') }}</p>
    @elseif (session('status') == 'two-factor-authentication-disabled')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600 dark:text-gray-400"
        >{{ __('Two factor authentication confirmed and disabled successfully.') }}</p>
    @elseif(session('auth.password_confirmed_at') != null)
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600 dark:text-gray-400"
        >{{ __('Please finish configuring two factor authentication below.') }}</p>

    @endif
    @if(! auth()->user()->two_factor_secret)
        @if(session('auth.password_confirmed_at') != null)
            <form method="post" action="{{ route('two-factor.enable') }}" class="mt-6 space-y-6">
                @csrf

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Enable') }}</x-primary-button>
                </div>
            </form>
        @else
            <form method="post" action="{{ route('two-factor.enable') }}" class="mt-6 space-y-6">
                @csrf

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Confirm password') }}</x-primary-button>
                </div>
            </form>
        @endif
    @endif

    @if ( auth()->user()->two_factor_secret )
        <div class="mt-2">{!! auth()->user()->twoFactorQrCodeSvg() !!}</div>

        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                <div>{{ $code }}</div>
            @endforeach
        </div>

        <div class="mt-2">
            <form method="post" action="/user/two-factor-recovery-codes" class="mt-6 space-y-6">
                @csrf

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Regenerate') }}</x-primary-button>
                </div>
            </form>
        </div>

        <form method="post" action="{{ route('two-factor.disable') }}" class="mt-6 space-y-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-4">
                <x-danger-button>{{ __('Disable') }}</x-primary-button>
            </div>
        </form>
    @endif
</section>
