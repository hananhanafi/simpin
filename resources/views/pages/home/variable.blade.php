<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Welcome Text</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                    <li class="breadcrumb-item active">Welcome Text</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">    
    <div class="card">
        <div class="card-body">
            <form  method="post" action="{{ url('/update') }}">
            {!! csrf_field() !!}
                <div class="col-lg-12 bottom-space">
                    <div class="form-group">
                        <textarea class="form-control custom-shadow text-14" rows="30" name="text" id="text">{{ $data[1] }}</textarea>
                        <input type="submit" value="Update Informasi" class="btn btn-info btn-flat h100"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ url('/upload') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="col-lg-12 bottom-space">
                    <div class="input-group input-group-sm">
                        <input type="hidden" id="info" name="info" value="2"/>
                        <span class="input-group-btn">
                            <input type="file" name="file" id="file"/>
                            <input type="submit" value="UPLOAD NPWP BARU" class="btn btn-info btn-flat h100"/>
                        </span>
                    </div>
                </div>
            </form>
            <form method="post" action="{{ url('/upload') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
                <div class="col-lg-12 bottom-space">
                    <div class="input-group input-group-sm">
                        <input type="hidden" id="info" name="info" value="4"/>
                        <span class="input-group-btn">
                            <input type="file" name="file" id="file"/>
                            <input type="submit" value="UPLOAD AKTA PENDIRIAN BARU" class="btn btn-info btn-flat h100"/>
                        </span>
                    </div>
                </div>
            </form>			  
			<form method="post" action="{{ url('/upload') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
                <div class="col-lg-12 bottom-space">
                    <div class="input-group input-group-sm">
                        <input type="hidden" id="info" name="info" value="3"/>
                        <span class="input-group-btn">
                            <input type="file" name="file" id="file"/>
                            <input type="submit" value="UPLOAD AD/ART BARU" class="btn btn-info btn-flat h100"/>
                        </span>
                    </div>
                </div>
            </form>	

            <form method="post" action="{{ url('/upload') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
                <div class="col-lg-12 bottom-space">
                    <div class="input-group input-group-sm">
                        <input type="hidden" id="info" name="info" value="5"/>
                        <span class="input-group-btn">
                            <input type="file" name="file" id="file"/>
                            <input type="submit" value="UPLOAD LAPORAN TAHUNAN BARU" class="btn btn-info btn-flat h100"/>
                        </span>
                    </div>
                </div>
            </form>	
						
            <form method="post" action="{{ url('/upload') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
                <div class="col-lg-12 bottom-space">
                    <div class="input-group input-group-sm">
                        <input type="hidden" id="info" name="info" value="6"/>
                        <span class="input-group-btn">
                            <input type="file" name="file" id="file"/>
                            <input type="submit" value="UPLOAD STRUKTUR ORGANISASI BARU" class="btn btn-info btn-flat h100"/>
                        </span>
                    </div>
                </div>
            </form>	
            </div>
    </div>
</div> <!-- row -->