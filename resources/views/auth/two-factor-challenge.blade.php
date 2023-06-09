<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Enter your code here for two factor auth.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />


        <form method="POST" action="/two-factor-challenge">
            @csrf
            <div>
                <x-input-label for="code" :value="__('Code')" />

                <x-text-input id="code" class="block mt-1 w-full"
                                type="text"
                                name="code" />

                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button>
                    {{ __('Login') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="/two-factor-challenge">
            @csrf
            <div>
                <x-input-label for="recovery_code" :value="__('Recovery Code')" />

                <x-text-input id="recovery_code" class="block mt-1 w-full"
                                type="text"
                                name="recovery_code" />

                <x-input-error :messages="$errors->get('recovery_code')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button>
                    {{ __('Login') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
