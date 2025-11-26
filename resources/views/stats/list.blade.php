@extends('layouts.app')

@section('content')

	@include('layouts.alert')

	<div class="header mb-3">
        <h1 class="header-title">
            <a href="{{ route('links.edit', $links_id) }}" class="text-light">{{ $links[0]->name }}</a>
        </h1>
        <p class="header-subtitle">
        		Date Created: <a href="{{ route('links.edit', $links_id) }}" class="text-light">{{ \Carbon\Carbon::parse($links[0]->created_at)->setTimezone(Auth::user()->timeZone)->format(config('defines.DATEFORMAT')) }}</a> | 
                Group: @if(!empty($groups[0]->id))<a href="{{ route('groups.edit', $groups[0]->id) }}" class="text-light">{{ $groups[0]->name }}</a>@else{{ '/' }}@endif | 
                Tracking Link: <a href="{{ $links[0]->tracking_link }}" title="{{ $links[0]->tracking_link }}" target="_blank" class="text-light bs-tooltip" data-placement="top" data-original-title="{{ $links[0]->tracking_link }}"><i class="fas fa-fw fa-external-link-alt"></i></a> | 
                Destination: <a href="{{ $links[0]->url }}" title="{{ $links[0]->url }}" target="_blank" class="text-light bs-tooltip" data-placement="top" data-original-title="{{ $links[0]->url }}"> <i class="fas fa-fw fa-external-link-alt"></i></a>
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-fw fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('links.list') }}">Link Bank</a></li>
                <li class="breadcrumb-item"><a href="{{ route('links.edit', $links_id) }}">{{ $links[0]->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Link Tracking Stats Details</li>
            </ol>
        </nav>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
            
                <div class="card-header">
                	
                    <form id="form" name="form" method="get" class="">
            
                        <div class="form-group">
                        
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="filter" class="control-label">Date Range</label>
                                    <input type="text" name="daterangepicker_custom" class="form-control" autocomplete="off" value=""  id="daterangepicker_custom" />
            						<input name="date_from" type="hidden" value="{{ $date_from }}" />
            						<input name="date_to" type="hidden" value="{{ $date_to }}" />
                                </div>
                                @if($type == 'chart')
                                	<div class="col-md-3">
                                        <label for="data_view" class="control-label">Data View</label>
                                        <select class="form-control" name="data_view">
                                            <option value="5" @if($data_view==5){{ ' selected="selected" ' }}@endif >Top 5</option>
                                            <option value="all" @if($data_view=='all'){{ ' selected="selected" ' }}@endif >All</option>
                                        </select>
                                    </div>
                                @endif
                            </div>
                            
                            <br clear="all" />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('stats.list', [$links_id, 'list']) }}" class="btn btn-@if($type == 'list'){{ 'outline-secondary' }}@else{{ 'secondary' }}@endif pull-left bs-tooltip" data-placement="top" data-original-title="Details"><i class="fas fa-fw fa-table"></i></a>
                                    <a href="{{ route('stats.list', [$links_id, 'map']) }}" class="btn btn-@if($type == 'map'){{ 'outline-secondary' }}@else{{ 'secondary' }}@endif pull-left bs-tooltip" data-placement="top" data-original-title="Maps"><i class="fas fa-fw fa-globe-americas"></i></a>
                                    <a href="{{ route('stats.list', [$links_id, 'chart']) }}" class="btn btn-@if($type == 'chart'){{ 'outline-secondary' }}@else{{ 'secondary' }}@endif pull-left bs-tooltip" data-placement="top" data-original-title="Charts"><i class="far fa-fw fa-chart-bar"></i></a>
                                
                                    <input type="submit" value="Search" class="btn btn-primary float-right ml-1">
                                    <a href="{{ route('stats.list', [$links_id, $type]) }}?reset=1" class="btn btn-warning float-right ml-1">Reset</a>
                                </div>
                            </div>
    
                        </div>
                        
                    </form>
                </div>
                
                
                <div class="card-body">
                    
                    @if ($type == 'list')
                    
                        @if(count($data) == 0)
                            <p>No entries</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered table-highlight-head">
                                    <thead>
                                        <tr>
                                            <th>Access Time</th>
                                            <th class="table_center">IP</th>
                                            <th class="table_center">Tier</th>
                                            <th class="table_center">Country</th>
                                            <th class="table_center">Browser</th>
                                            <th class="table_center">Platform</th>
                                            <th class="table_center">Type</th>
                                        </tr>
                                    </thead>  
                                    <tbody>    
                                    @foreach ($data as $data_v)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($data_v->created_at)->setTimezone(Auth::user()->timeZone)->format(config('defines.DATEFORMAT').' '.config

('defines.TIMEFORMAT')) }}</td>
                                            <td class="table_center">{{ $data_v->ip }}</td>
                                            <td class="table_center">{{ $data_v->tier }}</td>
                                            <td class="table_center"><i class="flag-icon flag-icon-{{ strtolower ($data_v->country_code) }} bs-tooltip" data-placement="top" data-original-title="{{ $data_v->country }}"></i></td>
                                            <td class="table_center">{{ $data_v->browser_name }}</td>
                                            <td class="table_center">{{ $data_v->os_platform }}</td>
                                            <td class="table_center">@if($data_v->click_type == 1){{ 'Unique' }}@else{{ 'Non-Unique' }}@endif</td>
                                            </td>
                                        </tr> 
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            {!! $data->appends(request()->input())->links() !!}
                            
                        @endif
                        
                    @elseif ($type == 'map')

                    	<div id="map_canvas" class="gmaps" style="border: 1px solid #f4f4f4; height:500px;" data-map-image="/images/map_marker_inside_chartreuse.png" data-map-simple="true"></div>
                    
                    @elseif ($type == 'chart')
                    	
                        <!-- Tabs-->
                        <div class="tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" href="#tab_bar" data-toggle="tab" role="tab">By Day</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab_pie" data-toggle="tab" role="tab">Time Period</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_bar" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="snapshot_chart" width="auto" height="auto"></canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <canvas id="browser_chart" width="auto" height="auto"></canvas>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="platforms_chart" width="auto" height="auto"></canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <canvas id="countries_chart" width="auto" height="auto"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_pie" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="snapshot_pie" width="auto" height="auto"></canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <canvas id="browser_pie" width="auto" height="auto"></canvas>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <canvas id="platforms_pie" width="auto" height="auto"></canvas>
                                        </div>
                                        <div class="col-md-6">
                                            <canvas id="countries_pie" width="auto" height="auto"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--END TABS-->

                    @endif
                    
                </div>
                
            </div>
        </div>
    </div>
    
    @if ($type == 'map')
        <link href="/js/jvectormap/jquery-jvectormap-2.0.5.css" rel="stylesheet" type="text/css" />
        <script src="/js/jvectormap/jquery-jvectormap-2.0.5.min.js" type="text/javascript"></script>
        <script src="/js/jvectormap/jquery-jvectormap-world-merc-en.js" type="text/javascript"></script>
        <script src="/js/jvectormap/gdp-data.js" type="text/javascript"></script>
    @endif
    
    @if ($type == 'chart')
        <script src="/js/chart/chart.min.js" type="text/javascript"></script>
    @endif
    
    <script type="text/javascript">
		
		
		@if ($type == 'map')
		
			var markers = [];
			var location_array = new Array();
			var map;
			var markerIndex = 0;
			
			@foreach ($data as $data_v)
				location_array.push({'lat':'{{ $data_v->lat }}',  'lng': '{{ $data_v->lng }}', 'ip': '{{ $data_v->ip }}'});
			@endforeach
			
			function CreateMap($container) {
				var mapoptions = {
					container: $container,
					map: 'world_merc_en',
					normalizeFunction: 'polynomial',
					hoverOpacity: 0.7,
					hoverColor: false,
					backgroundColor: 'transparent',
					regionStyle: {
						initial: {
							fill: '#d2d6de',//'#174f68',
							"fill-opacity": 1,
							stroke: 'none',
							"stroke-width": 0,
							"stroke-opacity": 1
						},
						hover: {
							"fill-opacity": 0.7,
							cursor: 'pointer'
						},
						selected: {
							fill: 'yellow'
						},
						selectedHover: {
						}
					},
					markerStyle: {
						initial: {
							//image: '',
							fill: '#e1a205',
							stroke: '#111'
						},
					},
					markers: markers.map(function (marker) {
						return {
							name: marker.title,
							latLng: marker.latLng
						}
					}),
					//series: {
					//    regions: [{
					//        values: gdpData,
					//        scale: ['#d2d6de', '#d2d6de'],
					//        normalizeFunction: 'polynomial'
					//    }],
					//},
					onMarkerClick: function (e, code) {
						//console.log(e);
						//console.log(code);
					},
					onMarkerTipShow: function (e, tip, code) {
						tip.html(tip.text());
						//console.log(e);
						//console.log(tip);
						//console.log(code);
					}
				};
			
				if ($container.attr("data-map-image")) {
					mapoptions.markerStyle.initial.image = $container.attr("data-map-image");
				}
			
				if (!$container.attr("data-map-simple")) {
					mapoptions.regionStyle.initial.fill = '#174f68';
					mapoptions.series = {
						regions: [{
							values: gdpData,
							scale: ['#C8EEFF', '#0071A4'],
							normalizeFunction: 'polynomial'
						}],
					}
				}
				map = new jvm.Map(mapoptions);
			}
			
			
			function AddMarker() {
				
				for (var index in location_array) {
					var IpAddressInfo = location_array[index];
					var marker = {
						latLng: [IpAddressInfo.lat, IpAddressInfo.lng],
						name: 'IP: '+IpAddressInfo.ip,
						title: IpAddressInfo.ip
					};
					map.addMarker(markerIndex, marker);
					markerIndex += 1;
				}
				
			}
			
		@endif

		
		@if ($type == 'chart')
			
			var colorArray = ["#63b598", "#ce7d78", "#ea9e70", "#a48a9e", "#c6e1e8", "#648177" ,"#0d5ac1" ,
									"#f205e6" ,"#1c0365" ,"#14a9ad" ,"#4ca2f9" ,"#a4e43f" ,"#d298e2" ,"#6119d0",
									"#d2737d" ,"#c0a43c" ,"#f2510e" ,"#651be6" ,"#79806e" ,"#61da5e" ,"#cd2f00" ,
									"#9348af" ,"#01ac53" ,"#c5a4fb" ,"#996635","#b11573" ,"#4bb473" ,"#75d89e" ,
									"#2f3f94" ,"#2f7b99" ,"#da967d" ,"#34891f" ,"#b0d87b" ,"#ca4751" ,"#7e50a8" ,
									"#c4d647" ,"#e0eeb8" ,"#11dec1" ,"#289812" ,"#566ca0" ,"#ffdbe1" ,"#2f1179" ,
									"#935b6d" ,"#916988" ,"#513d98" ,"#aead3a", "#9e6d71", "#4b5bdc", "#0cd36d",
									"#250662", "#cb5bea", "#228916", "#ac3e1b", "#df514a", "#539397", "#880977",
									"#f697c1", "#ba96ce", "#679c9d", "#c6c42c", "#5d2c52", "#48b41b", "#e1cf3b",
									"#5be4f0", "#57c4d8", "#a4d17a", "#225b8", "#be608b", "#96b00c", "#088baf",
									"#f158bf", "#e145ba", "#ee91e3", "#05d371", "#5426e0", "#4834d0", "#802234",
									"#6749e8", "#0971f0", "#8fb413", "#b2b4f0", "#c3c89d", "#c9a941", "#41d158",
									"#fb21a3", "#51aed9", "#5bb32d", "#807fb", "#21538e", "#89d534", "#d36647",
									"#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
									"#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
									"#1bb699", "#6b2e5f", "#64820f", "#1c271", "#21538e", "#89d534", "#d36647",
									"#7fb411", "#0023b8", "#3b8c2a", "#986b53", "#f50422", "#983f7a", "#ea24a3",
									"#79352c", "#521250", "#c79ed2", "#d6dd92", "#e33e52", "#b2be57", "#fa06ec",
									"#1bb699", "#6b2e5f", "#64820f", "#1c271", "#9cb64a", "#996c48", "#9ab9b7",
									"#06e052", "#e3a481", "#0eb621", "#fc458e", "#b2db15", "#aa226d", "#792ed8",
									"#73872a", "#520d3a", "#cefcb8", "#a5b3d9", "#7d1d85", "#c4fd57", "#f1ae16",
									"#8fe22a", "#ef6e3c", "#243eeb", "#1dc18", "#dd93fd", "#3f8473", "#e7dbce",
									"#421f79", "#7a3d93", "#635f6d", "#93f2d7", "#9b5c2a", "#15b9ee", "#0f5997",
									"#409188", "#911e20", "#1350ce", "#10e5b1", "#fff4d7", "#cb2582", "#ce00be",
									"#32d5d6", "#17232", "#608572", "#c79bc2", "#00f87c", "#77772a", "#6995ba",
									"#fc6b57", "#f07815", "#8fd883", "#060e27", "#96e591", "#21d52e", "#d00043",
									"#b47162", "#1ec227", "#4f0f6f", "#1d1d58", "#947002", "#bde052", "#e08c56",
									"#28fcfd", "#bb09b", "#36486a", "#d02e29", "#1ae6db", "#3e464c", "#a84a8f",
									"#911e7e", "#3f16d9", "#0f525f", "#ac7c0a", "#b4c086", "#c9d730", "#30cc49",
									"#3d6751", "#fb4c03", "#640fc1", "#62c03e", "#d3493a", "#88aa0b", "#406df9",
									"#615af0", "#4be47", "#2a3434", "#4a543f", "#79bca0", "#a8b8d4", "#00efd4",
									"#7ad236", "#7260d8", "#1deaa7", "#06f43a", "#823c59", "#e3d94c", "#dc1c06",
									"#f53b2a", "#b46238", "#2dfff6", "#a82b89", "#1a8011", "#436a9f", "#1a806a",
									"#4cf09d", "#c188a2", "#67eb4b", "#b308d3", "#fc7e41", "#af3101", "#ff065",
									"#71b1f4", "#a2f8a5", "#e23dd0", "#d3486d", "#00f7f9", "#474893", "#3cec35",
									"#1c65cb", "#5d1d0c", "#2d7d2a", "#ff3420", "#5cdd87", "#a259a4", "#e4ac44",
									"#1bede6", "#8798a4", "#d7790f", "#b2c24f", "#de73c2", "#d70a9c", "#25b67",
									"#88e9b8", "#c2b0e2", "#86e98f", "#ae90e2", "#1a806b", "#436a9e", "#0ec0ff",
									"#f812b3", "#b17fc9", "#8d6c2f", "#d3277a", "#2ca1ae", "#9685eb", "#8a96c6",
									"#dba2e6", "#76fc1b", "#608fa4", "#20f6ba", "#07d7f6", "#dce77a", "#77ecca"];
									
			var label_dates_array = new Array();
			var data_array = new Array();
			var colorCount = 0;
			
			@foreach ($data as $data_v)
				data_array.push({'lat':'{{ $data_v->lat }}',  'lng': '{{ $data_v->lng }}', 'date': '{{ \Carbon\Carbon::parse($data_v->created_at)->setTimezone(Auth::user()->timeZone)->format(config('defines.DATEFORMAT')) }}', 'click_type': '{{ $data_v->click_type }}', 'browser_name': '{{ $data_v->browser_name }}', 'os_platform': '{{ $data_v->os_platform }}', 'country_code': '{{ $data_v->country_code }}'});
			@endforeach
			
			var snpashot_array = new Array();
			@foreach ($snpashot_array as $v)
				snpashot_array['{{ $v["sort"] }}'] = [{'title':'{{ $v["title"] }}', 'id':'{{ $v["id"] }}', 'data':[], 'total': 0}];
			@endforeach
			
			var browser_array = new Array();
			@foreach ($browser_array as $v)
				browser_array['{{ $v->browser_name }}'] = [{'title':'{{ $v->browser_name }}', 'id':'{{ $v->browser_name }}', 'data':[], 'total': 0}];
			@endforeach
			browser_array['z'] = [{'title':'Bots', 'id':'x', 'data':[], 'total': 0}];
			
			var platforms_array = new Array();
			@foreach ($platforms_array as $v)
				platforms_array['{{ $v->os_platform }}'] = [{'title':'{{ $v->os_platform }}', 'id':'{{ $v->os_platform }}', 'data':[], 'total': 0}];
			@endforeach
			platforms_array['z'] = [{'title':'Bots', 'id':'x', 'data':[], 'total': 0}];
			
			var countries_array = new Array();
			@foreach ($countries_array as $v)
				countries_array['{{ $v->country_code }}'] = [{'title':'{{ $v->country }}', 'id':'{{ $v->country_code }}', 'data':[], 'total': 0}];
			@endforeach
			countries_array['z'] = [{'title':'Bots', 'id':'x', 'data':[], 'total': 0}];
			

			function datediff(first, second) {
				// Take the difference between the dates and divide by milliseconds per day.
				// Round to nearest whole number to deal with DST.
				return Math.round((second-first)/(1000*60*60*24));
			}
			
			
			function ChartSetAraryToZero (array, i) {
				for (var key in array) {
					array[key][0]['data'][i] = 0;
				}
				return array;
			}
			
			function ChartSetDataByDate (array, i, v, date, key_field) {
				for (var key in array) {
					if (v['date'] == date && v['lat'] > 0 && v[key_field] == array[key][0]['id']) {
						array[key][0]['data'][i] = parseInt(array[key][0]['data'][i]) + 1;
						array[key][0]['total'] = parseInt(array[key][0]['total']) + 1;
					} else if (v['date'] == date && v['lat'] == 0 && array[key][0]['id'] == 'x') {
						array[key][0]['data'][i] = parseInt(array[key][0]['data'][i]) + 1;
						array[key][0]['total'] = parseInt(array[key][0]['total']) + 1;
					}
					
				}
				return array;
			}
			
			function ChartSetDataSort (array) {		
				var new_array = new Array();
				for (var key in array) {
					new_array.push(array[key][0]);
				}
				var sortedArray = smoothSort(new_array, 'total', true);
				return sortedArray;
			}
			
			function ChartSetDataTop (array) {		
				var sortedArray = ChartSetDataSort (array);
				var br = 0;
				var data_array = new Array();
				for (var key in sortedArray) {
					data_array.push({'label':sortedArray[key]['title'], 'backgroundColor':colorArray[colorCount++], 'data': sortedArray[key]['data']});
					br++;
					@if ($data_view != 'all')
						if (br == {{ $data_view }}) break;
					@endif
				}
				return data_array;
			}
			
			function ChartSetDataTopPie (array) {		
				var sortedArray = ChartSetDataSort (array);
				var total_array = new Array();
				var color_array = new Array();
				var label_array = new Array();
				var br = 0;
				for (var key in sortedArray) {
					total_array.push(sortedArray[key]['total']);
					color_array.push(colorArray[colorCount++]);
					label_array.push(sortedArray[key]['title']+' ('+sortedArray[key]['total']+')');
					br++;
					@if ($data_view != 'all')
						if (br == {{ $data_view }}) break;
					@endif
				}
				var data_array = new Array();
				data_array.push({'backgroundColor':color_array, 'data': total_array});
				return [data_array, label_array];
			}
			
			function ChartIni (array, chart_hold, chart_title) {
				
				var ctx = document.getElementById(chart_hold).getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'bar',
					data: {
							labels: label_dates_array,
							datasets: array
							},
					options: {
						plugins: {
						  title: {
							display: true,
							text: chart_title
						  },
						  legend: {
								display: true,
								position: 'bottom'
						  },
						  tooltip: {
							callbacks: {
								afterTitle: function(data) {
									var total = 0;
									for (var key in data) {
										total = total + data[key]['raw'];
									}
									window.total = total;
								},
								label: function(context, data) {
									var label = context.dataset.label;
									if (label) label += ': ';
									var per = (parseInt (context.parsed.y) * 100) / parseInt (window.total);
									if (context.parsed.y !== null) label += context.parsed.y + ' (' + per.toFixed(2).replace(/\.0+$/,'')+'%)';
									return label;
								},
								footer: function(data) {
									return "TOTAL: " + window.total;
								}
							}
						  }
						},
						scales: {
							y: {
								beginAtZero: true
							}
						},
						responsive: true,
						scales: {
						  x: {
							stacked: true,
						  },
						  y: {
							stacked: true
						  }
						}
					}
				});
				
			}
			
			
			function ChartIniPie (data, label, chart_hold, chart_title) {
			
				var ctx = document.getElementById(chart_hold).getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'pie',
					data: {
							datasets: data,
							labels: label
							},
					options: {
						plugins: {
						  title: {
							display: true,
							text: chart_title
						  },
						  legend: {
								display: true,
								position: 'bottom'
						  },
						},
						responsive: true,
					}
				});	
				
			}
			
		@endif
		
		
		$(document).ready(function() {
			
			@if ($type == 'map')
				//map
				CreateMap($('#map_canvas'));
				AddMarker();
			@endif
			
			
			@if ($type == 'chart')
			
				var days = datediff ({{ $date_from_timestamp * 1000 }}, {{ $date_to_timestamp * 1000 }});
				for (var i = 0; i <= days; i++) {
					
					var new_date = new Date( {{ $date_from_timestamp * 1000 }} + (60*60*24*1000*i) );
					var date = moment(new_date).format("{{ config('defines.DATERANGEFORMAT_JS') }}");
					label_dates_array.push(date);

					var snpashot_array_new_1 = ChartSetAraryToZero (snpashot_array, i);
					var browser_array_new_1 = ChartSetAraryToZero (browser_array, i);
					var platforms_array_new_1 = ChartSetAraryToZero (platforms_array, i);
					var countries_array_new_1 = ChartSetAraryToZero (countries_array, i);
					
					for (var k in data_array) {
						var v = data_array[k];
						snpashot_array_new_1 = ChartSetDataByDate (snpashot_array_new_1, i, v, date, 'click_type');
						browser_array_new_1 = ChartSetDataByDate (browser_array_new_1, i, v, date, 'browser_name');
						platforms_array_new_1 = ChartSetDataByDate (platforms_array_new_1, i, v, date, 'os_platform');
						countries_array_new_1 = ChartSetDataByDate (countries_array_new_1, i, v, date, 'country_code');
					}
					
				}

				
				var snpashot_array_new_2 = ChartSetDataTop(snpashot_array_new_1);
				var browser_array_new_2 = ChartSetDataTop(browser_array_new_1);
				var platforms_array_new_2 = ChartSetDataTop(platforms_array_new_1);
				var countries_array_new_2 = ChartSetDataTop(countries_array_new_1);

				ChartIni (snpashot_array_new_2, 'snapshot_chart', 'Snapshot');
				ChartIni (browser_array_new_2, 'browser_chart', 'Top Browser');
				ChartIni (platforms_array_new_2, 'platforms_chart', 'Top Platform');
				ChartIni (countries_array_new_2, 'countries_chart', 'Top Countries');
				
				//pie
				colorCount = 0;
				var snpashot_array_pie = ChartSetDataTopPie(snpashot_array_new_1);
				var snpashot_array_pie_data = snpashot_array_pie[0];
				var snpashot_array_pie_label = snpashot_array_pie[1];
				
				var browser_array_pie = ChartSetDataTopPie(browser_array_new_1);
				var browser_array_pie_data = browser_array_pie[0];
				var browser_array_pie_label = browser_array_pie[1];
				
				var platforms_array_pie = ChartSetDataTopPie(platforms_array_new_1);
				var platforms_array_pie_data = platforms_array_pie[0];
				var platforms_array_pie_label = platforms_array_pie[1];
				
				var countries_array_pie = ChartSetDataTopPie(countries_array_new_1);
				var countries_array_pie_data = countries_array_pie[0];
				var countries_array_pie_label = countries_array_pie[1];
				
				ChartIniPie (snpashot_array_pie_data, snpashot_array_pie_label, 'snapshot_pie', 'Snapshot');
				ChartIniPie (browser_array_pie_data, browser_array_pie_label, 'browser_pie', 'Top Browser');
				ChartIniPie (platforms_array_pie_data, platforms_array_pie_label, 'platforms_pie', 'Top Platform');
				ChartIniPie (countries_array_pie_data, countries_array_pie_label, 'countries_pie', 'Top Countries');
				
			@endif
			
			
			//daterange
			var date_datepicker_from = new Date();
			date_datepicker_from.setTime({{ $date_from_timestamp * 1000 }});
			date_datepicker_from = changeTimezone(date_datepicker_from, "{{Auth::user()->timeZone}}");
			var date_from_daterangepicker_new = new Date(date_datepicker_from.getTime() + 0);
			
			var date_datepicker_to = new Date();
			date_datepicker_to.setTime({{ $date_to_timestamp * 1000 }});
			date_datepicker_to= changeTimezone(date_datepicker_to, "{{Auth::user()->timeZone}}");
			var date_to_daterangepicker_new = new Date(date_datepicker_to.getTime() + 0);
			
			$('#daterangepicker_custom').daterangepicker(
				{
					"locale": {
						"format": "{{ config('defines.DATERANGEFORMAT_JS') }}",
						"separator": " - ",
						"applyLabel": "Apply",
						"cancelLabel": "Cancel",
						"fromLabel": "From",
						"toLabel": "To",
						"customRangeLabel": "Custom Range",
						"firstDay": 1
					},
					opens: 'right',
					startDate: date_from_daterangepicker_new,
					endDate: date_to_daterangepicker_new,
					ranges: {
						 'Today': [moment(), moment()],
						 'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
						 'Last 7 Days': [moment().subtract('days', 6), moment()],
						 'Last 30 Days': [moment().subtract('days', 29), moment()],
						 'This Month': [moment().startOf('month'), moment().endOf('month')],
						 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
					  },
				},
				function(start, end) {
					
					$("[name=date_from]").val(start.format('YYYY-MM-DD'));
					$("[name=date_to]").val(end.format('YYYY-MM-DD'));
					$('#daterangepicker_custom').val(start.format("{{ config('defines.DATERANGEFORMAT_JS') }}") + " - " + end.format("{{ config('defines.DATERANGEFORMAT_JS') }}"));
					
				}
			);
			
		});
	
	</script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
            
@endsection
