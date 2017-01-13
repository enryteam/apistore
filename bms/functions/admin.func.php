<?php

/**
 * Rest接口调用
 * @param unknown $url
 * @param unknown $params
 * @return multitype:boolean string Ambigous <string, string, NULL>
 */
function restRequest($url, $params)
{
    $return = array(
        'result' => false,
        'msg' => ''
    );
    $url = pc_base::load_config('system', 'rest_url') . $url . ".do";
    if (is_array($params)) {
        $params = json_encode($params);
    }
    $http = pc_base::load_sys_class('http');
    $http->ContentType = "Content-Type: application/json\r\n";
    $http->method = 'POST';
    $http->post = $params;
    php4log('DEBUG', "\nREST请求地址：" . $url . "\nREST请求参数：" . preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $params) . "\n");
    $http->request($url);
    if ($http->is_ok()) {
        php4log('DEBUG', "\nREST响应结果：" . $http->get_data() . "\n");
        $result = json_decode($http->get_data(), true);
        if ($result['code'] == 1) {
            $return['result'] = true;
        }
        $return['msg'] = getCodeMsg($result['code']);
    } else {
        php4log('ERROR', "\nREST错误码：" . $http->errno() . "\nREST错误信息：" . $http->errmsg() . "\n");
        $return['msg'] = '请求失败';
    }
    return $return;
}

/**
 * 获得错误信息
 */
function getCodeMsg($code)
{
    $msg = pc_base::load_config('code', $code);
    if (! $msg) {
        $msg = '操作失败';
    }
    return $msg;
}

/**
 * 生成excel并下载
 *
 * @return string
 */
function createExcel($excel_data)
{
    $datas = array();
    array_push($datas, $excel_data);
    
    include PHPFRAME_PATH . '/phpframe/libs/classes/PHPExcel.php';
    include PHPFRAME_PATH . '/phpframe/libs/classes/PHPExcel/IOFactory.php';
    $Excel = new PHPExcel();
    $exclefile = $excel_data['title'] . '.xls';
    foreach ($datas as $key => $data) {
        if ($key) {
            $Excel->createSheet();
        }
        $Excel->setActiveSheetIndex($key);
        $Excel->getActiveSheet()->setTitle($data['title']);
        foreach ($data['column'] as $row => $columns) {
            $num = 0;
            foreach ($columns as $column) {
                $currentCell = getCharByNunber($num) . ($row + 1);
                $Excel->getActiveSheet()->setCellValue($currentCell, $column);
                // 设置居中
                $Excel->getActiveSheet()
                    ->getStyle($currentCell)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                // 所有垂直居中
                $Excel->getActiveSheet()
                    ->getStyle($currentCell)
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $num ++;
            }
        }
    }
    $objwriter = PHPExcel_IOFactory::createWriter($Excel, 'Excel5');
    header("Content-type:text/html;charset=utf-8");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $exclefile);
    header('Cache-Control: max-age=0');
    $objwriter->save('php://output');
    return;
}

function getCharByNunber($num)
{
    $num = intval($num);
    $arr = array(
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z'
    );
    return $arr[$num];
}

