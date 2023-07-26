<!-- resources/views/users/index.blade.php -->

<x-app-layout>
    <div class="container">
        <h1>Users</h1>
        <table class="table tab-bordered table-zebra">
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
                    <td>
                        <div class="flex gap-3">
                            <a href="{{ route('users.edit', $user) }}">
                                <button class="btn btn-xs btn-circle">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                            <form method="POST" action="{{ route('users.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-circle focus:ring-red-500">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
