<head>
    <title>{{ $sheet->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/handsontable/2.0.0/handsontable.min.css" t
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<br>
<h2>{{ $sheet->name }}</h2>
<div id="sheet"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/handsontable/2.0.0/handsontable.min.js"></script>
<script>
    let data = @json($sheet->content);

    let container = document.getElementById('sheet');
    let table = new Handsontable(container, {
        data: data,
        rowHeaders: true,
        colHeaders: true,
        minCols: 20,
        minRows: 20,
        afterChange: function (change, source) {
            if (source === 'loadData') return;

            console.log(change, source);

            fetch('/sheets/{{ $sheet->_id }}', {
                method: 'PUT',
                body: JSON.stringify({content: data}),
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
        }
    });
</script>
