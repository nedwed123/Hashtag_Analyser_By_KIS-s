-module(nedparse).
-compile(export_all).

start()->
ibrowse:start(),
ssl:start().

req(URL)->
case ibrowse:send_req(URL,[],get) of
{ok,_,_,Body} -> decorate(Body)
end.
decorate(B)-> case jiffy:decode(B) of
 {L} ->   
  case lists:keysearch(<<"data">>, 1, L) of
 {value, M} -> case M of
{_,U}->listparser(U)

 end 
  end 
  end.

listparser(L1)->listparser(L1,[]).
listparser([],L2)->L2;
listparser([H|T],L2)-> case H of  
{[{_,Y},{_,X}]}-> L2++[{my_binary_to_list(X),Y}|listparser(T,L2)]
end.




my_binary_to_list(<<H,T/binary>>) ->
    [H|my_binary_to_list(T)];
my_binary_to_list(<<>>) -> []. 

