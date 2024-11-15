<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit CD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('cds.update', $cd->id) }}" method="POST">
                        
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">TITLE</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $cd->title) }}" placeholder="Enter CD Title">
                                
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Artist -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">ARTIST</label>
                                <input type="text" class="form-control @error('artist') is-invalid @enderror" name="artist" value="{{ old('artist', $cd->artist) }}" placeholder="Enter Artist Name">
                                
                                @error('artist')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Genre -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">GENRE</label>
                                <input type="text" class="form-control @error('genre') is-invalid @enderror" name="genre" value="{{ old('genre', $cd->genre) }}" placeholder="Enter Genre">
                                
                                @error('genre')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">STOCK</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $cd->stock) }}" placeholder="Enter Stock">
                                
                                @error('stock')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                            <a href="{{ route('cds.index') }}" class="btn btn-md btn-secondary">CANCEL</a>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
