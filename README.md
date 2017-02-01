## Implementation of the [Dingo/Api](https://github.com/dingo/api) for OcotberCMS

#### Routes not working?
Ensure you require your API routes.php file within your Plugin.php boot method. Example: `require realpath(__DIR__ . '/http/api/routes.php');`