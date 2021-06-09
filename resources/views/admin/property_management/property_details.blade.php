<?php $get_SessionData = Session::get('admin_session'); ?>
    <main>
        <div class="container-fluid"> 
             <ol class="breadcrumb mb-4 mt-4 onscrollFixed">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard/index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Property</li>
                <li class="breadcrumb-item active">Property Images</li>
            </ol> 
             
            <a class="add_x" style="text-align: left;" href="javascript:void(0)">Property Images</a> 
            <div class="card mb-4">
                <div class="card-body">
                 
                         @foreach($prop_images as $key=>$val)
                         <div class="containerimg">
                                <img src="{{ url('/uploads/property_images') }}/{{$val->prop_id}}/{{$val->image}}" class="image-responsive <?php if($val->isFeatured==1){ echo 'brdr'; } ?>" height="100" />
                                @if($val->isFeatured==1)
                                    <button class="btn">Featured Image</button>
                                @endif
                            </div> 
                         @endforeach
                </div>
            </div>
        </div>
    </main> 
 

<script type="text/javascript"> 
    
 
</script>

