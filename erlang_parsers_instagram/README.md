# erlang_parsers_instagram

## src:

## id_se.erl
This file contains code request of instagram API the id(id can be countries such as se=sweden, dn=denmark and the rest of the scandinavian countries). This will return the id and number of likes recently.


## location_se.erl
This file contains the code to request recent tags in a certain are(langitude and longitude). The return will give you a the  recent tags on the choosen cordinates. In the location_se file you can find cordinates for places in Sweden, you can create your own files e.g location_dn.erl and change the langitude and longitude to places in Denmark.

The file also decodes the json message and search thrue it to get only the tags and returns them as a list.
 

## parse_ig_pop.erl
The file contains code to request popular hashtag in Instagram. The file gets several request for popular hashtags and saves a list for popular hashtag the latest 10 seconds. There is also a decoding part of json message. it searchs thru the the message an gives the popular hashtags in a list


## server.erl
Starting servers in erlang to get function and defining functions in API instagram and and Erlang server

## parse_tag
The given "id_se" URL is given here to get the media for the choosen id from current location and returns a list of recent media at the location.

The file also decodes the json message and search thrue it to get only the tags and returns them as a list.

## instagram_sup.erl
This supervisor is for instagram, starts the server and monitoring the server running.


## Dependencies

### [erlang-oauth](https://github.com/tim/erlang-oauth/)

erlang-oauth is used to construct signed request parameters required by OAuth.

### [ibrowse](https://github.com/cmullaparthi/ibrowse)

ibrowse is an HTTP client allowing to close a connection while the request is still being serviced. We need this for cancelling Twitter streaming API requests.

### [jiffy](https://github.com/davisp/jiffy)

jiffy is a JSON parser, which uses efficient C code to perform the actual parsing. [mochijson2](https://github.com/bjnortier/mochijson2) is another alternative that could be used here.

### [riakc](https://github.com/basho/riak-erlang-client)

riak-erlang-client is the library that we use to connect to Riak over the protocol buffers interface.

## Authors group KIS&S

* Neda Amiri
* Omar Abu Nabah
* Mohammad Ali
