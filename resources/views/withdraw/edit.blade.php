<x-app-layout>
    <div class="flex">

        <section class="z-50">
            @include('admin.sidebar')
        </section>

        <section class="px-4 w-full">
            <div class="container flex flex-col items-center justify-center">

                @include('session.alerts')

                <form class="w-full my-12 max-w-xs" method="POST" action="{{ route('withdrawals.update', $withdrawal->id) }}">
                    <center class="text-3xl font-semibold">Edit Withdrawal</center>

                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input disabled type="number" step="0.01" name="amount" id="amount" value="{{ $withdrawal->amount }}" class="input input-bordered input-secondary w-full max-w-xs">
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="select select-secondary w-full max-w-xs">
                            <option value="pending" {{ $withdrawal->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $withdrawal->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="paid" {{ $withdrawal->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact:</label>
                        <input disabled type="text" name="contact" id="contact" value="{{ $withdrawal->contact }}" class="input input-bordered input-secondary w-full max-w-xs">
                    </div>

                    <div data-tip="Update Details" class="w-full tooltip tooltip-bottom tooltip-warning flex items-center justify-center">
                        <x-round-button type="submit" class="bg-blue-600 ring-green-500 hover:bg-transparent hover:text-gray-50">
                            <i class="fa-solid fa-sd-card"></i>
                        </x-round-button>
                    </div>

                </form>
            </div>
        </section>

        <section class="h-full z-30 sticky">
            @include('layouts.stabilizer-sidebar')
        </section>

    </div>
</x-app-layout>
