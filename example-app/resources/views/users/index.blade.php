<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>user</h1>
    <div>index</div>
    <div>
        @if (session('success'))
            <div>
                {{session('success')}}
            </div>
        @endif
    </div>
    <div>
        <div>
            <a href="{{route('user.create')}}">Create</a>
        </div>
        <table border="1" >
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Desc</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</a></td>
                    <td>{{$user->qty}}</td>
                    <td>{{$user->price}}</td>
                    <td>{{$user->desc}}</td>
                    <td>
                        <a href="{{route('user.edit', ['user' => $user->id])}}">Edit</a>
                    </td>
                    <td>
                        <form action="{{route('user.destroy', ['user' => $user])}}" method="delete">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>