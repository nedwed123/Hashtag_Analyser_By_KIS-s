-module(server).

-behaviour(gen_server).

%% API
-export([start_link/0]).

%% gen_server callbacks
-export([init/1, handle_call/3, handle_cast/2, handle_info/2,
	 terminate/2, code_change/3,get/1,getM/1,tags_sweden/0,tags_finland/0,tags_germany/0,tags_norway/0,tags_denemark/0,likes_finland/0,likes_sweden/0,likes_germany/0,likes_norway/0,likes_denemark/0]).

-import(parse, [start/0, req/1]).
-import(nedparse,[reqM/1]).


start_link() ->
    gen_server:start_link({local, ?MODULE}, ?MODULE, [], []).

init([]) ->
parse:start(),
    {ok, 0}.

get(Word)-> gen_server:call(?MODULE,{tag,Word}).

getM(Word)->gen_server:call(?MODULE,{count,Word}).

tags_sweden()->gen_server:call(?MODULE,sweden_tags).

tags_germany()->gen_server:call(?MODULE,germany_tags).

tags_norway()->gen_server:call(?MODULE,norway_tags).

tags_denemark()->gen_server:call(?MODULE,denemark_tags).

tags_finland()->gen_server:call(?MODULE,finland_tags).

likes_sweden()->gen_server:call(?MODULE,sweden_likes).

likes_germany()->gen_server:call(?MODULE,germany_likes).

likes_norway()->gen_server:call(?MODULE,norway_likes).

likes_denemark()->gen_server:call(?MODULE,denemark_likes).

likes_finland()->gen_server:call(?MODULE,finland_likes).

handle_call(sweden_likes, _From, _State) ->
    Reply = id_se:pmap_id(),
    NewState=0,
    {reply, Reply, NewState};

handle_call(finland_likes, _From, _State) ->
    Reply = id_fn:pmap_id(),
    NewState=0,
    {reply, Reply, NewState};

handle_call(germany_likes, _From, _State) ->
    Reply = id_ge:pmap_id(),
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

handle_call(germany_tags, _From, _State) ->
    Reply = location_ge:pmap(),
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
    Reply = req(Word),
    NewState=0,
    {reply, Reply, NewState};

handle_call({count, Word}, _From, _State) ->
    Reply = {word,nedparse:reqM(Word)},
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
