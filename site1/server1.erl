-module(server1).

-behaviour(gen_server).

%% API
-export([start_link/0]).

%% gen_server callbacks
-export([init/1, handle_call/3, handle_cast/2, handle_info/2,
	 terminate/2, code_change/3,get/1]).


-import(riak,[start_con/0,fetch/2]).

start_link() ->
    gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).

init([]) ->
riak:start_con(),
    {ok, 0}.

get(Word)-> gen_server:call(?MODULE,{tag,Word,0}).

handle_call({tag, Word,N}, _From, _State) ->
    Reply = riak:fetch(Word,N),
    NewState=0,
    {reply, Reply, NewState};

handle_call(_Request, _From, State) ->
    Reply = ok,
    {reply, Reply, State}.

handle_cast(_Msg, State) ->
    {noreply, State}.

handle_info(_Info, State) ->
    {noreply, State}.

terminate(_Reason, _State) ->
    ok.

code_change(_OldVsn, State, _Extra) ->
    {ok, State}.
