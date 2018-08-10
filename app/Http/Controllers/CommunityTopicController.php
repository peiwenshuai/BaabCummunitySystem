<?php

namespace App\Http\Controllers;

use App\Model\CommunitySection;
use App\Model\CommunityTopic;
use App\Model\CommunityZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CommunityTopicController extends Controller
{
    //
    public function adminListShowByCategory(){
        $zones = CommunityZone::with('communitySections')->get();
        return view('admin.community-topic.show-by-category',compact('zones'));
    }

    public function adminListShow(Request $request){
        $selectedSection = false;
        if ($request->input('section_id')){
            $topics=CommunityTopic::where('section_id',$request->input('section_id'))->with('user','communitySection')->orderBy('order','desc')->paginate(15);
            $section = CommunitySection::find($request->input('section_id'));
            $selectedSection=true;
        }else{
            $topics=CommunityTopic::orderBy('order','desc')->with('user','communitySection')->paginate(15);
        }
        return view('admin.community-topic.list',compact('topics','section','selectedSection'));
    }

    public function adminCreateShow(Request $request){
        $zones = CommunityZone::all();
        if($request->input('zone_id')&&$request->input('section_id')){
            $zone_id = $request->input('zone_id');
            $section_id = $request->input('section_id');
            $selectedSections = CommunityZone::where('id',$zone_id)->first()->communitySections;
        }
        return view('admin.community-topic.create',compact('zones','zone_id','section_id','selectedSections'));
    }

    public function store(){
        $status = \request('status');
        //发布验证 暂存不验证
//        if($status=='public') {
        //验证
        $this->validate(\request(), [
            'title' => 'required',
            'content' => 'required',
            'zone_id' => 'required|integer|exists:community_zones,id',
            'section_id' => 'required|integer|exists:community_sections,id',
        ]);
//        }
        //逻辑
        $title = \request('title');
        $zone_id = \request('zone_id');
        $section_id = \request('section_id');
        $content = \request('content');
        $order = \request('order');
        $user_id = Auth::id();
        $data = compact('title','zone_id','section_id','content','user_id','order','status');

        $res=CommunityTopic::create($data);

        //渲染
        if ($res) {
            CommunityZone::find($zone_id)->increment('topic_count');
            CommunitySection::find($section_id)->increment('topic_count');
            if ($status == 'public') {
                return \redirect()->back()->with('tips', ['话题' . $title . '创建成功',]);
            } else {
                return \redirect()->back()->with('tips', ['话题' . $title . '暂存成功',]);
            }
        }else{
            return \redirect()->back()->withErrors('创建/暂存失败,服务器内部错误,请联系管理员');
        }
    }

    public function adminEditShow(CommunityTopic $topic){
        $zones = CommunityZone::all();
        $selectedSections = CommunityZone::where('id',$topic->zone_id)->first()->communitySections;

        return view('admin.community-topic.edit',compact('topic','zones','selectedSections'));
    }

    public function update(CommunityTopic $topic){
        //获取旧分类id
        $old_zone_id = $topic->zone_id;
        $old_section_id = $topic->section_id;

        $status = \request('status');
        //发布验证 暂存不验证
//        if($status=='public') {
        //验证
        $this->validate(\request(), [
            'title' => 'required',
            'content' => 'required',
            'zone_id' => 'required|integer|exists:community_zones,id',
            'section_id' => 'required|integer|exists:community_sections,id',
        ]);
//        }
        //逻辑
        $title = \request('title');
        $zone_id = \request('zone_id');
        $section_id = \request('section_id');
        $content = \request('content');
        $order = \request('order');
        $user_id = Auth::id();
        $data = compact('title','zone_id','section_id','content','user_id','order','status');

        $res=$topic->update($data);

        //渲染
        if ($res) {
            //旧分类计数器更新
            CommunityZone::find($old_zone_id)->update(['topic_count'=>CommunityTopic::where('zone_id',$old_zone_id)->count()]);
            CommunitySection::find($old_section_id)->update(['topic_count'=>CommunityTopic::where('section_id',$old_section_id)->count()]);
            //新分类计数器更新
            CommunityZone::find($zone_id)->update(['topic_count'=>CommunityTopic::where('zone_id',$zone_id)->count()]);
            CommunitySection::find($section_id)->update(['topic_count'=>CommunityTopic::where('section_id',$section_id)->count()]);
            if ($status == 'public') {
                return \redirect()->back()->with('tips', ['话题' . $title . '编辑成功',]);
            } else {
                return \redirect()->back()->with('tips', ['话题' . $title . '暂存成功',]);
            }
        }else{
            return \redirect()->back()->withErrors('编辑/暂存失败,服务器内部错误,请联系管理员');
        }
    }

    /* 删除行为
     * @param Request $companyId
     * @return int 1 success 0 failed
     */
    public function softDelete(Request $request){
        $topic = CommunityTopic::where('id',$request->id)->first();
        $topic->delete();
        if($topic->trashed()){
            $topic->communityZone()->decrement('topic_count');
            $topic->communitySection()->decrement('topic_count');
            $status = 1;
            $msg = "The topic has been deleted";
        }else{
            $status = 0;
            $msg = "Server internal error";
        }
        return json_encode(compact('status','msg'));//ajax

    }


    public function softDeletes(Request $request){
        $failedCount=0;
        for($i=0;$i<count($request->ids);$i++){
            $topic = CommunityTopic::where('id',$request->ids[$i])->first();
            $topic->delete();
            if(!$topic->trashed()){
                $failedCount++;
            }else{
                $topic->communityZone()->decrement('topic_count');
                $topic->communitySection()->decrement('topic_count');
            }
        }
        if($failedCount==0){
            $status = 1;
            $msg = "The selected topic has been deleted";
        }else{
            $status = 0;
            $msg = $failedCount."Server internal error";
        }
        return json_encode(compact('status','msg'));//ajax
    }

    public function turnUpOrder(CommunityTopic $topic){
        $topic->increment('order');
        return \redirect()->back()->with('tips', ['优先级已自增1']);
    }
    public function turnDownOrder(CommunityTopic $topic){
        $topic->decrement('order');
        return \redirect()->back()->with('tips', ['优先级已自减1']);
    }


    /**
     * uploadTopicImg
     * @param Request $request
     * @return string
     */
    public function uploadImg(Request $request)
    {
        $user = Auth::user();
        $data = [];
        $failCount=0;
        if ($request->isMethod('post')) {
            $file = $request->file('img');
            $len=0;
            foreach ($file as $key => $value) {
                $len = $key;
            }
            for ($i = 0; $i <= $len; $i++) {
                // 文件是否上传成功
                if ($file[$i]->isValid()) {
                    $this->validate($request,[
                        'img.*'=>'required|image'
                    ]);
                    // 获取文件相关信息
                    $originalName = $file[$i]->getClientOriginalName(); // 文件原名
                    $ext = $file[$i]->getClientOriginalExtension();     // 扩展名
                    $realPath = $file[$i]->getRealPath();   //临时文件的绝对路径
                    $type = $file[$i]->getClientMimeType();     // image/jpeg

                    // 上传文件
                    $filename = $user->id . '-' . date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
//                // 如果宽大于900 裁剪图片
                    $img=Image::make($realPath);
                    if ($img->width()>900){
                        $img->resize(900, null, function($constraint){		// 调整图像的宽到900，并约束宽高比(高自动)
                            $constraint->aspectRatio();
                        })->save();
                    }

                    // 使用我们新建的uploads本地存储空间（目录）
                    // 这里的userCover是配置文件的名称
                    $bool = Storage::disk('communityTopicImg')->put($filename, file_get_contents($realPath));
                    $img_url = "/uploads/community/topic/img/" . $filename;
                    if ($bool) {
                        array_push($data,$img_url);
                    }else{
                        $failCount++;
                    }
                }
            }
            if ($failCount==0){
                return json_encode(["errno" => 0, "data" => $data]);//ajax
            }
        }
    }

}