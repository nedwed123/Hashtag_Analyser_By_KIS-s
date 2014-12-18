-module(twitter_server).

-behaviour(gen_server).

%% API
-export([start_link/0]).

%% gen_server callbacks
-export([init/1, handle_call/3, handle_cast/2, handle_info/2,
	 terminate/2, code_change/3,get/3,getF/1,getX/1,getY/2]).


-import(riak,[start_con/0,fetch/2]).

start_link() ->
    gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).

init([]) ->
    riak:start_con(),
    {ok, 0}.

get(Word,N,Ch)->
    io:format("~p ~p ~p ~n" ,[Word,N,Ch]),
    gen_server:call(?MODULE,{tag,Word,N,Ch}).
getF(Word) -> 
    io:format("~p~n" ,[Word]),
    gen_server:call(?MODULE,{tag0,Word}).
getX(L) -> 
    io:format("~p~n" ,[L]),
    Result = riak:fetch_lang(L),
    Result.
%%    gen_server:call(?MODULE,{tag1,L}).
getY(Word,Day) -> 
    io:format("~p ~p ~n" ,[Word,Day]),
    gen_server:call(?MODULE,{tag2,Word,Day}).

handle_call({tag, Word,N,Ch}, _From, _State) ->
    io:format("choice is ~p ~n",[Ch]),
    Reply = riak:fetch(Word,N,Ch),
    NewState=0,
    {reply, Reply, NewState};

handle_call({tag0,Word}, _From, _State) ->
    Reply = riak:fetch(Word),
    NewState=0,
    {reply, Reply, NewState};

handle_call({tag1,L}, _From, _State) ->
    io:format("language is ~p~n",[L]),
    %%spawn(riak,fetch_lang,[L]),
    Result = riak:fetch_lang(L),
    io:format("RESULT : ~p~n" , [Result]),
    NewState=0,
    {reply, ok, NewState,hibernate};

handle_call({tag2,Word,Day}, _From, _State) ->
    io:format("Day is ~p~n",[Day]),
    Reply = riak:fetch_key(Word,Day),
    NewState=0,
    {reply, Reply, NewState};

handle_call(_Request, _From, State) ->
    Reply = ok,
    {reply, Reply, State}.

handle_cast(_Msg, State) ->
    io:format("~p~n",[_Msg]),
    {noreply, State}.

handle_info(_Info, State) ->
    {noreply, State}.

terminate(_Reason, _State) ->
    ok.

code_change(_OldVsn, State, _Extra) ->
    {ok, State}.





