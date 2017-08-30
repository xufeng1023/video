<form action="/admin/posts/{{ $post->id }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit" class="btn btn-xs btn-danger">
        <span class="glyphicon glyphicon-trash"></span>
    </button>
</form>
