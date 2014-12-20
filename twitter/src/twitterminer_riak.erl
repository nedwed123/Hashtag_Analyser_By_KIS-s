-module(twitterminer_riak).

-export([twitter_example/0, twitter_save_pipeline/3, get_riak_hostport/1]).

-record(hostport, {host, port}).

% This file contains example code that connects to Twitter and saves tweets to Riak.
% It would benefit from refactoring it together with twitterminer_source.erl.

keyfind(Key, L) ->
  {Key, V} = lists:keyfind(Key, 1, L),
  V.

%% @doc Get Twitter account keys from a configuration file.
get_riak_hostport(Name) ->
  {ok, Nodes} = application:get_env(twitter, riak_nodes),
  {Name, Keys} = lists:keyfind(Name, 1, Nodes),
  #hostport{host=keyfind(host, Keys),
            port=keyfind(port, Keys)}.


%% @doc This example will download a sample of tweets and print it.
twitter_example() ->
  URL = "https://stream.twitter.com/1.1/statuses/sample.json",
process_flag(trap_exit, true),
  % We get our keys from the twitterminer.config configuration file.
  Keys = twitterminer_source:get_account_keys(account1),
  RHP = get_riak_hostport(riak1),
  
  
  Result=riakc_pb_socket:start(RHP#hostport.host, RHP#hostport.port),
  case Result of
    {ok,R} ->{ok,R};
    {error,_}-> {ok,R}=riakc_pb_socket:start_link("127.0.0.1", 10027)
  end,
    

  % Run our pipeline
  P = twitterminer_pipeline:build_link(twitter_save_pipeline(R, URL, Keys)),

  % If the pipeline does not terminate after 60 s, this process will
  % force it.
  T = spawn_link(fun () ->
        receive
          cancel -> ok
        after 60000 -> % Sleep fo 60 s	
            twitterminer_pipeline:terminate(P)
        end
    end),

  Res = twitterminer_pipeline:join(P),
  T ! cancel,
  Res.

%% @doc Create a pipeline that connects to twitter and
%% saves tweets to Riak. We save all messages that have ids,
%% which might include delete notifications etc.
twitter_save_pipeline(R, URL, Keys) ->


  Prod = twitterminer_source:twitter_producer(URL, Keys),

  % Pipelines are constructed 'backwards' - consumer is first, producer is last.
  [
    twitterminer_pipeline:consumer(
      fun(Msg, N) -> save_tweet(R, Msg), N+1 end, 0),
    twitterminer_pipeline:map(
      fun twitterminer_source:decorate_with_id/1),
    twitterminer_source:split_transformer(),
    Prod].

% We save only objects that have ids.
save_tweet(_R, {parsed_tweet, _L, B, {id, _I}}) ->
%io:format("I is ~p~n",[I]),
{L}=jiffy:decode(B),
%io:format("Decoded is ~p~n",[L]),
Bd=decorate(L),
Id=fetch_key(L),

case check(Id)of
true-> 
handleInput(Id, Bd);
_->ok
end;
save_tweet(_, _) -> ok.

%Checks whether a tag has already been put to riak as key or not. if it has not been it will put the  object as new, otherwise fetches the old key and adds the retweets and favorite counts to it. 

handleInput(Bin,N)->
%% here you input your riak node port and public host (when server is public)

Res=riakc_pb_socket:start_link("127.0.0.1", 10017),
case Res of
  {ok,Pid}->{ok,Pid};
  {error,_}->{ok,Pid}=riakc_pb_socket:start_link("127.0.0.1", 10027)
end,

{Y,M,D}=erlang:date(),
%% Here we make date into a binary like: <<"20141118">>
Date_bin= list_to_binary(lists:map(fun erlang:integer_to_list/1, [Y, M, D])),
X= riakc_pb_socket:get(Pid, Date_bin,list_to_binary(string:to_lower(binary_to_list(list_to_binary(Bin))))),
case X  of
{error,notfound}->		
ObjNew = riakc_obj:new(Date_bin, list_to_binary(string:to_lower(binary_to_list(list_to_binary(Bin)))), N),
%io:format("New Key is ~tp~n",[string:to_lower(binary_to_list(list_to_binary(Bin)))]),
%io:format("New Value is ~p~n",[N]),
riakc_pb_socket:put(Pid, ObjNew, [{w, 0}]);

{ok,Fetched1}-> Z= binary_to_term(riakc_obj:get_value(Fetched1)),
case Z of
[Os,Qs,Ls]->
case N of 
[Ss,Us,_]->

Obj1=[(Os+Ss),(Qs+Us),Ls],
Object=riakc_obj:update_value(Fetched1,Obj1),
riakc_pb_socket:put(Pid,Object,[return_body]);
%io:format("OLd key  ~tp~n",[Bin]),
%io:format("OLd value  ~p~n",[Z]),
%io:format("updated value is ~p~n",[Obj1]);
_->ok
end;
[Lx]->
case N of 
[Sx,Ux,_]->
Obj2=[Sx,Ux,Lx],
Object2=riakc_obj:update_value(Fetched1,Obj2),
riakc_pb_socket:put(Pid,Object2,[return_body]);
%io:format("OoooLd key  ~tp~n",[Bin]),
%io:format("OoooLd value  ~p~n",[Z]),
%io:format("uuuupdated value is ~p~n",[Obj2]);

_->ok
end
end;
_->ok

end.


%checks if a list is empty or not
check(KeyList)->case KeyList of 
[]->false;
_->true 
end.

%%parses valuable data from the List. 
decorate([_|T])-> 

case lists:keysearch(<<"user">>,1,T)of
{value,{_,{O}}}->
case lists:keysearch(<<"lang">>,1,O)of
{value,{_,Zs}}->Q=[binary_to_list(Zs)]
end
end,

case  lists:keysearch(<<"retweeted_status">>,1,T) of
{value, {_,{Ps}}}->
case lists:keysearch(<<"favorite_count">>,1, Ps)of
{value,{_,Rs}}->case lists:keysearch(<<"retweet_count">>,1,Ps)of
{value,{_,Es}}->[Es,Rs]++Q
end
end;
_->Q
end.


%%parse the hashtag from the given List.
fetch_key([_|T])->case lists:keysearch(<<"entities">>,1,T)of 
{value,{_,{E}}}->
case lists:keysearch(<<"hashtags">>,1,E)of
{value, {_,Ss}}->hashFormat(Ss)
end
end.

%%cleans up the parsed hashtag so we only get the hashtags and nothing extra
hashFormat(U)->hashFormat(U,[]).
hashFormat([],W)->W;
hashFormat([H|_],W)->case H of
{[{_,R},_]}->[R]++W
%%if you want all the hashtags u put this:
%%{[{_,R},_]}->[R|hashFormat(T,W)]++W 
end.

