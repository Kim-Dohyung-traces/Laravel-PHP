<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticlesController extends Controller
{

    public function __construct()
    {
        //로그인 하지 않아도 index(게시판 홈), show(게시판 뷰)는 볼 수 있음
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    //메인 게시판
    public function index($slug = null)
    {
        //현재 실행중인 METHOD가 무엇인지.
        // return __METHOD__ . '조회 기능';

        //(1)
        // $articles = \App\Article::get();    #Article모델정보를 다 가져옴

        //(2)
        //Article모델의 user함수를 얻음  = with로 eager 로딩
        // $articles = \App\Article::with('user')->get(); //=> with후 get

        //(3)
        //Article모델의 user함수를 얻음 = load로 razy 로딩
        // $articles = \App\Article::get()->load('user');  //=> get후 load

        // //(4)                  latest()는 날짜를 기준으로 정렬 (페이지당 20개)
        // $articles = \App\Article::with('user')->latest()->paginate(20);

        //$slug는 태그로 검색할 경우에만 존재함
        $query = $slug ? \App\Tag::whereSlug($slug)->firstOrFail()->articles() : new \App\Article;
        $articles = $query->latest()->paginate(10);


        //render은 view가 만든 html코드가 쫙 나옴 p.142
        //dd(view('articles.index', compact('articles'))->render());
        //dd(\App\Article::with('user')->latest()->toSql());

        return view('articles.index', compact('articles'));
        //compact()는 배열을 만들어줌.
        //https://www.php.net 참조
    }

    //게시판 작성 요청
    public function create()        #게시판 생성시 보여주는 페이지
    {
        $article = new \App\Article;

        return view('articles.create', compact('article'));
    }


    //게시판 작성 완료
    //ArticlesRequest안에 제목, 내용에 대한 rule이 있음
    public function store(\App\Http\Requests\ArticlesRequest $request)
    {
        //작성을 요청한 유저의 게시판을 만듬(작성을 요청한 정보의 모든 속성을 $article에 대입)
        $article = $request->user()->articles()->create($request->all());

        //$article는 auth()->user()->articles()->create()를 호출함
        //==> 로그인한 유저의 게시판을 작성
        if (!$article) {
            return back()->wtih('flash_message', '글 작성 실패')->wtihInput();
        }

        //이벤트를 발생시킴 
        event(new \App\Events\ArticleCreated($article));

        $article->update($request->all());
        //입력한 태그를 요청하여 넣음?
        $article->tags()->sync($request->input('tags'));


        flash()->success('게시판을 생성하였습니다.');
        // var_dump('이벤트 발생완료');
        return redirect(route('articles.index'))
            ->with('flash_message', '글작성 성공!');
    }

    //게시판 뷰
    public function show(\App\Article $article)           //$id = URL에서 넘겨지는 리소스아이디
    {
        debug($article->toArray());

        $comments = $article->comments()->with('replies')->whereNull('parent_id')->latest()->get();

        return view('articles.show', compact('article','comments'));
    }

    //게시판 수정 요청
    public function edit(\App\Article $article)
    {
        $this->authorize('update', $article);
        // flash()->success('수정하신 내용을 저장했습니다.');

        return view('articles.edit', compact('article'));
    }


    //게시판 수정 완료
    public function update(\App\Http\Requests\ArticlesRequest $request, \App\Article $article)
    {
        $this->authorize('update', $article);
        $article->update($request->all());

        //store메서드에도 있음
        $article->tags()->sync($request->input('tags'));

        flash()->success('수정하신 내용을 저장했습니다.');

        return redirect(route('articles.show', $article->id));
    }

    //게시판 삭제, 완료
    public function destroy(\App\Article $article)
    {
        flash()->success('게시판 삭제를 완료했습니다.');
        $article->delete();
        return response()->json([], 204);
    }
}