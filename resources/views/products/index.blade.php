<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 10 Product Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-2">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Product List</h2>
            </div>

            <div class="mb-4 d-flex align-items-end gap-2">
                <form method="GET" action="{{ route('products.index') }}" class="d-flex gap-2">
                    <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}">
                    <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}">
                    
                    <select name="available">
                        <option value="">-- Availability --</option>
                        <option value="1" {{ request('available') === '1' ? 'selected' : '' }}>In Stock</option>
                        <option value="0" {{ request('available') === '0' ? 'selected' : '' }}>Out of Stock</option>
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </form>
                <a href="{{ route('cart.index') }}" class="btn btn-warning btn-sm">Add Cart</a>
            </div>
                    
            @if($role === 'admin')
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('products.create') }}">+ Create Product</a>
                </div>
            @endif
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price (₹)</th>
            <th>Stock</th>
            @if($role === 'admin')
                <th width="200px">Action</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{$product->price }}</td>
                <td>{{ $product->stock }}</td>
                @if($role === 'admin')
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="{{ $role === 'admin' ? 6 : 5 }}">No products found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
</body>
</html>