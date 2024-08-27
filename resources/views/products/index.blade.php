<a href="{{ route('products.create') }}">Add</a>
<h1>Products</h1>
<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Images</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody>
    @forelse($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->title }}</td>
            <td>
                @if ($product->images)
                    @foreach (json_decode($product->images, true) as $image)
                        <img src="{{ asset('storage/images/' . $image) }}" alt="{{ $product->title }}" style="width: 100px; height: 100px;">
                    @endforeach
                @else
                    <p>No images available</p>
                @endif
            </td>
            <td>
                <a href="{{ route('products.edit', $product->id) }}">Edit</a>
                <form action="{{ route('products.destroy', $product->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
        </tr>
    @empty
        <tr>
            <td colspan="3">No products found</td>
        </tr>
    @endforelse
    </tbody>
</table>
