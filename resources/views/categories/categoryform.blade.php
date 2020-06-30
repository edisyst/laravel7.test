
<div class="row">

    <div class="col-md-10">
        <form id="manageCategoryForm" action="{{empty($category->category_name)?route('categories.store'):route('categories.update', $category)}}"
              method="POST" class="form-inline">
            @csrf
            {{isset($category->category_name)?method_field('PATCH'):''}}
            <div class="form-group">
                <input type="text" name="category_name" id="category_name" class="form-control"
                       value="{{empty($category->category_name)?'':$category->category_name}}">
            </div>
            <button class="btn btn-primary" title="SAVE/UPDATE"><i class="fas fa-save"></i></button>
        </form>
    </div>

    @if(isset($category->category_name))
        <div class="col-md-2">
            <form method="post" action="{{route('categories.destroy', $category->id)}}" class="form-inline">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" title="DELETE"><i class="fas fa-trash-alt"></i></button>
            </form>
        </div>
    @endif

</div>