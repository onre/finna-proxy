finna-proxy
===========

Overview
--------

This is a proxy application for fetching metadata from
[finna.fi open API](https://www.kiwi.fi/pages/viewpage.action?pageId=53839221)
and representing it by SRU protocol to enable cataloguing with Koha.

The app relies on fullRecord field of the API containing the original
catalogued record. As of now, there is no check whatsoever regarding
the data type returned. However, most returned records are either
MARC21 or FINMARC, so it works most of the time.

Requirements
------------

### server

* php 5.5
* Apache (or any webserver, given that you look at .htaccess and configure accordingly)
* DOMdocument

### client

* YAZ 5.x

At least some versions of YAZ 4 does not seem to work with the proxy,
nor does it work with "real" SRU implementations, such as the Library
of Congress open database. However, this is the version included with
Ubuntu Koha packages. To circumvent this problem, this is what I did:

1. install a 5.x version of YAZ and latest yazpp as Ubuntu packages
   from [Index Data](http://www.indexdata.com/software)
2. get package source for *libnet-z3950-zoom-perl*
3. rebuild and install it

Bugs
----

Numerous. There is basically no error handling, the SRU specification
is not fully implemented etc. Also, finna.fi API seems to always
return XML with MARC21 namespace, even though the actual data format
may be FINMARC. Besides, the API might return Qualified Dublin Core as
well, but I haven't found a query that would return such a result so
that I could write code that'd just drop it from results, as Koha
doesn't support it anyway.

License
-------

Good old BSD 2-clause.

Copyright (c) 2016, Erno Palonheimo <esp@iki.fi>
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
