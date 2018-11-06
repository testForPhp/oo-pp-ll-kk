<?php
namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\FeeLog;
use App\Transformers\AdTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdsController extends Controller
{
    public function index()
    {
        $adsMenu = 'active';
        $feeCache = Cache::get('fee');
        $adModel = new Ad();

        $count = $adModel::where('status',0)->count();
        $yu = $feeCache->img_num - $count;

        $ad = $adModel::where('user_id',Auth::id())->orderBy('id','desc')->paginate(10);
        return view('member.ad',compact(['adsMenu','feeCache','yu','ad']));
    }

    public function edit($id)
    {
        $ad = Ad::where('id',$id)->where('user_id',Auth::id())->first();
        if(is_null($ad)){
            return $this->returnResponse(['message'=>'广告不存在'],404);
        }

        $adFormer = (new AdTransformer())->transformer($ad->toArray());
        return $this->returnResponse(['message'=>'success','data'=>$adFormer]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'img' => 'required|url',
            'link' => 'required|url'
        ]);
        $data = $request->only(['img','link']);

        $data_id = $request->get('id');

        if($data_id){
            return $this->update($data,$data_id);
        }

        if($this->checkCount()){
            return $this->returnResponse(['message'=>'对不起，广告位已卖完！'],404);
        }

        $user = Auth::user();

        if(Cache::get('fee')->img > $user->point){
            return $this->returnResponse(['code'=>2,'message'=>'余额不足，请前往充值！']);
        }

        $user->point = $user->point - Cache::get('fee')->img;

        if(!$user->save()){
            return $this->returnResponse(['message'=>'提交失败,请稍后尝试！'],500);
        }

        list($status,$end_date,$old_id) = $this->endTime();

        $data['user_id'] = $user->id;
        $ad = Ad::create($data);

        if(!$ad){
            $user->point = $user->point + Cache::get('fee')->img;
            $user->save();
            return $this->returnResponse(['message'=>'提交失败，请稍后重试！'],500);
        }

        $feeLogModel = new FeeLog();

        $feelog = $feeLogModel->create([
            'type' => 'img',
            'link_id' => $ad->id,
            'user_id' => $user->id,
            'summary' => '',
            'end_date' => $end_date,
            'sort_id' => 0
        ]);

        if($feelog){
            return $this->returnResponse(['message'=>'申请成功']);
        }

        $user->point = $user->point + Cache::get('fee')->img;
        $user->save();
        $feelog->delete();
        $ad->delete();
        return $this->returnResponse(['message'=>'提交失败，请稍后重试！'],500);
    }

    public function checkCount()
    {
        $count = Ad::where('status',0)->count();
        if($count >= Cache::get('fee')->img_num){
            return true;
        }
        return false;
    }
    
    public function update($data,$id)
    {
        $ad = Ad::where('id',$id)->where('user_id',Auth::id())->first();
        if(is_null($ad)){
            return $this->returnResponse(['message'=>'广告不存在'],404);
        }
        $result = Ad::where('id',$ad->id)->update([
            'img' => $data['img'],
            'link' => $data['link']
        ]);

        if($result){
            return $this->returnResponse(['message'=>'更新成功']);
        }
        return $this->returnResponse(['message'=>'提交失败，请稍后重试！'],500);
    }
    

    public function renew(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $adModel = new Ad();

        $ad = $adModel->find($request->get('id'));

        if(is_null($ad)){
            return $this->returnResponse(['message'=>'广告不存在'],404);
        }

        if($ad->status == 1  && $this->checkCount() == true){
            return $this->returnResponse(['message'=>'对不起，广告位已卖完！'],404);
        }

        $user = Auth::user();

        if(Cache::get('fee')->img > $user->point){
            return $this->returnResponse(['code'=>2,'message'=>'余额不足，请前往充值']);
        }

        list($status,$end_date,$old_id) = $this->endTime($ad->id);

        $user->point = $user->point - Cache::get('fee')->img;

        if(!$user->save()){
            return $this->returnResponse(['message'=>'提交失败，请稍后再试！'],500);
        }

        $summary = '';

        if($status == 1){
            $summary = '续费成功，时间叠加！';
        }
        $feelogModel = new FeeLog();
        $feelog = $feelogModel->create([
            'type' => 'img',
            'link_id' => $ad->id,
            'user_id' => $user->id,
            'sort_id' => 0,
            'summary' => $summary,
            'end_date' => $end_date
        ]);

        if(!$feelog){
            $user->point = $user->point + Cache::get('fee')->img;
            $user->save();
            return $this->returnResponse(['message'=>'提交失败，请稍后再试'],500);
        }
        $ad->status = 0;
        if($ad->save()){

            if($status == 1){
                $feelogModel->where('id',$old_id)->update(['status'=>1]);
            }
            return $this->returnResponse(['message'=>'续费成功！']);
        }

        $user->point = $user->point + Cache::get('fee')->img;
        $user->save();
        $feelog->delete();
        return $this->returnResponse(['message'=>'提交失败，请稍后重试！'],500);
    }

    protected function endTime($id = '')
    {
        $end_time = strtotime('+1month');
        $status = 0;

        if($id != ''){

            $ad = FeeLog::where('user_id',Auth::id())
                ->where('link_id',$id)
                ->where('status',0)
                ->first();

            if($ad){
                $end_time = strtotime(date('Y-m-d',$ad->end_date) . "+1month");
                $status = 1;
            }

        }

        $id = isset($ad->id) ? $ad->id : 0;
        return [$status,$end_time,$id];
    }

    public function destroy($id)
    {
        $ad = Ad::where('id',$id)->where('user_id',Auth::id())->first();
        if(is_null($ad)){
            return $this->returnResponse(['message'=>'广告不存在'],404);
        }
        if($ad->delete()){
            return $this->returnResponse(['message'=>'删除成功！']);
        }
        return $this->returnResponse(['message'=>'提交失败，请稍后重试！'],500);
    }

}