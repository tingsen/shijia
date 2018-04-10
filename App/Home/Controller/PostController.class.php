<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
//use Think\Controller;
class PostController extends BaseController {

	function _initialize(){
		parent::_initialize();
		$this->assign('css_header_post', true);
    }

	//新闻首页
	public function index() {
		$count = D('Post')->where(array('deleted'=>0, 'state'=>1, 'publish'=>1, 'kind'=>1))->count();
		$page = new \Think\Page($count, 5);
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$posts = D('Post')->where(array('deleted'=>0, 'state'=>1, 'publish'=>1, 'kind'=>1))->relation(array('category', 'cover'))->field('content', true)->order('sort desc, id desc')->limit($limit)->select();
		$this->assign('page_title', '新闻');
		$this->assign('posts', $posts);
		$this->assign('page', $page->show());
		$this->display();
	}

	//推广提升首页
	public function promotion() {
		$this->assign('css_header_post', false);
		$this->assign('css_header_promotion', true);
		$count = D('Post')->where(array('deleted'=>0, 'state'=>1, 'publish'=>1, 'kind'=>2))->count();
		$page = new \Think\Page($count, 5);
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$posts = D('Post')->where(array('deleted'=>0, 'state'=>1, 'publish'=>1, 'kind'=>2))->relation(array('category', 'cover'))->field('content', true)->order('sort desc, id desc')->limit($limit)->select();
		$this->assign('page_title', '推广提升');
		$this->assign('posts', $posts);
		$this->assign('page', $page->show());
		$this->display();
	}

	public function show() {
		$id = I('get.id', '', 'int');
		$post = D('Post')->find($id);
		if($post) {
			if($post['deleted']==1) $this->error('该内容已删除!');
			if($post['state']==0) $this->error('该内容已禁用!');
			if($post['publish']==0) $this->error('未发布!');
			$v = 'show';
			if($post['kind']==2) {
				$this->assign('css_header_post', false);
				$this->assign('css_header_promotion', true);
				$v = 'show_prom';
			}
		}else{
			$this->error('内容不存在!');
		}
		$this->assign('post', $post);
		$this->assign('page_title', $post['title']);
		$this->display($v);
	}

	//模糊搜索查询
	function search(){
		$keyword = I('post.title');
		$post=D('Post');
		$map['title']  = array('like','%'.$keyword.'%');
		$posts = $post->where(array('deleted'=>0, 'state'=>1, 'publish'=>1))->where($map)->count();
		$page = new \Think\Page($count, 10);
		$page->setConfig('theme',page_style());
		$limit = $page->firstRow . ',' . $page->listRows;
		$posts = D('Post')->where(array('deleted'=>0, 'state'=>1, 'publish'=>1))->where($map)->relation(array('category', 'cover'))->field('content', true)->order('id desc')->limit($limit)->select();
		$this->assign('page_title', '搜索');
		$this->assign('posts', $posts);
		$this->assign('page', $page->show());
		$this->display();
	}
}
