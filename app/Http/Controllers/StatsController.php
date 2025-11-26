<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\LinksDataRepository;
use App\Repositories\LinksRepository;
use App\Repositories\GroupsRepository;


class StatsController extends Controller
{

	public function __construct( LinksDataRepository $LinksDataRepository, LinksRepository $LinksRepository, GroupsRepository $GroupsRepository ) {

        $this->LinksDataRepository = $LinksDataRepository;
		$this->LinksRepository = $LinksRepository;
		$this->GroupsRepository = $GroupsRepository;
    }
	
    public function List($links_id, $type, Request $request)
    {
		$ID_users = Auth::id();
		$userTimeOffset = GetOffset (Auth::user()->timeZone);
		
		$reset  =  $request->input('reset');
		$date_from  =  $request->input('date_from');
		$date_to  =  $request->input('date_to');
		if (!$date_from && !$reset) $date_from = session('session_date_from');
		if (!$date_to && !$reset) $date_to = session('session_date_to');
		if (!$date_from) $date_from = date("Y-m-d", DateFromDateRange($userTimeOffset));
		if (!$date_to) $date_to = date("Y-m-d", GMTtoTimezone (time(), $userTimeOffset));
		session(['session_date_from' => $date_from]);
		session(['session_date_to' => $date_to]);
		$date_from_timestamp = strtotime ('00:00:00'.$date_from);
		$date_to_timestamp = strtotime ('00:00:00'.$date_to);
		$timestamp_from = ToTimestamp ($date_from, "start", $userTimeOffset);
		$timestamp_to = ToTimestamp ($date_to, "end", $userTimeOffset);
		
		$data_view  =  $request->input('data_view') ?? 5;
		
		$links = $this->LinksRepository->getById($ID_users, $links_id);
		$groups = $this->GroupsRepository->getById($ID_users, $links[0]->group_id);

		switch ($type) {
			
			case "list": 
				$links_data = $this->LinksDataRepository->getAllPaginated($links_id, $timestamp_from, $timestamp_to);
				return view('stats.list', ['data' => $links_data, 'links' => $links, 'groups' => $groups, 'links_id' => $links_id, 'type' => $type, 'date_from' => $date_from, 'date_to' => $date_to, 'date_from_timestamp' => $date_from_timestamp, 'date_to_timestamp' => $date_to_timestamp]);
			break;
			
			case "map": 
				$links_data = $this->LinksDataRepository->getLocationByDate($ID_users, $links_id, $timestamp_from, $timestamp_to);
				return view('stats.list', ['data' => $links_data, 'links' => $links, 'groups' => $groups, 'links_id' => $links_id, 'type' => $type, 'date_from' => $date_from, 'date_to' => $date_to, 'date_from_timestamp' => $date_from_timestamp, 'date_to_timestamp' => $date_to_timestamp]);
			break;
			
			case "chart": 
				$snpashot_array[] = array ('title' => 'Unique', 'id' => 1, 'sort' => '1');
				$snpashot_array[] = array ('title' => 'Non-Unique', 'id' => 0, 'sort' => '2');
				$snpashot_array[] = array ('title' => 'Bots', 'id' => 'x', 'sort' => '3');
				
				$browser_array = $this->LinksDataRepository->getBrowsersByDate($ID_users, $links_id, $timestamp_from, $timestamp_to);
				$platforms_array = $this->LinksDataRepository->getPlatformsByDate($ID_users, $links_id, $timestamp_from, $timestamp_to);
				$countries_array = $this->LinksDataRepository->getCountriesByDate($ID_users, $links_id, $timestamp_from, $timestamp_to);
				
				$links_data = $this->LinksDataRepository->getAllByDate($ID_users, $links_id, $timestamp_from, $timestamp_to);
				return view('stats.list', ['data' => $links_data, 'links' => $links, 'groups' => $groups, 'links_id' => $links_id, 'type' => $type, 'date_from' => $date_from, 'date_to' => $date_to, 'date_from_timestamp' => $date_from_timestamp, 'date_to_timestamp' => $date_to_timestamp, 'data_view' => $data_view, 'snpashot_array' => $snpashot_array, 'browser_array' => $browser_array, 'platforms_array' => $platforms_array, 'countries_array' => $countries_array]);
			break;
			
		}
		
    }
	
}
