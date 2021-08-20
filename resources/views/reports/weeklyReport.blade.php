<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Еженедельный отчет {{$weeklyReport['reportDateFromString']}} - {{$weeklyReport['reportDateToString']}}</title>
</head>
<body>
<div class="container">
    <h3>Еженедельный отчет {{$weeklyReport['reportDateFromString']}} - {{$weeklyReport['reportDateToString']}}</h3>
    <div class="row">
        <div class="col col-sm-9 col-xs-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>САЛОН</td>
                        @foreach($weeklyReport['reportSources'] as $reportSource)
                            <td>{{$reportSource}}</td>
                        @endforeach
                        <td>Досуг</td>
                        <td>Такси</td>
                        <td><b>ВСЕГО ОТ СПА</b></td>
                    </tr>
                </thead>
                <tbody>
                @foreach($weeklyReport['salonsData'] as $reportSalon)
                    <tr>
                        <td>{{$reportSalon["salon"]["name"]}}</td>
                        @foreach($weeklyReport['reportSources'] as $reportSource)
                            <td>{{$reportSalon[$reportSource] ?? '00.0'}}</td>
                        @endforeach
                        <td></td>
                        <td></td>
                        <td><b>{{$reportSalon['spa_total']}}</b></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col col-sm-3 col-xs-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td colspan="2">Общий итог</td>
                </tr>
                </thead>
                <tbody>
                    @foreach($weeklyReport['totalValues'] as $totalValueKey => $totalValue)
                        @if($totalValueKey !== 'total')
                            <tr>
                                <td>{{$totalValueKey}}</td>
                                <td>{{$totalValue}}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td><b>Месяц все</b></td>
                        <td><b>{{$weeklyReport['totalValues']['total']}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>




        <h5>Отчет по менеджерам и соцсетям</h5>
        <div class="col col-xs-12 col-sm-6">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Менеджеры</td>
                    <td>Кол. гостей</td>
                    <td>Доход</td>
                </tr>
                </thead>
                <tbody>
                @foreach($managersReport['salons'] as $salonName => $report)
                    <tr>
                        <td>{{$salonName}}</td>
                        <td>{{$report['visitors']}}</td>
                        <td>{{$report['income']}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>ИТОГО</td>
                        <td>{{$managersReport["visitors_total"]}}</td>
                        <td>{{$managersReport["total"]}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col col-xs-12 col-sm-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Салоны</td>
                        @foreach($socNetsReport['income']['sources'] as $source)
                            <td>{{$source}}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($socNetsReport['income']['salons'] as $salonName => $salon)
                    <tr>
                        <td>{{$salonName}}</td>
                        @foreach($salon as $salonSourceValue)
                            <td>{{$salonSourceValue}}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td>ИТОГО</td>
                    @foreach($socNetsReport['income']['total'] as $total)
                        <td>{{$total}}</td>
                    @endforeach
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="col col-xs-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td colspan="2">Общий доход соцсетей</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Менеджеры</td>
                        <td>{{$managersReport["total"]}}</td>
                    </tr>
                    <tr>
                        <td>Салоны</td>
                        <td>{{$socNetsReport['income']['overall']}}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>ВСЕГО</td>
                        <td>{{$managersReport["total"] + $socNetsReport['income']['overall']}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col col-xs-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td colspan="2">Общий расход соцсетей</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($totalExpensesReport['types'] as $expenseName => $expense)
                        <tr>
                            <td>{{$expenseName}}</td>
                            <td>{{$expense}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>ВСЕГО</td>
                        <td>{{$totalExpensesReport['total']}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>




        <h3 class="mt-5">Отчет по неделям</h3>
        <div class="col col-xs-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>НЕДЕЛЯ</td>
                        @foreach($weeksReport['weeks_involved'] as $week)
                            <td>{{$week}} нед.</td>
                        @endforeach
                        <td>ИТОГО</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weeksReport['salons'] as $salonName => $salon)
                        <tr>
                            <td>{{$salonName}}</td>
                            @foreach($weeksReport['weeks_involved'] as $week)
                                <td>{{$salon['income'][$week] ?? '0.00'}}</td>
                            @endforeach
                            <td>{{$salon['total_income']}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><b>Общий ИТОГ</b></td>
                        @php
                            echo str_repeat("<td></td>",count($weeksReport['weeks_involved']))
                        @endphp
                        <td><b>{{$weeksReport['total']}}</b></td>
                    </tr>
                    @foreach($weeksReport['expenses'] as $expenseName => $expense)
                        <tr>
                            <td>{{$expenseName}}</td>
                            @foreach($weeksReport['weeks_involved'] as $week)
                                <td>{{$expense['weekly'][$week] ?? '0.00'}}</td>
                            @endforeach
                            <td>{{$expense['total']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
