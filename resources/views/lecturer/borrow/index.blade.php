<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Borrow Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5">
        <h3 class="text-center my-4"><b>Library Management System</b></h3>
        <h3 class="text-center my-4">Viewing Catalogue</h3>
<header class="d-flex justify-content-center py-3">
    <ul class="nav nav-pills">
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
  <hr>

        <!-- Books Table -->
        <div class="card border-0 shadow-sm rounded mb-4">
            <div class="card-body">
                <h5>Books</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Year</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher }}</td>
                            <td>{{ $book->year }}</td>
                            <td>
                                @if($borrowedItems->contains('book_id', $book->id))
                                    <span class="badge bg-warning">Borrowed</span>
                                @else
                                    <span class="badge bg-success">Available</span>
                                @endif
                            </td>
                            <td>
                                @if(!$borrowedItems->contains('book_id', $book->id))
                                <form action="{{ route('borrow.item', ['type' => 'book', 'id' => $book->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">Borrow</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CDs Table -->
        <div class="card border-0 shadow-sm rounded mb-4">
            <div class="card-body">
                <h5>CDs</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Genre</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cds as $cd)
                        <tr>
                            <td>{{ $cd->title }}</td>
                            <td>{{ $cd->artist }}</td>
                            <td>{{ $cd->genre }}</td>
                            <td>
                                @if($borrowedItems->contains('cd_id', $cd->id))
                                    <span class="badge bg-warning">Borrowed</span>
                                @else
                                    <span class="badge bg-success">Available</span>
                                @endif
                            </td>
                            <td>
                                @if(!$borrowedItems->contains('cd_id', $cd->id))
                                <form action="{{ route('borrow.item', ['type' => 'cd', 'id' => $cd->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">Borrow</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Repeat similar structure for FYPs, Journals, and Newspapers -->
        @foreach(['fyps' => 'FYPs', 'journals' => 'Journals', 'newspapers' => 'Newspapers'] as $key => $label)
        <div class="card border-0 shadow-sm rounded mb-4">
            <div class="card-body">
                <h5>{{ $label }}</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($$key as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>
                                @if($borrowedItems->contains("{$key}_id", $item->id))
                                    <span class="badge bg-warning">Borrowed</span>
                                @else
                                    <span class="badge bg-success">Available</span>
                                @endif
                            </td>
                            <td>
                                @if(!$borrowedItems->contains("{$key}_id", $item->id))
                                <form action="{{ route('borrow.item', ['type' => $key, 'id' => $item->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">Borrow</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "Success",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
        @endif
    </script>

</body>
</html>
