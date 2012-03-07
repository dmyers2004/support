# PyroCMS Support Module

* [Website](http://unruhdesigns.com/)
* [Apache 2 License](http://www.apache.org/licenses/LICENSE-2.0.html)
* Requirements: PyroCMS 2.1-dev, jQuery in your theme
* Version: 0.9.0

## Description

This is a simple ticket module that I wrote in about a day for an intranet project. The use case was this: we wanted anyone in the company to be able 
to open a support request without having to have a login account. The IT department needed to be able to see new tickets come in 
on an open browser without having to refresh so all new tickets are ajaxed in. I may eventually create an RSS feed also so that it can easily 
be used with a status board.

## How it works

Visitors that need to create a ticket must supply 3 things: their name, the ticket title, and the ticket body. Their name, the ticket title, and the status of the request are public 
so anyone that visits the support page can see them (the ticket creator is warned of this). The ticket body is never displayed again, even to the 
person that created the ticket. Only admins (which in this case is the IT department) can view this so that visitors can paste passwords or etc into this field.

## Installation

It requires PyroCMS v2.1-dev. Download the zip file, extract it, and rename the main folder to "support". Either zip it and upload via PyroCMS' interface or 
drop the renamed folder into addons/default/modules or addons/shared_addons/modules. It assumes that your theme includes jQuery.

## Disclaimer

I wrote this to use PyroCMS 2.1-dev as I wanted to get a little practice with streams_core. However streams_core wasn't finished so you'll 
notice that not all calls use the streams api. Some database interaction is done via streams and some via support_tickets_m. If 
you are concerned about functionality instead of code style then disregard this paragraph :)