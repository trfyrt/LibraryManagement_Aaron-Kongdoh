<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h3>{{ $book->title }}</h3>
                        <hr />
                        <p><strong>Author:</strong> {{ $book->author }}</p>
                        <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
                        <p><strong>Year of Publication:</strong> {{ $book->year }}</p>
                        <p><strong>Type:</strong> {{ ucfirst($book->type) }}</p>
                        <hr />
                        <a href="{{ route('books.index') }}" class="btn btn-primary">Back to Books List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
