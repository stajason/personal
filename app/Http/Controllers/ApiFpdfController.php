<?php

namespace App\Http\Controllers;

use Response;
use Exception;
use FPDI;
use Imagick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToImage\Pdf;

/**
 * 在线生成pdf
 * @author jason <numberjason@gmail.com>
 * @since 2017-05-24
 */
class ApiFpdfController extends ApiBaseController
{
    /**
     * [newPdf 生成新pdf]
     */
    public function newPdf()
    {
        try {
            $resp = '{"1": "jason"}';
            return $resp;
            $data = [];
            $pdfPath = '/Users/jason/Downloads/jason.pdf';
            $pdf = new FPDI();
            $num = $pdf->setSourceFile($pdfPath);
            for ($i=1; $i <= $num ; $i++) { 
                $pdf->AddPage();
                $tplIdx = $pdf->importPage($i);
                $pdf->useTemplate($tplIdx, 10, 10, 190);
                $pdf->SetFont('stsongstdlight');
            }
            // $pdf->SetTextColor(0, 0, 0);
            // $pdf->SetXY(60, 57);
            // $pdf->Write(0, '√打敗快点快点看');
            // $pdf->SetXY(120, 57);
            // $pdf->Write(0, '123456789012');
            $pdf->endTemplate();
            $fileName = '/Users/jason/Downloads/' . md5(date('Y-m-d H:i:s')) . '_test.pdf';
            $pdf->Output($fileName, 'F');
            $data['fileName'] = $fileName;
            $this->setRespMsg(['data' => $data]);
        } catch (Exception $e) {
            $this->handle($e);
        }
        return $this->output();
    }

    /**
     * [pdfToImg pdf转换成img]
     */
    public function pdfToImg(Request $request)
    {
        try {
            $data = [];
            $start = time();
            $a = new \Imagick('/usr/local/var/www/github/personal/jason1.pdf');
            $end = time();
            dd($end - $start);

            $type = $request->input('type');
            $picNo = $request->input('pic_no');
            $pdfPath = '/usr/local/var/www/github/personal/jason.pdf';
            $path = '/usr/local/var/www/github/personal/public/assets/pc/uploads/pdf/';
            $pdf = new Pdf($pdfPath);
            if(!is_readable($pdfPath)){
                dd('no this file!');
            }
            //sleep(20);
            if ($type == 'num') {
                $num = $pdf->getNumberOfPages();
                if ($num) {
                    $data['num'] = $num;
                }
            } else {
                // $pdf->setResolution(190);
                $pdf->setResolution(300);
                $pdf->setOutputFormat('jpg');
                if ($picNo) {
                    $pdf->setPage($picNo);
                }
                $middlePath = $picNo .'-'. md5(time()). '.jpg';
                $start = time();
                $pdf->saveImage($path . $middlePath);
                $end = time();
                Log::info($end - $start);
                $data['realPath'] = '/assets/pc/uploads/pdf/' . $middlePath;

                // $start = time();
                // if ($num) {
                //     for ($i=1; $i < ($num + 1); $i++) {
                //         $startTime = time();
                //         $pdf->setPage($i);
                        
                        
                //         $endTime = time();
                //         $diffTime = $endTime - $startTime;
                //         Log::info('生成第'.$i.'张图片处理时长：'. $diffTime .'秒');
                //     }
                // }
                // $end = time();
                // $cha = $end - $start;
                // Log::info('总时长' . $cha .'秒');
                // $data['test'] = '1';
            }
            $this->setRespMsg(['data' => $data]);
        } catch (Exception $e) {
            $this->handle($e);
        }
        return $this->output();
    }
}










