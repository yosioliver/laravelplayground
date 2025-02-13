<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forms</title>
</head>
<body>
    <form action="{{ route('storeForm') }}" method="post">
        @csrf
        <label for="language">Favorite language</label><br>
        <input type="radio" id="css" name="language" value="CSS">
        <label for="css">CSS</label><br>
        <input type="radio" id="javascript" name="language" value="JavaScript">
        <label for="javascript">JavaScript</label>
        <br>
        <label for="checkbox">Option:</label><br>
        <input type="checkbox" name="options[]" id="checkbox" value="option1"> Option 1
        <input type="checkbox" name="options[]" id="checkbox" value="option2"> Option 2
        <input type="checkbox" name="options[]" id="checkbox" value="option3"> Option 3
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
