@foreach($items as $item)
<!-- Child comment 2-->
<div class="d-flex mt-4">
    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
    <div class="ms-3 flex-grow-1">
        <div class="fw-bold">Commenter Name</div>
        <div class="mb-2">
            {{$item['content']}}
        </div>

        <x-flex class="gap-3">
            <span wire:click="delete({{$item['id']}})">삭제({{$item['id']}})</span>
            <span wire:click="edit({{$item['id']}})">수정({{$item['id']}})</span>
            <span wire:click="reply({{$item['id']}}, {{$item['level']}})">댓글달기</span>
        </x-flex>

        @if($item['id'] == $reply_id)
                    <div class="mt-2">
                        <textarea class="form-control" rows="3"
                            placeholder="Join the discussion and leave a comment!"
                            wire:model.defer="forms.content">
                        </textarea>
                        <x-flex-between class="mt-2">
                            <div></div>
                            <div>
                                @if($editmode == "edit")
                                <button class="btn btn-secondary" wire:click="cencel()">취소</button>
                                <button class="btn btn-info" wire:click="update()">수정</button>
                                @else
                                <button class="btn btn-primary" wire:click="store()">작성</button>
                                @endif
                            </div>
                        </x-flex-between>
        </div>
        @endif

        {{-- 재귀호출 --}}
        @if(isset($item['items']))
            @include('jiny-posts::comments.comment_item',['items' => $item['items']])
        @endif


    </div>
</div>
@endforeach
