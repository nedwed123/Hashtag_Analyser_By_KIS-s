%Team: KIS&S
%T3 2014
%Project Hashtaganalyzer

-module(twitter_server).
-behaviour(gen_server).
-define(SERVER, ?MODULE).

%% ------------------------------------------------------------------
%% API Function Exports
%% ------------------------------------------------------------------

-export([start_link/0]).

%% ------------------------------------------------------------------
%% gen_server Function Exports
%% ------------------------------------------------------------------

-export([init/1, handle_call/3, handle_cast/2, handle_info/2,
         terminate/2, code_change/3]).

%% ------------------------------------------------------------------
%% API Function Definitions
%% ------------------------------------------------------------------

start_link() ->
    gen_server:start_link({local, ?SERVER}, ?MODULE, [], []).

%% ------------------------------------------------------------------
%% gen_server Function Definitions
%% ------------------------------------------------------------------

init([]) ->
Timer = erlang:send_after(1, self(), check),
  {ok, Timer}.

handle_call(_Request, _From, State) ->
    {reply, ok, State}.

handle_cast(store_tweet, State) ->
io:format("Stroing tweets data ~n"),
	twitterminer_riak:twitter_example(),
  erlang:send_after(300000, self(), tags),
    {noreply, State};
    
handle_cast(tags_tweet, State) ->
io:format("Stroing tags~n"),
  twitterminer_riak_d:twitter_example(),
  erlang:send_after(21600000, self(), check),
    {noreply, State};

handle_cast(_Msg, State) ->
    {noreply, State}.

handle_info(check, OldTimer) ->
  erlang:cancel_timer(OldTimer),
  gen_server:cast(?SERVER,store_tweet),
  {noreply, OldTimer};

  handle_info(tags, OldTimer) ->
  erlang:cancel_timer(OldTimer),
  gen_server:cast(?SERVER,tags_tweet),
  {noreply, OldTimer};

handle_info(_Info, State) ->
    {noreply, State}.

terminate(_Reason, _State) ->
    ok.

code_change(_OldVsn, State, _Extra) ->
    {ok, State}.

%% ------------------------------------------------------------------
%% Internal Function Definitions
%% ------------------------------------------------------------------

