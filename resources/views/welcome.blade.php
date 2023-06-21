<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CartoonPicker</title>
        <script src="{{ asset('js/app.js') }}" defer></script>

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>
        <div class="container">
        <a href="/home">Home</a>
            <div class="container my-2">
                <div>
                    @if ($message = Session::get('error'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert"
                        style="border-radius: 10px">
                        <strong>
                            <p style="margin: 0">{{ $message }}</p>
                        </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @elseif ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                        style="border-radius: 10px">
                        <strong>
                            <p style="margin: 0">{{ $message }}</p>
                        </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                </div>
            </div>
            <h1>CartoonPicker</h1>
            <form action="{{ route('process') }}" method="POST" class="my-2" id="pickerId">
                @csrf
                <div class="cartoons">
                    @foreach ($cartoons as $cartoon)
                    <div class="cartoon" id="cartoon{{$cartoon->cartoon_id}}" onclick="changeBorder(this)">
                        <input hidden type="checkbox" name="cartoons[]" value="{{$cartoon->cartoon_id}}">
                        <p>{{$cartoon->cartoon_name}}</p>
                        <img src="{{ asset('storage/'. $cartoon->cartoon_img) }}" alt="">
                    </div>
                    @endforeach
                </div>
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-dark">
                                <th>#Criteria</th>
                                @foreach ($criteria as $c)
                                <th>{{$c->criteria_name}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#Choose value</td>
                                @foreach ($criteria as $c)
                                <td>
                                    @foreach ($criteria_indicators as $criteria_indicator)
                                    <div>
                                        <input type="radio" name="criteria_indicator{{$c->criteria_id}}"
                                            value={{$criteria_indicator->criteria_indicator_value}}>
                                        {{$criteria_indicator->criteria_indicator_name}}
                                    </div>
                                    @endforeach
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary">Process</button>
            </form>
        </div>
        @isset($results)
        <div class="container">
            <h1>Result</h1>
            <a href="/">Back</a>
            @php
            $ind = 0;
            @endphp
            <div class="cartoonResults">
                @foreach ($results as $result)
                @php
                $ind++;
                @endphp
                <div class="result">
                    <script>
                        var section = document.getElementById("pickerId");
                    section.style.display = "none";
                    </script>
                    <h1># @if($ind < 10) 0{{$ind}}. @else {{$ind}}. @endif</h1>
                            <div class="cartoon">
                                <p>{{$result->cartoon_name}}</p>
                                <img src="{{ asset('storage/'. $result->cartoon_img) }}" alt="">
                            </div>
                </div>
                @endforeach
            </div>
        </div>
        @auth
        <div class="container">
        <a href="/home">Home</a>
            <table class="table">
                <thead>
                    <tr align="center">
                        <th>Criteria</th>
                        @foreach ($weights as $key => $value)
                        @foreach ($criteria_indicators as $criteria_indicator)
                        @if ($value == $criteria_indicator->criteria_indicator_value)
                        <th>{{$key}}
                            <br>
                            <small>({{$criteria_indicator->criteria_indicator_name}})</small>
                        </th>
                        @endif
                        @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <th>Weight</th>
                        @foreach ($weights as $key => $value)
                        <th>{{$value}}</th>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            @php
            $ind = 0;
            @endphp
            <h1>Normalized Matrix</h1>
            <table class="table">
                <thead>
                    <tr align="center">
                        <th>NO</th>
                        <th>Alternative</th>
                        @foreach ($criteria as $c)
                        <th>{{$c->criteria_name}}@if ($c->criteria_type == 'cost') - @else + @endif</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartoons as $cartoon)
                    @foreach ($normalized as $key => $value)
                    @if ($cartoon->cartoon_id == $key)
                    @php $ind++; @endphp
                    <tr align="center">
                        <td># @if($ind < 10) 0{{$ind}}. @else {{$ind}}. @endif</td>
                        <td>{{$cartoon->cartoon_name}}</td>
                        @foreach ($criteria as $c)
                        <td>{{$value[$c->criteria_name]}}</td>
                        @endforeach
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="container">
            @php
            $ind = 0;
            @endphp
            <h1>Weighted Matrix</h1>
            <table class="table">
                <thead>
                    <tr align="center">
                        <th>NO</th>
                        <th>Alternative</th>
                        @foreach ($criteria as $c)
                        <th>{{$c->criteria_name}}@if ($c->criteria_type == 'cost') - @else + @endif</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartoons as $cartoon)
                    @foreach ($weighted as $key => $value)
                    @if ($cartoon->cartoon_id == $key)
                    @php $ind++; @endphp
                    <tr align="center">
                        <td># @if($ind < 10) 0{{$ind}}. @else {{$ind}}. @endif</td>
                        <td>{{$cartoon->cartoon_name}}</td>
                        @foreach ($criteria as $c)
                        <td>{{$value[$c->criteria_name]}}</td>
                        @endforeach
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between">
                <div>
                    @php
                    $ind = 0;
                    @endphp
                    <h1>Max Min Matrix</h1>
                    <table class="table">
                        <thead>
                            <tr align="center">
                                <th>NO</th>
                                <th>Alternative</th>
                                <th>Max</th>
                                <th>Min</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartoons as $cartoon)
                            @foreach ($minMax as $key => $value)
                            @if ($cartoon->cartoon_id == $key)
                            @php $ind++; @endphp
                            <tr align="center">
                                <td># @if($ind < 10) 0{{$ind}}. @else {{$ind}}. @endif</td>
                                <td>{{$cartoon->cartoon_name}}</td>
                                <td>{{$value['max']}}</td>
                                <td>{{$value['min']}}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    <h1>Final Ranking Matrix</h1>
                    <table class="table">
                        <thead>
                            <tr align="center">
                                <th>Rank</th>
                                <th>Alternative</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ranked as $key1 => $value1)
                            @foreach ($cartoons as $cartoon )
                            @if ($cartoon->cartoon_id == $value1)
                            <tr align="center">
                                <td>{{$key1 + 1}}</td>
                                <td>{{$cartoon->cartoon_name}}</td>
                                @foreach ($finalResult as $key => $value)
                                @if ($cartoon->cartoon_id == $key)
                                <td>{{$value}}</td>
                                @endif
                                @endforeach
                            </tr>
                            @endif
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endauth
        @endisset
        <script>
            function changeBorder(input){
                input.firstElementChild.checked = !input.firstElementChild.checked;
                if (input.firstElementChild.checked) {
                    input.className = "cartoon-active";
                } else {
                    input.className = "cartoon";
                }
            }
        </script>
    </body>

</html>