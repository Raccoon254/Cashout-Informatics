<x-app-layout>
    <div class="flex">
        <section class="z-50">
            @can('manage')
                @include('admin.sidebar')
            @else
                @include('layouts.sidebar')
            @endcan
        </section>

        <section class="px-4 w-full">
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="pb-8 pr-4">
                            <h1 class="text-2xl font-semibold my-4">{{ $user->name }}'s Details</h1>
                            <table class="w-full table table-zebra">
                                <tr>
                                    <th class="text-left text-2xl pr-4">Field</th>
                                    <th class="text-left text-2xl">Value</th>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Email</td>

                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Referral Code</td>
                                    <td>{{ $user->referral_code }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Balance</td>
                                    <td>${{ number_format($user->balance, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Previous</td>
                                    <td>${{ number_format($user->previous, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Referred By</td>
                                    <td>{{ $user->referred_by }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Tokens</td>
                                    <td>{{ $user->tokens }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Type</td>
                                    <td>{{ $user->type }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Status</td>
                                    <td>{{ $user->status }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Last Login</td>
                                    <td>{{ $user->last_login }}</td>
                                </tr>
                                <tr>
                                    <td class="pr-4 flex items-center">
                                        <div class="h-[40px]"></div>Contact</td>
                                    <td>{{ $user->contact }}</td>
                                </tr>
                            </table>

                            @can('manage')
                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('users.edit', $user->id) }}" class="">
                                        <x-primary-button>
                                            <i class="fa-solid fa-pen-nib"></i> {{ __('Edit User') }}
                                        </x-primary-button>
                                    </a>
                                </div>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
