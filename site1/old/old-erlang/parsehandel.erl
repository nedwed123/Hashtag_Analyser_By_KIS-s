-module(parsehandel).
-behaviour(gen_server).

-export([start/0, stop/0]).
%% gen_server callbacks
-export([init/1, handle_call/2, handle_cast/2, handle_info/2,
  terminate/2, code_change/3]).

-compile(export_all).


start() -> gen_server:start_link({local, ?MODULE}, ?MODULE, []).
stop()  -> gen_server:cast(?MODULE, stop).

readL(Word) -> gen_server:call(?MODULE, {readL, Word}).
readM(Word)-> gen_server:call(?MODULE, {readM, Word}).


-record(state, {table}).

init([]) -> 
  {ok,[]}.

handle_call({readL, Word}, _From) ->
parse:start(), 
  Reply = parse:req(Word),
  {reply, Reply};

handle_call({readM, Word}, _From) ->
  Reply=nedparse:req(Word),
  {reply, Reply}.

handle_cast(stop, State) -> {stop, normal, State}.
handle_info(_Info, State) -> 
  error_logger:info_msg("handle_info ~p ~p.~n", [_Info, State]),
  {noreply, State}.
terminate(_Reason, _State) -> ok.
code_change(_OldVsn, State, _Extra) -> {ok, State}.