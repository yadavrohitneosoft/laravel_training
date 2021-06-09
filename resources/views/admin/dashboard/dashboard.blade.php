@extends('includes.template')



@section('content')
    <div id="content">
        <div class="mt30">
            <div style="" class="coverpart " ui-view=""> 
                <div style="padding: 18px 0 0 0px; width: 100%; border-radius: 0px; display: block; margin-top:0px;"> 
                    <div class="dash_logo" style="margin: 0 20px;background:transparent"> 
                        <div class="ctm-box-wrapper">
                            <img src="{{ asset('images/logo.png') }}" height="300" style="background:transparent" alt="" class="ds__logo">    
                        </div> 
                    </div> 
                </div> 
            </div>
        </div>
    </div>
@endsection