<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, minimal-ui, maximum-scale=1.0, user-scalable=0" />
    <meta property="og:site_name" content="{{ $link_name }}" />
    <meta property="og:title" content="{{ $link_name }}" />
    <meta property="og:description" content="{{ $link_name }}" />
    <meta property="og:image" content="" />
    @if(!empty($redirect_url) && empty($cloak_url))
    	<meta property="og:url" content="{{ $redirect_url }}" />
    	<meta http-equiv="refresh" content="0; url={{ $redirect_url }}" />
    @endif
    <title></title>
</head>
<body>
@if(!empty($pixel_code)){!! $pixel_code !!}@else{{ '' }}@endif

@if(!empty($cloak_url) && !empty($redirect_url))
	<style>
		body {
			margin: 0;
		}
	</style>
	<iframe width="100%" height="100%" src="{{ $redirect_url }}" scrolling="auto" frameborder="0" name="{{ $link_name }}" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"></iframe>
@endif
</body>
</html>