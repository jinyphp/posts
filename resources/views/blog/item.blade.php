<div class="card mb-4">

    @if(isset($item['image']) && $item['image'])
    <a href="#!">
        <img class="img-fluid rounded"
            src="/{{$item['image']}}" alt="{{$item['title']}}" />
    </a>
    @else
    <img src="https://dummyimage.com/850x350/dee2e6/6c757d.jpg" alt="..." />
    @endif


    <div class="card-body">
        <div class="small text-muted">{{$item['created_at']}}</div>
        <h2 class="card-title">{{$item['title']}}</h2>
        <p class="card-text">
            {{ truncateString( stripslashes($item['content']) ) }}
        </p>

        <a class="btn btn-primary" href="/blog/{{$item['id']}}">읽기 →</a>
    </div>
</div>
