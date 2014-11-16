-module(twitterminer_pipeline).

-export([build_link/1, terminate/1, join/1, consumer/2, map/1, raw_transformer/1, producer/2]).

% @doc Build a pipeline and run it, returning a handle to it. A pipeline is a list of stages
% built 'backwards' - producer is the last element, and consumer is the first one. The pipeline
% is linked to the calling process.
build_link(Stages) ->
  Ref = make_ref(),
  S = self(),
  P = spawn_link(fun () -> build_aux(S, Ref, Stages) end),
  receive
    {first_process, Ref, F} -> {P, F, Ref}
  end.

build_aux(S, Ref, [{consumer, C}|Stages]) ->
  CP = spawn_link(fun () ->
        receive {answer_sender, FinalAnswer, Sender} ->
            Res = C(FinalAnswer, Sender), FinalAnswer ! {answer, Res} end end),
  {Previous, First} = build_aux(Stages, CP),
  CP ! {answer_sender, self(), Previous},

  S ! {first_process, Ref, First},
  receive
    {answer_to, Ref, Pid} ->
      receive
        {answer, Res} -> Pid ! {answer, Ref, Res}
      end
  end.

build_aux([{transformer, T}|Stages], Next) ->
  CP = spawn_link(fun () -> receive {sink_sender, Sink, Sender} -> T(Sink, Sender) end end),
  {Previous, First} = build_aux(Stages, CP),
  CP ! {sink_sender, Next, Previous},
  {CP, First};
build_aux([{producer, P}], Next) ->
  CP = spawn_link(fun () -> receive {sink, Sink} -> P(Sink) end end),
  CP ! {sink, Next},
  {CP, CP}.

% @doc Send a terminate request to the pipeline
terminate({_P, F, _Ref}) ->
  F ! terminate,
  ok.

% @doc Wait for the pipeline to terminate and fetch the result
% This function does not link to the pipeline, assuming that we are already linked.
join({P, _F, Ref}) ->
  P ! {answer_to, Ref, self()},
  receive
    {answer, Ref, Res} -> Res
  end.

consumer_loop(P, Sink, Sender, State) ->
  Sender ! next,
  receive
    {message, Msg} ->
      NewState = P (Msg, State),
      consumer_loop(P, Sink, Sender, NewState);
    finished -> Sink ! {answer, {ok, State}};
    terminate   -> Sink ! {answer, {terminate, State}};
    {error, Reason} -> Sink ! {answer, {error, Reason, State}}
  end.

% @doc Create a consumer stage of the pipeline. Consumer function must
% support the interface imposed by consumer_loop/4.
consumer(P, I) ->
  {consumer,
    fun (AnswerTo, Sender) ->
        consumer_loop(P, AnswerTo, Sender, I) end}.

map_loop(F, Sink, Sender) ->
  Sender ! next,
  receive
    {message, Msg} ->
      Sink ! {message, F(Msg)},
      receive next -> ok end,
      map_loop(F, Sink, Sender);
    finished  -> Sink ! finished;
    terminate -> Sink ! terminate;
    {error, Reason} -> Sink ! {error, Reason}
  end.

% @doc Create a map transformer stage of the pipeline. Map function
% transforms a single message.
map(F) ->
  {transformer,
    fun (Sink, Sender) -> map_loop(F, Sink, Sender) end}.

% @doc Create a transformer stage by directly implementing
% a pipeline process. A transformer stage must handle the same
% kinds of messages as map_loop/3. L will be called with two
% arguments: Sink and Sender.
raw_transformer(L) -> {transformer, L}.

producer_loop(P, Sink, State) ->
  case P(State) of
    {continue, NewState} ->
      producer_loop(P, Sink, NewState);
    {message, NewState, Msg} ->
      Sink ! {message, Msg},
      receive next -> ok end,
      producer_loop(P, Sink, NewState);
    {error, Reason} -> Sink ! {error, Reason};
    finished  -> Sink ! finished;
    terminate -> Sink ! terminate
  end.

% @doc Create a producer stage of the pipeline. Producer function must
% support the interface imposed by producer_loop/3, and handle
% the 'terminate' message.
producer(P, I) ->
  {producer,
    fun (Sink) -> producer_loop(P, Sink, I) end}.

