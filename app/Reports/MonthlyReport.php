<?php

namespace App\Reports;

use Illuminate\Support\Facades\Storage;

class MonthlyReport
{
    protected $dataParams;
    protected $exportType = 'link';
    protected $exportValue;
    protected $exportTitle = '';

    public function __construct($dataParams = []){
        $this->dataParams = $dataParams;

        $monthlyReportData = \App\Reports\ReportBuilders\MonthlyReport::build();

        //шаблонизация
        if($monthlyReportData){
            $html = view('reports.monthlyReport', ['monthlyReport'=>$monthlyReportData]);

            $file_name = 'monthly_' . $monthlyReportData["reportDate"] . ".html";

            Storage::disk('local')->put($file_name, $html);

            $this->exportValue = $file_name;
            $this->exportTitle = 'Ежемесячный отчет за ' . $monthlyReportData["reportDateString"];
        }else{
            $this->exportValue = null;
        }
    }

    public function getType(){
        return $this->exportType;
    }

    public function getTitle(){
        return $this->exportTitle;
    }

    public function getData(){
        if($this->exportValue) {
            return "/export/reports/" . $this->exportValue . "?secure=" . md5("desu" . $this->exportValue);
        }else{
            return false;
        }
    }
}
