<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <form action="{{ route('storeForm') }}" method="post">
        @csrf
        @foreach ($errors->all() as $message)
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @endforeach
        <div class="mb-3">
            <label for="language" class="form-label">Favorite language:</label>
            <br>
            <input type="radio" id="css" name="language" value="CSS">
            <label for="css">CSS</label><br>
            <input type="radio" id="javascript" name="language" value="JavaScript">
            <label for="javascript">JavaScript</label>
        </div>
        <div class="mb-3">
            <label for="checkbox" class="form-label">Option:</label>
            <br>
            <input type="checkbox" name="options[]" id="checkbox" value="option1"> Option 1
            <input type="checkbox" name="options[]" id="checkbox" value="option2"> Option 2
            <input type="checkbox" name="options[]" id="checkbox" value="option3"> Option 3
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>
