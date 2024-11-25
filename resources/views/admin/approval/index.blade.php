<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Approval and Management</title>
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
        
        <!-- Books Section -->
        <h4>Books</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">TITLE</th>
                    <th scope="col">AUTHOR</th>
                    <th scope="col">PUBLISHER</th>
                    <th scope="col">YEAR</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->year }}</td>
                        <td>{{ $book->is_approved ? 'Approved' : 'Pending' }}</td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Are you sure?');" action="{{ route('books.destroy', $book->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                            </form>
                            @if (!$book->is_approved)
                                <form onsubmit="return confirm('Are you sure?');" action="{{ route('books.approve', $book->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">APPROVE</button>
                                </form>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    No Books needs approval.
                </div>
                @endforelse
            </tbody>
        </table>
        
        <!-- CDs Section -->
        <h4>CDs</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">TITLE</th>
                    <th scope="col">ARTIST</th>
                    <th scope="col">GENRE</th>
                    <th scope="col">STOCK</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cds as $cd)
                    <tr>
                        <td>{{ $cd->title }}</td>
                        <td>{{ $cd->artist }}</td>
                        <td>{{ $cd->genre }}</td>
                        <td>{{ $cd->stock }}</td>
                        <td>{{ $cd->is_approved ? 'Approved' : 'Pending' }}</td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Are you sure?');" action="{{ route('cds.destroy', $cd->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                            </form>
                            @if (!$cd->is_approved)
                                <form onsubmit="return confirm('Are you sure?');" action="{{ route('cds.approve', $cd->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">APPROVE</button>
                                </form>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    No CDs needs approval.
                </div>
                @endforelse
            </tbody>
        </table>
        
        <!-- Journals Section -->
        <h4>Journals</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">TITLE</th>
                    <th scope="col">AUTHOR</th>
                    <th scope="col">PUBLISH DATE</th>
                    <th scope="col">ABSTRACT</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($journals as $journal)
                    <tr>
                        <td>{{ $journal->title }}</td>
                        <td>{{ $journal->author }}</td>
                        <td>{{ $journal->publish_date }}</td>
                        <td>{{ Str::limit($journal->abstract, 50) }}</td>
                        <td>{{ $journal->is_approved ? 'Approved' : 'Pending' }}</td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Are you sure?');" action="{{ route('journals.destroy', $journal->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                            </form>
                            @if (!$journal->is_approved)
                                <form onsubmit="return confirm('Are you sure?');" action="{{ route('journals.approve', $journal->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">APPROVE</button>
                                </form>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    No Journals needs approval.
                </div>
                @endforelse
            </tbody>
        </table>
        
        <!-- Newspapers Section -->
        <h4>Newspapers</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">TITLE</th>
                    <th scope="col">PUBLISHER</th>
                    <th scope="col">PUBLISH DATE</th>
                    <th scope="col">STOCK</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($newspapers as $newspaper)
                    <tr>
                        <td>{{ $newspaper->title }}</td>
                        <td>{{ $newspaper->publisher }}</td>
                        <td>{{ $newspaper->publish_date }}</td>
                        <td>{{ $newspaper->stock }}</td>
                        <td>{{ $newspaper->is_approved ? 'Approved' : 'Pending' }}</td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Are you sure?');" action="{{ route('newspapers.destroy', $newspaper->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                            </form>
                            @if (!$newspaper->is_approved)
                                <form onsubmit="return confirm('Are you sure?');" action="{{ route('newspapers.approve', $newspaper->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">APPROVE</button>
                                </form>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                <div class="alert alert-danger">
                    No Newspapers needs approval.
                </div>
                @endforelse
            </tbody>
        </table>

        <!-- Fyps Section -->
        <h4>FYPs</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">TITLE</th>
                    <th scope="col">AUTHOR</th>
                    <th scope="col">SUPERVISOR</th>
                    <th scope="col">YEAR</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fyps as $fyp)
                    <tr>
                        <td>{{ $fyp->title }}</td>
                        <td>{{ $fyp->author }}</td>
                        <td>{{ $fyp->supervisor }}</td>
                        <td>{{ $fyp->year }}</td>
                        <td>{{ $fyp->is_approved ? 'Approved' : 'Pending' }}</td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Are you sure?');" action="{{ route('fyps.destroy', $fyp->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                            </form>
                            @if (!$fyp->is_approved)
                                <form onsubmit="return confirm('Are you sure?');" action="{{ route('fyps.approve', $fyp->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success">APPROVE</button>
                                </form>
                            @else
                                <span class="badge bg-success">Approved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <div class="alert alert-danger">
                        No FYPs need approval.
                    </div>
                @endforelse
            </tbody>
        </table>
        
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
