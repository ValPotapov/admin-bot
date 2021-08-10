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
                @foreach($reportSources as $reportSource)
                    <td>{{$reportSource}}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $reportSalon)
                <tr>
                    <td>{{$reportSalon["salon"]["name"]}}</td>
                    @foreach($reportSalon['sources'] as $salonSourceReport)
                        <td>{{$salonSourceReport}}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>ВСЕГО</td>
                @foreach($reportSources as $reportSourceId => $reportSource)
                    <td>{{$totalValues[$reportSourceId]}}</td>
                @endforeach
            </tr>
        </tfoot>
    </table>
</body>
</html>
