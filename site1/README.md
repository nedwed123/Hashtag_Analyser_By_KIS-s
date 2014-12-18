### site1
----------------------------
# index.php
This page is the main page when the user enters the site.
The user has the options of going into instagram.php, video.php, or twitter.php

# instagram.php
This page consists of 4 menu items on the top right which lead to index.php,
instagram.php, twitter.php, and comments.php. In the center-left of the page 
there is a search box with a go button. Underneith the search box there is a 
likes check box and a media check box. Underneith the check boxes there is another 
search box to compare a word with the above search box word. To the right of 
these 4 items there is a clickable map of scandinavia.

# result.php
This page shows how many times a searched word has been shared and 
if other words contain the word within them when the user enterd the word 
from the first searchbox in instagram.php

# Likes.php
This page displays liked pictures when a word is searched and the Likes check box 
is selected on instagram.php

# compare.php
This page shows a comparison of media counts between words entered in both 
search boxes from instagram.php

# test/docs/examples/norway.php
# test/docs/examples/sweden.php
# test/docs/examples/finland.php
# test/docs/examples/denmark.php
These 4 pages show popular hastags from that country when the country 
is click on the map in instagram.php

# video.php
This page redirects the user to a video on Vimeo.
The video on Vimeo explains to the user how the site wrorks.

# twitter.php
This page consists of 4 menu items on the top right which lead to index.php,
instagram.php, twitter.php, and comments.php. In the center-left of the page 
there is a search box with a go button. Underneith the search box there is a 
Days slider and under it a Recent Count check box. Underneith the check boxes 
there is another search box to compare a word with the above search box word. 
To the right of these 4 items there is a clickable map of scandinavia.

# key.php
This page shows a comparison of retweets and favorit counts of a mapreduce 
word when a map reduced word is entered in the first search box in twitter.php

# key_day.php
This page showsthe comparison of retweets and favorits of a mapreduce word for 
each previous day when a mapreduce word is entered in the first search box and 
a day between 1-5 is set on the Days slider bar in twitter.php

# mapred.php
This page displays mapreduce twitter results when a word is typed in the 
search box and Recent Count is selected on twitter.php

# key_compare.php
This page shows the comparison of two words when mapreduce words are entered in 
both search boxes of twitter.php

# language_no.php
# language_sv.php
# language_fn.php
# language_dn.php
These 4 pages show the recent counts in retweets and favorits from that country 
when the country is click on the map in twitter.php

# check.php
This page is not shown to the user, it handles the Days slider bar.

# 404.php
This page is shown when there is an error with redirecting to other pages, 
if the erlang servers and helper files crash the site in handling the requests,
or if there is no data found to display in the result pages.

# comments.php
In this page a user can write a comment about the site.

## css - folder holds style sheets needed by all php pages.
## images - holds images needed by all php pages.
## js - holds javascripts needed by all php pages.
## mypeb - php erlang bridge copied from https://github.com/videlalvaro/mypeb

Erlang files that need to be put in this site1 directory to function with mypeb 
can be found in the erlang_parsers_instagram and erlang_Parsers_twitter folders.

----------------------------
Authors group KIS&S

    Mahsa Abbasin
    Sali El Marsi
    Simeon Petrov
    Neda Amiri
    Omar Abu Nabah
    Mohammad Ali
