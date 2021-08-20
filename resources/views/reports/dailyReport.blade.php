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
                <tr>
                    <td>{{$salonData['salon']['name']}}</td>
                    <td>{{$salonData['cash_total']}}</td>
                    <td>{{$salonData['cash']}}</td>
                    <td>{{$salonData['cashless']}}</td>
                    <td>{{$salonData['collected']}}</td>
                </tr>
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
</body>
</html>
