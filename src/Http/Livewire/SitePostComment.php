<?php
namespace Jiny\Posts\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SitePostComment extends Component
{
    public $actions = [];

    public $post_id;
    public $rows = [];
    //public $rowdata = [];
    public $last_id;

    public $forms=[];
    public $post_comment = false;

    public function mount()
    {
        $this->reply_id = 0;

        $post_id = $this->post_id;
        $post = DB::table("posts")
            ->where('id',$post_id)
            ->first();
        if($post) {
            $this->post_comment = true;
        }
    }

    public function render()
    {
        if($this->post_comment) {
            $post_id = $this->post_id;

            $this->forms['post_id'] = $post_id;

            $rows = DB::table("post_comments")
                ->where('post_id',$post_id)
                ->orderBy('level',"desc")
                ->get();
            $this->rows = [];
            //$this->rowdata = [];
            foreach($rows as $item) {
                $id = $item->id;
                // 객체를 배열로 변환
                $this->rows[$id] = get_object_vars($item);
                //$this->rowdata[$id] = get_object_vars($item);
            }

            $this->tree();
            //dd($this->rows);

            // 기본값
            $viewFile = 'jiny-posts::comments.comment';
            return view($viewFile);
        }

        return view("jiny-posts::blog.blank");

    }


    private function tree()
    {
        foreach($this->rows as &$item) {
            $id = $item['id'];
            if($item['ref']) {
                $ref = $item['ref'];
                if(!isset($this->rows[$ref]['items'])) {
                    $this->rows[$ref]['items'] = [];
                }
                $this->rows[$ref]['items'] []= $item;

                unset($this->rows[$id]);
            }
        }
    }

    public function store()
    {
        if($this->reply_id) {
            $this->forms['ref'] = $this->reply_id;

            $id = $this->reply_id;
            //$level = $this->rowdata[$id]['level'];
            $this->forms['level'] = $this->level + 1;
        } else {
            $this->forms['ref'] = 0;
            $this->forms['level'] = 1;
        }


        // 2. 시간정보 생성
        $this->forms['created_at'] = date("Y-m-d H:i:s");
        $this->forms['updated_at'] = date("Y-m-d H:i:s");

        $form = $this->forms;

        $id = DB::table("post_comments")->insertGetId($form);
        $form['id'] = $id;
        $this->last_id = $id;

        $this->forms = []; // 초기화
        $this->reply_id = null;
        $this->level = null;
    }

    public $reply_id;
    public $level;
    public function reply($id, $level)
    {
        $this->reply_id = $id;
        $this->level = $level;
    }

    public function delete($id)
    {

        $node = $this->findNode($this->rows, $id);

        $this->deleteNode($node);
        //dd("done");
    }

    private function findNode($items, $id)
    {
        foreach($items as $item) {

            if($item['id'] == $id) {
                return $item;
            }

            // 서브트리가 있는 경우, 재귀탐색
            if(isset($item['items'])) {
                $result = $this->findNode($item['items'], $id);
                if($result) { //탐색한 결과가 있으면
                    // 탐색결과를 확인
                    if($result['id'] == $id) return $result;
                }
            }

        }

        return false;
    }

    private function deleteNode($items)
    {
        if(isset($items['items'])) {

            foreach($items['items'] as $i => $leaf) {
                if(isset($leaf['items'])) {
                    $this->deleteNode($leaf['items']);
                }
                //dump("leaf");
                //dump(__LINE__);
                //($leaf);
                $id = $leaf['id'];
                $this->dbDeleteRow($id);
            }
        }

        //dump("node");
        //dump(__LINE__);
        if(isset($items['id'])) {
            $id = $items['id'];
            //dump($items);
            $this->dbDeleteRow($id);
        } else {
            if(isset($items[0]['id'])) {
                $id = $items[0]['id'];
                //dump($items[0]);
                $this->dbDeleteRow($id);
            }
        }

        //
        //$this->dbDeleteRow($id);
    }

    private function dbDeleteRow($id)
    {
        //dump("삭제=".$id);

        DB::table("post_comments")
            ->where('id',$id)
            ->delete();

    }

    public $editmode=null;
    public function edit($id)
    {
        $this->editmode = "edit";
        $this->reply_id = $id;

        //dump($this->rows);
        $node = $this->findNode($this->rows, $id);
        //dd($node);
        $this->forms['content'] = $node['content'];
    }

    public function update()
    {
        DB::table("post_comments")
            ->where('id',$this->reply_id)
            ->update($this->forms);

        $this->forms = [];
        $this->editmode = null;
        $this->reply_id = null;
    }

    public function cencel()
    {
        $this->forms = [];
        $this->editmode = null;
        $this->reply_id = null;
    }






}
