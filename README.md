# Domain Access Search API

This module helps you filter your Search API index-based view so that only results for the 
current display are shown. It's based on the Views filter that exists in the Domain Access 
module, but that filter will not work for Search API-based views.

## Important note

This filter can be added to a Search API index-based view, but it will only work if you have 
added the Domain Access field (field_domain_access, type: string) to your Search API index.
