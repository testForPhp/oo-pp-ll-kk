<?php
namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\FeeLog;
use App\Models\Link;
use App\Models\Sort;
use App\Transformers\LinkTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LinksController extends Controller
{
    public function index()
    {
        $linkMenu = 'active';
        $sort = Sort::orderBy('type','desc')->orderBy('sorting','asc')->get(['title','code','id','type']);
        $links = Link::where('user_id',Auth::id())->orderBy('id','desc')->paginate(10);
        $fee = Cache::get('fee');
        $color = Color::orderBy('id','desc')->get();
        return view('member.link',compact(['linkMenu','sort','links','fee','color']));
    }

    public function renewColor(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $link = Link::find($request->get('id'));
        if(is_null($link)){
            return $this->returnResponse(['message'=>'网站不存在'],404);
        }

        $user = Auth::user();

        if(Cache::get('fee')->color > $user->point){
            return $this->returnResponse(['code'=>2,'message'=>'余额不足，请前往充值！']);
        }

        $user->point = $user->point - Cache::get('fee')->color;

        if(!$user->save()){
            return $this->returnResponse(['message'=>'提交失败，请稍后重试！'],500);
        }

        list($status,$end_time,$old_link_id) = $this->endTime($user->id,$link->id);

        $feeLogModel = new FeeLog();

        $feelog = $feeLogModel->create([
            'type' => 'color',
            'link_id' => $link->id,
            'user_id' => $user->id,
            'summary' => '续费，叠加上次剩余时间！',
            'end_date' => $end_time
        ]);

        if($feelog){
            $feeLogModel->where('id',$old_link_id)->update(['status'=>1]);
            return $this->returnResponse(['message'=>'续费成功']);
        }

        $user->point = $user->point + Cache::get('fee')->color;
        $user->save();
        return $this->returnResponse(['message'=>'提交失败，请稍后重试！'],500);

    }
    
    public function color(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'code' => 'required',
        ],[
            'id.required' => 'ID不能为空',
            'code.required' => '请选择颜色'
        ]);

        $user = Auth::user();
        $link = Link::where('user_id',$user->id)
            ->where('id',$request->get('id'))
            ->first();

        if(is_null($link)){
            return $this->returnResponse(['message'=>'网站不存在'],404);
        }

        $color = Color::where('code',$request->get('code'))->first();

        if(is_null($color)){
            return $this->returnResponse(['message'=>'颜色不存在！'],404);
        }

        $user = Auth::user();

        // 判断网站分类\类型\颜色，如果存在其一，则不需要扣费，否则扣除用户费用
        $feeCache = Cache::get('fee');

        $pay = 0;

        if($link->sort_id != $feeCache->recommend_id && $link->type != 1 && $link->color == ''){

            if($feeCache->color > $user->point){
                return $this->returnResponse(['message'=>'余额不足，请前往充值','code'=>2]);
            }

            $user->point = $user->point - $feeCache->color;

            if(!$user->save()){
                return $this->returnResponse(['message'=>'提交失败！'],400);
            }

            list($status,$end_time,$old_link_id) = $this->endTime($user->id,$link->id);

           $feelog =  FeeLog::create([
                'type' => 'color',
                'link_id' => $link->id,
                'user_id' => $user->id,
                'end_date' => $end_time
            ]);

           if(! $feelog){
               $user->point = $user->point + $feeCache->color;
               $user->save();
               return $this->returnResponse(['message'=>'提交失败，请稍后重试！'],500);
           }
            $pay = 1;
        }

        $link->color = $color->color;
        $link->status = 1;
        $result = $link->save();
        if($result){
            return $this->returnResponse(['message'=>'修改颜色成功！']);
        }

        if($pay == 1){
            $feelog->delete();
            $user->point = $user->point + $feeCache->color;
            $user->save();
        }

        return $this->returnResponse(['message'=>'提交失败，请稍后再试！'],500);

    }
    
    public function rank(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ],[
            'id.required'=>'ID不能为空'
        ]);
        $user = Auth::user();
        $model = new Link();
        $link = $model->where('user_id',$user->id)
            ->where('id',$request->get('id'))
            ->first();

        if(is_null($link)){
            return $this->returnResponse(['message'=>'网站不存在'],404);
        }

        if($link->type != 1 && $this->checkRank($link->sort_id) == true){
            return $this->returnResponse(['message'=>'分类排名已满！'],400);
        }

        if(Cache::get('fee')->rank > $user->point){
            return $this->returnResponse(['message'=>'余额不足，请前往充值！','code'=>2]);
        }

        $user->point = $user->point - Cache::get('fee')->rank;
        if(!$user->save()){
            return $this->returnResponse(['message'=>'提交失败，请刷新重试！'],400);
        }
        //计算停止时间
        list($status,$end_time,$old_link_id) = $this->endTime($user->id,$link->id);

        $summary = '';

        if($status == 1){
            $summary = '续费，叠加上次剩余时间！';
        }
        //增加记录
        $feeLogModel = new FeeLog();

        $feelog = $feeLogModel->create([
            'type'=>'rank',
            'user_id' => $user->id,
            'link_id' => $link->id,
            'end_date' => $end_time,
            'summary' => $summary
        ]);

        if(!$feelog){
            $user->point = $user->point + Cache::get('fee')->rank;
            $user->save();
            return $this->returnResponse(['message'=>'提交失败，请刷新后重试！'],500);
        }
        if($status == 1){
            $feeLogModel->where('id',$old_link_id)->update(['status'=>1]);
        }
        //修改链接属性
        $link->type = 1;
        $link->status = 1;
        if($link->save()){
            return $this->returnResponse(['message'=>'申请成功！','code'=>000]);
        }

        $feelog->delete();
        if($status == 1){
            $feeLogModel->where('id',$old_link_id)->update(['status'=>0]);
        }

        $user->point = $user->point + Cache::get('fee')->rank;
        $user->save();

        return $this->returnResponse(['申请失败，请稍后重试！'],500);

    }

    public function recommend(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ],[
            'id.required' => '请选择链接'
        ]);

        $linkModel = new Link();
        $link = $linkModel::find($request->get('id'));

        if(is_null($link)){
            return $this->returnResponse(['message'=>'链接不存在'],404);
        }

        $point = Cache::get('fee')->recommend;
        $sort_id = Cache::get('fee')->recommend_id;
        if(empty($sort_id)){
            return $this->returnResponse(['message'=>'系统没有开启精品推荐功能'],400);
        }

        if($link->sort_id != $sort_id && $this->checkRecommend() == true){
            return $this->returnResponse(['message'=>'精品推荐位置已满！'],400);
        }

        $user = Auth::user();

        if($point > $user->point){
            return $this->returnResponse(['code'=>2,'message'=>'余额不足，请前往充值！']);
        }

        $user->point = $user->point - $point;
        if(!$user->save()){
            return $this->returnResponse(['message'=>'操作失败，请刷新重试！'],500);
        }
        //增加记录,查询本网站之前是否有没到期的精品推荐，如果有则添加到期时间，并关闭之前的的记录。
        list($status,$end_time,$old_link_id) = $this->endTime($user->id,$link->id);

        $summary = '';
        $check_link_id = $link->sort_id;
        $feelogModel = new FeeLog();

        if($status == 1){
            $summary = '续费，叠加上次剩余时间！';
            $check_link_id = ($feelogModel::find($old_link_id))->sort_id;
        }

        $feelog = $feelogModel::create([
            'type' => 'recommend',
            'user_id' => $user->id,
            'link_id' => $link->id,
            'sort_id' => $check_link_id,
            'end_date' => $end_time,
            'summary' => $summary
        ]);

        if(!$feelog){
            $user->point = $user->point + $point;
            $user->save();
            return $this->returnResponse(['message'=>'提交失败，请刷新重试！'],500);
        }
        //修改链接
        if($old_link_id){
            $feelogModel::where('id',$old_link_id)->update(['status'=>1]);
        }

        $result = $linkModel::where('id',$link->id)->update(['sort_id'=>$sort_id,'status'=>1]);

        if($result){
            if($status){
                $msg = '续费成功！';
            }else{
                $msg = '申请成功！首页使用缓存，改动将在1小时内生效!';
            }
            return $this->returnResponse(['message'=>$msg,'code'=>000]);
        }

        if($old_link_id){
            $feelogModel::where('id',$old_link_id)->update(['status'=>0]);
        }

        $feelog->delete();
        $user->point = $user->point + $point;
        $user->save();
        return $this->returnResponse(['message'=>'提交失败，请刷新重试！'],500);
    }

    /**
     * 计算增值业务停止时间
     * @param $user_id 用户ID
     * @param $link_id 网站ID
     * @return array $status：判断本次是续费还是新增，0为新增，1为续费。$end_date：截止时间，时间戳类型,$log_id：如果是续费的话，值为上次记录的ID，否则为0
     */
    protected function endTime($user_id,$link_id)
    {
        $end_date = strtotime('+1month');
        $status = 0;

        $log = FeeLog::where('status',0)->where('user_id',$user_id)
            ->where('link_id',$link_id)
            ->first();

        if($log){
            $end_date = strtotime(date('Y-m-d',$log->end_date) . '+1month');
            $status = 1;
        }
        $log_id = isset($log->id) ? $log->id : 0;
        return [$status,$end_date,$log_id];
    }

    public function edit($id)
    {
        $link = Link::find($id);
        if(is_null($link)){
            return $this->returnResponse(['message'=>'链接不存在'],404);
        }
        $data = (new LinkTransformer())->objectTransformer($link);
        return $this->returnResponse(['data'=>$data,'message'=>'success']);
    }

    public function destroy($id)
    {
        $link = Link::where('id',$id)->where('user_id',Auth::id())->first();
        if(is_null($link)){
            return $this->returnResponse(['message'=>'链接不存在'],404);
        }
        if($link->delete()){
            return $this->returnResponse(['message'=>'删除成功']);
        }
        return $this->returnResponse(['message'=>'删除失败！'],500);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:8',
            'link' => 'required|max:50|url',
            'sort' => 'required',
            'id' => 'required'
        ],[
            'title.required' => '网站名称不能为空',
            'title.max' => '网站名称不能大于8位',
            'link.required'=>'链接不能为空',
            'link.max'=>'链接不能大于50位',
            'link.url'=>'请输入合法的链接',
            'sort.required' => '请选择分类'
        ]);

        $data = $request->only(['title','link','sort','id']);

        $model = new Link();
        $isMeLink = $model::where('id',$data['id'])->where('user_id',Auth::id())->first();
        if(is_null($isMeLink)){
            return $this->returnResponse(['message'=>'请勿非法操作'],403);
        }

        if($isMeLink->sort_id == Cache::get('fee')->recommend_id){
            unset($data['sort']);
        }else{
            $sort = Sort::where('code',$data['sort'])->first();
            if(is_null($sort)){
                return $this->returnResponse(['message'=>'分类不存在'],400);
            }
            unset($data['sort']);
            $data['sort_id'] = $sort->id;
        }

        $data['url'] = (new SourceController())->pregUrl($data['link']);

        $isLink = $model->where('id','!=',$isMeLink->id)->where(function ($query) use($data) {
            $query->where('title','like',"{$data['title']}")
                ->orWhere('link',"like","%{$data['url']}%");
        })->first();

        if($isLink){
            return $this->returnResponse(['message'=>'网站名称或链接已存在'],400);
        }
        unset($data['url']);

        if($isMeLink->status == 2){
            $data['status'] = 1;
        }

        $result = $model::where('id',$isMeLink->id)->update($data);

        if($result){
            return $this->returnResponse(['message'=>'修改成功']);
        }
        return $this->returnResponse(['message'=>'修改失败'],500);
    }

    private function checkRecommend()
    {
        $count = Link::where('sort_id',Cache::get('fee')->recommend_id)->count();
        if($count >= Cache::get('fee')->recommend_num){
            return true;
        }
        return false;
    }

    private function checkRank($id)
    {
        $count = Link::where('sort_id',$id)->where('type',1)->count();
        if($count >= Cache::get('fee')->rank_num){
            return true;
        }
        return false;
    }
    /**
     * 添加链接
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:8',
            'link' => 'required|max:50|url',
            'sort' => 'required'
        ],[
            'title.required' => '网站名称不能为空',
            'title.max' => '网站名称不能大于8位',
            'link.required'=>'链接不能为空',
            'link.max'=>'链接不能大于50位',
            'link.url'=>'请输入合法的链接',
            'sort.required' => '请选择分类'
        ]);

        $data = $request->only(['title','link','sort']);

        $sort = Sort::where('code',$data['sort'])->first();

        if(is_null($sort)){
            return $this->returnResponse(['message'=>'分类不存在'],400);
        }

        $url = (new SourceController())->pregUrl($data['link']);

        $model = new Link();
        $link = $model->where('title','like',"{$data['title']}")
            ->orWhere('link','like',"%{$url}%")
            ->first();

        if($link){
            return $this->returnResponse(['message'=>'网站已存在！'],400);
        }

        if($model::create([
            'title' => $data['title'],
            'link' => $data['link'],
            'sort_id' => $sort->id,
            'user_id' => Auth::id()
        ])){
            return $this->returnResponse(['message'=>'申请成功，请等待审核！']);
        }
        return $this->returnResponse(['message'=>'操作失败，请刷新重试！'],500);
    }
}