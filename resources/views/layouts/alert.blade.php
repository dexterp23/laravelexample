<!-- Error Message -->
@if($errors->any())
{!! implode('', $errors->all('<div class="alert alert-danger alert-dismissible" role="alert"><div class="alert-message">:message</div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')) !!}
@endif
<?php /* ?>
@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	<br /><br />
@endif
<?php */ ?>

<!-- Success Message -->
@if(Session::has('success'))
	<div class="alert alert-success alert-dismissible" role="alert">
        <div class="alert-message">
            {{Session::get('success')}}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('status'))
	<div class="alert alert-success alert-dismissible" role="alert">
        <div class="alert-message">
            {{ session('status') }}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif