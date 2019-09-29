<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/4
 * Time: 16:40
 */

namespace app\common;


class UserTree
{
    public function getChildren($users, $pid,$cu_pid,$c_path, $leve = 0,$c=1)
    {
        static $data = array();
        foreach ($users as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['leve'] = $leve;
                if($v['status']==1){
                    $status = '正常';
                }else if($v['status']==0){
                    $status='待审核';
                }else if($v['status']==-1){
                    $status = '未通过';
                }else{
                    $status='审核';
                }
                if($c==1){
//                    dump($c_path);die;
                    $c_path_c = explode('-',$c_path);
                    array_shift($c_path_c);
                    array_pop($c_path_c);
                    $c_path_num =count($c_path_c);
                    $path =explode('-',$v['path']);
                    array_shift($path);
                    array_pop($path);
                    if(count($path)<=5+$c_path_num-1){
                        $data[] = [
                            'id' => $v['id'],
                            'name' => $v['pid']!=$cu_pid ? str_repeat('└', $leve ) . $v['real_name'] : $v['real_name'],
                            'pid' => $v['pid'],
                            'agency' => $v['title'],
                            'status'=>$status,
                            'avatar'=>$v['avatar'],
                            'province'=>$v['province'],
                            'city'=>$v['city'],
                            'wechatid'=>$v['wechatid'],
                            'phone'=>$v['phone'],
                            'status_time'=>$v['status_time'],
                            'create_time'=>$v['create_time']
                        ];
                    }
                }
                unset($users[$k]);
                $this->getChildren($users, $v['id'], $cu_pid,$c_path,$leve + 1,$c);
            }
        }
        return $data;
    }
}