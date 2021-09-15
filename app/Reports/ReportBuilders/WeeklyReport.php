<?php

namespace App\Reports\ReportBuilders;

use App\Models\Expenses;
use App\Models\ExpensesTypes;
use App\Models\Report;
use App\Models\Source;

class WeeklyReport
{
    static function build(){
        $reportDateFrom = \Carbon\Carbon::create(2021,8,20);//\Carbon\Carbon::yesterday()->subDays(7);
        $reportDateFromString = $reportDateFrom->format('d M y');

        $reportDateTo = \Carbon\Carbon::create(2021,8,27);//\Carbon\Carbon::yesterday();
        $reportDateToString = $reportDateTo->format('d M y');

        $reportSources = [
            'Авито салона',
            'Рабочая Постоянщики',
            //'Такси',
            //'Досуг',
            'Соцсети',
            'Промо',
            'Рабочая Новые',
        ];
        $sourcesToReport = Source::whereIn('name',$reportSources)->pluck('id','name');

        $reports = Report::with(['salon','source'])
            ->whereBetween('date',[$reportDateFrom->format('Y-m-d'),$reportDateTo->format('Y-m-d')])
            ->whereIn('source_id',$sourcesToReport)
            ->orderBy('salon_id','ASC')
            ->get()
            ->toArray();

        $salonsData = [];
        $totalValues = [
            'total' => 0
        ];
        if($reports) {
            foreach ($reports as $report) {
                if (!isset($salonsData[$report['salon']['id']])) {
                    $salonsData[$report['salon']['id']] = [
                        'salon' => $report['salon'],
                        'spa_total' => 0
                    ];
                }

                $salonsData[$report['salon']['id']]['spa_total'] += $report['sum'];

                if (!isset($salonsData[$report['salon']['id']][$report['source']['name']]))
                    $salonsData[$report['salon']['id']][$report['source']['name']] = 0;
                $salonsData[$report['salon']['id']][$report['source']['name']] += $report['sum'];

                $totalValues['total'] += $report['sum'];
                if (!isset($totalValues[$report['source']['name']]))
                    $totalValues[$report['source']['name']] = 0;
                $totalValues[$report['source']['name']] += $report['sum'];
            }
        }


        //Отчет по неделям
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $reports = Report::with(['salon','source'])
            ->whereDate('date','>=', $startOfMonth)
            ->whereIn('source_id',$sourcesToReport)
            ->orderBy('date','ASC')
            ->get()
            ->toArray();

        $weeksReport = [
            'total' => 0,
            'salons' => [],
            'weeks_involved' => []
        ];
        foreach ($reports as $report){
            $reportDate = \Carbon\Carbon::createFromFormat('Y-m-d',$report['date']);
            $weekNumber = $reportDate->weekOfMonth;

            if(!in_array($weekNumber,$weeksReport['weeks_involved'])){
                $weeksReport['weeks_involved'][] = $weekNumber;
            }

            if(!isset($weeksReport['salons'][$report['salon']['name']])){
                $weeksReport['salons'][$report['salon']['name']] = [
                    'income' => [],
                    'total_income' => 0
                ];
            }

            //доход по неделе
            if(!isset($weeksReport['salons'][$report['salon']['name']]['income'][$weekNumber])){
                $weeksReport['salons'][$report['salon']['name']]['income'][$weekNumber]=0;
            }
            $weeksReport['salons'][$report['salon']['name']]['income'][$weekNumber]+= $report['sum'];

            //общий доход салона
            $weeksReport['salons'][$report['salon']['name']]['total_income']+= $report['sum'];

            //Общий доход
            $weeksReport['total']+= $report['sum'];
        }

        $expensesToReport = [
            "Досуг",
            "Контекст Гугл",
            "Контекст Яндекс"
        ];
        $expensesToReport = ExpensesTypes::whereIn('name',$expensesToReport)->pluck('id');

        $expenses = Expenses::with(['contractor','type'])
            ->whereDate('date','>=', $startOfMonth)
            ->whereIn('expenseTypeId',$expensesToReport)
            ->orderBy('date','ASC')
            ->get()
            ->toArray();

        foreach ($expenses as $expense){
            $expenseDate = \Carbon\Carbon::createFromFormat('Y-m-d',$expense['date']);
            $weekNumber = $expenseDate->weekOfMonth;

            if(!in_array($weekNumber,$weeksReport['weeks_involved'])){
                $weeksReport['weeks_involved'][] = $weekNumber;
            }

            //тип расхода по неделям
            $weeksReport['expenses'][$expense['type']['name']]['weekly'][$weekNumber] = $expense['sum'];

            //общее значение по типу расхода
            if(!isset($weeksReport['expenses'][$expense['type']['name']]['total'])){
                $weeksReport['expenses'][$expense['type']['name']]['total'] = 0;
            }
            $weeksReport['expenses'][$expense['type']['name']]['total']+= $expense['sum'];
        }
        sort($weeksReport['weeks_involved']);



        //Отчет по менеджерам
        $sourcesToReport = Source::where('name','LIKE','Менеджер%')->pluck('id');

        $reports = Report::with(['salon','source'])
            ->whereBetween('date',[$reportDateFrom->format('Y-m-d'),$reportDateTo->format('Y-m-d')])
            ->whereIn('source_id',$sourcesToReport)
            ->orderBy('salon_id','ASC')
            ->get()
            ->toArray();

        $managersReport = [
            'visitors_total' => 0,
            'total' => 0
        ];
        foreach ($reports as $report){
            if(!isset($managersReport['salons'][$report['salon']['name']])){
                $managersReport['salons'][$report['salon']['name']] = [
                    'visitors' => 0,
                    'income' => 0
                ];
            }
            $managersReport['salons'][$report['salon']['name']]['visitors']+= $report['stayed'];
            $managersReport['salons'][$report['salon']['name']]['income']+= $report['sum'];

            //total
            $managersReport['visitors_total']+= $report['stayed'];
            $managersReport['total']+= $report['sum'];
        }


        //Доход соцсетей
        $reportSources = [
            'Соцсети салона',
            'Авито салона'
        ];
        $sourcesToReport = Source::whereIn('name',$reportSources)->pluck('id','name');

        $reports = Report::with(['salon','source'])
            ->whereBetween('date',[$reportDateFrom->format('Y-m-d'),$reportDateTo->format('Y-m-d')])
            ->whereIn('source_id',$sourcesToReport)
            ->orderBy('salon_id','ASC')
            ->orderBy('source_id','ASC')
            ->get()
            ->toArray();

        $socNetsReport = [
            'income' => [
                'sources' => [],
                'salons' => [],
                'total' => [],
                'overall' => 0
            ]
        ];
        foreach ($reports as $report){
            if(!in_array($report['source']['name'],$socNetsReport['income']['sources'])){
                $socNetsReport['income']['sources'][] = $report['source']['name'];
            }

            if(!isset($socNetsReport['income']['salons'][$report['salon']['name']][$report['source']['name']])){
                $socNetsReport['income']['salons'][$report['salon']['name']][$report['source']['name']] = 0;
            }
            $socNetsReport['income']['salons'][$report['salon']['name']][$report['source']['name']]+= $report['sum'];

            if(!isset($socNetsReport['income']['total'][$report['source']['name']])) {
                $socNetsReport['income']['total'][$report['source']['name']] = 0;
            }
            $socNetsReport['income']['total'][$report['source']['name']]+= $report['sum'];

            $socNetsReport['income']['overall']+= $report['sum'];
        }

        //Общий расход соцсетей
        $expensesToReport = [
            "ЗП менеджеры",
        ];
        $expensesToReport = ExpensesTypes::whereIn('name',$expensesToReport)->pluck('id');

        $expenses = Expenses::with(['contractor','type'])
            ->whereDate('date','>=', $startOfMonth)
            ->whereIn('expenseTypeId',$expensesToReport)
            ->get()
            ->toArray();

        $totalExpensesReport = [
            'types' => [],
            'total' => 0
        ];
        foreach ($expenses as $expense){
            if(!isset($totalExpensesReport['types'][$expense['type']['name']])) {
                $totalExpensesReport['types'][$expense['type']['name']] = 0;
            }
            $totalExpensesReport['types'][$expense['type']['name']]+= $expense['sum'];

            $totalExpensesReport['total']+= $expense['sum'];
        }


        return [
            "reportDateFrom" => $reportDateFrom->format('d_m_y'),
            "reportDateTo" => $reportDateTo->format('d_m_y'),
            "weeklyReport" => [
                "reportDateFromString" => $reportDateFromString,
                "reportDateToString" => $reportDateToString,
                "reportSources" => $reportSources,
                "salonsData" => $salonsData,
                "totalValues" => $totalValues
            ],
            'weeksReport'=> $weeksReport,
            'managersReport' => $managersReport,
            'socNetsReport' => $socNetsReport,
            'totalExpensesReport' => $totalExpensesReport
        ];
    }
}
