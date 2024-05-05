<div class="mb-4">
    <!-- 첫번째 메인 Post -->
    @if(isset($rows[0]))
    <!-- Featured blog post-->
        @include("jiny-posts::blog.item",['item'=>$rows[0]])
    @endif

    <div class="row">
        @foreach ($rows as $item)
            @if ($loop->first)
                @continue
            @endif

            <div class="col-lg-6">
                <!-- Blog post-->
                @include("jiny-posts::blog.item",['item'=>$item])


                {{-- <div class="card mb-4">
                    <a href="#!">
                        <img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..." /></a>
                    <div class="card-body">
                        <div class="small text-muted">January 1, 2023</div>
                        <h2 class="card-title h4">{{$item['title']}}</h2>
                        <p class="card-text">
                            {{ truncateString("Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Reiciendis aliquid atque, nulla.") }}

                        </p>
                        <a class="btn btn-primary" href="/blog/{{$item['id']}}">Read more →</a>
                    </div>
                </div> --}}
            </div>
        @endforeach
    </div>

    <!-- pagenation -->
    {!! $pagination !!}

</div>

