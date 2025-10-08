<x-guest-layout>
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-4">Register</h2>

    <form id="register-form" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" data-validate="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
            <p id="name-error" class="text-sm text-red-600 mt-2 hidden"></p>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" data-validate="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <p id="email-error" class="text-sm text-red-600 mt-2 hidden"></p>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" data-validate="phone" class="block mt-1 w-full" type="tel" name="phone"
                :value="old('phone')" required autocomplete="tel" />
            <p id="phone-error" class="text-sm text-red-600 mt-2 hidden"></p>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- University Selection -->
        <div class="mt-4">
            <x-input-label for="university_id" :value="__('University')" />
            <select id="university_id" name="university_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                onchange="if(this.value==='create') { window.location='{{ route('universities.fromUser.create') }}'; }">

                <option value="">Select your university</option>

                @foreach ($universities as $university)
                    <option value="{{ $university->id }}"
                        {{ old('university_id') == $university->id ? 'selected' : '' }}>
                        {{ $university->name }}
                    </option>
                @endforeach

                <option value="create">➕ Add University</option>
            </select>

            <x-input-error :messages="$errors->get('university_id')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role_id" :value="__('Role')" />
            <select id="role_id" name="role_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Select your role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->id == 1 ? 'Admin' : ($role->id == 2 ? 'Ambassador' : ($role->id == 3 ? 'Vice' : ($role->id == 4 ? 'Representative' : 'Guest'))) }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register Button -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button id="register-button" class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        (function() {
            // validators
            const validators = {
                name: value => {
                    if (!value || value.trim().length < 2) return 'Name must be at least 2 characters.';
                    const ok = /^[\p{L}\s'’-]+$/u.test(value.trim());
                    return ok ? '' : 'Name contains invalid characters.';
                },
                email: value => {
                    if (!value) return 'Email is required.';
                    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return re.test(value) ? '' : 'Enter a valid email address.';
                },
                phone: value => {
                    if (!value) return 'Phone number is required.';
                    const digits = value.replace(/\D/g, '');
                    if (digits.length < 7) return 'Phone number is too short.';
                    if (digits.length > 15) return 'Phone number is too long.';
                    return '';
                }
            };

            const form = document.getElementById('register-form');
            const submitBtn = document.getElementById('register-button');

            function showError(input, message) {
                const id = input.id;
                const err = document.getElementById(id + '-error');
                if (message) {
                    err.textContent = message;
                    err.classList.remove('hidden');
                    input.classList.remove('border-gray-300');
                    input.classList.add('border-red-600', 'ring-red-600');
                    input.setAttribute('aria-invalid', 'true');
                } else {
                    err.textContent = '';
                    err.classList.add('hidden');
                    input.classList.remove('border-red-600', 'ring-red-600');
                    input.classList.add('border-gray-300');
                    input.removeAttribute('aria-invalid');
                }
            }

            function validateInput(input) {
                const type = input.dataset.validate;
                if (!type || !validators[type]) return '';
                const msg = validators[type](input.value);
                showError(input, msg);
                return msg;
            }

            // wire inputs
            const inputs = Array.from(form.querySelectorAll('[data-validate]'));
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    validateInput(input);
                    toggleSubmit();
                });
                input.addEventListener('blur', () => {
                    validateInput(input);
                    toggleSubmit();
                });
            });

            function toggleSubmit() {
                const anyError = inputs.some(i => validators[i.dataset.validate](i.value));
                submitBtn.disabled = anyError;
                if (submitBtn.disabled) {
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // final check on submit
            form.addEventListener('submit', function(e) {
                let hasError = false;
                inputs.forEach(i => {
                    const msg = validateInput(i);
                    if (msg) hasError = true;
                });
                if (hasError) {
                    e.preventDefault();
                    toggleSubmit();
                    // focus first invalid
                    const firstInvalid = inputs.find(i => i.getAttribute('aria-invalid') === 'true');
                    if (firstInvalid) firstInvalid.focus();
                }
            });

            // initial toggle
            toggleSubmit();
        })();
    </script>
</x-guest-layout>
