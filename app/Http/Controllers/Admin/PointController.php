<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\PointSort;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        $code = PointSort::orderBy('sort','asc')->paginate(20);
        return view('admin.point.index',compact(['code']));
    }

    public function used()
    {
        $code = Point::where('status',1)->orderBy('id','desc')->paginate(20);
        return view('admin.point.sort',compact('code'));
    }

    public function sort($id)
    {
        $code = Point::where('status',0)->where('sort_id',$id)->orderBy('id','desc')->paginate(20);
        return view('admin.point.sort',compact('code'));
    }

    public function edit($id)
    {
        $code = PointSort::find($id);
        if(is_null($code)){
            return $this->returnResponse(['message'=>'code sort is empty'],404);
        }
        return view('admin.point.edit',compact('code'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'point' => 'required',
            'link' => 'required',
            'id' => 'required'
        ]);
        $data = $request->only(['id','point','link','sort','summary']);
        $model = new PointSort();
        $code = $model::find($data['id']);
        if(is_null($code)){
            return $this->returnResponse(['message'=>'分类不存在'],404);
        }

        if($model::where('id',$data['id'])->update($data)){
            return $this->returnResponse(['message'=>'修改成功']);
        }

        return $this->returnResponse(['message'=>'修改失败']);
    }

    public function create()
    {
        return view('admin.point.create');
    }

    public function createCodeView($id)
    {
        $code = PointSort::find($id);
        if(is_null($code)){
            return $this->returnResponse(['message'=>'分类不存在'],404);
        }

        return view('admin.point.create_code',compact('code'));
    }
    /**
     * 创建分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'point' => 'required',
            'link' => 'required',
        ]);
        $data = $request->only(['point','link','sort','summary']);

        if(PointSort::create($data)){
            return $this->returnResponse(['message'=>'添加成功']);
        }
        return $this->returnResponse(['message'=>'添加失败'],500);
    }
    
    public function storeCode(Request $request)
    {
        $request->validate([
            'num' => 'required',
            'sort_id' => 'required'
        ],[
            'num.required' => '数量不能为空',
            'sort_id.required' => '请选择分类',
        ]);
        $form = $request->only(['num','sort_id']);

        $code = $this->code([],$form['num']);
        if(empty($code)){
            return $this->returnResponse(['message'=>'生成失败'],500);
        }

        $data = array();

        foreach ($code as $key=>$val){
            $data[$key]['code'] = $val;
            $data[$key]['sort_id'] = $form['sort_id'];
        }

        $result = (new Point())->insert($data);

        if($result){
            return $this->returnResponse(['message'=>'生成成功','data'=>$code]);
        }
        return $this->returnResponse(['message'=>'生成失败'],500);
    }

    public function destroy($id)
    {
        $code = Point::find($id);
        if(is_null($code)){
            return $this->returnResponse(['message'=>'激活码不存在'],404);
        }

        if($code->delete()){
            return $this->returnResponse(['message'=>'删除成功']);
        }
        return $this->returnResponse(['message'=>'删除失败'],500);
    }

    public function delete($id)
    {
        $code = PointSort::find($id);
        if(is_null($code)){
            return $this->returnResponse(['message'=>'分类不存在'],404);
        }

        if(Point::where('sort_id',$code->id)->delete()){
            $code->delete();
            return $this->returnResponse(['message'=>'删除成功']);
        }

        return $this->returnResponse(['message'=>'删除失败'],500);
    }

    public function code($codes = [], $num = 20)
    {

        if(empty($codes)){
            $codes = $this->createCode($num);
        }

        $data = Point::whereIn('code',$codes)->get(['code']);

        if($data->isEmpty() && count($codes) == $num){
            return $codes;
        }
        $items = array_diff($codes,collect($data)->pluck('code')->toArray());

        return $this->code(array_merge(
            $items,
            $this->createCode(($num - count($items)))
        ));
    }
    protected function createCode($length)
    {
        $codes = [];
        for ($i = 0; $i < $length; $i++){
            $codes[$i] = $this->randCode();
        }

        return $codes;
    }
    protected function randCode()
    {
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y','z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );
        $length = 6;
        $keys = array_rand($chars,$length);
        $codes = '';
        for ($i = 0; $i < $length; $i++){
            $codes .= $chars[$keys[$i]];
        }
        return $codes;
    }

}