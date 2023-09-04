<section class="w-full border p-2 sm:p-4 rounded border-base-100 hover:bg-base-100">
    <section class="top flex justify-between w-full">
        <h2 class="card-title">About This Page</h2>
        <div class="btn btn-circle btn-ghost btn-outline">
            <i class="fa-solid fa-circle-info"></i>
        </div>
    </section>
    @php
        $activaton_fee = Env('ACTIVATION_FEE');
    @endphp
    @if(Auth::user()->balance < $activaton_fee)
        <section class="flex flex-col gap-4">
            <p>
                You have to deposit at least KSH {{ $activaton_fee }} to activate your account and start earning and be able to the following Cashout Tasks
            </p>
            <ul class="list-disc list-inside flex flex-col gap-2 rounded-box">
                <li>Share Cash</li>
                <li>Send Money</li>
                <li>Deposit</li>
                <li>Withdraw</li>
                <li>Buy Airtime</li>
                <li>Do Referrals</li>
            </ul>
        </section>
    @else
        <section>
            Enter your email address to activate your account
        </section>
    @endif
</section>
