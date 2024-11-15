<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Newspaper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('newspapers.store') }}" method="POST">
                            @csrf

                            <!-- Title -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">TITLE</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" placeholder="Enter Newspaper Title">
                                
                                <!-- error message for title -->
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Publisher -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">PUBLISHER</label>
                                <select name="publisher" class="form-control @error('publisher') is-invalid @enderror">
                                    <option value="Kompas" {{ old('publisher') == 'Kompas' ? 'selected' : '' }}>Kompas</option>
                                    <option value="Tribun Timur" {{ old('publisher') == 'Tribun Timur' ? 'selected' : '' }}>Tribun Timur</option>
                                    <option value="Fajar" {{ old('publisher') == 'Fajar' ? 'selected' : '' }}>Fajar</option>
                                </select>
                                
                                <!-- Error message for publisher -->
                                @error('publisher')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Publish Date -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">PUBLISH DATE</label>
                                <input type="date" class="form-control @error('publish_date') is-invalid @enderror" name="publish_date" value="{{ old('publish_date') }}">
                                
                                <!-- error message for publish_date -->
                                @error('publish_date')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Availability -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold">AVAILABILITY</label>
                                <select class="form-control @error('is_available') is-invalid @enderror" name="is_available">
                                    <option value="1" {{ old('is_available') == '1' ? 'selected' : '' }}>Available</option>
                                    <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Not Available</option>
                                </select>

                                <!-- error message for availability -->
                                @error('is_available')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
