%Team: KIS&S
%T3 2014
%Project Hashtaganalyzer

-module(twitter_app).

-behaviour(application).

%% Application callbacks
-export([start/2, stop/1]).

%% ===================================================================
%% Application callbacks
%% ===================================================================

start(_StartType, _StartArgs) ->
	error_logger:tty(false),
    error_logger:logfile({open, log_report}),
    twitter_sup:start_link().

stop(_State) ->
    ok.
