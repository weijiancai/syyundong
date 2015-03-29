<?php

/**
 *@时间:20150325
 *@功能:显示首页
 */
class IndexAction extends Action
{
    public function index()
    {

        $this->display();
    }
    /*
     * @功能注册图片验证码
     * @时间：20150328
     */
    Public function verify()
    {
        import('ORG.Util.Image');
        Image::buildImageVerify(4, 1, png, 90, 30, 'verify');
    }
}