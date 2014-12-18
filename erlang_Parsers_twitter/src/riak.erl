-module(riak).
-compile(export_all).

start_con()->
    {ok, Pid} = riakc_pb_socket:start_link("127.0.0.1", port),
    register(riak,Pid),
    {ok,Pid}.

fetch(Key) ->
    {Y,M,D}=erlang:date(),
    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
    case riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)) of
	{ok, Fetched1}->
	    Obj=riakc_obj:get_value(Fetched1),
	    binary_to_term(Obj);
	_->"not found"
    end.

fetch_key(Key,Day) ->
    case Day of 
	0->
	    {Y,M,D}=erlang:date(),
	    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
	    case riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)) of
		{ok, Fetched1}->

		    Obj=riakc_obj:get_value(Fetched1),
		    binary_to_term(Obj);
		{error,_}->"not found"
	    end;
	X->
	    {Y,M,D}=erlang:date(),
	    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
	    case riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)) of
		{ok, Fetched1} ->
		    Obj=riakc_obj:get_value(Fetched1),
		    ObjF=binary_to_term(Obj),
		    L=date_check(date(),X,[]),
		    fetch_new_data(L,Key,[ObjF]);
		{error,_}->L=date_check(date(),X,[]),
			   ["not found " |fetch_new_data(L,Key,[])]
	    end
    end.

fetch(Key,Day,Ch)->
    case Day of 
	0->
	    {Y,M,D}=erlang:date(),
	    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
	    case riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)) of
		{ok, Fetched1}->

		    Obj=riakc_obj:get_value(Fetched1),
		    ObjF=binary_to_term(Obj),
		    check_choice0(ObjF,Ch);
		{error,_}->"error"
	    end;
	X->
	    {Y,M,D}=erlang:date(),
	    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
	    case riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)) of
		{ok, Fetched1} ->
		    Obj=riakc_obj:get_value(Fetched1),
		    ObjF=binary_to_term(Obj),
		    L=date_check(date(),X,[]),
		    NL=fetch_new_data(L,Key,[ObjF]),
		    check_choice(NL,Ch);
		{error,_}-> L=date_check(date(),X,[]),
			    io:format("~p~n",[L]),
			    ["not found "]++fetch_new_key(L,Key,Ch,[]) 
	    end
    end.

fetch_new_key([],_,_,List)->List;
fetch_new_key([H|T],Key,Choice,List)->
    {Y,M,D}=H,
    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
    case riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)) of
	{ok, Fetched1} ->
	    Obj=riakc_obj:get_value(Fetched1),
	    ObjF=binary_to_term(Obj),
	    Final=check_choice(ObjF,Choice),
	    NL=[List++Final],
	    fetch_new_key(T,Key,Choice,NL);
	{error,_} ->fetch_new_key(T,Key,Choice,List)++ ["not found"]
    end.


fetch_new_data([],_,List)->List;
fetch_new_data([H|T],Key,List) -> 
    {Y,M,D}=H,
    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
    case riakc_pb_socket:get(riak, Date_bin, list_to_binary(Key)) of
	{ok, Fetched1} ->
	    Obj=riakc_obj:get_value(Fetched1),
	    ObjF=binary_to_term(Obj),
	    List1=List ++ [ObjF],
	    fetch_new_data(T,Key,List1);
	{error,_} -> fetch_new_data(T,Key,List) ++["not found"] 
    end.


check_lang_cast(X,Language,Pid) ->
    {Y,M,D}=erlang:date(),
    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
    case riakc_pb_socket:get(riak, Date_bin, X) of
	{ok, Fetched1} ->
	    Value=riakc_obj:get_value(Fetched1),
	    Final=binary_to_term(Value),
	    %%io:format("sending~n~p",[Final]),
	    case find(Final,Language) of
		true ->
		    Pid ! {ok, [Final]};
		    %%gen_server:cast(twitter_server,Final);
		false -> Pid ! bad_data
	    end;
	_ ->
	    Pid ! bad_data
    end.

fetch_lang(Language) ->
    %%case Day of 
    %%	0 -> 
    {Y,M,D}=erlang:date(),
    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
    case riakc_pb_socket:list_keys(riak, Date_bin) of
	{ok,Lists}->
	    Spawn_Cast = fun(X) -> spawn(riak,check_lang_cast,[X,Language,self()]) end,
	    lists:foreach(Spawn_Cast, Lists),
	    receive_langs(length(Lists),[]);
	{error,_} -> 
	    "No data for today"
    end.

receive_langs(N,List)->
    receive 
	{ok,Final} ->
	    io:format("received ~p~n" , [Final]),
	    New_List= List ++ Final,
	    case length(New_List) of
		N ->
		    New_List;
		_ ->
		    receive_langs(N,New_List)
	    end;
	bad_data ->
	    case length(List)+1 of
		N ->
		    List;
		_ ->
		    receive_langs(N-1,List)
	    end
    end.
	    
%%check_choice1(Lists,Language);
%%_ -> 
%%{Y,M,D}=erlang:date(),
%%Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
%%case riakc_pb_socket:list_keys(riak, Date_bin) of
%%	{ok,Lists} -> 
%%check_choice1(Lists,L);
%%{error,_}-> "no data for today"
%%end



check_choice1([],_) -> [];
check_choice1([H|T],L) ->
    {Y,M,D}=erlang:date(),
    Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
    {ok, Fetched1} = riakc_pb_socket:get(riak, Date_bin, H),
    Value=riakc_obj:get_value(Fetched1),
    Final=binary_to_term(Value),
    case find(Final,L) of
	true ->
	    [binary_to_list(H),Final] ++ check_choice1(T,L);
	false -> check_choice1(T,L)
    end.



find([],_) -> false;
find([H|T],L) ->
    case H of 
	L -> true;
	_ -> find(T,L)
    end.


date_check(_,0,L)->L;
date_check({Y,M,D},N,L)  ->
    case D == 1 of
	false ->
	    T2 = L++[{Y,M,D-1}],
	    date_check({Y,M,D-1},N-1,T2);
	true ->
	    Last_D=calendar:last_day_of_the_month(Y, M-1),
	    T2 = L++[{Y,M-1,Last_D}],
	    date_check({Y,M-1,Last_D},N-1,T2)
    end.


check_choice0([A,B,C],H) ->
    case H of 
	C -> [A,B];
	_ -> ["not_found"]
    end;
check_choice0([_],_) ->
    ["not found"].


check_choice([],_) ->[];
check_choice([H|T],Ch) ->
    case H of 
	[A,B,Ch] -> [A,B]++check_choice(T,Ch);
	_ -> ["not_found"]++check_choice(T,Ch)
    end.




