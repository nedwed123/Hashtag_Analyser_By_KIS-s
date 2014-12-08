-module(location_se).
-compile(export_all).


start()->
	ibrowse:start(),
	ssl:start().

req(URL)->
	case ibrowse:send_req(URL,[],get) of
{ok,_,_,Body} -> decorate(Body)
end.
decorate(B) ->
  case jiffy:decode(B) of
  	{L}->
  	case lists:keysearch(<<"data">>, 1, L) of
    	{value, M}->save_id(M,[])
    end;
    _->ok
  end.
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
save_T([],L)->L;
save_T([H|T],List)->
case H of
	{X}->case proplists:get_value(<<"id">>,X) of
			Z->
			T2=[binary_to_list(Z)|List],
			save_T(T,T2)
		end
end.

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

format_list([])->[];
format_list([H|T])->
case H of
  {error,{1,invalid_json}}->format_list(T);
	[]->format_list(T);
	ok->format_list(T);
	_->lists:append(H,format_list(T))
end.

pmap_id()->
S = self(),
  L=["https://api.instagram.com/v1/locations/search?lat=57.706922&lng=11.967891&distance=5000&access_token=511546223.4dc6143.f86f1a1df18d45d3865cd4b75387beb3",
  "https://api.instagram.com/v1/locations/search?lat=57.696629&lng=11.986935&distance=5000&access_token=511546223.4dc6143.f86f1a1df18d45d3865cd4b75387beb3",
  "https://api.instagram.com/v1/locations/search?lat=59.330126&lng=18.068741&distance=5000&access_token=511546223.4dc6143.f86f1a1df18d45d3865cd4b75387beb3",
  "https://api.instagram.com/v1/locations/search?lat=59.330769&lng=18.057937&distance=5000&access_token=511546223.4dc6143.f86f1a1df18d45d3865cd4b75387beb3"],
   Pids = [spawn(fun () ->

           S ! {self(),catch(req(X))} end)
           || X <- L],

 [receive { P, Y} -> Y end
     || P <- Pids].