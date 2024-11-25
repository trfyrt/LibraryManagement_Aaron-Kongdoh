<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit FYP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('fyps.update', $fyp->id) }}" method="POST">
                        
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">TITLE</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $fyp->title) }}" placeholder="Enter FYP Title">
                                
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Author -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">AUTHOR</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author', $fyp->author) }}" placeholder="Enter Author Name">
                                
                                @error('author')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Supervisor -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">SUPERVISOR</label>
                                <input type="text" class="form-control @error('supervisor') is-invalid @enderror" name="supervisor" value="{{ old('supervisor', $fyp->supervisor) }}" placeholder="Enter Supervisor Name">
                                
                                @error('supervisor')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Year -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">YEAR</label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year', $fyp->year) }}" placeholder="Enter Year">
                                
                                @error('year')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                            <a href="{{ route('fyps.index') }}" class="btn btn-md btn-secondary">CANCEL</a>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
