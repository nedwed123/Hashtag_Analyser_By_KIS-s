

-module( pong ).
-export( [ start/0, pong/0 ] ).

start() ->
    Mypid = spawn( pong, pong, [ ] ),
    register( pong, Mypid).

pong() ->
    receive
        [Pid,getinfo] -> Pid! [self(),welcome],
            io:fwrite( "Got ~p.~n", [Pid] ),
	    pong();
        quit -> ok;
        X ->
            io:fwrite( "Got ~p.~n", [ X ] ),
            pong()
    end.

