
<div class="form-group">
    <label for="thumbnail">Thumbnail</label>
    <input type="file" name="img_path" id="img_path"
           class="form-control" value="{{$photo->img_path}}">
</div>

@if($photo->img_path)
    <div class="form-group">
        <img width="250" src="{{asset($photo->img_path)}}" alt="{{$photo->name}}">
    </div>
@endif