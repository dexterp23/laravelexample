@extends('layouts.app')

@section('content')

	@include('layouts.alert')

    <div class="row">
        <div class="col-12">
            <div class="card">
                
                <div class="card-body">
                	
					<div id="SaasOnBoardContainer_25"></div>
					<script type="text/javascript" src="https://app.saasonboard.com/assets/custom/js/iframe/videolibrary.js"></script>
                    <script type="text/javascript">
                      VideoLibrary.init([
                          "SaasOnBoardContainer_25",
                          "https://app.saasonboard.com/",
                          "dqV0HQ3ImHYjbaN",
                          "SaasOnBoardIFrame_25"
                      ]);
                    </script>
                                        
                </div>
                
            </div>
        </div>
    </div>
    
@endsection
