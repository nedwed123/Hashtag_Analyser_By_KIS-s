%Team: KIS&S
%T3 2014
%Project Hashtaganalyzer

-module(parse_tag).
-export([req/1,save_tag/1]).

%%--------------------------------------------------------------------
%% @doc
%% Sends request to Instagram api to get a list of 
%% recently tagged media from a given location
%% Ex: https://api.instagram.com/v1/locations/514276/media/recent?access_token=ACCESS-TOKEN
%%
%% @end
%%--------------------------------------------------------------------

req(Id)->
URL="https://api.instagram.com/v1/locations/"++[Id]++"/media/recent?access_token=511546223.4dc6143.f86f1a1df18d45d3865cd4b75387beb3",
case ibrowse:send_req(URL,[],get) of
{ok,_,_,Body} -> decorate(Body)
end.

%%--------------------------------------------------------------------
%% @doc
%% Decode the Json message from req/1 and returns the tags
%% @end
%%--------------------------------------------------------------------

decorate(B) ->
%io:format("Body is ~p~n",[B]),
  case catch(jiffy:decode(B)) of
    {L} -> case lists:keysearch(<<"data">>, 1, L) of
    	{value, M} -> save_tag(M);
    	_->"Exceeded Allowed Requests"
    end;
    _->ok
end.

%%--------------------------------------------------------------------
%% @doc
%% Decode the Json message from req/1 and returns the tags
%% @end
%%--------------------------------------------------------------------

save_tag(M)->
case M of
	{_,[H|_]}-> case H of
		{Z}->case proplists:get_value(<<"tags">>,Z) of
	X->save_list(X,[])
	end
	end;
	_->ok
end.

%%--------------------------------------------------------------------
%% @doc
%% Iterate through the list received from save_tag/1 and 
%% add converted binary tags to the list
%% @end
%%--------------------------------------------------------------------

save_list([],L)->L;
save_list([H|T],L)->
T2=L++[binary_to_list(H)],
save_list(T,T2).