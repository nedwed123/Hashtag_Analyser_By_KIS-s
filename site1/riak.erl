-module(riak).
-compile(export_all).

start_con()->
{ok, Pid} = riakc_pb_socket:start_link("54.171.161.63", 10017),
register(riak,Pid),
{ok,Pid}.

fetch(Key,Day)->
case Day of 
	0->
	{Y,M,D}=erlang:date(),
	 Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
case riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key))of
	{ok, Fetched1}->

Obj=riakc_obj:get_value(Fetched1),
ObjF=binary_to_term(Obj),
ObjF;
{error,_}->"not found"
end;
M->
	{Y,M,D}=erlang:date(),
	 Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
{ok, Fetched1} = riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)),
Obj=riakc_obj:get_value(Fetched1),
ObjF=binary_to_term(Obj),
ObjF,
L=date_check(date(),M,[]),
fetch_new_data(L,Key,[ObjF])

end.

date_check(_,0,L)->L;
date_check({Y,M,D},N,L)  ->
case D =/= 1 of
	true ->
T2 = L ++ [{Y,M,D-1}],
date_check({Y,M,D-1},N-1,T2)
end.

fetch_new_data([],_,List)->List;
fetch_new_data([H|T],Key,List) -> 
	{Y,M,D}=H,
	 Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
	{ok, Fetched1} = riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)),
	Obj=riakc_obj:get_value(Fetched1),
	ObjF=binary_to_term(Obj),
	List1=List ++ [ObjF],
fetch_new_data(T,Key,List1).

find(_, []) -> false;
find(X, [X | _]) -> true;
find(X, [_ | Xs]) -> find(X, Xs).

check_lang([])-> [];
check_lang([H|T]) -> 
case  find(H, "sv") of
	true -> [H| check_lang(T)];
	false -> check_lang(T)
end.