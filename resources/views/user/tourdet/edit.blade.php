@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Rule</div>
                <div class="panel-body">
                    @if($Tournament > 0 )
                        <form id="frm" class="form-horizontal" role="form" method="POST" action="/tour/{{$Tournament}}/tourdet/{{$Tour_Det->rule_id}}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label for="shiftid" class="col-md-4 control-label">Select Rule</label>
                            <div class="col-md-6">
                                <select name="rule" class="form-control">
                                    <option  value="0" selected disabled>Select Rule</option>
                                    @foreach($Rules as $Rule)
                                        <option @if($Rule->id == $Tour_Det->rule_id) selected @endif value="{{$Rule->id}}">{{$Rule->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--                        
                        <div class="form-group">
                            <label for="specification" class="col-md-4 control-label">Specification</label>
                            <div class="col-md-6">
                                <input id="specification" type="text" class="form-control" name="specification" value="" autofocus required="" > 
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label for="value" class="col-md-4 control-label">Value</label>
                            <div class="col-md-6">
                                <input id="value" type="text" class="form-control" name="value" value="{{$Tour_Det->value}}" autofocus required="" > 
                            </div>
                        </div>
<!--                        
                        <div class="form-group">
                            <label for="range_from" class="col-md-4 control-label">Range From</label>
                            <div class="col-md-6">
                                <input id="range_from" type="number" class="form-control" name="range_from" value="" autofocus required="" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="range_to" class="col-md-4 control-label">Range To</label>
                            <div class="col-md-6">
                                <input id="range_to" type="number" class="form-control" name="range_to" value="" autofocus required="" > 
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                <button type="button" style="width: 100%" onclick="Validateform();" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        <div class=" col-md-12 col-sm-12 col-xs-12">
                            @if(count($errors) > 0)
                                <div class="from-group" >
                                    <div class="col-md-6 col-md-offset-4 alert alert-danger" style="margin-top: 10px;">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function Validateform(){
//        if($('#name').val() == "" || $('#name').val() == "undefined" || $('#name').val() == "NaN"){
//            alert('Please Enter Organisation Name');
//            return;
//        }else{
//            if($("#name").val().length > 70){
//                alert('Organisation Name Is Too Long');
//                return;
//            }
//        }
//        if($('#business_type').val() == "" || $('#business_type').val() == "undefined" || $('#business_type').val() == "NaN"){
//            alert('Please Enter Business Type');
//            return;
//        }else{
//            if($("#business_type").val().length > 70){
//                alert('Business Type Is Too Long');
//                return;
//            }
//        }
//        if($('#business_operation').val() == "" || $('#business_operation').val() == "undefined" || $('#business_operation').val() == "NaN"){
//            alert('Please Enter Business Operation');
//            return;
//        }else{
//            if($("#business_operation").val().length > 70){
//                alert('Business Operation Is Too Long');
//                return;
//            }
//        }
//        if($('#address').val() == "" || $('#address').val() == "undefined" || $('#address').val() == "NaN"){
//            alert('Please Enter Address');
//            return;
//        }else{
//            if($("#address").val().length > 70){
//                alert('Address Is Too Long');
//                return;
//            }
//        }
//        if($('#landmark').val() == "" || $('#landmark').val() == "undefined" || $('#landmark').val() == "NaN"){
//            alert('Please Enter Landmark');
//            return;
//        }else{
//            if($("#landmark").val().length > 25){
//                alert('Landmark Is Too Long');
//                return;
//            }
//        }
//        if($('#pin').val() == "" || $('#pin').val() == "undefined" || $('#pin').val() == "NaN"){
//            alert('Please Enter Pincode');
//            return;
//        }else{
//            if($('#pin').inputmask('unmaskedvalue').length !== 6){
//                alert('Please Entre Valid Pincode');
//                return;
//            }
//        }
//        if($('#city').val() == "" || $('#city').val() == "undefined" || $('#city').val() == "NaN"){
//            alert('Please Enter City');
//            return;
//        }else{
//            if($("#city").val().length > 20){
//                alert('City Is Too Long');
//                return;
//            }
//            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
//            if (!Reg.test($('#city').val())) {
//                alert('Invalid City');
//                return;
//            }
//        }
//        if($('#state').val() == "" || $('#state').val() == "undefined" || $('#state').val() == "NaN"){
//            alert('Please Enter State');
//            return;
//        }else{
//            if($("#state").val().length > 20){
//                alert('State Is Too Long');
//                return;
//            }
//            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
//            if (!Reg.test($('#state').val())) {
//                alert('Invalid State');
//                return;
//            }
//        }
//        if($('#country').val() == "" || $('#country').val() == "undefined" || $('#country').val() == "NaN"){
//            alert('Please Enter Country');
//            return;
//        }else{
//            if($("#country").val().length > 20){
//                alert('Country Is Too Long');
//                return;
//            }
//            var Reg = new RegExp(/^[A-Za-z _.-]+$/);
//            if (!Reg.test($('#country').val())) {
//                alert('Invalid Country');
//                return;
//            }
//        }
//        if($('#spoc').val() == "" || $('#spoc').val() == "undefined" || $('#spoc').val() == "NaN"){
//            alert('Please Enter SPOC');
//            return;
//        }else{
//            
//        }
        document.getElementById('frm').submit();
    }
</script>


@endsection