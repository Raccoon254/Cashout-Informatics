<x-app-layout>
    <div class="flex">
        <section class="z-50">
            @include('admin.sidebar')
        </section>

        <section class="px-4 w-full">
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <form method="POST" action="{{ route('users.update', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <!-- Name -->
                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Name') }}
                                    </label>
                                    <input id="name" type="text" class="input input-bordered input-primary w-full"
                                           name="name" value="{{ old('name', $user->name) }}" required autofocus />
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Email') }}
                                    </label>
                                    <input id="email" type="email" class="input input-bordered input-primary w-full"
                                           name="email" value="{{ old('email', $user->email) }}" required />
                                </div>

                                <!-- Referral Code -->
                                <div class="mb-4">
                                    <label for="referral_code" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Referral Code') }}
                                    </label>
                                    <input id="referral_code" type="text"
                                           class="input input-bordered input-primary w-full" name="referral_code"
                                           value="{{ old('referral_code', $user->referral_code) }}" />
                                </div>

                                <!-- Balance -->
                                <div class="mb-4">
                                    <label for="balance" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Balance') }}
                                    </label>
                                    <input id="balance" type="number" class="input input-bordered input-primary w-full"
                                           name="balance" value="{{ old('balance', $user->balance) }}" />
                                </div>

                                <!-- Previous -->
                                <div class="mb-4">
                                    <label for="previous" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Previous') }}
                                    </label>
                                    <input id="previous" type="number" class="input input-bordered input-primary w-full"
                                           name="previous" value="{{ old('previous', $user->previous) }}" />
                                </div>

                                <!-- Tokens -->
                                <div class="mb-4">
                                    <label for="tokens" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Tokens') }}
                                    </label>
                                    <input id="tokens" type="number" class="input input-bordered input-primary w-full"
                                           name="tokens" value="{{ old('tokens', $user->tokens) }}" />
                                </div>

                                <!-- Type -->
                                <div class="mb-4">
                                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Type') }}
                                    </label>
                                    <input id="type" type="text" class="input input-bordered input-primary w-full"
                                           name="type" value="{{ old('type', $user->type) }}" />
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Status') }}
                                    </label>
                                    <input id="status" type="text" class="input input-bordered input-primary w-full"
                                           name="status" value="{{ old('status', $user->status) }}" />
                                </div>

                                <!-- Last Login -->
                                <div class="mb-4">
                                    <label for="last_login" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Last Login') }}
                                    </label>
                                    <input id="last_login" type="datetime-local"
                                           class="input input-bordered input-primary w-full" name="last_login"
                                           value="{{ old('last_login', $user->last_login) }}" />
                                </div>

                                <!-- Contact -->
                                <div class="mb-4">
                                    <label for="contact" class="block text-gray-700 text-sm font-bold mb-2">
                                        {{ __('Contact') }}
                                    </label>
                                    <input id="contact" type="tel" class="input input-bordered input-primary w-full"
                                           name="contact" value="{{ old('contact', $user->contact) }}" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="ml-4">
                                        {{ __('Update User') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
