<?php

namespace App\Http\Controllers;

use App\Model\CommunitySection;
use App\Model\CommunityZone;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CommunityCategoryController extends Controller
{

    /**
     * 显示后台分区列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showZonesAndSections(){
        $zones = CommunityZone::orderBy('order','desc')->with('communitySections')->get();
        return view('admin.community-category.zones-and-sections-list',compact('zones'));
    }

    /**
     * 显示后台分区创建页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminZoneCreateShow(){
        return view('admin.community-category.zone-create');
    }

    /**
     * 分区创建逻辑
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function adminZoneStore(){
        //验证权限
        $this->authorize('create',CommunityZone::class);

        $status = \request('status');
        //验证
        $this->validate(\request(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        //逻辑
        $name = \request('name');
        $description = \request('description');
        $img_url = \request('img_url');
        $order = \request('order');
        if ($img_url!=""){
            $data = compact('name','description','order','img_url','status');
        }else{
            $data = compact('name','description','order','status');
        }

        $res=CommunityZone::create($data);

        //渲染
        if ($res) {
            if ($status == 'publish') {
                return \redirect()->back()->with('tips', [__('controller.createSuccess',['name'=>$name]),]);
            } else {
                return \redirect()->back()->with('tips', [__('controller.saveSuccess',['name'=>$name]),]);
            }
        }else{
            return \redirect()->back()->withErrors(__('controller.failedServerError'));
        }

    }

    /**
     * 显示分区编辑页面
     * @param CommunityZone $zone
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminZoneEditShow(CommunityZone $zone){
        return view('admin.community-category.zone-edit',compact('zone'));
    }

    /**
     * 分区更新逻辑
     * @param CommunityZone $zone
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function adminZoneUpdate(CommunityZone $zone){
        //验证权限
        $this->authorize('update',$zone);

        $status = \request('status');
        //验证
        $this->validate(\request(), [
            'name' => 'required',
            'description' => 'required',
        ]);
        //逻辑
        $name = \request('name');
        $description = \request('description');
        $img_url = \request('img_url');
        $order = \request('order');
        $data = compact('name','description','order','img_url','status');

        $res=$zone->update($data);
        //渲染
        if ($res) {
            if ($status == 'publish') {
                return \redirect()->back()->with('tips', [__('controller.editSuccess',['name'=>$name]),]);
            } else {
                return \redirect()->back()->with('tips', [__('controller.saveSuccess',['name'=>$name]),]);
            }
        }else{
            return \redirect()->back()->withErrors(__('controller.failedServerError'));
        }

    }

    /* zone删除行为
     * @param Request $companyId
     * @return int 1 success 0 failed
     */
    public function zoneSoftDelete(Request $request){
        $zone = CommunityZone::where('id',$request->id)->first();

        //验证权限
        $this->authorize('delete',$zone);

        $zone->delete();
        if($zone->trashed()){
            $zone->communityTopics()->delete();
            $status = 1;
            $msg = __('controller.deleteSuccess');
        }else{
            $status = 0;
            $msg = __('controller.failedServerError');
        }
        return json_encode(compact('status','msg'));//ajax

    }

    /**
     * 后台社区版块创建
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminSectionCreateShow(Request $request){
        $zones = CommunityZone::orderBy('order','desc')->get();
        $selectedZone=$request->input('zone_id');
        return view('admin.community-category.section-create',compact('zones','selectedZone'));
    }

    /**
     * 版块创建逻辑
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function adminSectionStore(){
        $this->authorize('create',CommunitySection::class);

        $status = \request('status');
        //验证
        $this->validate(\request(), [
            'name' => 'required',
            'description' => 'required',
            'zone_id' => 'required|integer',
        ]);
        //逻辑
        $name = \request('name');
        $description = \request('description');
        $zone_id = \request('zone_id');
        $img_url = \request('img_url');
        $order = \request('order');
        if ($img_url!=""){
            $data = compact('name','description','zone_id','order','img_url','status');
        }else{
            $data = compact('name','description','zone_id','order','status');
        }

        $res=CommunitySection::create($data);

        //渲染
        if ($res) {
            if ($status == 'publish') {
                $section_count = $res->communityZone->communitySections()->where('status','publish')->count();
                $res->communityZone->update(compact('section_count'));

                return \redirect()->back()->with('tips', [__('controller.createSuccess',['name'=>$name]),]);
            } else {
                return \redirect()->back()->with('tips', [__('controller.saveSuccess',['name'=>$name]),]);
            }
        }else{
            return \redirect()->back()->withErrors(__('controller.failedServerError'));
        }

    }

    /**
     * 显示后台版块编辑页
     * @param CommunitySection $section
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminSectionEditShow(CommunitySection $section){
        $zones = CommunityZone::orderBy('order','desc')->get();
        return view('admin.community-category.section-edit',compact('section','zones')
        );
    }

    /**
     * 版块编辑逻辑
     * @param CommunitySection $section
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function adminSectionUpdate(CommunitySection $section){
        $this->authorize('update',$section);

        $status = \request('status');
        //验证
        $this->validate(\request(), [
            'name' => 'required',
            'description' => 'required',
            'zone_id' => 'required|integer',
        ]);
        //逻辑
        $name = \request('name');
        $description = \request('description');
        $zone_id = \request('zone_id');
        $img_url = \request('img_url');
        $order = \request('order');
        $data = compact('name','description','zone_id','order','img_url','status');

        $res=$section->update($data);
        //渲染
        if ($res) {
            if ($status == 'publish') {
                $section_count = $section->communityZone->communitySections()->where('status','publish')->count();
                $section->communityZone->update(compact('section_count'));

                return \redirect()->back()->with('tips', [__('controller.editSuccess',['name'=>$name]),]);
            } else {
                return \redirect()->back()->with('tips', [__('controller.saveSuccess',['name'=>$name]),]);
            }
        }else{
            return \redirect()->back()->withErrors(__('controller.failedServerError'));
        }

    }

    /* section删除行为
     * @param Request $companyId
     * @return int 1 success 0 failed
     */
    public function sectionSoftDelete(Request $request){
        $section = CommunitySection::where('id',$request->id)->first();

        //验证权限
        $this->authorize('delete',$section);

        $section->delete();
        if($section->trashed()){
            $section->communityTopics()->delete();
            $status = 1;
            $msg = __('controller.deleteSuccess');
        }else{
            $status = 0;
            $msg = __('controller.failedServerError');
        }
        return json_encode(compact('status','msg'));//ajax

    }

    /**
     * ajax获得分区下的版块
     * @param Request $request
     * @return string
     */
    public function getSectionsByZoneId(Request $request){
        $this->validate($request,[
            'id'=>'required|integer|exists:community_zones'
        ]);
        $sections = CommunityZone::where('id',$request->id)->first()->communitySections()->orderBy('order','desc')->get();
        return json_encode(compact('sections'));
    }


    /**
     * 处理上传的分区封面
     * @param Request $request
     * @return string
     */
    public function uploadZoneImg(Request $request)
    {
        $this->authorize('uploadCover',CommunityZone::class);

        $user = Auth::user();
        if ($request->isMethod('post')) {
            $this->validate($request,[
                'img_data'=>'required'
            ]);

            $image=$request->img_data;

            $realPath = decodeBase64ImgToFile($image);
            // 获取文件相关信息
            $ext = 'jpeg'; // 扩展名

            // 上传文件
            $filename = $user->id . '-' . date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 如果宽大于1280 裁剪图片
            $img=Image::make($realPath);
            $img->fit(200)->save();
//                if ($img->width()>1280){
//                    $img->resize(1280, null, function($constraint){		// 调整图像的宽到1280，并约束宽高比(高自动)
//                        $constraint->aspectRatio();
//                    })->save();
//                }
            // 使用我们新建的uploads本地存储空间（目录）
            // 这里的userCover是配置文件的名称
            $bool = Storage::disk('communityCategoryImg')->put($filename, file_get_contents($realPath));
            $cover_url = "/uploads/community/category/img/" . $filename;
            if ($bool) {
                return json_encode(["status" => 1, "src" => $cover_url]);//ajax
            }

        }
    }

}
