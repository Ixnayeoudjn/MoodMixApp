<div style="background-color: #351c00; padding: 25px 30px; border-radius: 15px">
    <header style="margin-bottom: 20px; background-color: transparent; padding: 0px; ; display: flex; flex-direction: column; align-items: flex-start;">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" style="color: #c9c14e; font-size: 1.3rem;">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" style="font-size: 0.95rem;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 " style="padding: 0">
        @csrf
        @method('put')

        <div class="password-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" style="font-size: 1rem;" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" placeholder="Enter your Current Password" style="background-color: white; color: #333; font-size: 1rem;" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" style="font-size: 1rem;" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" placeholder="Confirm your New Password" style="background-color: white; color: #333; font-size: 1rem;" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; width: 50%;">
            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" style="font-size: 1rem;" />
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" placeholder="Enter your New Password" style="background-color: white; color: #333; font-size: 1rem;" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4" style="justify-content: flex-end;">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</div>
