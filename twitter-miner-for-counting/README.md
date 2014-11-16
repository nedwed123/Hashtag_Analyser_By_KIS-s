# DIT029 Twitter Miner

This is a demonstrator Twitter streaming API client for the DIT029 course at the [Gothenburg University](http://www.gu.se).

**License:** This software is released into the public domain (see `LICENSE`).

**Current Version:** 0.1

## Quickstart guide

1.  Get Erlang

    You need an Erlang installation to run this project.

1.  Get Rebar

    Rebar is a build script for Erlang projects. You may install it from your distribution packages, or get it from here:

    https://github.com/basho/rebar

1.  Clone the repo

        $ git clone https://github.com/michalpalka/dit029-twitter-miner.git

1.  Get the dependencies

        $ cd dit029-twitter-miner/
        $ rebar get-deps

1.  Compile the dependencies and the package

        $ rebar compile

1.  Get a Twitter account and generate authentication keys

    1.  Open a Twitter account at https://twitter.com .

    1.  Go to https://apps.twitter.com and create a new app.

    1.  Generate API keys for the app using the API Keys tab, as described
        [here](https://dev.twitter.com/oauth/overview/application-owner-access-tokens).

    1.  Collect the `API key`, `API secret`, `Access token` and `Access token secret`,
        and put them into the `twitterminer.config` file, which you find in the repo's
        toplevel directory.

1.  Run the example

    Run the Erlang shell from the repo's toplevel directory with additional library path and configuration flags

        $ erl -pa deps/*/ebin -pa ebin -config twitterminer

    Start all needed Erlang applications in the shell

    ```erlang
    1> application:ensure_all_started(twitterminer).
    ```

    Note that the previous step requires Erlang/OTP 16B02 or newer. If you have an older installation, you have to start them manually, as follows (see [this](http://stackoverflow.com/questions/10502783/erlang-how-to-load-applications-with-their-dependencies) for more information):

    ```erlang
    1> [application:start(A) || A <- [asn1, crypto, public_key, ssl, ibrowse, twitterminer]].
    ```

    Now you are ready to run your example.

    ```erlang
    2> twitterminer_source:twitter_example().
    ```

    If everything goes OK, you should see a stream of tweets running for 60 s. If you get a message indicating HTTP response code 401, it probably means authentication error.

## Saving tweets to Riak

If you are able to run the basic example above, you can try an example that saves the tweets to Riak, as follows:

1. Edit the `twitterminer.config` file to include the host/port of the Riak node that you want to connect to.

1. Run the Erlang interpreter with the dependencies, and start the needed applications:

        $ erl -pa deps/*/ebin -pa ebin -config twitterminer

    ```erlang
    1> application:ensure_all_started(twitterminer).
    ```
1. Run the example

    ```erlang
    2> twitterminer_riak:twitter_example().
    ```

    If you get no errors, your tweets should be saved in the `<"tweets">` bucket in your Riak database.

## Dependencies

### [erlang-oauth](https://github.com/tim/erlang-oauth/)

erlang-oauth is used to construct signed request parameters required by OAuth.

### [ibrowse](https://github.com/cmullaparthi/ibrowse)

ibrowse is an HTTP client allowing to close a connection while the request is still being serviced. We need this for cancelling Twitter streaming API requests.

### [jiffy](https://github.com/davisp/jiffy)

jiffy is a JSON parser, which uses efficient C code to perform the actual parsing. [mochijson2](https://github.com/bjnortier/mochijson2) is another alternative that could be used here.

### [riakc](https://github.com/basho/riak-erlang-client)

riak-erlang-client is the library that we use to connect to Riak over the protocol buffers interface.

## Author

* Michał Pałka (michalpalka) <michal.palka@chalmers.se>

