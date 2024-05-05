<div>
    <div class="mb-3">
        <label class="form-label">제목</label>
        <input type="text" class="form-control"
            placeholder="블로그 제목"
            wire:model.defer="forms.title">
    </div>
    <div class="mb-3">
        <label class="form-label">키워드</label>
        <input type="text" class="form-control"
            placeholder="키워드 카테고리"
            wire:model.defer="forms.keyword">
    </div>
    <div class="mb-3">
        <label class="form-label">내용</label>
        <textarea class="form-control" placeholder="Textarea"
            rows="10"
            wire:model.defer="forms.content"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">대표이미지</label>
        <input class="form-control" type="file" wire:model.defer="forms.image">
        <x-form-text>
            @if(isset($forms['image']))
            {{$forms['image']}}
            @endif
        </x-form-text>
    </div>

    <div class="mb-3">
        <label class="form-label">작성자</label>
        <input type="text" class="form-control"
            placeholder="작성자"
            wire:model.defer="forms.name">
    </div>

    {{-- <div class="mb-3">
        <label class="form-check m-0">
            <input type="checkbox" class="form-check-input">
            <span class="form-check-label">Check me out</span>
        </label>
    </div>
    <button class="btn btn-primary" wire:click="store">등록</button> --}}
</div>
