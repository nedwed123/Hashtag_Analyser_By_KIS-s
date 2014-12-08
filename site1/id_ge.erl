-module(id_ge).
-compile(export_all).
-import(parse, [decorate_likes/1]).
start()->
	ibrowse:start(),
	ssl:start().

req(String)->
	URL="https://api.instagram.com/v1/locations/"++[String]++"/media/recent?access_token=511546223.4dc6143.f86f1a1df18d45d3865cd4b75387beb3",
		case ibrowse:send_req(URL,[],get) of
			{ok,_,_,Body} -> decorate_likes(Body)
		end.

pmap_id() ->
  S = self(),
  List=location_ge:pmap_id(),
  L=lists:append(List),
   Pids = [spawn(fun () ->

           S ! {self(),req(X)} end)
           || X <- L],

  NewList=[receive { P, Y} -> Y end
     || P <- Pids],
     sum(format_list(NewList)).

format_list([])->[];
format_list([H|T])->
case H of
ok ->format_list(T);
_->[H|format_list(T)]
end.

sum([])->0;
sum([H|T])-> H+sum(T).