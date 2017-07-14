<?php

namespace App\Http\Controllers\Contract;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class purchaseContractController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $pn = Input::get('pn');
        $cnt = Input::get('cnt');
        $selectItem = Input::get('selectItem');
        if(!$pn){
            $pn = 1;
        }
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
            $response = $client->request('GET', '/api/contract/sf/list',[
                'query'=>[
                    'pn'=>$pn,
                    'cnt'=>$cnt,
                    'selectItem'=>$selectItem,
                    ]
            ]);
            echo $response->getBody();
    }

    /**
     * Show the form for creating a new resource.
     *    合同新增的时候获取条款信息
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/create');
        echo $response->getBody();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->params;
        //数据格式化
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $data = $request->params;
        $data['jiafangfeiyong'] = implode(',',$data['jiafangfeiyong']);
        $data['yifangfeiyong'] = implode(',',$data['yifangfeiyong']);
        $response = $client->request('POST', '/api/contract/sf/save', [
            'json' => $data,
        ]);
        $res = $response->getBody();
        $res = json_decode($res);
        $res->data->yifangfeiyong = explode(',',$res->data->yifangfeiyong);
        $res->data->jiafangfeiyong = explode(',',$res->data->jiafangfeiyong);
        echo json_encode($res)  ;
    }

    /**
     * Display the specified resource.
     * 根据合同ID获取合同的信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id);
        $res = $response->getBody();
        $res = json_decode($res);
        $res->data->yifangfeiyong = explode(',',$res->data->yifangfeiyong);
        $res->data->jiafangfeiyong = explode(',',$res->data->jiafangfeiyong);
        echo json_encode($res)  ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/submit');
        echo $response->getBody();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 二次优化
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/buchongXieyi/save', [
            'json' => $request->params
        ]);
        echo $response->getBody();
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
    /*
     * 合同审核
     *
     * */
    public function review(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);

        $response = $client->request('POST', '/api/contract/sf/shenhe', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
    /*
     * 修改合同条款api/contract/hetong/update/tiao
     * */
    public function editTiaoKuan(Request $request){
        $data['id'] = $request->params['id'];
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        //条
        if(array_key_exists('kuanList', $request->params)){
            $requestUrl = '/api/contract/hetong/update/tiao';
            $data['title'] = $request->params['title'];
        }
        //款
        if(array_key_exists('xiangList', $request->params)){
            $requestUrl = '/api/contract/hetong/update/kuan/id/'.$data['id'];
            $data['content'] = $request->params['content'];
        }
        //项
        if(array_key_exists('kuanid', $request->params)){
            $requestUrl = '/api/contract/hetong/update/xiang';
            $data['content'] = $request->params['content'];
        }
        $response = $client->request('POST', $requestUrl, [
            'json' => $data
        ]);
        echo $response->getBody();
    }
    //合同状态变为：已确认
    public function confirm(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/confirm');
        echo $response->getBody();
    }
    //合同状态变为：待确认
    public function confirming(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/confirming');
        echo $response->getBody();
    }
    //合同状态变为：违约处理中
    public function violating(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/violating');
        echo $response->getBody();
    }
    //合同状态变为：合同终止
    public function terminated(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/terminated');
        echo $response->getBody();
    }
    //合同状态变为：优化中
    public function releasing(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/releasing');
        echo $response->getBody();
    }
    //合同状态变为：优化成功  执行两个动作：协议改为已提交的状态，合同改为已经优化的状态
    public function released(){
        $id = Input::get('id');
        $xyid = Input::get('xyid');

        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/'.$id.'/released');
        $response = $client->request('GET', '/api/contract/sf/buchongXieyi/'.$xyid.'/confrim?id='.$xyid);
        echo $response->getBody();
    }
    //状态变更为审核中
    public function approving(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', "/api/contract/sf/$id/approving");
        echo $response->getBody();
    }
    /*
     * /api/contract/sf/buchongXieyi/3
     * 获取该合同的优化协议
     * */
    public function getOptimize(){
        $id = Input::get('id');
        $client = new Client ([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', '/api/contract/sf/buchongXieyi/'.$id);
        echo $response->getBody();
    }
    //合同终止的时候提交合同ID，然后获取应付信息
    public function weiYueInfo(Request $request){
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
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
        $client = new Client([
            'base_uri' => $this->base_url,
            'timeout'  => 2.0,
            'headers' =>['access_token'=>'XXXX','app_id'=>'123']
        ]);
        $response = $client->request('POST', '/api/contract/sf/weiyue/save', [
            'json' => $request->params
        ]);
        echo $response->getBody();
    }
}
