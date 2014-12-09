%Team: KIS&S
%T3 2014
%Project Hashtaganalyzer

-module(parse).
-export([start/0,req/1,decorate/1,decorate_likes/1]).

%%--------------------------------------------------------------------
%% @doc
%% Starts ibrowse and ssl
%% @end
%%--------------------------------------------------------------------

start()->
ibrowse:start(),
ssl:start().

%%--------------------------------------------------------------------
%% @doc
%% Sends request to Instagram api to get a list of 
%% recently tagged media for a certain tag
%% Ex: https://api.instagram.com/v1/tags/snow/media/recent?access_token=ACCESS-TOKEN
%%
%% @end
%%--------------------------------------------------------------------

req(String)->
URL="https://api.instagram.com/v1/tags/"++[String]++"/media/recent?count=1000&access_token=511546223.4dc6143.f86f1a1df18d45d3865cd4b75387beb3",
case ibrowse:send_req(URL,[],get) of
{ok,_,_,Body} -> decorate(Body)
end.

%%--------------------------------------------------------------------
%% @doc
%% Decode the Json message from req/1 and get the number of likes 
%% @end
%%--------------------------------------------------------------------

decorate_likes(B)->
case jiffy:decode(B) of
    {L} ->
    case lists:keysearch(<<"data">>, 1, L) of
      {value,{<<"data">>,[]}}->"error";
      {value, M} ->save_count(M,[]);
      _->"error"
   end
  end.

%%--------------------------------------------------------------------
%% @doc
%% Decode the Json message from req/1 and get the number of likes,
%% links to images and their urls. 
%% @end
%%--------------------------------------------------------------------
decorate(B) ->
  case jiffy:decode(B) of
    {L} ->
    case lists:keysearch(<<"data">>, 1, L) of
       {value,{<<"data">>,[]}}->"error";
      {value, M} ->[save_count(M,[]),save_link(M),save_url(M)];
      _->"error"
      
       
   end
  end.

%%--------------------------------------------------------------------
%% @doc
%% Get the number of likes for the other media objects . The function will iterate 
%% through the list received from save_count/2 and retruns total number of likes. 
%% 
%%
%% @end
%%--------------------------------------------------------------------


parseL([],List)->sum(List);
parseL([H|T],List)->
case H of
        {Z}->  case proplists:get_value(<<"likes">>,Z) of
         {[H2|_]} ->case H2 of
              {_,Y}-> 
              %% add the number to List which already holds the value of likes of first object
              L3=[Y|List],
            parseL(T,L3)
          end
        end
      end.


%%--------------------------------------------------------------------
%% @doc
%% Get the number of likes for the first media object . In this case M is 
%% tuple which has a list as its second element.
%%
%% @end
%%--------------------------------------------------------------------
save_count(M,L)->
case M of
      {_,[H|T]}-> 
       case H of
        {Z}->  case proplists:get_value(<<"likes">>,Z) of
         {[H2|_]} -> 
         case H2 of
          %% get number of likes
            {_,Y}->Y, 
          %% add number of likes to empty list
            L2=[Y|L],
            %% call parseL to iterate through the tail 
            parseL(T,L2)
           end
              end
                end;
                _->ok
                  end.
%%--------------------------------------------------------------------
%% @doc
%% Save the url for the first image from the parsed message from decorate/1
%% @end
%%--------------------------------------------------------------------
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

%%--------------------------------------------------------------------
%% @doc
%% Save the url for the images from the message from save_url/1 
%% and returns list of urls. 
%% @end
%%--------------------------------------------------------------------

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

%%--------------------------------------------------------------------
%% @doc
%% Save the link for the first image from the parsed message from decorate/1
%% @end
%%--------------------------------------------------------------------

save_link(M)->
case M of
  {_,[H|T]}-> case H of
    {Z}->case proplists:get_value(<<"link">>,Z) of
  X->parse_link(T,[binary_to_list(X)])
  end
  end;
  _->ok
end.

%%--------------------------------------------------------------------
%% @doc
%% Save the link for the images from the message from save_link/1 
%% and returns list of links. 
%% @end
%%--------------------------------------------------------------------

parse_link([],List)->List;
parse_link([H|T],List)->
case H of
        {Z}->  case proplists:get_value(<<"link">>,Z) of
         X->parse_link(T,List ++ [binary_to_list(X)])
          end
        
      end.

%%--------------------------------------------------------------------
%% @doc
%% Returns the sum of all values in a list 
%% @end
%%--------------------------------------------------------------------
sum([])->0;
sum([H|T])-> H+sum(T).
