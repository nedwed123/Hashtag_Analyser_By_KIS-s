
%Team: KIS&S
%T3 2014
%Project Hashtaganalyzer

-module(server).
-behaviour(gen_server).
-define(SERVER, ?MODULE).

%% ------------------------------------------------------------------
%% API Function Exports
%% ------------------------------------------------------------------

-export([start_link/0,compare/2,get/1,getM/1,tags_sweden/1,tags_finland/1,tags_norway/1,
	tags_denemark/1,likes_sweden/1,likes_finland/1,likes_norway/1,likes_denemark/1]).

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

compare(Word1,Word2)->
	gen_server:call(?MODULE,{compare,Word1,Word2}).

get(Word)-> 
	gen_server:call(?MODULE,{tag,Word}).

getM(Word)->
	gen_server:call(?MODULE,{count,Word}).

tags_sweden(_W)->
	gen_server:call(?MODULE,sweden_tags).

tags_finland(_W)->
	gen_server:call(?MODULE,finland_tags).

tags_norway(_W)->
	gen_server:call(?MODULE,norway_tags).

tags_denemark(_W)->
	gen_server:call(?MODULE,denemark_tags).

likes_sweden(_W)->
	gen_server:call(?MODULE,sweden_likes).

likes_finland(_W)->
	gen_server:call(?MODULE,finland_likes).

likes_norway(_W)->
	gen_server:call(?MODULE,norway_likes).

likes_denemark(_W)->
	gen_server:call(?MODULE,denemark_likes).

%% ------------------------------------------------------------------
%% gen_server Function Definitions
%% ------------------------------------------------------------------


init([]) ->
parse:start(),
    {ok, 0}.

handle_call(sweden_likes, _From, _State) ->
    Reply = id_se:pmap_id(),
    NewState=0,
    {reply, Reply, NewState};

handle_call(finland_likes, _From, _State) ->
    Reply = id_fn:pmap_id(),
    NewState=0,
    {reply, Reply, NewState};  

handle_call(norway_likes, _From, _State) ->
    Reply = id_noy:pmap_id(),
    NewState=0,
    {reply, Reply, NewState};

handle_call(denemark_likes, _From, _State) ->
    Reply = id_dn:pmap_id(),
    NewState=0,
    {reply, Reply, NewState};

handle_call(finland_tags, _From, _State) ->
    Reply = location_fn:pmap(),
    NewState=0,
    {reply, Reply, NewState};
handle_call(norway_tags, _From, _State) ->
    Reply = location_noy:pmap(),
    NewState=0,
    {reply, Reply, NewState};
handle_call(denemark_tags, _From, _State) ->
    Reply = location_dn:pmap(),
    NewState=0,
    {reply, Reply, NewState};        

handle_call(sweden_tags, _From, _State) ->
    Reply = location_se:pmap(),
    NewState=0,
    {reply, Reply, NewState};

handle_call({tag, Word}, _From, _State) ->
    Reply = parse:req(Word),
    NewState=0,
    {reply, Reply, NewState};

handle_call({count, Word}, _From, _State) ->
    Reply = nedparse:reqM(Word),
    NewState=0,
    {reply, Reply, NewState}; 

handle_call({compare,Word1,Word2}, _From, _State) ->
    Reply = [nedparse:reqM(Word1),nedparse:reqM(Word2)],
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

%% ------------------------------------------------------------------
%% Internal Function Definitions
%% ------------------------------------------------------------------

