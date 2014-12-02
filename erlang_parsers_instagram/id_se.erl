-module(id_se).
-compile(export_all).
-import(parse, [decorate_likes/1]).

%%--------------------------------------------------------------------
%% @doc
%% Starts ibrowse and ssl
%% @end
%%--------------------------------------------------------------------
start()->
	ibrowse:start(),
	ssl:start().

%%--------------------------------------------------------------------
%% @doc
%% Sends request to Instagram api to get the total number of 
%% recently tagged media for a certain id
%% Ex: https://api.instagram.com/v1/locations/514276/media/recent?access_token=ACCESS-TOKEN
%%
%% @end
%%--------------------------------------------------------------------

req(String)->
	URL="https://api.instagram.com/v1/locations/"++[String]++"/media/recent?access_token=ACCESS-TOKEN",
		case ibrowse:send_req(URL,[],get) of
			{ok,_,_,Body} -> decorate_likes(Body)
		end.
%%--------------------------------------------------------------------
%% @doc
%% Get list of ids from location_se:pmap_id/0 then get the number of likes per id . 
%% Returns total number of likes for all ids.
%% @end
%%--------------------------------------------------------------------

pmap_id() ->
  S = self(),
  List=location_se:pmap_id(),
  L=lists:append(List),
   Pids = [spawn(fun () ->

           S ! {self(),req(X)} end)
           || X <- L],

  NewList=[receive { P, Y} -> Y end
     || P <- Pids],
     sum(format_list(NewList)).
%%--------------------------------------------------------------------
%% @doc
%% Remove empty lists and ok from the NewList in pmap_id/0 to return a list
%% that has tags only.
%% @end
%%--------------------------------------------------------------------
format_list([])->[];
format_list([H|T])->
case H of
ok ->format_list(T);
_->[H|format_list(T)]
end.

%%--------------------------------------------------------------------
%% @doc
%% Return the sum of likes of all objects for all ids
%% @end
%%--------------------------------------------------------------------

sum([])->0;
sum([H|T])-> H+sum(T).