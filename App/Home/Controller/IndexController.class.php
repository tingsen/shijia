<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
//use Think\Controller;
class IndexController extends BaseController {
	
	function _initialize(){
		parent::_initialize();
		$this->assign('css_header_index', true);
    }

	function index(){

		//首页寄语slide
		$jiyu = load_column('index_jiyu', 3);
		//新闻大图轮换
		$index_news_slide = load_column('index_news_slide', 3);
		//个人奖轮换
		$index_person_prize_slide = load_column('index_person_prize_slide', 1);
		//单位奖轮换
		$index_company_prize_slide = load_column('index_company_prize_slide', 1);
		//视频
		$prize_video = load_block('index_prize_video', true);
		if($prize_video) {
			$prize_video_arr = explode('@@', $prize_video);
		}else{
			$prize_video_arr = array();
		}
		$posts = D('Post')->field('content', true)->where(array('state'=>1, 'publish'=>1, 'stick'=>1, 'deleted'=>0))->relation(array('cover','category'))->order('sort desc,id desc')->limit(6)->select();
		$this->assign('page_title', '首页');
		$this->assign('posts', $posts);
		$this->assign('jiyu_slide', $jiyu);
		$this->assign('index_news_slide', $index_news_slide);
		$this->assign('person_prize_slide', $index_person_prize_slide);
		$this->assign('company_prize_slide', $index_company_prize_slide);
		$this->assign('prize_video', $prize_video_arr);
		$this->display();
	}

	//视频
	function prize_video() {
		$mark = I('get.mark');
		$prize_video = load_block($mark, true);
		if($prize_video) {
			$prize_video_arr = explode('@@', $prize_video);
		}else{
			if(empty($prize_video)) $this->error('内容不存在!');
		}
		$this->assign('prize_video', $prize_video_arr);
		$this->display();
	}
}
