<?php
namespace Jiny\Posts\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class SitePostView extends Component
{
    use WithFileUploads;
    use \Jiny\WireTable\Http\Trait\Hook;
    use \Jiny\WireTable\Http\Trait\Permit;
    use \Jiny\WireTable\Http\Trait\Tabbar;
    use \Jiny\WireTable\Http\Trait\Upload;

    public $actions = [];
    public $message;
    public $_id;
    public $row = [];

    public $post_keywords = [];


    public function mount()
    {
        $this->actions['id'] = $this->_id;
        $this->actions['table'] = "posts";
        $this->actions['view']['form'] = "jiny-posts::blog.form";
    }

    public function render()
    {
        // 포스트 정보 읽기
        $row = DB::table("posts")->where('id', $this->_id)->first();
        if($row) {
            $this->row = get_object_vars($row); // 객체를 배열로 변환

            if($this->row['keyword']) {
                $this->post_keywords = explode(",", $this->row['keyword']);
            }

            // 컨덴츠 decoder
            $this->row['content'] = stripslashes($this->row['content']);
            $this->row['content'] = nl2br($this->row['content']);

            // 기본값
            $viewFile = 'jiny-posts::blog.wire_view';
            return view($viewFile);
        }

        return view("jiny-posts::blog.unknown");
    }

    protected $listeners = ['refeshTable'];
    public function refeshTable()
    {
        // 페이지를 재갱신 합니다.
    }

    public $forms = [];
    public $forms_old=[];
    public $popupForm;
    public function close()
    {
        $this->popupForm = false;
    }

    public function cancel()
    {
        $this->popupForm = false;
        $this->forms = [];
    }

    public function edit($id=null)
    {
        // 수정 id 체크
        if(!$id) {
            if(isset($this->actions['id'])) {
                $id = $this->actions['id'];
            }
        }

        if($id) {
            // 팝업창 활성화
            $this->popupForm = true;



            //$id = $this->actions['id'];
            $row = DB::Table("posts")->where('id',$id)->first();
            foreach($row as $key => $value) {
                $this->forms[$key] = $value;
                $this->forms_old[$key] = $value;
            }

            $this->forms['content'] = stripslashes($this->forms['content']);
            //addslashes();
        }

    }

    public function update()
    {
        if(isset($this->actions['id'])) {

            // 팝업창 비활성화
            $this->popupForm = false;

            //dump($this->forms);
            // 3. 파일 업로드 체크 Trait
            $this->fileUpload();

            //dd($this->forms);

            $id = $this->actions['id'];
            $form = $this->forms;
            $form['content'] = addslashes($form['content']);
            DB::Table("posts")->where('id',$id)->update($form);

            $this->forms = [];

            // Livewire Table을 갱신을 호출합니다.
            // $this->emit('refeshTable');
            $this->dispatch('refeshTable');
        }
    }

    /** ----- ----- ----- ----- -----
     *  데이터 삭제
     *  삭제는 2단계로 동작합니다. 삭제 버튼을 클릭하면, 실제 동작 버튼이 활성화 됩니다.
     */
    public $popupDelete = false;
    public $confirm = false;
    public function delete($id=null)
    {
        $this->popupDelete = true;
    }

    public function deleteCancel()
    {
        $this->popupDelete = false;
    }

    public function deleteConfirm()
    {
        $this->popupDelete = false;

        $row = DB::table($this->actions['table'])->find($this->actions['id']);
            //dd($row);
            $form = [];
            foreach($row as $key => $value) {
                $form[$key] = $value;
            }

            // 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookDeleting")) {
                $row = $controller->hookDeleting($this, $form);
            }

            // uploadfile 필드 조회
            /*
            $fields = DB::table('uploadfile')->where('table', $this->actions['table'])->get();
            foreach($fields as $item) {
                $key = $item->field; // 업로드 필드명
                if (isset($row->$key)) {
                    Storage::delete($row->$key);
                }
            }
            */

            // 데이터 삭제
            DB::table($this->actions['table'])
                ->where('id', $this->actions['id'])
                ->delete();

            // 컨트롤러 메서드 호출
            if ($controller = $this->isHook("hookDeleted")) {
                $row = $controller->hookDeleted($this, $form);
            }

            // 입력데이터 초기화
            $this->cancel();

            // 팝업창 닫기
            $this->popupForm = false;
            $this->popupDelete = false;

            // Livewire Table을 갱신을 호출합니다.
            // $this->emit('refeshTable');
            $this->dispatch('refeshTable');

    }


    public function request($key=null)
    {
        if($key) {
            if(isset($this->actions['request'][$key])) {
                return $this->actions['request'][$key];
            }
        }

        return $this->actions['request'];
    }


    /**
     * 컨트롤러에서 선안한 메소드를 호출
     */
    public function hook($method, ...$args) { $this->call($method, $args); }
    public function call($method, ...$args)
    {
        if(isset($this->actions['controller'])) {
            $controller = $this->actions['controller']::getInstance($this);
            if(method_exists($controller, $method)) {
                return $controller->$method($this, $args[0]);
            }
        }
    }






}
