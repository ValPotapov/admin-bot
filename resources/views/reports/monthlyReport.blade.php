<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Ежемесячный отчет {{$monthlyReport['reportDateString']}}</title>
</head>
<body>
<div class="container">
    <h3>Ежемесячный отчет {{$monthlyReport['reportDateString']}}</h3>
    <div class="row">
        <div class="col col-sm-9 col-xs-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td colspan="{{2+count($monthlyReport['cashReport']['salons'])}}">ИНКАССАЦИЯ ЗА {{$monthlyReport['reportDateString']}}</td>
                    </tr>
                    <tr>
                        <td>ДАТА</td>
                        @foreach($monthlyReport['cashReport']['salons'] as $salon)
                            <td>{{$salon}}</td>
                        @endforeach
                        <td><b>За день</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyReport['cashReport']['days'] as $dayName => $day)
                        <tr>
                            <td>{{$dayName}}</td>
                            @foreach($monthlyReport['cashReport']['salons'] as $salonName)
                                <td>{{$day['salons'][$salonName] ?? '0'}}</td>
                            @endforeach
                            <td><b>{{$day['total']}}</b></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
