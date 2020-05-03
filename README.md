## Implementation of the [Dingo/Api](https://github.com/dingo/api) for OcotberCMS

## Setup

Add the following env variables

```
API_PREFIX=api
API_SUBTYPE=YOUR_SUBTYPE
API_DEBUG=true
JWT_TTL=31622400
JWT_BLACKLIST_ENABLED=false
API_DEFAULT_FORMAT=json
```

## Testing

First get a token

```
curl -X "POST" "http://127.0.0.1:8000/api/auth/token" \
     -H 'Accept: application/x.YOUR_SUBTYPE.v1+json' \
     -H 'Content-Type: application/x-www-form-urlencoded; charset=utf-8'
```

Then using the token

```
curl "http://127.0.0.1:8000/api/user/details" \
     -H 'Accept: application/x.YOUR_SUBTYPE.v1+json' \
     -H 'Authorization: Bearer TOKEN_FROM_FIRST_REQUEST'

```

### Common problems

#### Routes not working?
Ensure you require your API routes.php file within your Plugin.php boot method. Example: `require realpath(__DIR__ . '/http/api/routes.php');`