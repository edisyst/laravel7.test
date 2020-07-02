
<div class="form-group">

    <label for="categories">Categories</label> {{-- name="categories[]" PER PASSARGLIENE + DI UNA --}}
    <select multiple size="4" name="categories[]" id="categories" class="form-control">

        @foreach($categories as $category)
            <option {{(isset($selectedCategories) && in_array($category->id, $selectedCategories))? 'selected':''}}
                    value="{{$category->id}}">{{$category->category_name}}
            </option>
        @endforeach
    </select>

</div>