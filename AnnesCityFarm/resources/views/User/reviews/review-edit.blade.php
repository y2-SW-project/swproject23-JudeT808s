<form method="POST" action="{{ route('admin.animals.update', $animal) }}" enctype="multipart/form-data" method="post">
    @method('PUT')
    @csrf
    <form method="POST" action="{{ route('review.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $review->name }} "
                required>
        </div>
        <div class="form-group">
            <label for="stars">stars</label>
            <input type="radio" name="stars" value="{{ $review->name }} " required>

        </div>
        <div class="form-group">
            <label for="body">body</label>
            <input type="text" name="body" id="body" class="form-control"value="{{ $review->name }} "
                required>
        </div>


        <button type="submit" class="btn btn-primary">Update Review</button>

    </form>
