
%%Parse count media on hashtag
-module(parse).
-compile(export_all).

start()->
ibrowse:start(),
ssl:start().

req(String)->
URL="https://api.instagram.com/v1/tags/"++[String]++"/media/recent?count=100&access_token=511546223.4dc6143.f86f1a1df18d45d3865cd4b75387beb3",
case ibrowse:send_req(URL,[],get) of
{ok,_,_,Body} -> decorate(Body)
end.

decorate_likes(B)->
case jiffy:decode(B) of
    {L} ->
    case lists:keysearch(<<"data">>, 1, L) of
      {value,{<<"data">>,[]}}->"error";
      {value, M} ->save_count(M,[]);
      _->"error"
   end
  end.

decorate(B) ->
  case jiffy:decode(B) of
    {L} ->
    case lists:keysearch(<<"data">>, 1, L) of
     {value,{<<"data">>,[]}}->"error";
    	{value, M} ->[save_count(M,[]),save_link(M),save_url(M)]
       
   end
  end.
parseL([],List)->sum(List);
parseL([H|T],List)->
case H of
        {Z}->  case proplists:get_value(<<"likes">>,Z) of
         {[H2|_]} ->case H2 of
              {_,Y}-> L3=[Y|List],
            parseL(T,L3)
          end
        end
      end.

save_count(M,L)->
case M of
      {_,[H|T]}-> 
       case H of
        {Z}->  case proplists:get_value(<<"likes">>,Z) of
         {[H2|_]} -> 
         case H2 of
            {_,Y}->Y, 
            L2=[Y|L],
            parseL(T,L2)
           end
              end
                end;
                _->ok
                  end.

save_url(M)->
case M of
{_,[H|T]}-> case H of
    {Z}->case proplists:get_value(<<"images">>,Z) of
{Y}->case proplists:get_value(<<"low_resolution">>,Y) of
  {W}->case proplists:get_value(<<"url">>,W) of
X->parse_url(T,[binary_to_list(X)])
  end
end
end
end
end.


parse_url([],List)->List;
parse_url([H|T],List)->
case H of 
  {Z}->case proplists:get_value(<<"images">>,Z) of
{Y}->case proplists:get_value(<<"low_resolution">>,Y) of
  {W}->case proplists:get_value(<<"url">>,W) of
X->parse_url(T,List ++ [binary_to_list(X)])
  end
end
end
end.

save_link(M)->
case M of
  {_,[H|T]}-> case H of
    {Z}->case proplists:get_value(<<"link">>,Z) of
  X->parse_link(T,[binary_to_list(X)])
  end
  end;
  _->ok
end.
parse_link([],List)->List;
parse_link([H|T],List)->
case H of
        {Z}->  case proplists:get_value(<<"link">>,Z) of
         X->parse_link(T,List ++ [binary_to_list(X)])
          end
        
      end.

sum([])->0;
sum([H|T])-> H+sum(T).
