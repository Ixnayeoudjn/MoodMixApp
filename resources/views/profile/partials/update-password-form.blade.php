<div style="background-color: #351c00; padding: 25px 30px; border-radius: 15px">
    <header style="margin-bottom: 20px; background-color: transparent; padding: 0px; ; display: flex; flex-direction: column; align-items: flex-start;">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" style="color: #c9c14e; font-size: 1.3rem;">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" style="font-size: 0.95rem; font-weight: bold; color: white;">
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
                
                <!-- Password Strength Indicator -->
                <div style="margin-top: 12px;">
                    <div class="password-strength-meter">
                        <div class="password-strength-bar" id="strengthBar" style="width: 0%; background-color: #888;"></div>
                    </div>
                    <div class="password-strength-text" id="strengthText" style="font-size: 0.85rem; margin-top: 6px; color: #999;">
                        Password strength: <span id="strengthLabel">Enter a password</span>
                    </div>
                    <ul class="password-requirements" style="margin-top: 10px; font-size: 0.85rem;">
                        <li id="req-length" style="color: #999;">
                            <span class="requirement-icon">○</span> At least 8 characters
                        </li>
                        <li id="req-uppercase" style="color: #999;">
                            <span class="requirement-icon">○</span> At least one uppercase letter (A-Z)
                        </li>
                        <li id="req-lowercase" style="color: #999;">
                            <span class="requirement-icon">○</span> At least one lowercase letter (a-z)
                        </li>
                        <li id="req-number" style="color: #999;">
                            <span class="requirement-icon">○</span> At least one number (0-9)
                        </li>
                        <li id="req-special" style="color: #999;">
                            <span class="requirement-icon">○</span> At least one special character (!@#$%^&*)
                        </li>
                    </ul>
                </div>
                
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

<style>
    .password-strength-meter {
        width: 100%;
        height: 6px;
        background-color: #ddd;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 8px;
    }

    .password-strength-bar {
        height: 100%;
        transition: width 0.3s ease, background-color 0.3s ease;
        border-radius: 3px;
    }

    .password-strength-text {
        display: flex;
        gap: 6px;
        align-items: center;
    }

    .password-strength-text span {
        font-weight: 600;
    }

    .password-requirements {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .password-requirements li {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 0;
        transition: color 0.3s ease;
    }

    .requirement-icon {
        display: inline-block;
        font-weight: bold;
        width: 16px;
        text-align: center;
    }

    .password-requirements li.met {
        color: #4caf50 !important;
    }

    .password-requirements li.met .requirement-icon {
        color: #4caf50;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('update_password_password');
        const confirmPasswordInput = document.getElementById('update_password_password_confirmation');
        const strengthBar = document.getElementById('strengthBar');
        const strengthLabel = document.getElementById('strengthLabel');

        const requirements = {
            length: document.getElementById('req-length'),
            uppercase: document.getElementById('req-uppercase'),
            lowercase: document.getElementById('req-lowercase'),
            number: document.getElementById('req-number'),
            special: document.getElementById('req-special')
        };

        function evaluatePassword() {
            const password = passwordInput.value;
            let strength = 0;
            let metRequirements = 0;

            // Check length (8+ characters)
            const hasLength = password.length >= 8;
            if (hasLength) {
                strength += 20;
                metRequirements++;
                requirements.length.classList.add('met');
            } else {
                requirements.length.classList.remove('met');
            }

            // Check uppercase
            const hasUppercase = /[A-Z]/.test(password);
            if (hasUppercase) {
                strength += 20;
                metRequirements++;
                requirements.uppercase.classList.add('met');
            } else {
                requirements.uppercase.classList.remove('met');
            }

            // Check lowercase
            const hasLowercase = /[a-z]/.test(password);
            if (hasLowercase) {
                strength += 20;
                metRequirements++;
                requirements.lowercase.classList.add('met');
            } else {
                requirements.lowercase.classList.remove('met');
            }

            // Check numbers
            const hasNumber = /[0-9]/.test(password);
            if (hasNumber) {
                strength += 20;
                metRequirements++;
                requirements.number.classList.add('met');
            } else {
                requirements.number.classList.remove('met');
            }

            // Check special characters
            const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            if (hasSpecial) {
                strength += 20;
                metRequirements++;
                requirements.special.classList.add('met');
            } else {
                requirements.special.classList.remove('met');
            }

            // Update strength bar
            strengthBar.style.width = strength + '%';

            // Update strength label and color
            if (password.length === 0) {
                strengthLabel.textContent = 'Enter a password';
                strengthBar.style.backgroundColor = '#888';
            } else if (strength < 40) {
                strengthLabel.textContent = 'Weak';
                strengthBar.style.backgroundColor = '#f44336';
            } else if (strength < 60) {
                strengthLabel.textContent = 'Fair';
                strengthBar.style.backgroundColor = '#ff9800';
            } else if (strength < 80) {
                strengthLabel.textContent = 'Good';
                strengthBar.style.backgroundColor = '#ffc107';
            } else {
                strengthLabel.textContent = 'Strong';
                strengthBar.style.backgroundColor = '#4caf50';
            }
        }

        // Evaluate on input
        passwordInput.addEventListener('input', evaluatePassword);
        
        // Initialize on page load if password field already has value
        evaluatePassword();
    });
</script>
