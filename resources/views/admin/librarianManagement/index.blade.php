<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Librarian Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5">
        <h3 class="text-center my-4"><b>Library Management System - Admin</b></h3>

        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="{{ route('approval.index') }}" class="nav-link link-secondary" style="font-weight: 600">Approval</a></li>
                <li class="nav-item"><a href="{{ route('librarianManagement.index') }}" class="nav-link link-dark" style="font-weight: 600">Manage Librarian</a></li>
                <li class="nav-item"><form method="POST" action="{{ route('logout') }}" class="nav-link link-danger" style="font-weight: 600">
                    @csrf
                    
                    <x-responsive-nav-link class="link-danger" :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
                </form></li>
            </ul>
        </header>
        
        <h4>Librarian</h4>
        <a href="{{ route('register') }}" class="btn btn-md btn-success mb-3">ADD NEW LIBRARIAN</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">NAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($librarians as $librarian)
                    <tr>
                        <td>{{ $librarian->name }}</td>
                        <td>{{ $librarian->email }}</td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Are you sure?');" action="{{ route('librarianManagement.destroy', $librarian->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                            </form>
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    There's no Librarian
                </div>
                @endforelse
            </tbody>
        </table>
            
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
