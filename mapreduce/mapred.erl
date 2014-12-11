-module(mapred).
-export([mapred/0, maptags/3, redtags/2,makeList/0,removeTuples/1]).


%start()->
% register(lol,Pid).

makeList()->
{ok,Pid}=riakc_pb_socket:start("54.171.161.63", 10037),
{Y,M,D}=erlang:date(),
%% Here we make date into a binary like: <<"20141118">>
Bucket= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
{ok,K}=riakc_pb_socket:list_keys(Pid, Bucket),
recursiveListMaker(K,Bucket).

%% we want a list with this format [{BUcket,Key},{BUcket1,Key1},....] 
%% the function below returns that to us 
%% it takes a list in this format [key,key1,key2,....]

recursiveListMaker(L,Buk)->recursiveListMaker(L,Buk,[]).
recursiveListMaker([],_,B)->B;

recursiveListMaker([H|T],Buk,B)->L1= [{Buk,H}]++B,recursiveListMaker(T,Buk,L1).

mapred() ->
%{Y,M,D}=erlang:date(),
%% Here we make date into a binary like: <<"20141118">>
%Bucket= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),

 Keys=makeList(),
{ok,Pid}=riakc_pb_socket:start("54.171.161.63", 10037),

	{ok, [{1, [Result]}]} = riakc_pb_socket:mapred(
		Pid,
		Keys,
		[
			{map, {modfun, ?MODULE, maptags}, none, false},
			{reduce, {modfun, ?MODULE, redtags}, none, true}
		]
	),
	ListWithTuples=dict:to_list(Result),
	T=lists:keysort(2,ListWithTuples),
	S=lists:reverse(T),
	removeTuples(S).


removeTuples(L)->removeTuples(L,[]).
removeTuples([],Buff)->Buff;
removeTuples([H|T],Buff)->case H of
{W,Ws}-> N=Buff++[W,Ws],
removeTuples(T,N)
end.




maptags(RiakObject, _, _) ->  %We don't care about keydata or the static argument
	[dict:from_list([{
I,1}|| I <- binary_to_term(riak_object:get_value(RiakObject))])].

redtags(Input, _) ->  %Once again we don't care about the static argument
[lists:foldl(fun(Tag, Acc) -> dict:merge(
fun(_, Amount1, Amount2) -> Amount1 + Amount2
end,
Tag,
Acc)
end,
dict:new(),
Input
)].
