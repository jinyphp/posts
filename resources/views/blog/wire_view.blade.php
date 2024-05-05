<article>
    <!-- Post header-->
    <header class="mb-4">
        <x-flex-between>
            <div>
                <!-- Post title-->
                <h1 class="fw-bolder mb-1">{{$row['title']}}</h1>
                <!-- Post meta content-->
                <div class="text-muted fst-italic mb-2">
                    {{-- January 1, 2023 --}}
                    {{$row['created_at']}}
                </div>
            </div>
            <div>
                @if (isset($actions['id']))
                <button class="btn btn-info" wire:click="edit">수정</button>
                @endif
            </div>
        </x-flex-between>


        <!-- Post categories-->
        @foreach($post_keywords as $item)
        <a class="badge bg-secondary text-decoration-none link-light"
            href="#!">
            {{$item}}
        </a>
        @endforeach
    </header>

    <!-- Preview image figure-->

    <figure class="mb-4">
        @if(isset($row['image']) && $row['image'])
        <img class="img-fluid rounded"
            src="/{{$row['image']}}" alt="{{$row['title']}}" />
        @else
        <img class="img-fluid rounded"
            src="https://dummyimage.com/900x400/ced4da/6c757d.jpg" alt="..." />
        @endif
    </figure>

    <!-- Post content-->
    <section class="mb-5">
        {!! $row['content'] !!}
    </section>




    <x-loading-indicator/>

    <!-- 팝업 데이터 수정창 -->
    @if ($popupForm)
    <x-wire-dialog-modal wire:model="popupForm" maxWidth="3xl">
        <x-slot name="title">
            @if (isset($actions['id']))
                {{ __('수정') }}
            @endif
        </x-slot>

        <x-slot name="content">
            @includeIf($actions['view']['form'])
        </x-slot>


        <x-slot name="footer">
            @if($message)
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @endif


            @if (isset($actions['id']))
            {{-- 수정폼--}}
            <div class="flex justify-between">
                <div> {{-- 2단계 삭제 --}}
                    @if($popupDelete)
                    <span class="text-red-600">정말로 삭제를 진행할까요?</span>
                    <button type="button" class="btn btn-danger btn-sm" wire:click="deleteConfirm">삭제</button>
                    @else
                    <button type="button" class="btn btn-danger" wire:click="delete">삭제</button>
                    @endif
                </div>
                <div> {{-- right --}}
                    <button type="button" class="btn btn-secondary"
                        wire:click="cancel">취소</button>
                    <button type="button" class="btn btn-info"
                        wire:click="update">수정</button>
                </div>
            </div>
            @endif
        </x-slot>
    </x-wire-dialog-modal>
    @endif

</article>
