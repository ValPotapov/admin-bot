<?php

namespace App\Reports;

use App\Models\Report;
use App\Models\Salon;
use App\Models\Source;
use Illuminate\Support\Facades\Storage;

class DailyReport
{
    protected $dataParams;
    protected $exportType = 'link';
    protected $exportValue;
    protected $exportTitle = '';
    protected $view = null;

    public function __construct($dataParams = []){
        $this->dataParams = $dataParams;

        if(isset($dataParams['reportDate'])){
            $reportDate = \Carbon\Carbon::parse($dataParams['reportDate']);
            $reportDateString = $reportDate->format('d M y');
        }else{
            $reportDate = \Carbon\Carbon::now()->yesterday();
            $reportDateString = $reportDate->format('d M y');
        }

        $reports = Report::with(['salon','source'])
            ->where('date',$reportDate->format('Y-m-d'))
            ->orderBy(Source::select('name')
                ->whereColumn('sources.id', 'reports.source_id')
            )
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
                        'collected' => 0,
                        'detailed' => [
                            'aggregators' => [],
                            'socnets' => [
                                'rows' => [],
                                'total' => 0
                            ],
                            'others' => []
                        ]
                    ];
                }

                switch ($report['source']['name']) {
                    case 'Безналичные':
                        $salonsData[$report['salon']['id']]['cashless'] = $report['sum'];
                        $totalValues['cashless'] += $report['sum'];
                        break;
                    case 'Инкассация':
                        $salonsData[$report['salon']['id']]['collected'] = $report['sum'];
                        $totalValues['collected'] += $report['sum'];
                        break;
                    default:
                        $salonsData[$report['salon']['id']]['cash'] += $report['sum'];
                        $totalValues['cash'] += $report['sum'];
                }

                $salonsData[$report['salon']['id']]['cash_total']+= $report['sum'];
                $totalValues['cash_total'] += $report['sum'];

                //детальный отчет по салону
                if($report['source']['name']!=='Безналичные' && $report['source']['name']!=='Инкассация'){
                    if($report['source']['name'] == 'Агрегаторы'){
                        $salonsData[$report['salon']['id']]['detailed']['aggregators'] = $report;
                    }elseif ($report['source']['name'] == 'Соцсети салона' || strpos($report['source']['name'],'Менеджер')!==false){
                        $salonsData[$report['salon']['id']]['detailed']['socnets']['rows'][] = $report;
                        $salonsData[$report['salon']['id']]['detailed']['socnets']['total']+= $report['sum'];
                    }else{
                        $salonsData[$report['salon']['id']]['detailed']['others'][] = $report;
                    }
                }
            }

            //собираем салоны, не заполнившие отчет
            $missingSalons = Salon::query()
                ->whereNotIn('id',array_keys($salonsData))
                ->orderBy('id','ASC')
                ->get()
                ->toArray();

            foreach ($missingSalons as $missingSalon){
                $salonsData[$missingSalon['id']] = [
                    'salon' => $missingSalon,
                    'empty' => true
                ];
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

            $this->view = $html;
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

    public function getView(){
        return $this->view;
    }
}
