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
                            <img src="https://www.neosofttech.com/sites/all/themes/neosoft2017/images/neosoft.svg" style="background:transparent" alt="" class="ds__logo">    
                        </div> 
                        <!--  <img src="{{ URL::asset('/') }}public/img/graph1.png" alt="" class="ds__logo">  --> 
                    </div> 
                </div> 
            </div>
        </div>
    </div>
@endsection