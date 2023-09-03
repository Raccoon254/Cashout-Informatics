<x-app-layout>
    <div class="flex">
        <section class="z-50">
            @include('admin.sidebar')
        </section>

        <section class="px-4 w-full">
            <center class="text-3xl font-semibold my-4">Users</center>

            @include('session.alerts')
        <table class="table table-zebra">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="">
                        <div class="flex gap-4">
                            <a class="tooltip tooltip-warning" data-tip="Edit {{ $user->name }}" href="{{ route('users.edit', $user) }}">
                                <button class="btn btn-sm btn-ghost ring btn-circle">
                                    <i class="fa-solid fa-pen-nib"></i>
                                </button>
                            </a>

                            <a class="tooltip tooltip-warning" data-tip="Show {{ $user->name }}" href="{{ route('users.show', $user) }}">
                                <button class="btn btn-sm btn-ghost ring btn-circle">
                                    <i class="fas fa-mountain"></i>
                                </button>
                            </a>

                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </section>
    </div>
</x-app-layout>
