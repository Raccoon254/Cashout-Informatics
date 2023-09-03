<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Withdrawal Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4">Withdrawal Details</h1>

                <table class="table table-zebra">
                    <tbody>
                    <tr>
                        <td class="font-bold">User:</td>
                        <td>{{ $withdrawal->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Amount:</td>
                        <td>${{ number_format($withdrawal->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Status:</td>
                        <td>{{ $withdrawal->status }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Contact:</td>
                        <td>{{ $withdrawal->contact }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Fee:</td>
                        <td>${{ number_format($withdrawal->fee, 2) }}</td>
                    </tr>
                    </tbody>
                </table>

                @can('manage')
                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('withdrawals.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Withdrawals
                        </a>

                        <a href="{{ route('withdrawals.edit', $withdrawal->id) }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                            <i class="fa-solid fa-gears"></i> Edit Withdrawal
                        </a>

                    </div>

                @else

                    <div class="mt-6 flex gap-4">

                        <a href="{{ route('user.withdrawals') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                            <i class="fas fa-arrow-left mr-2"></i> My Withdrawals
                        </a>

                    </div>

                @endcan

            </div>
        </div>
    </div>
</x-app-layout>
