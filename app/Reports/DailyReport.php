<?php

namespace App\Reports;

use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class DailyReport
{
    protected $dataParams;
    protected $exportType = 'link';
    protected $exportValue;
    protected $exportTitle = '';

    public function __construct($dataParams = []){
        $this->dataParams = $dataParams;

        $reportDate = \Carbon\Carbon::now()->yesterday();
        $reportDateString = $reportDate->format('d M y');

        $reports = Report::with(['salon','source'])
            ->where('date',$reportDate->format('Y-m-d'))
            ->orderBy('salon_id','ASC')
            ->get()
            ->toArray();

        if($reports) {
            $reportSources = [];
            $reportData = [];
            $totalValues = [];
            foreach ($reports as $report) {
                if (!isset($reportData[$report['salon']['id']])) {
                    $reportData[$report['salon']['id']] = [
                        'salon' => $report['salon'],
                        'sources' => []
                    ];
                }

                //собираем справочник типов источников
                if (!isset($reportSources[$report['source']['id']])) {
                    $reportSources[$report['source']['id']] = $report['source']['name'];
                }

                $reportData[$report['salon']['id']]['sources'][$report['source']['id']] = $report['sum'];

                //считаем total
                if (!isset($totalValues[$report['source']['id']])) {
                    $totalValues[$report['source']['id']] = 0;
                }
                $totalValues[$report['source']['id']] += $report['sum'];
            }

            $html = view('reports.dailyReport', [
                "reportDateString" => $reportDateString,
                "reportSources" => $reportSources,
                "reportData" => $reportData,
                "totalValues" => $totalValues
            ]);


            $file_name = 'daily_' . $reportDate->format('d_m_y') . ".html";

            Storage::disk('local')->put($file_name, $html);

            $this->exportValue = $file_name;
            $this->exportTitle = 'Ежедневный отчет за ' . $reportDateString;
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
