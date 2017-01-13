<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
$session_storage = 'session_' . pc_base::load_config('system', 'session_storage');
pc_base::load_sys_class($session_storage);
// pc_base::load_app_class('admin');
include_once PHPFRAME_PATH . 'phpframe/libs/classes/WideImage/WideImage.php';

class iimage
{

    private $attachment;

    private $alowexts = "jpg|gif|png|jpeg";

    public function __construct()
    {
        $this->attachment = pc_base::load_sys_class('attachment');
        // parent::__construct();
    }

    /**
     * 单图上传
     */
    public function upload()
    {
        $imageField = getgpc("img");
        $thumb = getgpc("thumbname");
        $thumb = empty($thumb) ? "thumb" : trim($thumb);
        $oldname = $this->attachment->upload($imageField, $this->alowexts);
        $tmp = explode('.', $oldname);
        $tmp[count($tmp) - 2] = $tmp[count($tmp) - 2] . "_" . $thumb;
        $newname = join('.', $tmp);
        // 生成缩略图
        WideImage::load(UPLOAD_PATH . str_replace('uploadfile/', '', $oldname))->resize(500)->saveToFile(UPLOAD_PATH . str_replace('uploadfile/', '', $newname));
        
        // 添加水印
        // if (getgpc("watermark") == "1") {
        // WideImage::load(str_replace('uploadfile/', '', UPLOAD_PATH) . $oldname)->merge(WideImage::load(UPLOAD_PATH . "watermark.png"), "right - 10", "bottom - 10", 100)->saveToFile(str_replace('uploadfile/', '', UPLOAD_PATH) . $oldname);
        // }
        
        if ($oldname) {
            $data = array(
                'code' => 1,
                'message' => "上传成功",
                'data' => 'im/' . str_replace('uploadfile/', '', $newname)
            );
            echo json_encode($data);
            exit();
        } else {
            $data = array(
                'code' => 0,
                'message' => "上传失败",
                'data' => $this->attachment->error()
            );
            echo json_encode($data);
            exit();
        }
    }

    /**
     * [uploadimg description]
     *
     * @return [type] [description]
     */
    public function uploadimg()
    {
        $oldname = getgpc("path");
        
        // 添加水印
        if (getgpc("watermark") == "1") {
            $oriname = str_replace("_tmp", "", $oldname);
            WideImage::load(str_replace('uploadfile/', '', UPLOAD_PATH) . $oriname)->merge(WideImage::load(UPLOAD_PATH . "watermark.png"), "right - 10", "bottom - 10", 100)->saveToFile(str_replace('uploadfile/', '', UPLOAD_PATH) . $oriname);
        }
        $thumb = getgpc("thumbname");
        $thumb = empty($thumb) ? "thumb" : trim($thumb);
        $replace = getgpc("replace");
        $tmp = explode('.', $oldname);
        $tmp[count($tmp) - 2] = $tmp[count($tmp) - 2] . "_" . $thumb;
        $newname = join('.', $tmp);
        $newname = str_replace("_" . $replace, "", $newname);
        // 裁剪缩略图
        WideImage::load(str_replace('uploadfile/', '', UPLOAD_PATH) . $oldname)->saveToFile(str_replace('uploadfile/', '', UPLOAD_PATH) . $newname);
        returnRes(1, "操作成功", $newname, UPLOAD_URL);
    }

    /**
     * 图片裁剪
     */
    public function cut()
    {
        $oldname = getgpc("path");
        $x = getgpc("x");
        $y = getgpc("y");
        $w = getgpc("w");
        $h = getgpc("h");
        if (empty($w)) {
            returnRes(- 1, "请选择要裁剪的区域");
        }
        // 添加水印
        if (getgpc("watermark") == "1") {
            $oriname = str_replace("_tmp", "", $oldname);
            WideImage::load(UPLOAD_PATH . str_replace('uploadfile/', '', $oriname))->merge(WideImage::load(UPLOAD_PATH . "watermark.png"), "right - 10", "bottom - 10", 100)->saveToFile(str_replace('uploadfile/', '', UPLOAD_PATH) . $oriname);
        }
        $thumb = getgpc("thumbname");
        $thumb = empty($thumb) ? "thumb" : trim($thumb);
        $replace = getgpc("replace");
        $tmp = explode('.', $oldname);
        $tmp[count($tmp) - 2] = $tmp[count($tmp) - 2] . "_" . $thumb;
        $newname = join('.', $tmp);
        $newname = str_replace("_" . $replace, "", $newname);
        // 裁剪缩略图
        WideImage::load(UPLOAD_PATH . str_replace('im/', '', $oldname))->crop($x, $y, $w, $h)->saveToFile(UPLOAD_PATH . str_replace('im/', '', $newname));
        returnRes(1, "操作成功", $newname);
    }

    /**
     * 多图上传
     */
    public function multipleUpload()
    {
        $imageField = getgpc("img");
        $thumb = getgpc("thumbname");
        $thumb = empty($thumb) ? "thumb" : trim($thumb);
        $results = $this->attachment->upload($imageField, $this->alowexts);
        $newnames = array();
        if ($results) {
            if (! is_array($results)) {
                $oldnames = array(
                    $results
                );
            } else {
                $oldnames = $results;
            }
            foreach ($oldnames as $oldname) {
                $tmp = explode('.', $oldname);
                $tmp[count($tmp) - 2] = $tmp[count($tmp) - 2] . "_" . $thumb;
                $tmpname = join('.', $tmp);
                // 生成缩略图
                WideImage::load(str_replace('uploadfile/', '', UPLOAD_PATH) . $oldname)->resize(500)->saveToFile(str_replace('uploadfile/', '', UPLOAD_PATH) . $tmpname);
                $thumb = "thumb";
                $replace = "tmp";
                $tmp = explode('.', $tmpname);
                $tmp[count($tmp) - 2] = $tmp[count($tmp) - 2] . "_" . $thumb;
                $newname = join('.', $tmp);
                $newname = str_replace("_" . $replace, "", $newname);
                // 裁剪缩略图
                $width = WideImage::load(str_replace('uploadfile/', '', UPLOAD_PATH) . $tmpname)->getWidth();
                $height = WideImage::load(str_replace('uploadfile/', '', UPLOAD_PATH) . $tmpname)->getHeight();
                $size = $width < $height ? $width : $height;
                WideImage::load(str_replace('uploadfile/', '', UPLOAD_PATH) . $tmpname)->crop(0, 0, $size, $size)->saveToFile(str_replace('uploadfile/', '', UPLOAD_PATH) . $newname);
                $newnames[] = $newname;
            }
        }
        if ($results) {
            $data = array(
                'code' => 1,
                'message' => "上传成功",
                'data' => $newnames
            );
            echo json_encode($data);
            exit();
        } else {
            $data = array(
                'code' => 0,
                'message' => "上传失败",
                'data' => $this->attachment->error()
            );
            echo json_encode($data);
            exit();
        }
    }

    public function retate()
    {
        $oldname = getgpc("path");
        $thumb = getgpc("thumbname");
        $thumb = empty($thumb) ? "thumb" : trim($thumb);
        $thumb_path = str_replace('uploadfile/', '', UPLOAD_PATH) . $oldname;
        $o_path = str_replace("_" . $thumb, "", $thumb_path);
        WideImage::load(str_replace('uploadfile/', '', UPLOAD_PATH) . $oldname)->rotate(90)->saveToFile(str_replace('uploadfile/', '', UPLOAD_PATH) . $oldname);
        WideImage::load($o_path)->rotate(90)->saveToFile($o_path);
        returnRes(1, "操作成功", $oldname);
    }
}