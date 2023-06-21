@extends('layouts.app')

@section('content')
<div class="container">
    @if ($message = Session::get('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 10px">
        <strong>
            <p style="margin: 0">{{ $message }}</p>
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px">
        <strong>
            <p style="margin: 0">{{ $message }}</p>
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div>
        <div class="d-flex flex-wrap justify-content-between">
            <div>
                <form action="{{ route('addCriteria') }}" method="POST" id="addCriteriaForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal fade" id="addCriteria" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="addCriteria" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCriteriaLabel">
                                        Add Criteria
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="cartoonName">Criteria Name</label>
                                        <input type="text" class="form-control" id="criteriaName"
                                            placeholder="Criteria Name" name="criteriaName">
                                        <label for="cartoonType">Criteria Type</label>
                                        <select class="form-control" id="criteriaType" name="criteriaType">
                                            <option value="benefit">Benefit</option>
                                            <option value="cost">Cost</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <a onclick="$('#addCriteriaForm').submit();" type="button"
                                            class="btn btn-sm btn-primary">Add</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="d-flex">
                    <h1>Criteria List: {{count($criteria)}}</h1>
                    <a class="align-self-center btn btn-sm ms-auto btn-success" data-bs-toggle="modal"
                        data-bs-target="#addCriteria">Add</a>
                </div style="justify-self-stretch">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#NO</th>
                            <th>Criteria Name</th>
                            <th>Criteria Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($criteria as $c)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$c->criteria_name}}</td>
                            <td>{{$c->criteria_type}}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('editCriteria', $c) }}"
                                        id="formEditCriteria{{$c->criteria_id}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal fade" id="editCriteria{{$c->criteria_id}}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="editCriteria{{$c->criteria_id}}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editCriteria{{$c->criteria_id}}Label">
                                                            {{$c->criteria_name}}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="cartoonName">Criteria Name</label>
                                                        <input type="text" class="form-control"
                                                            id="criteriaName{{$c->criteria_id}}"
                                                            placeholder="{{$c->criteria_name}}"
                                                            value="{{$c->criteria_name}}" name="criteriaName">
                                                        <label for="cartoonType">Criteria Type</label>
                                                        <select class="form-control"
                                                            id="criteriaType{{$c->criteria_id}}" name="criteriaType">
                                                            @if ($c->criteria_type == 'benefit')
                                                            <option value="benefit" selected>Benefit</option>
                                                            <option value="cost">Cost</option>
                                                            @else
                                                            <option value="benefit">Benefit</option>
                                                            <option value="cost" selected>Cost</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <a onclick="$('#formEditCriteria{{$c->criteria_id}}').submit();"
                                                            type="button" class="btn btn-sm btn-primary">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                        data-bs-target="#editCriteria{{$c->criteria_id}}">Edit</a>
                                    <form action="{{ route('deleteCriteria', $c) }}"
                                        id="formdeleteCriteria{{$c->criteria_id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal fade" id="deleteCriteria{{$c->criteria_id}}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="deleteCriteria{{$c->criteria_id}}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteCriteria{{$c->criteria_id}}Label">
                                                            {{$c->criteria_name}}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="alert alert-warning p-2">
                                                            Are you sure you want to delete {{$c->criteria_name}}?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <a onclick="$('#formdeleteCriteria{{$c->criteria_id}}').submit();"
                                                            type="button" class="btn btn-sm btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteCriteria{{$c->criteria_id}}">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <form action="{{ route('addCriteriaIndicator') }}" method="POST" id="addCriteriaIndicatorForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal fade" id="addCriteriaIndicator" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="addCriteriaIndicator" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCriteriaLabel">
                                        Add Criteria Indicator
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="cartoonName">Criteria Indicator Name</label>
                                        <input type="text" class="form-control" id="criteriaIndicatorName"
                                            placeholder="Criteria Indicator Name" name="criteriaIndicatorName">
                                        <label for="cartoonType">Criteria Value</label>
                                        <input type="number" class="form-control" id="criteriaIndicatorValue"
                                            placeholder="0" name="criteriaIndicatorValue">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <a onclick="$('#addCriteriaIndicatorForm').submit();" type="button"
                                            class="btn btn-sm btn-primary">Add</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="d-flex">
                    <h1>Criteria Indicators: {{count($criteria_indicators)}}</h1>
                    <a class="align-self-center btn btn-sm ms-auto btn-success" data-bs-toggle="modal"
                        data-bs-target="#addCriteriaIndicator">Add</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#NO</th>
                            <th>Criteria Indicator Name</th>
                            <th>Criteria Indicator Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($criteria_indicators as $ci)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$ci->criteria_indicator_name}}</td>
                            <td>{{$ci->criteria_indicator_value}}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('editCriteriaIndicator', $ci) }}"
                                        id="formEditCriteriaIndicator{{$ci->criteria_indicator_id}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal fade" id="editCriteriaIndicator{{$ci->criteria_indicator_id}}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="deleteCartoon{{$ci->criteria_indicator_id}}Label"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editCriteriaIndicator{{$ci->criteria_indicator_id}}Label">
                                                            {{$ci->criteria_indicator_name}}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="cartoonName">Criteria Name</label>
                                                        <input type="text" class="form-control"
                                                            id="criteriaIndicatorName{{$ci->criteria_indicator_name}}"
                                                            placeholder="{{$ci->criteria_indicator_name}}"
                                                            value="{{$ci->criteria_indicator_name}}"
                                                            name="criteriaIndicatorName">
                                                        <label for="cartoonType">Criteria Value</label>
                                                        <input type="number" class="form-control"
                                                            id="criteriaIndicatorValue{{$ci->criteria_indicator_name}}"
                                                            placeholder="{{$c->criteria_indicator_value}}"
                                                            value="{{$ci->criteria_indicator_value}}"
                                                            name="criteriaIndicatorValue">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <a onclick="$('#formEditCriteriaIndicator{{$ci->criteria_indicator_id}}').submit();"
                                                            type="button" class="btn btn-sm btn-primary">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                        data-bs-target="#editCriteriaIndicator{{$ci->criteria_indicator_id}}">Edit</a>
                                    <form action="{{ route('deleteCriteriaIndicator', $ci) }}"
                                        id="formdeleteCriteriaIndicator{{$ci->criteria_indicator_id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal fade"
                                            id="deleteCriteriaIndicator{{$ci->criteria_indicator_id}}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="deleteCriteriaIndicator{{$ci->criteria_indicator_id}}Label"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteCriteriaIndicator{{$ci->criteria_indicator_id}}Label">
                                                            {{$ci->criteria_indicator_name}}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="alert alert-warning p-2">
                                                            Are you sure you want to delete
                                                            {{$ci->criteria_indicator_name}}?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <a onclick="$('#formdeleteCriteriaIndicator{{$ci->criteria_indicator_id}}').submit();"
                                                            type="button" class="btn btn-sm btn-danger">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteCriteriaIndicator{{$ci->criteria_indicator_id}}">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <form action="{{ route('addCartoon') }}" method="POST" id="addCartoonForm" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="modal fade" id="addCartoon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="addCartoon" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCartoonLabel">
                                Add Cartoon
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="cartoonName">Cartoon Name</label>
                                <input type="text" class="form-control" id="cartoonName" placeholder="Cartoon Name"
                                    name="cartoonName">
                            </div>
                            <div class="form-group my-2">
                                <label for="cartoonImg">Cartoon Image</label>
                                <input type="file" class="form-control" id="cartoonImg" placeholder="Cartoon Image"
                                    name="cartoonImg">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <a onclick="$('#addCartoonForm').submit();" type="button"
                                    class="btn btn-sm btn-primary">Add</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form hidden action="{{ route('deleteSelectedCartoon') }}" method="POST" id="deleteSelectedCartoonForm">
            @csrf
            @method('DELETE')
            @foreach ($cartoons as $cartoon)
            <input id="cartoonsSelected" type="checkbox" name="cartoons[]" value="{{$cartoon->cartoon_id}}">
            @endforeach
        </form>
        <form action="{{ route('process') }}" method="POST" id="resultsCartoonForm">
            @csrf
            @foreach ($cartoons as $cartoon)
            <input hidden id="resultCartoonsSelected" type="checkbox" name="cartoons[]" value="{{$cartoon->cartoon_id}}"
                checked>
            @endforeach
            <div id="criteria" style="display: none">
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
                <button class="btn btn-sm btn-primary" type="submit">Process</button>
            </div>
        </form>
        <form action="{{ route('updateData') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="d-flex">
                <h1>List of Catoons: {{count($cartoons)}}</h1>
                <div class="d-flex ms-auto">
                    <a style="display: none" class="btn btn-sm btn-danger align-self-center" id="deleteSelectedbtn"
                        onclick="$('#deleteSelectedCartoonForm').submit();">
                    </a>
                    <a class="btn btn-sm btn-secondary ms-2 align-self-center" id="resultSelectedbtn"
                        onclick="$('#criteria').slideToggle();">Results</a>
                    <a class="btn btn-sm btn-success mx-2 align-self-center" data-bs-toggle="modal"
                        data-bs-target="#addCartoon">Add</a>
                    <button class="btn btn-sm btn-primary align-self-center" type="submit">Update</button>
                </div>
            </div>
            <table class="mt-1 table table-hover table-bordered">
                <thead>
                    <tr valign="top">
                        <th>Alternative / Criteria</th>
                        @foreach ($criteria as $c)
                        <th>{{$c->criteria_name}}
                            @if ($c->criteria_type == 'cost') - @else + @endif</th>
                        </th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartoons as $cartoon)
                    <tr>
                        <td>
                            <div class="cartoon" onclick="check(this)">
                                <input hidden id="cartoons" type="checkbox" name="cartoons[]"
                                    value="{{$cartoon->cartoon_id}}">
                                <p>{{$cartoon->cartoon_name}}</p>
                                <a data-bs-toggle="modal" data-bs-target="#editCartoonImage{{$cartoon->cartoon_id}}">
                                    <img src="{{ asset('storage/'. $cartoon->cartoon_img) }}" alt="">
                                </a>
                            </div>
                        </td>
                        @foreach ($criteria as $c)
                        <td><input class="inputTable form-control"
                                name="table-{{$cartoon->cartoon_id}}-{{$c->criteria_id}}" type="number" step=any
                                placeholder="{!! $cartoon->{$c->criteria_name} !!}"
                                value="{!! $cartoon->{$c->criteria_name} !!}"></td>
                        @endforeach
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-sm btn-info mx-1" data-bs-toggle="modal"
                                    data-bs-target="#editCartoon{{$cartoon->cartoon_id}}">Edit</a>
                                <a class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteCartoon{{$cartoon->cartoon_id}}">Delete</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
        @foreach ($cartoons as $cartoon)
        <form action="{{ route('editDataCartoon', $cartoon) }}" id="formCartoon{{$cartoon->cartoon_id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal fade" id="editCartoon{{$cartoon->cartoon_id}}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteCartoon{{$cartoon->cartoon_id}}Label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCartoon{{$cartoon->cartoon_id}}Label">
                                {{$cartoon->cartoon_name}}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input class="form-control" type="text" name="cartoon_name"
                                placeholder="{{$cartoon->cartoon_name}}" value="{{$cartoon->cartoon_name}}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <a onclick="$('#formCartoon{{$cartoon->cartoon_id}}').submit();" type="button"
                                class="btn btn-sm btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{ route('editCartoonImage', $cartoon) }}" id="formCartoonImage{{$cartoon->cartoon_id}}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal fade" id="editCartoonImage{{$cartoon->cartoon_id}}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteCartoon{{$cartoon->cartoon_id}}Label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCartoonImage{{$cartoon->cartoon_id}}Label">
                                {{$cartoon->cartoon_name}}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset('storage/'. $cartoon->cartoon_img) }}" alt="" class="img-fluid"
                                style="width: 100%; border-radius: 20px; margin-bottom: 10px;">
                            <input class="form-control" type="file" name="cartoonImg">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <a onclick="$('#formCartoonImage{{$cartoon->cartoon_id}}').submit();" type="button"
                                class="btn btn-sm btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{ route('deleteCartoon', $cartoon) }}" id="formdeleteCartoon{{$cartoon->cartoon_id}}"
            method="POST">
            @csrf
            @method('DELETE')
            <div class="modal fade" id="deleteCartoon{{$cartoon->cartoon_id}}" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteCartoon{{$cartoon->cartoon_id}}Label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCartoon{{$cartoon->cartoon_id}}Label">
                                {{$cartoon->cartoon_name}}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="alert alert-warning p-2">
                                Are you sure you want to delete {{$cartoon->cartoon_name}}?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <a onclick="$('#formdeleteCartoon{{$cartoon->cartoon_id}}').submit();" type="button"
                                class="btn btn-sm btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endforeach
    </div>
