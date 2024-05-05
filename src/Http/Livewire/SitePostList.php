<?php
namespace Jiny\Posts\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;

class SitePostList extends Component
{
    use \Jiny\WireTable\Http\Trait\DataFetch;

    use WithPagination;
    public $paging = 5;

    public $actions;

    public $rows = [];
    public $last_id;

    public function mount()
    {
        $this->actions['table'] = "posts";

        // 페이징 초기화
        if (isset($this->actions['paging'])) {
            $this->paging = $this->actions['paging'];
        }
    }

    public function render()
    {


        // 1. 데이터 테이블 체크
        if(isset($this->actions['table'])) {
            if($this->actions['table']) {
                $this->setTable($this->actions['table']);
            }
        } else {
            // 테이블명이 없는 경우
            return view("jiny-wire-table::errors.message",[
                'message' => "WireTable 테이블명이 지정되어 있지 않습니다."
            ]);
        }

        // 3. 데이터를 읽어 옵니다.
        $rows = $this->dataFetch($this->actions);
        $this->rows = [];
        foreach($rows as $item) {
            // 객체를 배열로 변환
            $this->rows []= get_object_vars($item);
        }



        $totalPages = $rows->lastPage();
        $currentPage = $rows->currentPage();
        $pageLinks = $rows->links();
        //dump($pageLinks);
        //dd($rows);

        //dd($this->rows);

        // 기본값
        $viewFile = 'jiny-posts::blog.list';
        return view($viewFile,[
            'pagination' => $pageLinks
        ]);
    }




}
