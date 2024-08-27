<form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <label for="name">Name</label>
    <input type="text" name="title" id="name" value="{{ $product->title }}">

    <label for="description">Description</label>
    <textarea name="description" id="description">{{ $product->description }}</textarea>

    <label for="images">Images</label>
    <input type="file" name="images[]" id="images" multiple>

    @if ($product->images)
        @foreach (json_decode($product->images, true) as $image)
            <img src="{{ asset('storage/images/' . $image) }}" alt="{{ $product->title }}" style="width: 100px; height: 100px;">
        @endforeach
    @else
        <p>No images available</p>
    @endif

    <button type="submit">Update</button>
</form>
