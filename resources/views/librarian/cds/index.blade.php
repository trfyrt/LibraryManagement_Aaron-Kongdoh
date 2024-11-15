<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CDs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4"><b>Library Management System</b></h3>
                    <h3 class="text-center my-4">Viewing CDs</h3>
                    <header class="d-flex justify-content-center py-3">
                        <ul class="nav nav-pills">
                          <li class="nav-item"><a href="{{ route('books.index') }}" class="nav-link link-secondary" style="font-weight: 600">Books</a></li>
                          <li class="nav-item"><a href="{{ route('cds.index') }}" class="nav-link link-dark" style="font-weight: 600">CDs</a></li>
                          <li class="nav-item"><a href="{{ route('journals.index') }}" class="nav-link link-secondary" style="font-weight: 600">Journals</a></li>
                          <li class="nav-item"><a href="{{ route('newspapers.index') }}" class="nav-link link-secondary" style="font-weight: 600">Newspapers</a></li>
                        </ul>
                      </header>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="{{ route('cds.create') }}" class="btn btn-md btn-success mb-3">ADD CD</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">ARTIST</th>
                                    <th scope="col">GENRE</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col" style="width: 20%">ACTIONS</th>
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
                                                <a href="{{ route('cds.show', $cd->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('cds.edit', $cd->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        No CDs available.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $cds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //message with sweetalert
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

    </script>

</body>
</html>
