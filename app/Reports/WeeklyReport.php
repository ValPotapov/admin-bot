<?php

namespace App\Reports;

use Illuminate\Support\Facades\Storage;

class WeeklyReport
{
    protected $dataParams;
    protected $exportType = 'link';
    protected $exportValue;
    protected $exportTitle = '';

    public function __construct($dataParams = []){
        $this->dataParams = $dataParams;

        $weeklyReportData = \App\Reports\ReportBuilders\WeeklyReport::build();

        //шаблонизация
        if($weeklyReportData){
            $html = view('reports.weeklyReport', $weeklyReportData);

            $file_name = 'weekly_' . $weeklyReportData["reportDateFrom"] . "_" . $weeklyReportData["reportDateTo"] . ".html";

            Storage::disk('local')->put($file_name, $html);

            $this->exportValue = $file_name;
            $this->exportTitle = 'Еженедельный отчет от ' . $weeklyReportData["weeklyReport"]["reportDateFromString"] . ' до '. $weeklyReportData["weeklyReport"]["reportDateToString"];
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
