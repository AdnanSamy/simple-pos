<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div class="container">
        <table class="table" border="1">
            @foreach($data as $item)
                <thead>
                    <th></th>
                </thead>
            @endforeach
        </table>
    </div>
</body>
</html>
