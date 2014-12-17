-module(delete_keys).
-compile(export_all).

%% This module deletes todays bucket on node 10037. 
%% For this to work you need to change the ip address in the start function

start()->
%% start connection to our Server (sally's AWS) and our third riak node
{ok, Pid} = riakc_pb_socket:start_link("127.0.0.1", 10037),
%% gives us current date
{Y,M,D}=erlang:date(),
%% Here we make date into a binary like: <<"20141118">>
Bucket= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
{ok,K}=riakc_pb_socket:list_keys(Pid, Bucket),
delete_key(Pid,Bucket,K).

delete_key(_,_,[])->[];
delete_key(P,B, [H|T])->case H of
_-> riakc_pb_socket:delete(P, B ,H),
delete_key(P,B,T)
end.

