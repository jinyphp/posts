<?php
namespace Jiny\Posts\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class SitePostCreate extends Component
{
    use WithFileUploads;
    use \Jiny\WireTable\Http\Trait\Hook;
    use \Jiny\WireTable\Http\Trait\Permit;

    use \Jiny\WireTable\Http\Trait\Tabbar;

    use \Jiny\WireTable\Http\Trait\Upload;

    public $actions = [];
    public $message;

    public $forms = [];
    public $last_id;

    public function mount()
    {
        $this->actions['table'] = "posts";
        $this->actions['view']['form'] = "jiny-posts::blog.form";
    }

    public function render()
    {
        // 기본값
        $viewFile = 'jiny-posts::blog.create';
        return view($viewFile);
    }

    public function store()
    {
        //dd($this->form);

        // 2. 시간정보 생성
        $this->forms['created_at'] = date("Y-m-d H:i:s");
        $this->forms['updated_at'] = date("Y-m-d H:i:s");

        $form = $this->forms;

        $form['content'] = addslashes($form['content']);

        $id = DB::table("posts")->insertGetId($form);
        $form['id'] = $id;
        $this->last_id = $id;

        $this->forms = []; //초기화

        // 작성한 포스트 view로 이동합니다.
        $this->redirect('/blog/'.$id);

        // Livewire Table을 갱신을 호출합니다.
        //$this->emit('refeshTable');
        //$this->dispatch('refeshTable');
    }


    public $popupForm = false;
    public function close()
    {
        $this->popupForm = false;
    }

    public function cancel()
    {
        $this->popupForm = false;
        $this->forms = [];
    }

    public function create()
    {
        $this->popupForm = true;
    }



}