</div>
<script>
    function check(input){
        input.firstElementChild.checked = !input.firstElementChild.checked;
        if (input.firstElementChild.checked) {
            input.className = "cartoon-active";
        } else {
            input.className = "cartoon";
        }
        var check = false;
        var count = 0;
        const cb = document.querySelectorAll('#cartoons');
        const cbSelected = document.querySelectorAll('#cartoonsSelected');
        const cbResultSelected = document.querySelectorAll('#resultCartoonsSelected');
        for (let i = 0; i < cb.length; i++) {
            if(cb[i].checked){
                cbSelected[i].checked = true;
                cbResultSelected[i].checked = true;
                check = true;
                count++;
            }else{
                cbSelected[i].checked = false;
                cbResultSelected[i].checked = false;
            }
        }
        deleteSelectedbtn = document.querySelector('#deleteSelectedbtn');
        resultSelectedbtn = document.querySelector('#resultSelectedbtn');
        deleteSelectedbtn.textContent = 'Delete (' + count + ')';
        if (count > 0) {
            resultSelectedbtn.textContent = 'Result (' + count + ')';
        }
        else {
            for (let i = 0; i < cbResultSelected.length; i++) {
                cbResultSelected[i].checked = true;
            }
            resultSelectedbtn.textContent = 'Result';
        }
        deleteSelectedbtn.style.display = check ? 'block' : 'none';
        console.log(count);
    }
</script>
@endsection