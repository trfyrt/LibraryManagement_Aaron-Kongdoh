<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('books.update', $book->id) }}" method="POST">
                        
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">TITLE</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $book->title) }}" placeholder="Enter Book Title">
                                
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Author -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">AUTHOR</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author', $book->author) }}" placeholder="Enter Author Name">
                                
                                @error('author')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Publisher -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">PUBLISHER</label>
                                <input type="text" class="form-control @error('publisher') is-invalid @enderror" name="publisher" value="{{ old('publisher', $book->publisher) }}" placeholder="Enter Publisher Name">
                                
                                @error('publisher')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Year -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">YEAR OF PUBLICATION</label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year', $book->year) }}" placeholder="Enter Year of Publication">
                                
                                @error('year')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">BOOK TYPE</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror">
                                    <option value="book" {{ old('type', $book->type) == 'book' ? 'selected' : '' }}>Book</option>
                                    <option value="ebook" {{ old('type', $book->type) == 'ebook' ? 'selected' : '' }}>Ebook</option>
                                </select>

                                @error('type')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                            <a href="{{ route('books.index') }}" class="btn btn-md btn-secondary">CANCEL</a>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
