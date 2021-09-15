<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Отчет {{$reportDateString}}</title>
</head>
<body>
    <div class="container">
        <h3>Отчет {{$reportDateString}}</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>САЛОН</td>
                    <td>ОБЩАЯ КАССА</td>
                    <td>НАЛИЧНЫЕ</td>
                    <td>БЕЗНАЛИЧНЫЕ</td>
                    <td>ИНКАССИРОВАНО</td>
                </tr>
            </thead>
            <tbody>
                @foreach($salonsData as $salonData)
                    @if(isset($salonData['empty']))
                        <tr class="table-danger">
                            <td>{{$salonData['salon']['name']}}</td>
                            <td colspan="4" class="text-center">Отчет не заполнен</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{$salonData['salon']['name']}}</td>
                            <td>{{$salonData['cash_total']}}</td>
                            <td>{{$salonData['cash']}}</td>
                            <td>{{$salonData['cashless']}}</td>
                            <td>{{$salonData['collected']}}</td>
                        </tr>
                    @endif
                @endforeach
                <tr></tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><b>ВСЕГО</b></td>
                    <td><b>{{$totalValues['cash_total']}}</b></td>
                    <td><b>{{$totalValues['cash']}}</b></td>
                    <td><b>{{$totalValues['cashless']}}</b></td>
                    <td><b>{{$totalValues['collected']}}</b></td>
                </tr>
            </tfoot>
        </table>
        @foreach($salonsData as $salonData)
            @if(isset($salonData['detailed']))
                <h4 class="mt-5">{{$salonData['salon']['name']}}</h4>
                <table class="table mb-5">
                    <thead>
                        <tr>
                            <td></td>
                            <td>Звонки</td>
                            <td>Пришли</td>
                            <td>Остались</td>
                            <td>Касса</td>
                            <td>Причина ухода</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Агрегаторы</td>
                            <td>{{$salonData['detailed']['aggregators']['number_calls']}}</td>
                            <td>{{$salonData['detailed']['aggregators']['came']}}</td>
                            <td>{{$salonData['detailed']['aggregators']['stayed']}}</td>
                            <td>{{$salonData['detailed']['aggregators']['sum']}}</td>
                            <td>{{$salonData['detailed']['aggregators']['cause'] ?? ''}}</td>
                        </tr>
                        <tr class="table-secondary">
                            <td><b>СОЦСЕТИ</b></td>
                            <td colspan="5"></td>
                        </tr>
                    @foreach($salonData['detailed']['socnets']['rows'] as $socnet)
                        <tr>
                            <td>{{$socnet['source']['name']}}</td>
                            <td>{{$socnet['number_calls']}}</td>
                            <td>{{$socnet['came']}}</td>
                            <td>{{$socnet['stayed']}}</td>
                            <td>{{$socnet['sum']}}</td>
                            <td>{{$socnet['cause'] ?? ''}}</td>
                        </tr>
                    @endforeach
                        <tr class="table-secondary">
                            <td><b>КАССА ОБЩАЯ СОЦСЕТИ</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>{{$salonData['detailed']['socnets']['total']}}</b></td>
                            <td></td>
                        </tr>
                    @foreach($salonData['detailed']['others'] as $report)
                        <tr>
                            <td>{{$report['source']['name']}}</td>
                            <td>{{$report['number_calls']}}</td>
                            <td>{{$report['came']}}</td>
                            <td>{{$report['stayed']}}</td>
                            <td>{{$report['sum']}}</td>
                            <td>{{$report['cause'] ?? ''}}</td>
                        </tr>
                    @endforeach
                        <tr class="table-secondary">
                            <td><b>Инкассация</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>{{$salonData['collected']}}</b></td>
                            <td></td>
                        </tr>
                        <tr class="table-secondary">
                            <td><b>ОБЩАЯ КАССА</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>{{$salonData['cash_total']}}</b></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @endforeach
    </div>
</body>
</html>
