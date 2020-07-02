
<div class="form-group">
    <label for="thumbnail">Thumbnail</label>
    <input type="file" name="album_thumb" id="album_thumb"
           class="form-control" value="{{$album->album_thumb}}">
</div>

@if($album->album_thumb)
    <div class="form-group">
        <img width="250" src="{{asset($album->path)}}" alt="{{$album->album_name}}">
    </div>
@endif