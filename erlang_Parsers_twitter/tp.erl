-module(tp).
-compile(export_all).


getTweet(Id)->
{ok,Pid}=riakc_pb_socket:start_link("127.0.0.1", 10017),
{ok,Fetched1}= riakc_pb_socket:get(Pid, <<"tweets">>,Id),
P=riakc_obj:get_value(Fetched1),
{L}=jiffy:decode(P),
decorate(L).




decorate([_|T])-> case lists:keysearch(<<"favorite_count">>, 1,T )of
{value,R}->
case  lists:keysearch(<<"retweet_count">>,1,T) of 
{value, M}-> 
case lists:keysearch(<<"user">>,1,T)of
{value,{_,{I}}}->
case lists:keysearch(<<"lang">>,1,I)of
{value,Z}->
case lists:keysearch(<<"entities">>,1,T) of
{value,{_,{E}}}->
case lists:keysearch(<<"hashtags">>,1,E)of
{value, {S,Ss}}->[R,M,Z,{S,hashFormat(Ss)}]
end
end
end
end
end
end.


hashFormat(U)->hashFormat(U,[]).
hashFormat([],W)->W;
hashFormat([H|T],W)->case H of
{[{_,R},_]}->[R|hashFormat(T)]++W
end. 
