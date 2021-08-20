<?php

namespace App\Reports;

use App\Models\Report;
use App\Models\Source;
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
            $salonsData = [];
            $totalValues = [
                'cash_total' => 0,
                'cash' => 0,
                'cashless' => 0,
                'collected' => 0
            ];
            foreach ($reports as $report) {
                if (!isset($salonsData[$report['salon']['id']])) {
                    $salonsData[$report['salon']['id']] = [
                        'salon' => $report['salon'],
                        'cash_total' => 0,
                        'cash' => 0,
                        'cashless' => 0,
                        'collected' => 0
                    ];
                }

                if($report['source']['name'] === 'Наличные') {
                    $salonsData[$report['salon']['id']]['cash'] = $report['sum'];
                    $totalValues['cash'] += $report['sum'];
                }

                if($report['source']['name'] === 'Безналичные') {
                    $salonsData[$report['salon']['id']]['cashless'] = $report['sum'];
                    $totalValues['cashless'] += $report['sum'];
                }

                if($report['source']['name'] === 'Инкассация') {
                    $salonsData[$report['salon']['id']]['collected'] = $report['sum'];
                    $totalValues['collected'] += $report['sum'];
                }

                $salonsData[$report['salon']['id']]['cash_total']+= $report['sum'];
                $totalValues['cash_total'] += $report['sum'];
            }

            $html = view('reports.dailyReport', [
                "reportDateString" => $reportDateString,
                "salonsData" => $salonsData,
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
