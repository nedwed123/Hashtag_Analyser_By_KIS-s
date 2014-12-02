
%Team: KIS&S
%T3 2014
%Project Hashtaganalyzer

%Parsing the latest popular tags used in instagram from instagram API link below

-module(parse_ig_pop).
-export([start/0, check_req/0, req/0, store_tags/2, remove_binary/1, parse_tags/2]).

%Start the SSL encryption and ibrowse. Requested everytime starting Erlang shell
start()->
ibrowse:start(),
ssl:start().

%Request from the instagram latest popular hashtag with timer to get the latest
%tag every 20 sec and save the hashtags 4 times with the interval of 2,2,3 sec
check_req()->
Z=req(),
timer:sleep(20000),
Y=req(),
timer:sleep(20000),
D = req(),
timer:sleep(30000),
Q = req(),
io:format("~p ~n ~p ~n ~p ~n ~p ~n",[Z,Y,D,Q]).

%Gets the popular hashtags from instagram API and decode the json message and
% peforms a keysearch for "data" returns 2 lists.(Change access token to own)
req()->
URL="https://api.instagram.com/v1/media/popular?access_token=ACCESS_TOKEN",
case ibrowse:send_req(URL,[],get) of
{ok,_,_,Body} -> decorate(Body)
end.
decorate(B) ->
  case jiffy:decode(B) of
    {L} ->
    case lists:keysearch(<<"data">>, 1, L) of
    	{value,Z}-> parse_tags(Z,[])

end
  end.

 %Storing the tags that are requested via the link. It will be stored and added
 % to  list. The proplists:get_value gets the value from a tuple. 
store_tags([],List)->remove_binary(List);
store_tags([H|T],List)->
case H of
{Z}->  case proplists:get_value(<<"tags">>,Z) of

Y-> case Y of
	[X]->store_tags(T,List ++ [X]);
	_->store_tags(T,List)
  end
    end
  end.

% remove_binary changes the value from binary to list recursively 
remove_binary([])->[];
remove_binary([H|T])->
[binary_to_list(H) | remove_binary(T)].
parse_tags(M,L)->
case M of
      {_,[H|T]}-> 
       case H of
        {Z}->  case proplists:get_value(<<"tags">>,Z) of
        	X-> store_tags(T,L ++ X)
              end
                end;
                _->ok
                  end.



