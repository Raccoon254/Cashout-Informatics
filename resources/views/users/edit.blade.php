<!-- resources/views/users/edit.blade.php -->

<x-app-layout>
    <div class="container">
        <h1>Edit User</h1>
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</x-app-layout>
