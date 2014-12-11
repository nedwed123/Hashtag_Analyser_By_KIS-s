%Team: KIS&S
%T3 2014
%Project Hashtaganalyzer

-module(location_noy).
-export([req/1,pmap_id/0,pmap/0,format_list/1]).

%%--------------------------------------------------------------------
%% @doc
%% Sends request to Instagram api to get a list of 
%% recently tagged media for a certain location with specifying latitude and langtitude
%% Ex: https://api.instagram.com/v1/locations/search?lat=57.706922&lng=11.967891&distance=5000&access_token=ACCESS-TOKEN
%%
%% @end
%%--------------------------------------------------------------------
req(URL)->
	case ibrowse:send_req(URL,[],get) of
{ok,_,_,Body} -> decorate(Body)
end.
%%--------------------------------------------------------------------
%% @doc
%% Decode the Json message from req/1 and get the number of ids 
%% for certain location 
%% @end
%%--------------------------------------------------------------------
decorate(B) ->
  case jiffy:decode(B) of
  	{L}->
  	case lists:keysearch(<<"data">>, 1, L) of
    	{value, M}->save_id(M,[])
    end
  end.
%%--------------------------------------------------------------------
%% @doc
%% Get the id for the first location . In this case M is 
%% tuple which has a list as its second element.
%% @end
%%--------------------------------------------------------------------
save_id(M,List)->
case M of
	{_,[H|T]}-> case H of
		{X}->case proplists:get_value(<<"id">>,X) of
			Z->
			T2=[binary_to_list(Z)|List],
			save_T(T,T2)

		end
	end
end.
%%--------------------------------------------------------------------
%% @doc
%% Get the ids for the other locations . The function will iterate 
%% through the list received from save_id/2 and retruns the ids for all locations. 
%% @end
%%--------------------------------------------------------------------
save_T([],L)->L;
save_T([H|T],List)->
case H of
	{X}->case proplists:get_value(<<"id">>,X) of
			Z->
			T2=[binary_to_list(Z)|List],
			save_T(T,T2)
		end
end.
%%--------------------------------------------------------------------
%% @doc
%% Spawn process depending on the number of ids available and 
%% get the tags in each ID.
%% @end
%%--------------------------------------------------------------------
pmap() ->
  S = self(),
  List=pmap_id(),
  L=lists:append(List),
   Pids = [spawn(fun () ->

          S ! {self(), parse_tag:req(X)} end)
           || X <- L],

 NewList= [receive { P, Y} -> Y end
     || P <- Pids],
    format_list(NewList).
%%--------------------------------------------------------------------
%% @doc
%% Remove empty lists and ok from the NewList in pmap/0 to return a list
%% that has tags only.
%% @end
%%--------------------------------------------------------------------
format_list([])->[];
format_list([H|T])->
case H of
  {error,{1,invalid_json}}->format_list(T);
	[]->format_list(T);
	ok->format_list(T);
	_->lists:append(H,format_list(T))
end.
%%--------------------------------------------------------------------
%% @doc
%% Spawn process depending on the number of URLs available and 
%% get the ids of the specefied locations.
%% @end
%%--------------------------------------------------------------------
pmap_id()->
S = self(),
  L=["https://api.instagram.com/v1/locations/search?lat=59.911932&lng=10.755247&distance=5000&access_token=ACCESS-TOKEN"],
   Pids = [spawn(fun () ->

           S ! {self(),catch(req(X))} end)
           || X <- L],

 [receive { P, Y} -> Y end
     || P <- Pids].