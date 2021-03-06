<?php

namespace App\Http\Controllers\Contract;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class saleContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //出房合同的列表页的数据
    public function index(){
        $pn = Input::get('pn');
        $cnt = Input::get('cnt');
        $selectItem = Input::get('selectItem');
        $status = Input::get('zhuangtai');
        if(!$pn){
            $pn = 1;
        }
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/list',[
            'query'=>[
                'pn'=>$pn,
                'cnt'=>$cnt,
                'selectItem'=>$selectItem,
                'status'=>$status,
            ]
        ]);
        echo $response->getBody();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //出房合同点新增后保存数据的方法
    public function store(Request $request)
    {
        //return $request->params;
        //数据格式化
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $data = $request->params;
        $data['jiafangfeiyong'] = implode(',',$data['jiafangfeiyong']);
        $response = $client->request('POST', '/api/contract/xs/save', [
            'json' => $data,
        ]);
        $res = $response->getBody();
        $res = json_decode($res);
        $res->data->jiafangfeiyong = explode(',',$res->data->jiafangfeiyong);
        echo json_encode($res);
    }





    /**
     * Display the specified resource.
     * 根据合同ID获取合同的信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //出房合同点编辑后显示数据的方法
    public function show($id)
    {
        //dd(10101010);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/'.$id);
        $res = $response->getBody();
        $res = json_decode($res);
        $res->data->jiafangfeiyong = explode(',',$res->data->jiafangfeiyong);
        echo json_encode($res);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*edit --->编辑*/
    //在这里是提交那个按钮的处理
    public function edit($id)
    {
        //dd(666);
        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET','/api/contract/xs/'.$id.'/submit');
        echo $response->getBody();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //出房合同点击编辑后保存的方法
    public function update(Request $request, $id)
    {
        //dd(555);
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/update'.$id);
        echo $response->getBody();
        /*$info = $request->params;
        dd($info);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /*weiYueSave
     * 合同审核
     *
     * */
    public function review(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);

        $response = $client->request('POST', '/api/contract/xs/shenhe', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }

    //出房合同获取收房合同的楼盘
    public function getchuzuren(){
        //dd(111111);
        $fangyuanId = Input::get('fangyuanId');
        //dd($fangyuanId);
        $client = new Client([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET','/api/contract/sf/queryChengzufang/'.$fangyuanId);
        echo $response->getBody();
    }
    //解约协议的保存
    public function jieyuesave(Request $request){
        //dd(222);
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/xs/jieyueXieyi/save', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    public function jieyuelist()
    {
        //dd(10101010);
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/jieyueXieyi/'.$id);
        echo $response->getBody();
    }
    //解约协议的提交
    public function submit(Request $request){
        //dd(111111);
        //dd($request);
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST','/api/contract/xs/jieyueXieyi/submit', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    //合同状态变为：审核中
    public function approving(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/'.$id.'/approving');
        echo $response->getBody();
    }
    //合同状态变为：解约中
    public function releasing(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/'.$id.'/releasing');
        echo $response->getBody();
    }
    //合同状态变为：解约完成
    public function released(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/'.$id.'/released');
        echo $response->getBody();
    }

    public function sub($id)
    {
        //return $request->params;
        //数据格式化
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/'.$id);
        echo $response->getBody();
    }
    //合同状态变为：正在确认
    public function confirm(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET','/api/contract/xs/'.$id.'/confirm');
        echo $response->getBody();
    }
    //合同状态变为：已确认
    public function confirmed(){
        //dd(555);
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET','/api/contract/xs/'.$id.'/confirmed');
        echo $response->getBody();
    }
    //合同状态变为：违约处理中
    public function violating(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/'.$id.'/violating');
        echo $response->getBody();
    }
    //合同状态变为：合同终止
    public function terminated(){
        //dd(1111);
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/'.$id.'/terminated');
        echo $response->getBody();
    }
    /*
     * /api/contract/sf/buchongXieyi/3
     * 获取该合同的优化协议
     * */
    public function jieyue(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,

        ]);
        $response = $client->request('GET', '/api/contract/xs/jieyueXieyi/'.$id);
        echo $response->getBody();
    }
    //合同终止的时候提交合同ID，然后获取应付信息
    public function weiYueInfo(Request $request){
        //dd(111);
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/cw/comm/inithtwy', [
            'json' => $request->params
        ]);
        echo $response->getBody();

    }
    /*
     * api/contract/sf/weiyue/save
     * */
    public function weiYueSave(Request $request){
        //dd($request);
        $client = new Client([
            'base_uri' => $this->base_url,

            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/xs/weiyue/save', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    /*
     * 扫描合同复印件列表copyImageList
     * */
    public function copyImageList(Request $request){
        $id = Input::get('id');
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('GET', '/api/contract/xs/img/'.$id.'/query', [

        ]);
        $res = json_decode($response->getBody());
        $data2 = [];
        foreach ($res->data as $key => $value){
            $content = base64_decode($res->data[$key]->content);
            //新文件名
            $_nowdate = date("YmdHis");
            $rnd = rand(10000, 99999);
            $new_file_name = $_nowdate . '_' . $rnd . '.' . 'jpg';
            $path = 'image/tmp/';
            if (!file_exists($path)) {
                mkdir($path,0755,true);
            }
            file_put_contents($path.$new_file_name,$content);
            $url = $path.$new_file_name;
            $value->url =$url;
            $value->content =null;
            $data2[$value->type][] = $value;
        }
        $res->data = $data2;
        echo json_encode($res);
        //$this->removeDir($path);
    }

    public function addCopyImage(){
        //dd(111);
        //PHP上传失败
        if (!empty($_FILES['file']['error'])) {
            switch($_FILES['file']['error']){
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension。';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            return $error;
        }
        $fp = fopen($_FILES["file"]["tmp_name"],"rb");
        $image = fread($fp,$_FILES["file"]["size"]);
        $image = base64_encode($image);
        $data = [
            'hetongid'=>$_POST['id'],
            'type'=>$_GET['type'],
            'content'=>$image,
        ];
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/xs/img/upload', [
            'json' =>$data
        ]);
        echo $response->getBody();
    }
    /*
     * 删除图片
     * */
    public function deleteCopyImage(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
        ]);
        $response = $client->request('GET', '/api/contract/xs/img/'.$id.'/del/');
        echo $response->getBody();

    }
    /*
     * 资料是否齐全
     * */
    public function isCopyComplete(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/xs/img/set', [
            'json' =>$request->params
        ]);
        echo $response->getBody();
    }
    public function getCopyComplete(){
        $id = Input::get('id');
        $client = new Client([
            'base_uri' => $this->base_url,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('GET', '/api/contract/xs/img/'.$id.'/isComplete');
        echo $response->getBody();
    }
    //获取渠道经纪自由人
    public function getzyrNameList(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
        ]);
        $bkName = $request->params['name'];
        $response = $client->request('GET', '/api/qd/ziyou/list', [
                'query' => [
                    'page' => 1,
                    'size' => 10,
                    'zt' => 1,
                    'uname' => $bkName
                ]

            ]
        );
        echo $response->getBody();

    }

}