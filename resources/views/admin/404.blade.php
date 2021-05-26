@extends('includes.template')



@section('content')
    <div id="content">
        <div class="mt30">
            <div style="" class="coverpart " ui-view=""> 
                <div style="padding: 18px 0 0 0px; width: 100%; border-radius: 0px; display: block; margin-top:0px;">
                    <!-- 
                        <div class="bread__box">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/administrator/index') }}">Home</a></li>
                                </ol>
                            </nav>
                        </div> 
                    --> 
                    <div class="dash_logo" style="margin: 0 20px;background:transparent"> 
                        <div class="ctm-box-wrapper">
                            404 | Not Found | &nbsp;
                        </div>  
                        <div class="ctm-box-wrapper">
                            <a href="{{ url('/dashboard/index') }}" class="btn btn-responsive" style="padding:5px; background:#e23434; color:#fff">Return to Dashboard</a>  
                        </div> 
                        <!--  <img src="{{ URL::asset('/') }}public/img/graph1.png" alt="" class="ds__logo">  --> 
                    </div> 
                </div> 
            </div>
        </div>
    </div>
@endsection