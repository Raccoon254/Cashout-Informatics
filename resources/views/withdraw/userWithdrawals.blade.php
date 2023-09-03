<x-app-layout>

    <section class="flex w-full">
        <div class="h-full z-30 sticky">
            @include('layouts.sidebar')
        </div>
        <div class="w-full">
            <center class="text-3xl my-4 font-semibold">
                Withdrawals
            </center>
            @if(session('success'))
                <div class="alert rounded mb-4 alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert rounded mb-4 alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ session('error') }}
                </div>
            @endif


            @if(count($withdrawals) > 0)
                <table class="table table-zebra">
                    <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->user->name }}</td>
                            <td>${{ number_format($withdrawal->amount, 2) }}</td>
                            <td class="{{ $withdrawal->status === 'paid' ? 'bg-red-400' : ($withdrawal->status === 'pending' ? 'bg-white' : 'bg-green-400') }}">
                                {{ $withdrawal->status }}
                            </td>
                            <td>{{ $withdrawal->contact }}</td>
                            <td>{{ $withdrawal->created_at->diffForHumans() }}</td>
                            <td data-tip="View Withdrawal {{ $withdrawal->id }}" class="tooltip tooltip-warning">
                                <a href="{{ route('withdrawals.show', $withdrawal->id) }}">
                                    <x-round-button>
                                        <i class="fa-solid fa-mountain"></i>
                                    </x-round-button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <section class="w-full flex flex-col items-center justify-center h-[60vh]">
                    <p>No withdrawals to yet.</p>
                </section>
            @endif

        </div>
    </section>
</x-app-layout>
