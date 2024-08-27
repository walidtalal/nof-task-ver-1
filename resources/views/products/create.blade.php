<form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="title" id="name">

    <label for="description">Description</label>
    <textarea name="description" id="description"></textarea>

    <label for="images">images</label>
    <input type="file" name="images[]" id="images" multiple>

    <button type="submit">Save</button>
</form>
