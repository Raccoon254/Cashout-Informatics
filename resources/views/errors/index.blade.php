<x-guest-layout>
    <section class="px-4 w-full">
        <section class="mb-4 text-gray-50">
            <span class="text-2xl text-gray-50 font-semibold">
                Hello  {{ Auth::user()->name }}<br>
            </span>
            <p>
                You are not authorized to do that action.
            </p>
        </section>
    </section>
</x-guest-layout>
