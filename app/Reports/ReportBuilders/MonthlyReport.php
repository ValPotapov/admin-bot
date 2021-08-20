<?php

namespace App\Reports\ReportBuilders;

use App\Models\Report;
use App\Models\Source;

class MonthlyReport
{
    static function build(){
        $reportDate = \Carbon\Carbon::now();

        $monthStart = $reportDate->startOfMonth();

        $reportSources = [
            'Инкассация',
        ];
        $sourcesToReport = Source::whereIn('name',$reportSources)->pluck('id')->toArray();

        $reports = Report::with(['salon','source'])
            ->whereDate('date','>=',$monthStart)
            ->whereIn('source_id',$sourcesToReport)
            ->orderBy('date','ASC')
            ->orderBy('salon_id','ASC')
            ->get()
            ->toArray();

        $cashReport = [
            'salons' => [],
            'days' => [],
        ];
        foreach ($reports as $report){
            if(!in_array($report['salon']['name'],$cashReport['salons'])){
                $cashReport['salons'][] = $report['salon']['name'];
            }

            $reportItemDate = \Carbon\Carbon::createFromFormat('Y-m-d',$report['date'])->format('d.m.y');
            if(!isset($cashReport['days'][$reportItemDate])){
                $cashReport['days'][$reportItemDate] = [
                    'salons' => [],
                    'total' => 0
                ];
            }

            $cashReport['days'][$reportItemDate]['salons'][$report['salon']['name']] = $report['sum'];
            $cashReport['days'][$reportItemDate]['total']+= $report['sum'];
        }

        return [
            'reportDate'=>$reportDate->format('m_Y'),
            'reportDateString'=>$reportDate->format('M Y'),
            'cashReport' => $cashReport
        ];
    }
}
